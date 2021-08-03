<?php
//General
function db_get_last_error()
{
	global $wpdb;
	return $wpdb->last_error;
}

function db_get_insert_id()
{
	global $wpdb;
	return $wpdb->insert_id;
}


//Articles	

function db_get_article($ID_Article)
{
	global $wpdb;
	$result =  $wpdb->get_results(
		"SELECT 
			a.ID_Article, 
			a.ID_Issue,
			a.ID_Section,
			a.SeqNumber,
			a.Title,  
			a.Authors, 
			a.Affiliation, 
			a.PageCount, 
			a.RecvDate,
			a.CorName,  
			a.CorMail, 
			a.RemDate,
			a.IsRevApproved, 
			a.IsTechApproved, 
			a.Language, 
			a.Comments
		FROM 
			articles a
		WHERE 
			a.ID_Article = {$ID_Article}"
	);

	return $result[0];
}

function db_get_article_ext($ID_Article)
{
	return db_get_articles_ext($ID_Article)[0];
}

function db_get_articles_ext($ID_Article = null)
{
	$byid = '';
	if (!is_null($ID_Article))
		$byid = " AND a.ID_Article = {$ID_Article} ";

	global $wpdb;
	$result =  $wpdb->get_results(
		"SELECT 
			a.ID_Article, 
			a.ID_Issue, i.Title as ITitle,
			a.ID_Section, s.Title as STitle, s.ShortTitle as SSTitle,
			a.SeqNumber,
			a.Title,  
			a.Authors, 
			a.Affiliation, 
			a.PageCount, 
			a.RecvDate,
			a.CorName,  
			a.CorMail, 
			a.RemDate,
			a.IsRevApproved, 
			a.IsTechApproved, 
			a.Language, 
			a.Comments
		FROM 
			articles a, 
			sections s, 
			issues i
		WHERE 
			a.ID_Issue = i.ID_Issue 
			AND a.ID_Section=s.ID_Section 
			{$byid}
		ORDER BY 
			a.ID_Article DESC;"
	);

	return $result;
}

function db_add_article($article)
{
	// global $wpdb;		
	// return $wpdb->insert('articles', $article);
}

function db_update_article($article)
{
	if (!is_object($article)) $article = (object)$article;
	$update = (array)$article;

	global $wpdb;
	return $wpdb->update('articles', $update, array('ID_Article' => $article->ID_Article));
}

function db_delete_article($article)
{
	global $wpdb;
	return $wpdb->delete('articles', array('ID_Article' => $article->ID_Article));
}

//Issues

function db_get_issue($ID_Issue)
{
	return db_get_issues_ext($ID_Issue)[0];
}

function db_get_issue_ext($ID_Issue)
{
	return db_get_issues_ext($ID_Issue)[0];
}

function db_get_issues_ext($ID_Issue = null)
{
	$byid = '';
	if (!is_null($ID_Issue))
		$byid = " WHERE i.ID_Issue = {$ID_Issue} ";

	global $wpdb;
	$result =  $wpdb->get_results(
		"SELECT 
			i.ID_Issue, 
			i.Title,
			i.IsActive
		FROM 
			issues i
		{$byid}
		ORDER BY 
			i.ID_Issue DESC;"
	);

	return $result;
}

function db_add_issue($issue)
{
	// global $wpdb;		
	// return $wpdb->insert('issues', $issue);
}

function db_update_issue($issue)
{
	if (!is_object($issue)) $issue = (object)$issue;
	$update = (array)$issue;

	global $wpdb;
	return $wpdb->update('issues', $update, array('ID_Issue' => $issue->ID_Issue));
}

function db_delete_issue($issue)
{
	global $wpdb;
	return $wpdb->delete('issues', array('ID_Issue' => $issue->ID_Issue));
}

//Experts

function db_get_expert($ID_Expert)
{
	return db_get_experts_ext($ID_Expert)[0];
}

function db_get_expert_ext($ID_Expert)
{
	return db_get_experts_ext($ID_Expert)[0];
}

function db_get_experts_ext($ID_Expert = null)
{
	$byid = '';
	if (!is_null($ID_Expert))
		$byid = " WHERE e.ID_Expert = {$ID_Expert} ";

	global $wpdb;
	$results = $wpdb->get_results(
		"SELECT 
			e.ID_Expert, 
			e.Name, 
			e.Mail,
			e.IsActive,
			e.Position,
			e.Interests,
			e.Phone,
			e.Comments
		FROM 
			experts e
		{$byid}
		ORDER BY
			e.ID_Expert DESC"
	);

	return $results;
}

function db_add_expert($expert)
{
	// global $wpdb;		
	// return $wpdb->insert('experts', $expert);
}

function db_update_expert($expert)
{
	if (!is_object($expert)) $expert = (object)$expert;
	$update = (array)$expert;

	global $wpdb;
	return $wpdb->update('experts', $update, array('ID_Expert' => $expert->ID_Expert));
}

function db_delete_expert($expert)
{
	global $wpdb;
	return $wpdb->delete('experts', array('ID_Expert' => $expert->ID_Expert));
}

//Verdicts	

function db_get_verdict($ID_Verdict)
{
	return db_get_verdicts_ext($ID_Verdict)[0];
}

function db_get_verdict_ext($ID_Verdict)
{
	return db_get_verdicts_ext($ID_Verdict)[0];
}

function db_get_verdicts_ext($ID_Verdict = null)
{
	$byid = '';
	if (!is_null($ID_Verdict))
		$byid = " WHERE v.ID_Verdict = {$ID_Verdict} ";

	global $wpdb;
	$result =  $wpdb->get_results(
		"SELECT 
			v.ID_Verdict, 
			v.Title
		FROM 
			verdicts v
		{$byid}
		ORDER BY 
			v.ID_Verdict DESC"
	);

	return $result;
}

function db_add_verdict($verdict)
{
	// global $wpdb;		
	// return $wpdb->insert('verdicts', $verdict);
}

function db_update_verdict($verdict)
{
	if (!is_object($verdict)) $verdict = (object)$verdict;
	$update = (array)$verdict;

	global $wpdb;
	return $wpdb->update('verdicts', $update, array('ID_Verdict' => $verdict->ID_Verdict));
}

function db_delete_verdict($verdict)
{
	global $wpdb;
	return $wpdb->delete('verdicts', array('ID_Verdict' => $verdict->ID_Verdict));
}

//Reviews

function db_get_review($ID_Review)
{
	global $wpdb;
	$result =  $wpdb->get_results(
		"SELECT 
			r.ID_Review, 
			r.ID_Article,
			r.ID_Expert,
			r.RevNo,
			r.ToExpDate, 
			r.FromExpDate, 
			r.ID_Verdict,
			r.ToAuthDate, 
			r.FromAuthDate, 
			r.RemDate,
			r.Comments 
		FROM 
			reviews r
		WHERE 
			r.ID_Review = {$ID_Review}"
	);

	return $result[0];
}

function db_get_review_ext($ID_Review)
{
	return db_get_reviews_ext($ID_Review)[0];
}

function db_get_reviews_ext($ID_Review = null)
{
	$byid = '';
	if (!is_null($ID_Review))
		$byid = " AND r.ID_Review = {$ID_Review} ";

	global $wpdb;
	$result =  $wpdb->get_results(
		"SELECT 
			r.ID_Review, 
			r.ID_Article, a.Title as ATitle,
			r.ID_Expert, e.Name as EName, 
			r.RevNo,
			r.ToExpDate, 
			r.FromExpDate, 
			r.ID_Verdict, v.Title as VTitle, 
			r.ToAuthDate, 
			r.FromAuthDate, 
			r.RemDate, 
			r.Comments 
		FROM 
			reviews r LEFT JOIN verdicts v ON r.ID_Verdict=v.ID_Verdict, 
			articles a,
			experts e			
		WHERE 
			r.ID_Expert=e.ID_Expert
			AND r.ID_Article=a.ID_Article
			{$byid}
		ORDER BY 
			r.ID_Review DESC"
	);

	return $result;
}

function db_add_review($review)
{
	// global $wpdb;
	// return $wpdb->insert('reviews', $review);
}

function db_update_review($review)
{
	if (!is_object($review)) $review = (object)$review;
	$update = (array)$review;

	global $wpdb;
	return $wpdb->update('reviews', $update, array('ID_Review' => $review->ID_Review));
}

function db_delete_review($review)
{
	global $wpdb;
	return $wpdb->delete('reviews', array('ID_Review' => $review->ID_Review));
}

//Sections

function db_get_section($ID_Section)
{
	global $wpdb;
	$result =  $wpdb->get_results(
		"SELECT 
			s.ID_Section, 
			s.Title, 
			s.ShortTitle, 
			s.ID_Expert		
		FROM 
			sections s
		WHERE 
			s.ID_Section = {$ID_Section}"
	);

	return $result[0];
}

function db_get_section_ext($ID_Section)
{
	return db_get_sections_ext($ID_Section)[0];
}

function db_get_sections_ext($ID_Section = null)
{
	$byid = '';
	if (!is_null($ID_Section))
		$byid = " WHERE s.ID_Section = {$ID_Section} ";

	global $wpdb;
	$result =  $wpdb->get_results(
		"SELECT 
			s.ID_Section, 
			s.Title, 
			s.ShortTitle, 
			s.ID_Expert, e.Name		
		FROM 
			sections s LEFT JOIN experts e ON s.ID_Expert = e.ID_Expert
		{$byid}
		ORDER BY 
			s.ID_Section"
	);

	return $result;
}

function db_add_section($section)
{
	// global $wpdb;		
	// return $wpdb->insert('sections', $section);
}

function db_update_section($section)
{
	if (!is_object($section)) $section = (object)$section;
	$update = (array)$section;

	global $wpdb;
	return $wpdb->update('sections', $update, array('ID_Section' => $section->ID_Section));
}

function db_delete_section($section)
{
	global $wpdb;
	return $wpdb->delete('sections', array('ID_Section' => $section->ID_Section));
}
