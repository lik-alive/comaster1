<?php

include_once __DIR__ . '/general.php';

function tables_list_article()
{
	$myrows =  db_get_articles_ext();

	foreach ($myrows as $value) {
		$ResultData['h_ida'] = $value->ID_Article;
		$ResultData['h_iss'] = $value->ITitle;
		$ResultData['h_sec'] = $value->SSTitle;
		$ResultData['h_sqn'] = $value->SeqNumber;
		$ResultData['h_aut'] = $value->Authors;
		$ResultData['h_tit'] = g_cfl($value->Title);
		$ResultData['h_aff'] = $value->Affiliation;
		$ResultData['h_pgc'] = $value->PageCount;
		$ResultData['h_rec'] = date('d-m-Y', strtotime($value->RecvDate));
		$ResultData['h_can'] = $value->CorName;
		$ResultData['h_cam'] = $value->CorMail;
		$ResultData['h_rad'] = $value->RemDate;
		$ResultData['h_ira'] = $value->IsRevApproved;
		$ResultData['h_ita'] = $value->IsTechApproved;
		$ResultData['h_lan'] = $value->Language;
		$ResultData['h_com'] = $value->Comments;
		$data[] = $ResultData;
	}

	return json_encode($data);
}

function tables_list_expert()
{
	$myrows =  db_get_experts_ext();

	foreach ($myrows as $value) {
		$ResultData['h_ide'] = $value->ID_Expert;
		$ResultData['h_nam'] = $value->Name;
		$ResultData['h_mai'] = $value->Mail;
		$ResultData['h_isa'] = $value->IsActive;
		$ResultData['h_pos'] = $value->Position;
		$ResultData['h_int'] = $value->Interests;
		$ResultData['h_phn'] = $value->Phone;
		$ResultData['h_com'] = $value->Comments;
		$data[] = $ResultData;
	}

	return json_encode($data);
}

function tables_list_section()
{
	$myrows =  db_get_sections_ext();

	foreach ($myrows as $value) {
		$ResultData['h_ids'] = $value->ID_Section;
		$ResultData['h_tit'] = $value->Title;
		$ResultData['h_sht'] = $value->ShortTitle;
		$ResultData['h_exp'] = $value->Name;
		$data[] = $ResultData;
	}

	return json_encode($data);
}

function tables_list_issue()
{
	$myrows =  db_get_issues_ext();

	foreach ($myrows as $value) {
		$ResultData['h_idi'] = $value->ID_Issue;
		$ResultData['h_tit'] = $value->Title;
		$ResultData['h_isa'] = $value->IsActive;
		$data[] = $ResultData;
	}

	return json_encode($data);
}

function tables_list_verdict()
{
	$myrows =  db_get_verdicts_ext();

	foreach ($myrows as $value) {
		$ResultData['h_idv'] = $value->ID_Verdict;
		$ResultData['h_tit'] = $value->Title;
		$data[] = $ResultData;
	}

	return json_encode($data);
}

function tables_list_review()
{
	$myrows =  db_get_reviews_ext();

	foreach ($myrows as $value) {
		$ResultData['h_idr'] = $value->ID_Review;
		$ResultData['h_att'] = $value->ID_Article;
		$ResultData['h_enm'] = $value->EName;
		$ResultData['h_rno'] = $value->RevNo;
		$ResultData['h_ted'] = g_fnd($value->ToExpDate);
		$ResultData['h_fed'] = g_fnd($value->FromExpDate);
		$ResultData['h_vtt'] = $value->VTitle;
		$ResultData['h_tad'] = g_fnd($value->ToAuthDate);
		$ResultData['h_fad'] = g_fnd($value->FromAuthDate);
		$ResultData['h_rex'] = g_fnd($value->RemDate);
		$ResultData['h_com'] = $value->Comments;
		$data[] = $ResultData;
	}

	return json_encode($data);
}

function tables_list_article_ids_tostr()
{
	global $wpdb;
	$result = $wpdb->get_results(
		"SELECT 
			a.ID_Article, 
			a.Title 
		FROM 
			articles a"
	);

	foreach ($result as $item) {
		$item->Title = g_cfl(mb_substr($item->Title, 0, 60) . '...');
	}

	return $result;
}

function tables_list_expert_ids_tostr()
{
	global $wpdb;
	return $wpdb->get_results(
		"SELECT 
			e.ID_Expert, 
			e.Name 
		FROM 
			experts e
		WHERE
			e.IsActive = 'Y'
		ORDER BY 
			e.Name"
	);
}

function tables_list_issue_ids_tostr()
{
	global $wpdb;
	return $wpdb->get_results(
		"SELECT 
			i.ID_Issue, 
			i.Title 
		FROM 
			issues i"
	);
}

function tables_list_section_ids_tostr()
{
	global $wpdb;
	return $wpdb->get_results(
		"SELECT 
			s.ID_Section, 
			s.Title 
		FROM 
			sections s"
	);
}

function tables_list_verdict_ids_tostr()
{
	global $wpdb;
	return $wpdb->get_results(
		"SELECT 
			v.ID_Verdict, 
			v.Title 
		FROM 
			verdicts v"
	);
}
