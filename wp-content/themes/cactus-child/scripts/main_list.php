<?php

include_once __DIR__ . '/general.php';

function main_list_nst_articles_count($idsec)
{
	$wsc = g_wsc($idsec);
	global $wpdb;
	$result =  $wpdb->get_results(
		"SELECT 
			COUNT(a.ID_Article) as RCount
		FROM
			articles a INNER JOIN issues i ON a.ID_Issue = i.ID_Issue
		WHERE 
			i.IsActive = 'Y'
			{$wsc}"
	);

	return $result[0]->RCount;
}

function main_list_nst_articles_approved_count($idsec)
{
	$wsc = g_wsc($idsec);
	global $wpdb;
	$result =  $wpdb->get_results(
		"SELECT 
			COUNT(a.ID_Article) as RCount
		FROM
			articles a INNER JOIN issues i ON a.ID_Issue = i.ID_Issue
		WHERE 
			i.IsActive = 'Y' AND a.IsRevApproved = 'Y' AND a.IsTechApproved = 'Y' 
			{$wsc}"
	);

	return $result[0]->RCount;
}

function main_list_nst_articles_revapproved_count($idsec)
{
	$wsc = g_wsc($idsec);
	global $wpdb;
	$result =  $wpdb->get_results(
		"SELECT 
		COUNT(a.ID_Article) as RCount
		FROM
			articles a INNER JOIN issues i ON a.ID_Issue = i.ID_Issue
		WHERE 
			i.IsActive = 'Y' AND a.IsRevApproved = 'Y' 
			{$wsc}"
	);

	return $result[0]->RCount;
}

function main_list_nst_articles_techapproved_count($idsec)
{
	$wsc = g_wsc($idsec);
	global $wpdb;
	$result =  $wpdb->get_results(
		"SELECT 
			COUNT(a.ID_Article) as RCount
		FROM
			articles a INNER JOIN issues i ON a.ID_Issue = i.ID_Issue
		WHERE 
			i.IsActive = 'Y' AND a.IsTechApproved = 'Y' 
			{$wsc}"
	);

	return $result[0]->RCount;
}

function main_list_nst_articles_one_positive_count($idsec)
{
	$wsc = g_wsc($idsec);
	global $wpdb;
	$result =  $wpdb->get_results(
		"SELECT 
			COUNT(ra.ID_Article) as RCount
		FROM
			(SELECT 
				a.ID_Article
			FROM
				articles a INNER JOIN reviews r ON a.ID_Article = r.ID_Article INNER JOIN issues i ON a.ID_Issue = i.ID_Issue
			WHERE 
				i.IsActive = 'Y' AND r.ID_Verdict = 1
				{$wsc}
			GROUP BY
				a.ID_Article) as ra"
	);

	return $result[0]->RCount;
}

add_action('wp_ajax_main_list_nst_new_articles', 'main_list_nst_new_articles');
function main_list_nst_new_articles()
{
	$idsec = $_GET['id'];
	$wsc = g_wsc($idsec);

	global $wpdb;
	$myrows =  $wpdb->get_results(
		"SELECT 
			a.ID_Article, 
			a.Authors, 
			a.Title, 
			a.RecvDate,
			s.ShortTitle as SSTitle
		FROM 
			articles a INNER JOIN issues i ON a.ID_Issue = i.ID_Issue, sections s
		WHERE 
			a.ID_Section=s.ID_Section AND i.IsActive = 'Y'
			AND a.ID_Article NOT IN (SELECT ID_Article FROM reviews) 
			{$wsc} 
		ORDER BY
			a.RecvDate;"
	);

	$data = array();

	foreach ($myrows as $value) {
		$ResultData['h_ida'] = $value->ID_Article;
		$ResultData['h_sec'] = $value->SSTitle;
		$ResultData['h_aut'] = $value->Authors;
		$ResultData['h_tit'] = g_cfl($value->Title);
		$ResultData['h_rec'] = date('d-m-Y', strtotime($value->RecvDate));
		$data[] = $ResultData;
	}

	$rowscount = sizeof($data);
	$json_data = array(
		"draw"            => intval($_REQUEST['draw']),
		"recordsTotal"    => intval($rowscount),
		"recordsFiltered" => intval($rowscount),
		"data"            => $data,
	);

	echo json_encode($json_data);
	exit();
}

add_action('wp_ajax_main_list_nst_require_revapprove_articles', 'main_list_nst_require_revapprove_articles');
function main_list_nst_require_revapprove_articles()
{
	$idsec = $_GET['id'];
	$wsc = g_wsc($idsec);

	global $wpdb;
	$finished =  $wpdb->get_results(
		"SELECT 
			a.ID_Article, 
			a.Authors, 
			a.Title,
			s.ShortTitle as SSTitle,
			r.ID_Verdict, v.Title as VTitle
		FROM 
			articles a 
            INNER JOIN issues i ON a.ID_Issue = i.ID_Issue
            INNER JOIN sections s ON a.ID_Section = s.ID_Section
            INNER JOIN reviews r ON a.ID_Article = r.ID_Article
			LEFT JOIN verdicts v ON r.ID_Verdict = v.ID_Verdict
		WHERE 
			i.IsActive = 'Y' 
			AND a.IsRevApproved = 'N'
			AND r.ID_Review IN (
				SELECT 
					MAX(r.ID_Review)
				FROM 
					reviews r
				GROUP BY 
					r.ID_Article, r.ID_Expert
			)
			AND a.ID_Article NOT IN (
				SELECT r.ID_Article
				FROM
					(SELECT 
						MAX(r.ID_Review) as MID_Review
					FROM 
						reviews r            
					GROUP BY 
						r.ID_Article, r.ID_Expert) mr
					INNER JOIN reviews r ON r.ID_Review = mr.MID_Review
				WHERE 
					r.ID_Verdict IS NULL 
					OR ((r.ID_Verdict = 2 OR r.ID_Verdict = 3) AND r.ToAuthDate IS NOT NULL)
			)
			{$wsc}
		ORDER BY
			a.ID_Article;"
	);

	$data = array();

	$lastidarticle = null;
	$lastno = -1;
	foreach ($finished as $value) {
		if ($lastidarticle !== $value->ID_Article) {
			$lastidarticle = $value->ID_Article;
			$ResultData['h_ida'] = $value->ID_Article;
			$ResultData['h_sec'] = $value->SSTitle;
			$ResultData['h_aut'] = $value->Authors;
			$ResultData['h_tit'] = g_cfl($value->Title);
			$ResultData['h_ver'] = '';
			$data[] = $ResultData;
			$lastno++;
		}

		$data[$lastno]['h_ver'] .= $value->VTitle . "<br>";
	}

	$rowscount = sizeof($data);
	$json_data = array(
		"draw"            => intval($_REQUEST['draw']),
		"recordsTotal"    => intval($rowscount),
		"recordsFiltered" => intval($rowscount),
		"data"            => $data,
	);

	echo json_encode($json_data);
	exit();
}

add_action('wp_ajax_main_list_nst_require_techapprove_articles', 'main_list_nst_require_techapprove_articles');
function main_list_nst_require_techapprove_articles()
{
	$idsec = $_GET['id'];
	$wsc = g_wsc($idsec);

	global $wpdb;
	$myrows =  $wpdb->get_results(
		"SELECT 
			a.ID_Article, 
			a.Authors, 
			a.Title,
			s.ShortTitle as SSTitle,
			a.RecvDate,
			lr.MaxDate
		FROM
			sections s, 
			articles a INNER JOIN issues i ON a.ID_Issue = i.ID_Issue 
			LEFT JOIN (
				SELECT
					r.ID_Article,
					MAX(r.FromAuthDate) MaxDate
				FROM
					reviews r
				GROUP BY 
					r.ID_Article
				) lr ON a.ID_Article = lr.ID_Article
				
		WHERE 
			a.ID_Section=s.ID_Section
			AND i.IsActive = 'Y' 
			AND a.IsRevApproved = 'Y'
			AND a.IsTechApproved = 'N'
		ORDER BY
			a.ID_Article"
	);

	$data = array();

	foreach ($myrows as $value) {
		$ResultData['h_ida'] = $value->ID_Article;
		$ResultData['h_sec'] = $value->SSTitle;
		$ResultData['h_aut'] = $value->Authors;
		$ResultData['h_tit'] = g_cfl($value->Title);
		if ($value->MaxDate != '')
			$ResultData['h_mxd'] = date('d-m-Y', strtotime($value->MaxDate));
		else
			$ResultData['h_mxd'] = date('d-m-Y', strtotime($value->RecvDate));
		$data[] = $ResultData;
	}

	$rowscount = sizeof($data);
	$json_data = array(
		"draw"            => intval($_REQUEST['draw']),
		"recordsTotal"    => intval($rowscount),
		"recordsFiltered" => intval($rowscount),
		"data"            => $data,
	);

	echo json_encode($json_data);
	exit();
}
