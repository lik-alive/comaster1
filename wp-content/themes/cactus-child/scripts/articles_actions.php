<?php

include_once __DIR__ . '/general.php';
include_once __DIR__ . '/db_handler.php';
include_once __DIR__ . '/letter_factory.php';
include_once __DIR__ . '/reviews_actions.php';

add_action('wp_ajax_articles_create', 'articles_create');
function articles_create()
{
	printf('<p class = "bg-danger">Functionality is locked in this demo-version</p>');
	exit();

	// $article = array(
	// 	'ID_Issue' => '3',
	// 	'ID_Section' => g_si($_POST["id_section"]),
	// 	'Authors' => g_si($_POST["authors"]),
	// 	'Title' => mb_strtoupper(g_si($_POST["title"])),
	// 	'Affiliation' => g_si($_POST["affiliation"]),
	// 	'PageCount' => g_si($_POST["pageCount"]),
	// 	'RecvDate' => g_si($_POST["recvDate"]),
	// 	'CorName' => g_si($_POST["corName"]),
	// 	'CorMail' => g_si($_POST["corMail"]),
	// 	'Language' => g_si($_POST["language"]),
	// 	'Comments' =>  g_sin($_POST["comments"])
	// );

	// $res = db_add_article($article);

	// if (!$res) {
	// 	printf('<p class = "bg-danger">%s</p>', 'Статья не была добавлена: ' . db_get_last_error());
	// 	exit();
	// }

	// g_sf($_FILES['files'], db_get_insert_id() . '/article', 'article.zip');

	// $article = db_get_article(db_get_insert_id());


	// if (g_si($_POST["isToAuthor"])) {
	// 	try {
	// 		letter_toauthor_newarticle($article);
	// 		printf('<p class = "bg-success">%s</p>', 'Письмо автору отправлено');
	// 	} catch (Exception $e) {
	// 		printf('<p class = "bg-danger">%s</p>', 'Ошибка отправления письма автору: ' . $e->getMessage());
	// 	}
	// }

	// if (g_si($_POST["isToEditor"])) {
	// 	request_experts(db_get_insert_id());
	// }

	// printf(db_get_insert_id());

	// exit();
}

function request_experts($ID_Article)
{
	$article = db_get_article($ID_Article);
	if ($article == "") {
		printf('<p class = "bg-danger">%s</p>', "Статья #{$ID_Article} не найдена");
		exit();
	}

	$section = db_get_section($article->ID_Section);
	$editor = db_get_expert($section->ID_Expert);

	$articlefile = g_lf($ID_Article . '/article')[0];
	if ($articlefile !== null) {
		$attachments = array(
			'name' => array(basename($articlefile)),
			'tmp_name' => array($articlefile)
		);
	}

	try {
		letter_toeditor_newarticle($article, $editor, $attachments);
		printf('<p class = "bg-success">%s</p>', 'Письмо редактору раздела отправлено');
	} catch (Exception $e) {
		printf('<p class = "bg-danger">%s</p>', 'Ошибка отправления письма редактору раздела: ' . $e->getMessage());
	}
}

add_action('wp_ajax_articles_request_experts', 'articles_request_experts');
function articles_request_experts()
{
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$ID_Article = g_si($_POST['ID_Article']);

		request_experts($ID_Article);
	}
	exit();
}

add_action('wp_ajax_articles_add_expert', 'articles_add_expert');
function articles_add_expert()
{
	printf('<p class = "bg-danger">Functionality is locked in this demo-version</p>');
	exit();

	// if ($_SERVER['REQUEST_METHOD'] == "POST") {
	// 	$ID_Article = g_si($_POST['ID_Article']);
	// 	$ID_Expert = g_si($_POST['ID_Expert']);

	// 	$article = db_get_article($ID_Article);
	// 	if ($article == "") {
	// 		printf('<p class = "bg-danger">%s</p>', "Статья #{$ID_Article} не найдена");
	// 		exit();
	// 	}

	// 	$expert = db_get_expert($ID_Expert);
	// 	if ($expert == "") {
	// 		printf('<p class = "bg-danger">%s</p>', "Рецензент #{$ID_Expert} не найден");
	// 		exit();
	// 	}

	// 	global $wpdb;
	// 	$hasThatExpert = $wpdb->get_results(
	// 		"SELECT r.ID_Review
	// 		FROM reviews r 
	// 		WHERE r.ID_Article = {$ID_Article} AND r.ID_Expert = {$ID_Expert};"
	// 	);

	// 	if (sizeof($hasThatExpert) > 0) {
	// 		printf('<p class = "bg-danger">%s</p>', "Рецензент #{$ID_Expert} уже назначен");
	// 		exit();
	// 	}

	// 	$expNo = $wpdb->get_results(
	// 		"SELECT COUNT(gr.ID_Review) as No
	// 		FROM
	// 		(SELECT r.ID_Review
	// 		FROM reviews r
	// 		WHERE r.ID_Article = {$ID_Article}
	// 		GROUP BY r.ID_Expert) gr;"
	// 	)[0]->No;

	// 	$review = array(
	// 		'ID_Article' => $ID_Article,
	// 		'ID_Expert' => $ID_Expert,
	// 		'RevNo'		=> ($expNo + 1) . '.1',
	// 		'ToExpDate' => date('Y-m-d')
	// 	);

	// 	$res = db_add_review($review);

	// 	if ($res) printf('<p class = "bg-success">%s</p>', 'Рецензент добавлен');
	// 	else {
	// 		printf('<p class = "bg-danger">%s</p>', 'Рецензент не был добавлен: ' . db_get_last_error());
	// 		exit();
	// 	}

	// 	$articlefile = g_lf($ID_Article . '/article')[0];
	// 	if ($articlefile !== null) {
	// 		$attachments = array(
	// 			'name' => array(basename($articlefile)),
	// 			'tmp_name' => array($articlefile)
	// 		);
	// 	}

	// 	try {
	// 		letter_toexpert_firstreview($article, $expert, (object)$review, $attachments);
	// 		printf('<p class = "bg-success">%s</p>', 'Письмо рецензенту отправлено');
	// 	} catch (Exception $e) {
	// 		printf('<p class = "bg-danger">%s</p>', 'Ошибка отправления письма рецензенту: ' . $e->getMessage());
	// 	}
	// }
	// exit();
}

function articles_revapprove_inner($ID_Article)
{
	$article = db_get_article($ID_Article);
	if ($article == "") {
		printf('<p class = "bg-danger">%s</p>', "Статья #{$ID_Article} не найдена");
		return;
	}

	$article->IsRevApproved = 'Y';

	$res = db_update_article($article);
	if ($res !== false) printf('<p class = "bg-success">%s</p>', 'Содержание одобрено');
	else {
		printf('<p class = "bg-danger">%s</p>', "Содержание не было одобрено: " . db_get_last_error());
		return;
	}

	closeAllReviews($ID_Article);

	try {
		letter_toauthor_approve($article);
		printf('<p class = "bg-success">%s</p>', 'Письмо авторам отправлено');
	} catch (Exception $e) {
		printf('<p class = "bg-danger">%s</p>', 'Ошибка отправления письма авторам: ' . $e->getMessage());
	}
}

add_action('wp_ajax_articles_revapprove', 'articles_revapprove');
function articles_revapprove()
{
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$ID_Article = g_si($_POST['ID_Article']);

		articles_revapprove_inner($ID_Article);
	}
	exit();
}

add_action('wp_ajax_articles_revreject', 'articles_revreject');
function articles_revreject()
{
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$ID_Article = g_si($_POST['ID_Article']);

		$article = db_get_article($ID_Article);
		if ($article == "") {
			printf('<p class = "bg-danger">%s</p>', "Статья #{$ID_Article} не найдена");
			exit();
		}

		$article->ID_Issue = '1';

		$res = db_update_article($article);
		if ($res !== false) printf('<p class = "bg-success">%s</p>', 'Статья отклонена');
		else {
			printf('<p class = "bg-danger">%s</p>', "Статья не была отклонена: " . db_get_last_error());
			exit();
		}

		closeAllReviews($ID_Article);

		try {
			letter_toauthor_reject($article);
			printf('<p class = "bg-success">%s</p>', 'Письмо авторам отправлено');
		} catch (Exception $e) {
			printf('<p class = "bg-danger">%s</p>', 'Ошибка отправления письма авторам: ' . $e->getMessage());
		}

		exit();
	}
}

add_action('wp_ajax_articles_senddetails', 'articles_senddetails');
function articles_senddetails()
{
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$ID_Article = g_si($_POST['ID_Article']);
		$TechDetails = g_si($_POST['TechDetails']);

		$article = db_get_article($ID_Article);
		if ($article == "") {
			printf('<p class = "bg-danger">%s</p>', "Статья #{$ID_Article} не найдена");
			exit();
		}

		try {
			letter_toauthor_techproblems($article, $TechDetails);
			printf('<p class = "bg-success">%s</p>', 'Письмо автору отправлено');
		} catch (Exception $e) {
			printf('<p class = "bg-danger">%s</p>', 'Ошибка отправления письма автору: ' . $e->getMessage());
		}
		exit();
	}
}

add_action('wp_ajax_articles_techapprove', 'articles_techapprove');
function articles_techapprove()
{
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$ID_Article = g_si($_POST['ID_Article']);

		$article = db_get_article($ID_Article);
		if ($article == "") {
			printf('<p class = "bg-danger">%s</p>', "Статья #{$ID_Article} не найдена");
			exit();
		}

		$article->IsTechApproved = 'Y';

		$res = db_update_article($article);
		if ($res !== false) printf('<p class = "bg-success">%s</p>', 'Оформление одобрено');
		else {
			printf('<p class = "bg-danger">%s</p>', "Оформление не было одобрено: " . db_get_last_error());
			exit();
		}
		exit();
	}
}

add_action('wp_ajax_articles_reserve', 'articles_reserve');
function articles_reserve()
{
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$ID_Article = g_si($_POST['ID_Article']);
		$ID_Issue = g_si($_POST['ID_Issue']);

		$article = db_get_article($ID_Article);
		if ($article == "") {
			printf('<p class = "bg-danger">%s</p>', "Статья #{$ID_Article} не найдена");
			exit();
		}

		global $wpdb;
		$lastNo = $wpdb->get_results(
			"SELECT 
			MAX(a.SeqNumber) as MaxNo
			FROM 
			articles a
			WHERE
			a.ID_Issue = {$ID_Issue} AND a.ID_Section = {$article->ID_Section}
			"
		)[0];


		$article->ID_Issue = $ID_Issue;
		$article->SeqNumber = $lastNo->MaxNo + 1;

		$res = db_update_article($article);
		if ($res !== false) printf('<p class = "bg-success">%s</p>', 'Статья добавлена в выпуск');
		else {
			printf('<p class = "bg-danger">%s</p>', "Статья не была добавлена в выпуск: " . db_get_last_error());
			exit();
		}

		exit();
	}
}

add_action('wp_ajax_articles_reorder', 'articles_reorder');
function articles_reorder()
{
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$ID_Article = g_si($_POST['ID_Article']);
		$IsUp = g_si($_POST['IsUp']);

		$article = db_get_article($ID_Article);
		if ($article == "") {
			printf('<p class = "bg-danger">%s</p>', "Статья #{$ID_Article} не найдена");
			exit();
		}

		$oldSeqNumber = $article->SeqNumber;
		if ($IsUp == 'Y') $newSeqNumber = $oldSeqNumber - 1;
		else  $newSeqNumber = $oldSeqNumber + 1;

		if ($newSeqNumber < 1) exit();

		global $wpdb;
		$lastNo = $wpdb->get_results(
			"SELECT 
			MAX(a.SeqNumber) as MaxNo
			FROM 
			articles a
			WHERE
			a.ID_Issue = {$article->ID_Issue} AND a.ID_Section = {$article->ID_Section}
			"
		)[0];

		if ($newSeqNumber > $lastNo->MaxNo) exit();

		$article2 = $wpdb->get_results(
			"SELECT 
			*
			FROM 
			articles a
			WHERE
			a.SeqNumber = {$newSeqNumber} AND a.ID_Issue = {$article->ID_Issue} AND a.ID_Section = {$article->ID_Section}
			"
		)[0];

		$article->SeqNumber = $newSeqNumber;
		$res = db_update_article($article);
		if ($res !== false) printf('<p class = "bg-success">%s</p>', 'Статья обновлена');
		else {
			printf('<p class = "bg-danger">%s</p>', "Статья не была обновлена: " . db_get_last_error());
			exit();
		}

		if (is_null($article2)) exit();

		$article2->SeqNumber = $oldSeqNumber;
		$res = db_update_article($article2);
		if ($res !== false) printf('<p class = "bg-success">%s</p>', 'Статья обновлена');
		else {
			printf('<p class = "bg-danger">%s</p>', "Статья не была обновлена: " . db_get_last_error());
			exit();
		}

		exit();
	}
}

add_action('wp_ajax_articles_remind_author', 'articles_remind_author');
function articles_remind_author()
{
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$ID_Article = g_si($_POST['ID_Article']);
		$ToAuthDate = g_si($_POST['ToAuthDate']);

		$article = db_get_article($ID_Article);
		if ($article == "") {
			printf('<p class = "bg-danger">%s</p>', "Статья #{$ID_Article} не найдена");
			exit();
		}

		$article->RemDate = date('Y-m-d');

		$res = db_update_article($article);
		if ($res !== false) printf('<p class = "bg-success">%s</p>', 'Напоминание автору добавлено');
		else {
			printf('<p class = "bg-danger">%s</p>', "Напоминание автору не было добавлено: " . db_get_last_error());
			exit();
		}

		try {
			$limdate1 =  date('Y-m-d', strtotime($ToAuthDate . '+31 days'));
			if ($limdate1 >= date('Y-m-d')) letter_toauthor_lightreminder($article, $ToAuthDate);
			else letter_toauthor_hardreminder($article, $ToAuthDate);
			printf('<p class = "bg-success">%s</p>', 'Письмо автору отправлено');
		} catch (Exception $e) {
			printf('<p class = "bg-danger">%s</p>', 'Ошибка отправления письма автору: ' . $e->getMessage());
		}
	}
	exit();
}

add_action('wp_ajax_articles_update_file', 'articles_update_file');
function articles_update_file()
{
	printf('<p class = "bg-danger">Functionality is locked in this demo-version</p>');
	exit();

	// if ($_SERVER['REQUEST_METHOD'] == "POST") {
	// 	$ID_Article = g_si($_POST['ID_Article']);

	// 	$files = $_FILES['files'];

	// 	g_sf($files, $ID_Article . '/article', 'article.zip');
	// 	printf('<p class = "bg-success">%s</p>', 'Файлы обновлены');
	// }
	// exit();
}

function articles_get_fileinfo($ID_Article)
{
	$filename = g_lf($ID_Article . '/article');
	if ($filename !== null) {
		return '"' . basename($filename[0]) . '"' . ' (создан ' . date('d-m-Y', filectime($filename[0])) . ')';
	}
	return null;
}
