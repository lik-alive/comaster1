<?php

include_once __DIR__ . '/letter_helper.php';
include_once __DIR__ . '/fpdm/FPDM.php';

//To Author

///TRANSLATE
function letter_toauthor_nopdfarticle($article)
{
	$toName = $article->CorName;
	$toMail = $article->CorMail;

	$messagebody =
		"Для публикации в нашем журнале статья должна соответствовать не только научным\n" .
		"требованиям, но и \"Правилам подготовки рукописей\", обусловленным\n" .
		"регламентами наукометрических баз и возможностями нашей полиграфии.\n" .
		"\n" .
		"Ознакомиться с актуальной редакцией \"Правил\" можно на нашем сайте:\n" .
		"http://www.computeroptics.smr.ru/guidelines.htm\n" .
		"\n" .
		"В частности, статьи предоставляются на русском или английском\n" .
		"языке в электронном виде в форматах MS Word (2000/XP/2003/2013) – \n" .
		"doc, docx или rtf и копия в pdf (с разрешением 144 dpi).\n" .
		"\n" .
		"Просим прислать новую версию статьи, отвечающую указанным правилам.\n" .
		"\n";

	letter_create_and_send($toName, $toMail, $article->Authors . " " . g_cfl($article->Title), $messagebody, 'авт', null);
}

function letter_toauthor_newarticle($article)
{
	$toName = $article->CorName;
	$toMail = $article->CorMail;

	$recvdate = date('d-m-Y', strtotime($article->RecvDate));

	if ($article->Language == 'R') {
		$messagebody =
			"Ваша статья была получена " . $recvdate . " и отправлена на рецензирование.\n";
	} else {
		$messagebody =
			"Your article was received on " . $recvdate . " and sent out for review.\n";
	}

	letter_create_and_send($toName, $toMail, $article->Authors . " " . g_cfl($article->Title), $messagebody, 'авт', null, false, true, $article->Language);
}

function letter_toauthor_review($article, $attachments, $review, $techdetails)
{
	// $toName = $article->CorName;
	// $toMail = $article->CorMail;

	// if ($article->Language == 'R') {
	// 	$revPositiv =
	// 		"Рады сообщить, что один из рецензентов дал положительную оценку Вашей статье\n" .
	// 		"и одобрил её публикацию в журнале.\n";
	// } else {
	// 	$revPositiv =
	// 		"We are glad to inform you that one of the reviewers has given a positive assessment\n" .
	// 		"of your article and approved its publication in the journal.\n";
	// }

	// $limdate = date('d-m-Y', strtotime('+30 days'));

	// if ($article->Language == 'R') {
	// 	$revProblems =
	// 		"Прошу ознакомиться с прилагаемой рецензией, устранить отмеченные недостатки и/или\n" .
	// 		"дать обоснованные возражения на замечания рецензента до " . $limdate . ".\n" .
	// 		"\n" .
	// 		"Пожалуйста,   внимательно   ознакомьтесь   с   политикой   журнала  по\n" .
	// 		"рецензированию  на нашем  сайте - там Вы найдёте актуальную информацию\n" .
	// 		"по форме ответного письма:\n" .
	// 		"http://www.computeroptics.smr.ru/RedDoc/Rec.htm\n" .
	// 		"\n" .
	// 		"Актуальный образец/бланк ответа на замечания рецензента в приложении.\n";
	// } else {
	// 	$revProblems =
	// 		"Please find the reviewer's report enclosed, revise the manuscript and/or\n" .
	// 		"give reasoned objections to the reviewer's comments before " . $limdate . ".\n" .
	// 		"\n" .
	// 		"Once you have revised the manuscript, please email it in MSWORD format to me,\n" .
	// 		"with a cover letter in PDF format outlining point-by-point the revisions you\n" .
	// 		"have made in regards to the reviewer's comments and guidelines.\n" .
	// 		"\n" .
	// 		"Please find attached the response form.\n";
	// }

	// if ($article->Language == 'R') {
	// 	$techProblems =
	// 		"Для публикации в нашем журнале статья должна соответствовать не только научным\n" .
	// 		"требованиям, но и \"Правилам подготовки рукописей\", обусловленным\n" .
	// 		"регламентами наукометрических баз и возможностями нашей полиграфии.\n" .
	// 		"\n" .
	// 		"Ознакомиться с актуальной редакцией \"Правил\" можно на нашем сайте:\n" .
	// 		"http://www.computeroptics.smr.ru/guidelines.htm\n" .
	// 		"\n" .
	// 		"Прошу устранить следующие замечания по оформлению:\n" .
	// 		$techdetails . "\n";
	// } else {
	// 	$techProblems =
	// 		"For publication in our journal, the manuscript should also correspond to\n" .
	// 		"guidelines. The current version of Authors Guidelines is available at:\n" .
	// 		"http://www.computeroptics.smr.ru/ENG/guidelines.htm\n" .
	// 		"\n" .
	// 		"Please revise the following technical comments:\n" .
	// 		$techdetails . "\n";
	// }

	// $messagebody = $revPositiv;
	// if ($review->ID_Verdict != 1) {
	// 	$messagebody = $revProblems;

	// 	global $TEMPLATESPATH, $TEMPLATEREPLYRUSFILENAME, $TEMPLATEREPLYENGFILENAME, $TEMPPATH;
	// 	if ($article->Language == 'R') {
	// 		$templfilename = $TEMPLATEREPLYRUSFILENAME;
	// 	} else {
	// 		$templfilename = $TEMPLATEREPLYENGFILENAME;
	// 	}

	// 	$replyfile_ext = mb_substr($templfilename, mb_strrpos($templfilename, '.'));

	// 	if (mb_strpos($article->Authors, ' ') === false) $shortauthor = $article->Authors;
	// 	else $shortauthor = mb_substr($article->Authors, 0, mb_strpos($article->Authors, ' '));
	// 	$shortauthor = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $shortauthor);

	// 	if (mb_strpos($article->Title, ' ') === false) $shorttitle = g_cfl($article->Title);
	// 	else $shorttitle = g_cfl(mb_substr($article->Title, 0, mb_strpos($article->Title, ' ')));
	// 	$shorttitle = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $shorttitle);

	// 	$replyfile_name = 'Reply ' . $shortauthor . ' ' . $shorttitle . ' ' . $review->RevNo . $replyfile_ext;

	// 	g_cpf($TEMPLATESPATH . $templfilename, $TEMPPATH . $replyfile_name);

	// 	$template = array(
	// 		'name' => array($replyfile_name),
	// 		'tmp_name' => array($TEMPPATH . $replyfile_name)
	// 	);

	// 	if (sizeof($attachments) == 0) $attachments = $template;
	// 	else $attachments = array_merge_recursive($attachments, $template);
	// }

	// if ($techdetails != "") $messagebody = $messagebody . "\n\n" . $techProblems;

	// letter_create_and_send($toName, $toMail, $article->Authors . " " . g_cfl($article->Title), $messagebody, 'авт', $attachments, false, true, $article->Language);
}

///TRANSLATE
function letter_toauthor_nopdfreply($article)
{
	$toName = $article->CorName;
	$toMail = $article->CorMail;

	$messagebody =
		"Пожалуйста,   внимательно   ознакомьтесь   с   политикой   журнала  по\n" .
		"рецензированию  на нашем  сайте - там Вы найдёте актуальную информацию\n" .
		"по форме ответного письма:\n" .
		"http://www.computeroptics.smr.ru/RedDoc/Rec.htm\n" .
		"\n" .
		"В частности:\n" .
		"\n" .
		"Авторы после получения рецензии подготавливают и отправляют e-mail в редакцию с приложениями:\n" .
		"1. Файл pdf с ответами на все замечания рецензента (-тов).\n" .
		"2. Файл zip или rar, включающий все файлы статьи (Word’овский файл статьи, доработанной с учётом\n" .
		"   замечаний как рецензентов, так и замечаний по оформлению, обязательно образ статьи в формате pdf\n" .
		"   и, при наличии, файлы иллюстраций).\n" .
		"   Все правки должны быть отмечены цветом.\n" .
		"\n" .
		"Просим прислать новую версию статьи, отвечающую указанным правилам.\n";

	letter_create_and_send($toName, $toMail, $article->Authors . " " . g_cfl($article->Title), $messagebody, 'авт', null);
}

function letter_toauthor_techproblems($article, $techdetails)
{
	$toName = $article->CorName;
	$toMail = $article->CorMail;

	if ($article->Language == 'R') {
		$techProblems =
			"Для публикации в нашем журнале статья должна соответствовать не только научным\n" .
			"требованиям, но и \"Правилам подготовки рукописей\", обусловленным\n" .
			"регламентами наукометрических баз и возможностями нашей полиграфии.\n" .
			"\n" .
			"Ознакомиться с актуальной редакцией \"Правил\" можно на нашем сайте:\n" .
			"http://www.computeroptics.smr.ru/guidelines.htm\n" .
			"\n" .
			"Прошу устранить следующие замечания по оформлению:\n" .
			$techdetails . "\n";
	} else {
		$techProblems =
			"For publication in our journal, the manuscript should also correspond to\n" .
			"guidelines. The current version of Authors Guidelines is available at:\n" .
			"http://www.computeroptics.smr.ru/ENG/guidelines.htm\n" .
			"\n" .
			"Please revise the following technical comments:\n" .
			$techdetails . "\n";
	}

	$messagebody = $techProblems;

	letter_create_and_send($toName, $toMail, $article->Authors . " " . g_cfl($article->Title), $messagebody, 'авт', null, true, true, $article->Language);
}

///TRANSLATE
function letter_toauthor_lightreminder($article, $date)
{
	$toName = $article->CorName;
	$toMail = $article->CorMail;

	$toauthdate = date('d-m-Y', strtotime($date));

	$messagebody =
		$toauthdate . " Вам были высланы замечания рецензентов.\n" .
		"\n" .
		"В    соответствии    с   регламентом   журнала,  новая  версия  статьи\n" .
		"ожидается от Вас в течение месяца.\n" .
		"http://www.computeroptics.smr.ru/RedDoc/Rec.htm\n" .
		"\n" .
		"Данный срок подходит к концу, однако редакция журнала пока не получила от Вас ответа.\n" .
		"\n" .
		"Проясните,  пожалуйста, когда будет прислана новая версия статьи с\n" .
		"учётом замечаний рецензентов?\n";

	letter_create_and_send($toName, $toMail, $article->Authors . " " . g_cfl($article->Title), $messagebody, 'авт', $attachments, false, true);
}

///TRANSLATE
function letter_toauthor_hardreminder($article, $date)
{
	$toName = $article->CorName;
	$toMail = $article->CorMail;

	$toauthdate = date('d-m-Y', strtotime($date));

	if ($article->Language == 'R') {
		$messagebody =
			$toauthdate . " Вам были высланы замечания рецензентов.\n" .
			"\n" .
			"В    соответствии    с   регламентом   журнала,  новая  версия  статьи\n" .
			"ожидалась от Вас в течение месяца.\n" .
			"http://www.computeroptics.smr.ru/RedDoc/Rec.htm\n" .
			"\n" .
			"Данный срок истёк, однако редакция журнала не получила от Вас ответа.\n" .
			"\n" .
			"Проясните,  пожалуйста, когда будет прислана новая версия статьи с\n" .
			"учётом замечаний рецензентов?\n" .
			"\n" .
			"Если в течение 5 дней от Вас не поступит ответа - статья будет снята\n" .
			"с рассмотрения.\n";
	} else {
		$messagebody =
			$toauthdate . " the reviewers comments have been sent to your email.\n" .
			"\n" .
			"In accordance with the guidelines of our journal, the revised manuscript\n" .
			"was expected from you within the month.\n" .
			"http://www.computeroptics.smr.ru/ENG/guidelines.htm\n" .
			"\n" .
			"This deadline has expired, but the editorial board has not received your reply.\n" .
			"\n" .
			"Could you please clarify, when a new version of the manuscript will be sent?\n";
	}

	letter_create_and_send($toName, $toMail, $article->Authors . " " . g_cfl($article->Title), $messagebody, 'авт', $attachments, false, true, $article->Language);
}

function letter_toauthor_approve($article)
{
	$toName = $article->CorName;
	$toMail = $article->CorMail;

	if ($article->Language == 'R') {
		$messagebody =
			"Рады сообщить, что Ваша статья одобрена рецензентами. Итоговый вердикт \n" .
			"по  статье,  включая  номер  журнала  для публикации, будет вынесен на \n" .
			"ближайшем заседании редколлегии.";
	} else {
		$messagebody =
			"Congratulations! Your manuscript has been accepted for publication.\n";
	}
	letter_create_and_send($toName, $toMail, $article->Authors . " " . g_cfl($article->Title), $messagebody, 'авт', $attachments, false, false, $article->Language);
}

function letter_toauthor_reject($article)
{
	$toName = $article->CorName;
	$toMail = $article->CorMail;

	if ($article->Language == 'R') {
		$messagebody =
			"Вынужден Вам сообщить, что редколлегия журнала «Компьютерная оптика», \n" .
			"рассмотрев статью: \n" .
			"\"" . g_cfl($article->Title) . "\" \n" .
			"пришла в результате обсуждения к выводу о несоответствии уровня представления \n" .
			"результатов исследования принятым в нашем журнале критериям научной строгости \n" .
			"и результативности и, как следствие, к решению о невозможности опубликования \n" .
			"статьи в журнале «Компьютерная оптика». \n";
	} else {
		$messagebody =
			"Unfortunately, I have to inform you that the editorial board of the journal\n" .
			"\"Computer Optics\" after considering the reviews' comments to the article:\n" .
			"\"" . g_cfl($article->Title) . "\"\n" .
			"has come to decision that your manuscript cannot be accepted for publication.\n";
	}
	letter_create_and_send($toName, $toMail, $article->Authors . " " . g_cfl($article->Title), $messagebody, 'авт', $attachments, false, false, $article->Language);
}

//To Editor

function letter_toeditor_newarticle($article, $editor, $attachments)
{
	$toName = $editor->Name;
	$toMail = $editor->Mail;

	$limdate =  date("d-m-Y", strtotime("+3 days"));
	$site_url = site_url();

	$messagebody =
		"Редакцией журнала \"Компьютерная оптика\" получена прилагаемая статья.\n" .
		"\n" .
		"Прошу назначить рецензентов, выслав их ФИО на ko@smr.ru до " . $limdate . "\n" .
		"или же добавив их на мастер-сайте: $site_url/articles/view/?id=" . $article->ID_Article . "\n";

	letter_create_and_send($toName, $toMail, $article->Authors . " " . g_cfl($article->Title), $messagebody, 'ред', $attachments, false, true);
}

//To Expert

function letter_toexpert_firstreview($article, $expert, $review, $attachments)
{
	printf('<p class = "bg-danger">Functionality is locked in this demo-version</p>');
	exit();

	// $toName = $expert->Name;
	// $toMail = $expert->Mail;

	// $limdate1 =  date("d-m-Y", strtotime("+14 days"));
	// $limdate2 =  date("d-m-Y", strtotime("+3 days"));

	// //Продление сроков в декабре
	// if (date('m') == '12') {
	// 	$limdate1 =  date('d-m-Y', strtotime("+30 days"));
	// }

	// $messagebody =
	// 	"Редакцией журнала \"Компьютерная оптика\" получена прилагаемая статья.\n" .
	// 	"\n" .
	// 	"Если ее содержание пересекается с областью Ваших научных интересов (или Ваших\n" .
	// 	"коллег) в степени, достаточной для написания рецензии, то прошу прислать\n" .
	// 	"рецензию прилагаемой статьи на ko@smr.ru до " . $limdate1 . ".\n" .
	// 	"\n" .
	// 	"Или дать аргументированный отказ от рецензирования до " . $limdate2 . ".\n" .
	// 	"\n" .
	// 	"Актуальный образец/бланк рецензии в приложении.\n";

	// global $TEMPLATESPATH, $TEMPLATEREVIEWRUSFILENAME, $TEMPLATEREVIEWENGFILENAME, $REVIEWSPATH;
	// if ($article->Language == 'R') {
	// 	$templfilename = $TEMPLATEREVIEWRUSFILENAME;
	// } else {
	// 	$templfilename = $TEMPLATEREVIEWENGFILENAME;
	// }

	// $revfile_ext = mb_substr($templfilename, mb_strrpos($templfilename, '.'));

	// //TODO
	// $author_s = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $article->Authors);

	// if (mb_strpos($author_s, ' ') === false) $shortauthor = $author_s;
	// else $shortauthor = mb_substr($author_s, 0, mb_strpos($author_s, ' '));

	// //TODO
	// $title_s = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $article->Title);

	// if (mb_strpos($title_s, ' ') === false) $shorttitle = g_cfl($title_s);
	// else $shorttitle = g_cfl(mb_substr($title_s, 0, mb_strpos($title_s, ' ')));

	// $revfile_name = $shortauthor . ' ' . $shorttitle . ' ' . $review->RevNo . $revfile_ext;

	// $fields = array(
	// 	'Text1'    => $article->Authors . ' ' . g_cfl($article->Title)
	// );

	// $template = array();

	// try {
	// 	$pdf = new FPDM\FPDM($TEMPLATESPATH . $templfilename);
	// 	$pdf->Load($fields, true);
	// 	$pdf->Merge();
	// 	$pdf->Output($REVIEWSPATH . $revfile_name, 'F');

	// 	$template = array(
	// 		'name' => array($revfile_name),
	// 		'tmp_name' => array($REVIEWSPATH . $revfile_name)
	// 	);
	// } catch (Exception $e) {
	// 	printf('<p class = "bg-danger">%s</p>', 'Ошибка генерации pdf-рецензии: ' . $e->getMessage());
	// }

	// if (sizeof($attachments) == 0) $attachments = $template;
	// else $attachments = array_merge_recursive($attachments, $template);

	// letter_create_and_send($toName, $toMail, $article->Authors . ' ' . g_cfl($article->Title), $messagebody, 'рец', $attachments);
}

function letter_toexpert_secondreview($article, $expert, $attachments)
{
	printf('<p class = "bg-danger">Functionality is locked in this demo-version</p>');
	exit();

	// $toName = $expert->Name;
	// $toMail = $expert->Mail;

	// $limdate1 =  date("d-m-Y", strtotime("+14 days"));

	// //Продление сроков в декабре
	// if (date('m') == '12') {
	// 	$limdate1 =  date('d-m-Y', strtotime("+30 days"));
	// }

	// $messagebody =
	// 	"Прошу ознакомиться с исправленной версией статьи.\n" .
	// 	"Все ли Ваши замечания учтены, можно ли передавать статью в печать?\n" .
	// 	"\n" .
	// 	"Ваше заключение прошу прислать на ko@smr.ru до " . $limdate1 . ".\n" .
	// 	"\n" .
	// 	"При необходимости, актуальный образец/бланк рецензии в приложении.\n";

	// global $TEMPLATESPATH, $TEMPLATEREVIEWRUSFILENAME, $TEMPLATEREVIEWENGFILENAME, $REVIEWSPATH;
	// if ($article->Language == 'R') {
	// 	$templfilename = $TEMPLATEREVIEWRUSFILENAME;
	// } else {
	// 	$templfilename = $TEMPLATEREVIEWENGFILENAME;
	// }

	// $revfile_ext = mb_substr($templfilename, mb_strrpos($templfilename, '.'));

	// //TODO
	// $author_s = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $article->Authors);

	// if (mb_strpos($author_s, ' ') === false) $shortauthor = $author_s;
	// else $shortauthor = mb_substr($author_s, 0, mb_strpos($author_s, ' '));

	// //TODO
	// $title_s = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $article->Title);

	// if (mb_strpos($title_s, ' ') === false) $shorttitle = g_cfl($title_s);
	// else $shorttitle = g_cfl(mb_substr($title_s, 0, mb_strpos($title_s, ' ')));

	// $revfile_name = $shortauthor . ' ' . $shorttitle . ' ' . $review->RevNo . $revfile_ext;

	// $fields = array(
	// 	'Text1'    => $article->Authors . ' ' . g_cfl($article->Title)
	// );

	// $pdf = new FPDM\FPDM($TEMPLATESPATH . $templfilename);
	// $pdf->Load($fields, true);
	// $pdf->Merge();
	// $pdf->Output($REVIEWSPATH . $revfile_name, 'F');

	// $template = array(
	// 	'name' => array($revfile_name),
	// 	'tmp_name' => array($REVIEWSPATH . $revfile_name)
	// );

	// if (sizeof($attachments) == 0) $attachments = $template;
	// else $attachments = array_merge_recursive($attachments, $template);

	// letter_create_and_send($toName, $toMail, $article->Authors . " " . g_cfl($article->Title), $messagebody, 'рец', $attachments, false, true);
}

function letter_toexpert_lightreminder($article, $expert, $review)
{
	$toName = $expert->Name;
	$toMail = $expert->Mail;

	$torevdate = date('d-m-Y', strtotime($review->ToExpDate));
	$limdate1 =  date('d-m-Y', strtotime($review->ToExpDate . '+14 days'));

	$messagebody =
		"Напоминаем, что " . $torevdate . " Вам была выслана на рецензирование статья:\n" .
		$article->Authors . " \"" . g_cfl($article->Title) . "\".\n" .
		"\n" .
		"В соответствии с регламентом журнала, рецензия ожидается до " . $limdate1 . ".\n" .
		"\n" .
		"Редакция очень ждёт рецензию от Вас к данному сроку.\n";

	letter_create_and_send($toName, $toMail, $article->Authors . " " . g_cfl($article->Title), $messagebody, 'авт', $attachments, false, true);
}

function letter_toexpert_hardreminder($article, $expert, $review)
{
	$toName = $expert->Name;
	$toMail = $expert->Mail;

	$torevdate = date('d-m-Y', strtotime($review->ToExpDate));
	$limdate1 =  date('d-m-Y', strtotime($review->ToExpDate . '+14 days'));

	$messagebody =
		$torevdate . " Вам была выслана на рецензирование статья:\n" .
		$article->Authors . " \"" . g_cfl($article->Title) . "\".\n" .
		"\n" .
		"В соответствии с регламентом журнала, рецензия ожидалась до " . $limdate1 . "\n" .
		"Данный срок истёк, однако редакция журнала не получила от Вас ответа.\n" .
		"\n" .
		"Проясните, пожалуйста, будет ли от Вас рецензия на статью, и если да,\n" .
		"то в какой срок?\n" .
		"\n" .
		"Если в течение 5 дней от Вас не поступит ответа - мы будем вынуждены\n" .
		"снять Вас с рецензирования данной статьи.\n";

	letter_create_and_send($toName, $toMail, $article->Authors . " " . g_cfl($article->Title), $messagebody, 'авт', $attachments, false, true);
}

function letter_toexpert_payment($expert)
{
	$toName = $expert->Name;
	$toMail = $expert->Mail;

	$messagebody =
		"Журнал \"Компьютерная оптика\" благодарит Вас за плодотворную работу\n" .
		"и высокое качество рецензий в 2017 году.\n" .
		"\n" .
		"В соответствии с регламентом, за написание рецензий для нашего журнала\n" .
		"полагается денежное вознаграждение рецензенту.\n" .
		"\n" .
		"Получить его Вы можете, начиная с 18.12.2017, либо по адресу:\n" .
		"г. Самара, ул. Молодогвардейская 151, 402 ауд.,\n" .
		"\n" .
		"либо прислав номер своего сотового телефона на почту ko@smr.ru для перевода\n" .
		"суммы вознаграждения на Ваш личный счёт у мобильного оператора.\n" .
		"\n" .
		"\n" .
		"P.S. Редакция журнала поздравляет Вас с наступающими праздниками\n" .
		"и желает великих свершений в Новом Году! \n";

	letter_create_and_send($toName, $toMail, 'Итоги рецензирования в 2017 году', $messagebody, 'авт', $attachments, false, true);
}
