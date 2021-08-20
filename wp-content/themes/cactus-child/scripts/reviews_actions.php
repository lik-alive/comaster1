<?php

include_once __DIR__ . '/general.php';
include_once __DIR__ . '/db_handler.php';
include_once __DIR__ . '/letter_factory.php';
include_once __DIR__ . '/articles_actions.php';

function closeAllReviews($ID_Article)
{
	global $wpdb;
	$myrows =  $wpdb->get_results(
		"SELECT 
		r.ID_Review, r.ID_Verdict
		FROM 
		reviews r
		WHERE 
		r.ID_Article = {$ID_Article}
		AND r.ID_Review IN 
		(SELECT 
		MAX(r.ID_Review) as MID_Review
		FROM 
		reviews r  
		WHERE 
		r.ID_Article = {$ID_Article}
		GROUP BY 
		r.ID_Expert)"
	);

	foreach ($myrows as $value) {
		if ($value->ID_Verdict === null) {
			$review = db_get_review($value->ID_Review);
			$review->FromExpDate = date('Y-m-d');
			$review->ID_Verdict = 6;
			db_update_review($review);
		}
	}
}

function isDoubleApproved($ID_Article)
{
	global $wpdb;
	$myrows =  $wpdb->get_results(
		"SELECT 
		a.ID_Article
		FROM 
		articles a
		WHERE 
		a.ID_Article NOT IN (
		SELECT 
		r.ID_Article
		FROM
		(SELECT 
		MAX(r.ID_Review) as MID_Review
		FROM 
		reviews r  
		WHERE 
		r.ID_Article = {$ID_Article}
		GROUP BY 
		r.ID_Expert) mr 
		INNER JOIN reviews r ON mr.MID_Review = r.ID_Review
		WHERE 
		(r.ID_Verdict = 2 OR r.ID_Verdict = 3 OR r.ID_Verdict = 4)
		)
		AND a.ID_Article IN (
		SELECT 
		rc.ID_Article
		FROM 
		(SELECT 
		r.ID_Article, COUNT(r.ID_Review) as RevCount
		FROM
		reviews r
		WHERE 
		r.ID_Article = {$ID_Article} AND r.ID_Verdict = 1) rc
		WHERE 
		rc.RevCount >= 2
		)"
	);

	return sizeof($myrows) == 1;
}

add_action('wp_ajax_reviews_fromexpert', 'reviews_fromexpert');
function reviews_fromexpert()
{
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$ID_Review = g_si($_POST['ID_Review']);
		$FromExpDate = g_si($_POST['RecvDate']);
		$ID_Verdict = g_si($_POST['ID_Verdict']);
		$IsToAuthors = g_si($_POST['IsToAuthors']);

		$review = db_get_review($ID_Review);
		if ($review == "") {
			printf('<p class = "bg-danger">%s</p>', "Рецензия #{$ID_Review} не найдена");
			exit();
		}

		$review->FromExpDate = $FromExpDate;
		$review->ID_Verdict = $ID_Verdict;

		$res = db_update_review($review);

		if ($res !== false) printf('<p class = "bg-success">%s</p>', 'Ответ рецензента добавлен');
		else {
			printf('<p class = "bg-danger">%s</p>', 'Ответ рецензента не был добавлен: ' . db_get_last_error());
			exit();
		}

		$article = db_get_article($review->ID_Article);

		if ($_FILES['files']['tmp_name'][0] != '') {
			$revfile_tmp_name = $_FILES['files']['tmp_name'][0];
			$revfile_name = $_FILES['files']['name'][0];
			$revfile_ext = mb_substr($revfile_name, mb_strrpos($revfile_name, '.'));

			if (mb_strpos($article->Authors, ' ') === false) $shortauthor = $article->Authors;
			else $shortauthor = mb_substr($article->Authors, 0, mb_strpos($article->Authors, ' '));
			$shortauthor = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $shortauthor);

			if (mb_strpos($article->Title, ' ') === false) $shorttitle = g_cfl($article->Title);
			else $shorttitle = g_cfl(mb_substr($article->Title, 0, mb_strpos($article->Title, ' ')));
			$shorttitle = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $shorttitle);

			$revfile_name = $shortauthor . ' ' . $shorttitle . ' ' . $review->RevNo . $revfile_ext;

			$attachments = array(
				'name' => array($revfile_name),
				'tmp_name' => array($revfile_tmp_name)
			);

			g_sf($attachments, $review->ID_Article . '/reviews/' . $ID_Review, 'review.zip');
		}

		$ID_Review = g_si($_POST['ID_Review']);
		$TechDetails = g_si($_POST['TechDetails']);
		if ($IsToAuthors == 'on')
			reviews_toauthor_inner($ID_Review, $TechDetails);

		if ($review->ID_Verdict == '1' && isDoubleApproved($review->ID_Article)) {
			articles_revapprove_inner($review->ID_Article);
		}
	}
	exit();
}

function reviews_toauthor_inner($ID_Review, $TechDetails)
{
	$review = db_get_review($ID_Review);
	if ($review == "") {
		printf('<p class = "bg-danger">%s</p>', "Рецензия #{$ID_Review} не найдена");
		return;
	}

	$review->ToAuthDate = date('Y-m-d');

	$res = db_update_review($review);

	if ($res !== false) printf('<p class = "bg-success">%s</p>', 'Направление автору добавлено');
	else {
		printf('<p class = "bg-danger">%s</p>', 'Направление автору не было добавлен: ' . db_get_last_error());
		return;
	}

	$article = db_get_article($review->ID_Article);

	$file = g_lf($review->ID_Article . '/reviews/' . $ID_Review)[0];

	if ($file !== null)
		$attachments = array(
			'name' => array(basename($file)),
			'tmp_name' => array($file)
		);

	try {
		letter_toauthor_review($article, $attachments, $review, $TechDetails);
		printf('<p class = "bg-success">%s</p>', 'Письмо автору отправлено');
	} catch (Exception $e) {
		printf('<p class = "bg-danger">%s</p>', 'Ошибка отправления письма автору: ' . $e->getMessage());
	}
}

add_action('wp_ajax_reviews_toauthor', 'reviews_toauthor');
function reviews_toauthor()
{
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$ID_Review = g_si($_POST['ID_Review']);
		$TechDetails = g_si($_POST['TechDetails']);

		reviews_toauthor_inner($ID_Review, $TechDetails);
	}
	exit();
}


add_action('wp_ajax_reviews_fromauthor', 'reviews_fromauthor');
function reviews_fromauthor()
{
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$ID_Review = g_si($_POST['ID_Review']);
		$FromAuthDate = g_si($_POST['RecvDate']);

		$review = db_get_review($ID_Review);
		if ($review == "") {
			printf('<p class = "bg-danger">%s</p>', "Рецензия #{$ID_Review} не найдена");
			exit();
		}

		$review->FromAuthDate = $FromAuthDate;

		$res = db_update_review($review);

		if ($res !== false) printf('<p class = "bg-success">%s</p>', 'Ответ автора добавлен');
		else {
			printf('<p class = "bg-danger">%s</p>', 'Ответ автора не был добавлен: ' . db_get_last_error());
			exit();
		}

		g_sf($_FILES['files'], $review->ID_Article . '/replies/' . $ID_Review, 'reply.zip');

		reviews_toexpert_inner($ID_Review);
	}
	exit();
}

function reviews_toexpert_inner($ID_Review)
{
	$review = db_get_review($ID_Review);
	if ($review == "") {
		printf('<p class = "bg-danger">%s</p>', "Рецензия #{$ID_Review} не найдена");
		return;
	}

	$expNo = mb_substr($review->RevNo, 0, mb_strpos($review->RevNo, '.'));
	$stgNo = (int)mb_substr($review->RevNo, mb_strpos($review->RevNo, '.') + 1);

	$newreview = array(
		'ID_Article' => $review->ID_Article,
		'ID_Expert' => $review->ID_Expert,
		'RevNo'		=> $expNo . '.' . ($stgNo + 1),
		'ToExpDate' => date('Y-m-d')
	);

	$res = db_add_review($newreview);

	if ($res) printf('<p class = "bg-success">%s</p>', 'Направление рецензенту добавлено');
	else {
		printf('<p class = "bg-danger">%s</p>', 'Направление рецензенту не было добавлен: ' . db_get_last_error());
		return;
	}

	$article = db_get_article($review->ID_Article);
	$expert = db_get_expert($review->ID_Expert);

	$file = g_lf($review->ID_Article . '/replies/' . $ID_Review)[0];

	if ($file)
		$attachments = array(
			'name' => array(basename($file)),
			'tmp_name' => array($file)
		);

	try {
		letter_toexpert_secondreview($article, $expert, $attachments);
		printf('<p class = "bg-success">%s</p>', 'Письмо рецензенту отправлено');
	} catch (Exception $e) {
		printf('<p class = "bg-danger">%s</p>', 'Ошибка отправления письма рецензенту: ' . $e->getMessage());
	}
}

add_action('wp_ajax_reviews_remind_expert', 'reviews_remind_expert');
function reviews_remind_expert()
{
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$ID_Review = g_si($_POST['ID_Review']);

		$review = db_get_review($ID_Review);
		if ($review == "") {
			printf('<p class = "bg-danger">%s</p>', "Рецензия #{$ID_Review} не найдена");
			exit();
		}

		$review->RemDate = date('Y-m-d');

		$res = db_update_review($review);
		if ($res !== false) printf('<p class = "bg-success">%s</p>', 'Напоминание рецензенту добавлено');
		else {
			printf('<p class = "bg-danger">%s</p>', 'Напоминание рецензенту не было добавлено: ' . db_get_last_error());
			exit();
		}

		$article = db_get_article($review->ID_Article);
		$expert = db_get_expert($review->ID_Expert);

		try {
			$limdate1 =  date('Y-m-d', strtotime($review->ToExpDate . '+14 days'));
			if ($limdate1 >= date('Y-m-d')) letter_toexpert_lightreminder($article, $expert, $review);
			else letter_toexpert_hardreminder($article, $expert, $review);
			printf('<p class = "bg-success">%s</p>', 'Письмо рецензенту отправлено');
		} catch (Exception $e) {
			printf('<p class = "bg-danger">%s</p>', 'Ошибка отправления письма рецензенту: ' . $e->getMessage());
		}
	}
	exit();
}

add_action('wp_ajax_reviews_update_file', 'reviews_update_file');
function reviews_update_file()
{
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$ID_Review = g_si($_POST['ID_Review']);

		$review = db_get_review($ID_Review);
		if ($review == "") {
			printf('<p class = "bg-danger">%s</p>', "Рецензия #{$ID_Review} не найдена");
			exit();
		}

		$article = db_get_article($review->ID_Article);

		$files = $_FILES['files'];

		$revfile_tmp_name = $files['tmp_name'][0];
		$revfile_name = $files['name'][0];
		$revfile_ext = mb_substr($revfile_name, mb_strrpos($revfile_name, '.'));

		if (mb_strpos($article->Authors, ' ') === false) $shortauthor = $article->Authors;
		else $shortauthor = mb_substr($article->Authors, 0, mb_strpos($article->Authors, ' '));

		if (mb_strpos($article->Title, ' ') === false) $shorttitle = g_cfl($article->Title);
		else $shorttitle = g_cfl(mb_substr($article->Title, 0, mb_strpos($article->Title, ' ')));

		$revfile_name = $shortauthor . ' ' . $shorttitle . ' ' . $review->RevNo . $revfile_ext;

		$attachments = array(
			'name' => array(g_cfn($revfile_name)),
			'tmp_name' => array($revfile_tmp_name)
		);

		g_sf($attachments, $review->ID_Article . '/reviews/' . $ID_Review, 'review.zip');
		printf('<p class = "bg-success">%s</p>', 'Файлы обновлены');
	}
	exit();
}

add_action('wp_ajax_reviews_get_fileinfo', 'reviews_get_fileinfo');
function reviews_get_fileinfo()
{
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$ID_Review = g_si($_POST['ID_Review']);
		$review = db_get_review($ID_Review);
		$filename = g_lf($review->ID_Article . '/reviews/' . $ID_Review);
		if (sizeof($filename) > 0) {
			printf('"' . basename($filename[0]) . '"' . ' (создан ' . date('d-m-Y', filectime($filename[0])) . ')');
		}
	}
	exit();
}
