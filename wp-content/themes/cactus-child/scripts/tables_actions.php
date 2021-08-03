<?php

include_once __DIR__ . '/general.php';
include_once __DIR__ . '/db_handler.php';

add_action('wp_ajax_tables_add_or_update_article', 'tables_add_or_update_article');
function tables_add_or_update_article()
{
	$article = array(
		'ID_Issue' => g_si($_POST["ID_Issue"]),
		'ID_Section' => g_si($_POST["ID_Section"]),
		'SeqNumber' => g_sin($_POST["SeqNumber"]),
		'Title' => mb_strtoupper(g_si($_POST["Title"])),
		'Authors' => g_si($_POST["Authors"]),
		'Affiliation' => g_si($_POST["Affiliation"]),
		'PageCount' => g_si($_POST["PageCount"]),
		'RecvDate' => g_si($_POST["RecvDate"]),
		'CorName' => g_si($_POST["CorName"]),
		'CorMail' => g_si($_POST["CorMail"]),
		'RemDate' => g_sin($_POST["RemDate"]),
		'IsRevApproved' => (g_si($_POST["IsRevApproved"]) == 'on') ? 'Y' : 'N',
		'IsTechApproved' => (g_si($_POST["IsTechApproved"]) == 'on') ? 'Y' : 'N',
		'Language' => g_si($_POST["Language"]),
		'Comments' =>  g_sin($_POST["Comments"])
	);

	$ID_Article = g_si($_POST["id"]);
	if ($ID_Article == '') {
		$res = db_add_article($article);
		if (!$res) {
			printf('<p class = "bg-danger">%s</p>', 'Статья не была добавлена: ' . db_get_last_error());
			exit();
		}
		printf(db_get_insert_id());
	} else {
		$article['ID_Article'] = $ID_Article;
		$res = db_update_article($article);
		if ($res !== false) printf('<p class = "bg-success">%s</p>', 'Статья обновлена');
		else {
			printf('<p class = "bg-danger">%s</p>', 'Статья не была обновлена: ' . db_get_last_error());
			exit();
		}
	}

	exit();
}

add_action('wp_ajax_tables_delete_article', 'tables_delete_article');
function tables_delete_article()
{
	$ID_Article = g_si($_POST["id"]);

	$article = db_get_article($ID_Article);

	if ($article == "") {
		printf('<p class = "bg-danger">%s</p>', "Статья #{$ID_Article} не найдена");
		exit();
	}

	$res = db_delete_article($article);
	if (!$res) {
		printf('<p class = "bg-danger">%s</p>', 'Статья не была удалена: ' . db_get_last_error());
		exit();
	}

	exit();
}

add_action('wp_ajax_tables_add_or_update_expert', 'tables_add_or_update_expert');
function tables_add_or_update_expert()
{
	$expert = array(
		'ID_Expert' => g_si($_POST["ID_Expert"]),
		'Name' => g_si($_POST["Name"]),
		'Mail' => g_si($_POST["Mail"]),
		'IsActive' => (g_si($_POST["IsActive"]) == 'on') ? 'Y' : 'N',
		'Position' => g_sin($_POST["Position"]),
		'Interests' => mb_strtolower(g_sin($_POST["Interests"])),
		'Phone' => g_sin($_POST["Phone"]),
		'Comments' => g_sin($_POST["Comments"])
	);

	$ID_Expert = g_si($_POST["id"]);
	if ($ID_Expert == '') {
		$res = db_add_expert($expert);
		if (!$res) {
			printf('<p class = "bg-danger">%s</p>', 'Эксперт не был добавлен: ' . db_get_last_error());
			exit();
		}
		printf(db_get_insert_id());
	} else {
		$expert['ID_Expert'] = $ID_Expert;
		$res = db_update_expert($expert);
		if ($res !== false) printf('<p class = "bg-success">%s</p>', 'Эксперт обновлён');
		else {
			printf('<p class = "bg-danger">%s</p>', 'Эксперт не был обновлён: ' . db_get_last_error());
			exit();
		}
	}

	exit();
}

add_action('wp_ajax_tables_delete_expert', 'tables_delete_expert');
function tables_delete_expert()
{
	$ID_Expert = g_si($_POST["id"]);

	$expert = db_get_expert($ID_Expert);

	if ($expert == "") {
		printf('<p class = "bg-danger">%s</p>', "Эксперт #{$ID_Expert} не найден");
		exit();
	}

	$res = db_delete_expert($expert);
	if (!$res) {
		printf('<p class = "bg-danger">%s</p>', 'Эксперт не был удалён: ' . db_get_last_error());
		exit();
	}

	exit();
}

add_action('wp_ajax_tables_add_or_update_issue', 'tables_add_or_update_issue');
function tables_add_or_update_issue()
{
	$issue = array(
		'ID_Issue' => g_si($_POST["ID_Issue"]),
		'Title' => g_si($_POST["Title"]),
		'IsActive' => (g_si($_POST["IsActive"]) == 'on') ? 'Y' : 'N'
	);

	$ID_Issue = g_si($_POST["id"]);
	if ($ID_Issue == '') {
		$res = db_add_issue($issue);
		if (!$res) {
			printf('<p class = "bg-danger">%s</p>', 'Выпуск не был добавлен: ' . db_get_last_error());
			exit();
		}
		printf(db_get_insert_id());
	} else {
		$issue['ID_Issue'] = $ID_Issue;
		$res = db_update_issue($issue);
		if ($res !== false) printf('<p class = "bg-success">%s</p>', 'Выпуск обновлён');
		else {
			printf('<p class = "bg-danger">%s</p>', 'Выпуск не был обновлён: ' . db_get_last_error());
			exit();
		}
	}

	exit();
}

add_action('wp_ajax_tables_delete_issue', 'tables_delete_issue');
function tables_delete_issue()
{
	$ID_Issue = g_si($_POST["id"]);

	$issue = db_get_issue($ID_Issue);

	if ($issue == "") {
		printf('<p class = "bg-danger">%s</p>', "Выпуск #{$ID_Issue} не найден");
		exit();
	}

	$res = db_delete_issue($issue);
	if (!$res) {
		printf('<p class = "bg-danger">%s</p>', 'Выпуск не был удалён: ' . db_get_last_error());
		exit();
	}

	exit();
}

add_action('wp_ajax_tables_add_or_update_review', 'tables_add_or_update_review');
function tables_add_or_update_review()
{
	$review = array(
		'ID_Review' => g_si($_POST["ID_Review"]),
		'ID_Article' => g_si($_POST["ID_Article"]),
		'ID_Expert' => g_si($_POST["ID_Expert"]),
		'RevNo' => g_sin($_POST["RevNo"]),
		'ToExpDate' => g_sin($_POST["ToExpDate"]),
		'FromExpDate' => g_sin($_POST["FromExpDate"]),
		'ID_Verdict' => g_sin($_POST["ID_Verdict"]),
		'ToAuthDate' => g_sin($_POST["ToAuthDate"]),
		'FromAuthDate' => g_sin($_POST["FromAuthDate"]),
		'RemDate' => g_sin($_POST["RemDate"]),
		'Comments' =>  g_sin($_POST["Comments"])
	);

	$ID_Review = g_si($_POST["id"]);
	if ($ID_Review == '') {
		$res = db_add_review($review);
		if (!$res) {
			printf('<p class = "bg-danger">%s</p>', 'Рецензия не была добавлена: ' . db_get_last_error());
			exit();
		}
		printf(db_get_insert_id());
	} else {
		$review['ID_Review'] = $ID_Review;
		$res = db_update_review($review);
		if ($res !== false) printf('<p class = "bg-success">%s</p>', 'Рецензия обновлена');
		else {
			printf('<p class = "bg-danger">%s</p>', 'Рецензия не была обновлена: ' . db_get_last_error());
			exit();
		}
	}

	exit();
}

add_action('wp_ajax_tables_delete_review', 'tables_delete_review');
function tables_delete_review()
{
	$ID_Review = g_si($_POST["id"]);

	$review = db_get_review($ID_Review);

	if ($review == "") {
		printf('<p class = "bg-danger">%s</p>', "Рецензия #{$ID_Review} не найдена");
		exit();
	}

	$res = db_delete_review($review);
	if (!$res) {
		printf('<p class = "bg-danger">%s</p>', 'Рецензия не была удалена: ' . db_get_last_error());
		exit();
	}

	exit();
}

add_action('wp_ajax_tables_add_or_update_section', 'tables_add_or_update_section');
function tables_add_or_update_section()
{
	$section = array(
		'ID_Section' => g_si($_POST["ID_Section"]),
		'Title' => g_si($_POST["Title"]),
		'ShortTitle' => g_si($_POST["ShortTitle"]),
		'ID_Expert' => g_si($_POST["ID_Expert"])
	);

	$ID_Section = g_si($_POST["id"]);
	if ($ID_Section == '') {
		$res = db_add_section($section);
		if (!$res) {
			printf('<p class = "bg-danger">%s</p>', 'Раздел не был добавлен: ' . db_get_last_error());
			exit();
		}
		printf(db_get_insert_id());
	} else {
		$section['ID_Section'] = $ID_Section;
		$res = db_update_section($section);
		if ($res !== false) printf('<p class = "bg-success">%s</p>', 'Раздел обновлён');
		else {
			printf('<p class = "bg-danger">%s</p>', 'Раздел не был обновлён: ' . db_get_last_error());
			exit();
		}
	}

	exit();
}

add_action('wp_ajax_tables_delete_section', 'tables_delete_section');
function tables_delete_section()
{
	$ID_Section = g_si($_POST["id"]);

	$section = db_get_section($ID_Section);

	if ($section == "") {
		printf('<p class = "bg-danger">%s</p>', "Раздел #{$ID_Section} не найден");
		exit();
	}

	$res = db_delete_section($section);
	if (!$res) {
		printf('<p class = "bg-danger">%s</p>', 'Раздел не был удалён: ' . db_get_last_error());
		exit();
	}

	exit();
}

add_action('wp_ajax_tables_add_or_update_verdict', 'tables_add_or_update_verdict');
function tables_add_or_update_verdict()
{
	$verdict = array(
		'ID_Verdict' => g_si($_POST["ID_Verdict"]),
		'Title' => g_si($_POST["Title"])
	);

	$ID_Verdict = g_si($_POST["id"]);
	if ($ID_Verdict == '') {
		$res = db_add_verdict($verdict);
		if (!$res) {
			printf('<p class = "bg-danger">%s</p>', 'Вердикт не был добавлен: ' . db_get_last_error());
			exit();
		}
		printf(db_get_insert_id());
	} else {
		$verdict['ID_Verdict'] = $ID_Verdict;
		$res = db_update_verdict($verdict);
		if ($res !== false) printf('<p class = "bg-success">%s</p>', 'Вердикт обновлён');
		else {
			printf('<p class = "bg-danger">%s</p>', 'Вердикт не был обновлён: ' . db_get_last_error());
			exit();
		}
	}

	exit();
}

add_action('wp_ajax_tables_delete_verdict', 'tables_delete_verdict');
function tables_delete_verdict()
{
	$ID_Verdict = g_si($_POST["id"]);

	$verdict = db_get_verdict($ID_Verdict);

	if ($verdict == "") {
		printf('<p class = "bg-danger">%s</p>', "Вердикт #{$ID_Verdict} не найден");
		exit();
	}

	$res = db_delete_verdict($verdict);
	if (!$res) {
		printf('<p class = "bg-danger">%s</p>', 'Вердикт не был удалён: ' . db_get_last_error());
		exit();
	}

	exit();
}
