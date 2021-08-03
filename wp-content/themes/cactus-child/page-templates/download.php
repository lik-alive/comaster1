<?php
/*
		Template Name: Download
	*/

if (g_cua('administrator', 'seceditor')) {
	$ID_Article = g_si($_GET['ida']);
	$ID_Review = g_si($_GET['idr']);

	if ($ID_Article === '' && $ID_Review === '') die('Неверные параметры');

	if ($ID_Review === '') $file = g_lf($ID_Article . '/article')[0];
	else $file = g_lf($ID_Article . '/reviews/' . $ID_Review)[0];

	if ($file === null) die('Файл не найден');
	else {
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=" . basename($file));
		header("Content-Type: application/zip");
		header("Content-Transfer-Encoding: binary");

		readfile($file);
	}
}
