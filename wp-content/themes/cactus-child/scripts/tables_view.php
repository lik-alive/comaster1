<?php

include_once __DIR__ . '/general.php';
include_once __DIR__ . '/db_handler.php';

function tables_view_article($id)
{
	return db_get_article_ext($id);
}

function tables_view_expert($id)
{
	return db_get_expert_ext($id);
}

function tables_view_issue($id)
{
	return db_get_issue_ext($id);
}

function tables_view_review($id)
{
	return db_get_review_ext($id);
}

function tables_view_section($id)
{
	return db_get_section_ext($id);
}

function tables_view_verdict($id)
{
	return db_get_verdict_ext($id);
}
