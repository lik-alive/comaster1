<?php

include_once __DIR__ . '/general.php';

function securestr($str)
{
	return str_replace('\'', '', $str);
}

function letterheader($name, $lang)
{
	if (strpos($name, ' ') !== false)
		$name = substr($name, strpos($name, ' ') + 1);

	if ($lang == 'R') {
		return "Здравствуйте, $name!\n\n";
	} else {
		return "Dear $name,\n\n";
	}
}

function letterfooter($lang)
{
	if ($lang == 'R') {
		return "\n\n" .
			"--\n" .
			"С уважением,\n" .
			"ответственный секретарь журнала \"Компьютерная оптика\"\n" .
			"Дмитрий Викторович Кирш,\n" .
			"ko@smr.ru";
	} else {
		return "\n\n" .
			"--\n" .
			"Sincerely yours,\n" .
			"Dmitriy Kirsch,\n" .
			"Executive Secretary of Journal \"Computer Optics\"\n" .
			"ko@smr.ru";
	}
}

function createDayMask($prefix)
{
	global $LETTERSFOLDER;
	$folder = $LETTERSFOLDER . date('Y-m-d') . '/';

	if (!file_exists($folder)) {
		if (!mkdir($folder)) {
			throw new Exception('Невозможно создать папку для хранения писем');
		}
	}
	return $folder . $prefix . " " . date('H-i-s') . ' ' . round(microtime(true) * 1000) . " ";
}

function saveMIMELetter($message)
{
	$envelope["date"] = date('r');
	$envelope["from"] = mb_encode_mimeheader('Кирш Дмитрий Викторович', "windows-1251") . " <ko@smr.ru>";
	$envelope["to"] = '';
	for ($i = 0; $i < sizeof($message->toName); $i++) {
		if ($i > 0) $envelope["to"] .= '; ';
		$envelope["to"] .= mb_encode_mimeheader($message->toName[$i], "windows-1251") . " <{$message->toMail[$i]}>";
	}
	$envelope["subject"] = mb_encode_mimeheader($message->subject, "windows-1251");
	$envelope["custom_headers"] = array(
		"X-Confirm-Reading-To: ko@smr.ru",
		"Disposition-Notification-To: ko@smr.ru",
		"Return-Receipt-To: ko@smr.ru",
		"X-Bat-Delay: 30m"
	);

	$headerPart["type"] = TYPEMULTIPART;
	$headerPart["subtype"] = "mixed";

	$textPart["type"] = TYPETEXT;
	$textPart["subtype"] = "plain";
	$textPart["charset"] = "utf-8";
	$textPart["encoding"] = ENCBASE64;

	$textPart["contents.data"] = base64_encode($message->text);

	$body[1] = $headerPart;
	$body[2] = $textPart;

	$partCount = sizeof($message->attachments['name']);
	for ($partNo = 0; $partNo < $partCount; $partNo++) {
		$tmp_name = $message->attachments['tmp_name'][$partNo];
		$name = $message->attachments['name'][$partNo];
		$fp = fopen($tmp_name, "r");
		$contents = fread($fp, filesize($tmp_name));
		fclose($fp);

		$filePart['type'] = TYPEAPPLICATION;
		$filePart['encoding'] = ENCBASE64;
		$filePart['subtype'] = "octet-stream";
		$filePart['description'] = $name;
		$filePart['disposition.type'] = 'attachment';
		$filePart['disposition'] = array('filename' => mb_encode_mimeheader($name, "windows-1251"));
		$filePart['type.parameters'] = array('name' => mb_encode_mimeheader($name, "windows-1251"));
		$filePart['contents.data'] = base64_encode($contents);
		$body[$partNo + 3] = $filePart;
	}

	$result = file_put_contents($message->mimeFile, imap_mail_compose($envelope, $body));

	if (!$result) {
		throw new Exception('Не удалось создать файл с письмом');
	}
}

function saveTextLetter($message)
{
	$result = file_put_contents($message->textFile, mb_convert_encoding($message->text, 'windows-1251'));

	if (!$result) {
		throw new Exception('Не удалось создать файл с письмом');
	}
}

function importMessageToTheBAT($message)
{
	global $BATEXEC;
	$command = "\"" . $BATEXEC . "\" /IMPORTF=\"//ko@smr.ru/Outbox/toapprove\";FILE=\"{$message->mimeFile}\";UNREAD;";
	shell_exec($command);
}

function addMessageToTheBAT($message)
{
	global $BATEXEC;
	global $LETTERTEMPLATE;
	$command = "\"" . $BATEXEC . "\" /MAILF=\"//ko@smr.ru/Outbox\";";

	for ($i = 0; $i < sizeof($message->toName); $i++)
		$command .= "TO=\"{$message->toName[$i]} <{$message->toMail[$i]}>\";";

	$command .=
		"S=\"{$message->subject}\";" .
		"C=\"{$message->textFile}\";" .
		"T=\"{$message->templateFile}\";";

	for ($i = 0; $i < sizeof($message->attachments['tmp_name']); $i++)
		$command .= "A=\"{$message->attachments['tmp_name'][$i]}\";";

	shell_exec($command);
}

function letter_create_and_send($toName, $toMail, $subject, $messagebody, $prefix, $attachments, $copyToTech = false, $isImmedeate = false, $lang = 'R')
{
	global $LETTERTEMPLATE, $LETTERTEMPLATETECH;
	$filename = createDayMask($prefix) . $toName;
	$MIMEfilename = $filename . ".eml";
	$TXTfilename = $filename . ".txt";

	$message = (object)[
		'toName' => array($toName),
		'toMail' => array($toMail),
		'subject' => securestr($subject),
		'text' => letterheader($toName, $lang) . $messagebody . letterfooter($lang),
		'attachments' => $attachments,
		'textFile' => $TXTfilename,
		'mimeFile' => $MIMEfilename,
		'templateFile' => $LETTERTEMPLATE
	];

	if ($copyToTech) {
		$message->templateFile = $LETTERTEMPLATETECH;
	}

	saveMIMELetter($message);
	saveTextLetter($message);

	if ($isImmedeate)
		addMessageToTheBAT($message);
	else
		importMessageToTheBAT($message);
}
