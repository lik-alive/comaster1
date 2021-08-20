<?php

$FILESFOLDER = ABSPATH . 'files/';
// $LETTERSFOLDER = $FILESFOLDER . 'letters/';
// $LETTERTEMPLATE = $LETTERSFOLDER . 'template_def.txt';
// $LETTERTEMPLATETECH = $LETTERSFOLDER . 'template_tech.txt';
// $BATEXEC = 'E:/The Bat!/thebat.exe';

$TEMPPATH = $FILESFOLDER . "temp/";
$REVIEWSPATH = $FILESFOLDER . "reviews/";

$TEMPLATESPATH = $FILESFOLDER . 'templates/';
$TEMPLATEREVIEWRUSFILENAME = 'review/rus/review.pdf';
$TEMPLATEREPLYRUSFILENAME  = 'review/rus/reply.pdf';
$TEMPLATEREVIEWENGFILENAME = 'review/eng/review.pdf';
$TEMPLATEREPLYENGFILENAME  = 'review/eng/reply.pdf';

function g_si($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
	return $data;
}

function g_sin($data)
{
	$data = g_si($data);
	return ($data == '') ? null : $data;
}

function g_cfl($str)
{
	$str = mb_strtolower($str);
	if (mb_strtoupper(mb_substr($str, 0, 1)) == mb_substr($str, 0, 1))
		return mb_substr($str, 0, 1) . mb_strtoupper(mb_substr($str, 1, 1)) . mb_strtolower(mb_substr($str, 2));
	else
		return mb_strtoupper(mb_substr($str, 0, 1)) . mb_strtolower(mb_substr($str, 1));
}

function g_sn($fullName)
{
	if (mb_strpos($fullName, ' ') === false) return $fullName;

	$surname = mb_substr($fullName, 0, mb_strpos($fullName, ' '));
	$fullName = mb_substr($fullName, mb_strpos($fullName, ' ') + 1);

	if (mb_strpos($fullName, ' ') === false) return $surname . ' ' . mb_substr($fullName, 0, 1) . '.';

	$firstname = mb_substr($fullName, 0, mb_strpos($fullName, ' '));
	$fullName = mb_substr($fullName, mb_strpos($fullName, ' ') + 1);

	return $surname . ' ' . mb_substr($firstname, 0, 1) . '.' . mb_substr($fullName, 0, 1) . '.';
}

function g_fnd($date)
{
	return is_null($date) ? null : date('d-m-Y', strtotime($date));
}

function g_wsc($idsec)
{
	if ($idsec == '777') return "";
	else return " AND a.ID_Section = {$idsec} ";
}

function g_wis($idiss)
{
	if ($idiss == '777') return "";
	else if ($idiss == '888') return " AND i.IsActive = 'Y' ";
	else return " AND a.ID_Issue = {$idiss} ";
}

function g_wex($idexp)
{
	return is_null($idexp) ? '' : " AND e.ID_Expert = {$idexp} ";
}

//FILES

function g_cfn($filename)
{
	return str_replace(array('/', '/', ':', '*', '?', '"', '<', '>', '|'), '', $filename);
}

function g_cpf($frompath, $topath)
{
	$fr = fopen($frompath, "r");
	$contents = fread($fr, filesize($frompath));
	fclose($fr);

	$fw = fopen($topath, "w");
	fwrite($fw, $contents);
	fclose($fw);
}

function g_sf($attachments, $subfolder, $zipname)
{
	$partCount = sizeof($attachments['name']);
	if ($partCount === 0) return;

	global $FILESFOLDER;
	$folder = $FILESFOLDER . $subfolder . '/';

	if (!file_exists($folder)) {
		mkdir($folder, 0777, true);
	}

	//Clear folder
	$files = glob($folder . '*');
	foreach ($files as $file) {
		if (is_file($file)) unlink($file);
	}

	if ($partCount === 1) {
		g_cpf($attachments['tmp_name'][0], $folder . $attachments['name'][0]);
	} else {
		$zip = new ZipArchive();
		if ($zip->open($folder . $zipname, ZipArchive::CREATE) !== true) return;

		for ($partNo = 0; $partNo < $partCount; $partNo++) {
			$zip->addFile($attachments['tmp_name'][$partNo], $attachments['name'][$partNo]);
		}

		$zip->close();
	}
}

function g_lf($subfolder)
{
	global $FILESFOLDER;
	$folder = $FILESFOLDER . $subfolder . '/';

	if (file_exists($folder)) {
		$invisibleFileNames = array(".", "..");

		$files = scandir($folder);
		foreach ($files as $value) {
			if ($value === '.' || $value === '..') {
				continue;
			}
			$result[] = $folder . $value;
		}

		return $result;
	}

	return null;
}

//LOG USERS
function g_lu()
{
	$user = g_sgcu();
	$Title = $user . '_lastvisit';

	global $wpdb;
	$ID_XVAL =  $wpdb->get_results(
		"SELECT 
			x.ID_XVAL
		FROM 
			xvals x 
		WHERE 			
			x.Title LIKE '%{$Title}%'"
	)[0]->ID_XVAL;

	$value = array(
		'ID_XVAL' => $ID_XVAL,
		'Value' => date('Y-m-d')
	);
	$wpdb->update('xvals', $value, array('ID_XVAL' => $ID_XVAL));
}

//CHANGE USER VIEW
$TESTMODE = false;

function g_gtm()
{
	global $TESTMODE;
	return $TESTMODE;
}

function g_cua(...$users)
{
	if (g_gtm()) {
		return g_tcua(...$users);
	} else {
		return g_scua(...$users);
	}
}

function g_scua(...$users)
{
	foreach ($users as $user) {
		if (current_user_can($user)) return true;
	}
	return false;
}

function g_tcua(...$users)
{
	foreach ($users as $user) {
		if (g_gcr() == $user) return true;
	}
	return false;
}

function g_gcu()
{
	if (g_gtm()) {
		return g_tgcu();
	} else {
		return g_sgcu();
	}
}

function g_sgcu()
{
	return wp_get_current_user()->user_login;
}

function g_tgcu()
{
	global $wpdb;

	$myrows =  $wpdb->get_results(
		"SELECT 
			x.Value
		FROM 
			xvals x 
		WHERE 			
			x.ID_XVAL=1"
	)[0];

	return $myrows->Value;
}

function g_gcr()
{
	global $wpdb;

	$myrows =  $wpdb->get_results(
		"SELECT 
			x.Value
		FROM 
			xvals x 
		WHERE 			
			x.ID_XVAL=1"
	)[0];

	if (
		$myrows->Value == 'doeditor'
		|| $myrows->Value == 'oieditor'
		|| $myrows->Value == 'cmeditor'
	) return 'seceditor';

	return $myrows->Value;
}

add_action('wp_ajax_g_chu', 'g_chu');
function g_chu()
{
	$ID_User = g_si($_GET['idu']);

	$user = '';
	if ($ID_User == '777') $user = 'administrator';
	else if ($ID_User == '1') $user = 'doeditor';
	else if ($ID_User == '2') $user = 'oieditor';
	else if ($ID_User == '3') $user = 'cmeditor';
	else if ($ID_User == '4') $user = 'tech';
	else if ($ID_User == '5') $user = 'maineditor';
	else return;

	global $wpdb;
	$value = array(
		'ID_XVAL' => 1,
		'Title' => 'cu',
		'Value' => $user
	);
	$wpdb->update('xvals', $value, array('ID_XVAL' => 1));
}
