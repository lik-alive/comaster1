<?php

include_once __DIR__ . '/general.php';
include_once __DIR__ . '/db_handler.php';

add_action('wp_ajax_articles_list', 'articles_list');
function articles_list()
{
	$ID_Section = g_si($_GET['ids']);
	$wsc = g_wsc($ID_Section);
	$ID_Issue = g_si($_GET['idi']);
	$wis = g_wis($ID_Issue);

	global $wpdb;

	$myrows =  $wpdb->get_results(
		"SELECT 
			a.ID_Article, 
			a.SeqNumber,
			a.Authors, 
			a.Title,
			a.RecvDate, 
			a.IsRevApproved, 
			a.IsTechApproved, 
			a.ID_Section,
			s.ShortTitle as SSTitle,
			a.ID_Issue,
			i.Title as ITitle,
			i.IsActive as IIsActive,
			rl.LastDate
		FROM 
			articles a
			
			INNER JOIN
				issues i ON i.ID_Issue = a.ID_Issue
			
			LEFT JOIN 
				(SELECT
					r.ID_Article, 
					MAX(r.FromExpDate) as LastDate
				FROM
					reviews r
				GROUP BY
					r.ID_Article
				) rl ON a.ID_Article = rl.ID_Article,
			sections s
		WHERE 			
			a.ID_Section=s.ID_Section {$wis} {$wsc} 
		ORDER BY 
			i.ID_Issue DESC, a.IsRevApproved DESC, a.IsTechApproved DESC, a.ID_Section, a.RecvDate;"
	);

	$data = array();
	foreach ($myrows as $value) {
		$end = time();
		$recv = strtotime($value->RecvDate);

		$ResultData['h_ida'] = $value->ID_Article;
		$ResultData['h_sno'] = $value->SeqNumber;
		$ResultData['h_sec'] = $value->SSTitle;
		$ResultData['h_aut'] = $value->Authors;
		$ResultData['h_ids'] = $value->ID_Section;
		$ResultData['h_tit'] = g_cfl($value->Title);
		$ResultData['h_tmd'] = floor(($end - $recv) / (60 * 60 * 24));
		$ResultData['h_ast'] = $value->IsRevApproved . $value->IsTechApproved;
		$ResultData['h_idi'] = $value->ID_Issue;
		$ResultData['h_iti'] = $value->ITitle;
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

add_action('wp_ajax_articles_list_mtng', 'articles_list_mtng');
function articles_list_mtng()
{
	global $wpdb;

	$myrows =  $wpdb->get_results(
		"SELECT 
			a.ID_Article, 
			a.SeqNumber,
			a.Authors, 
			a.Title, 
			a.PageCount,
			a.RecvDate, 
			a.IsRevApproved, 
			a.IsTechApproved, 
			a.ID_Section,
			s.ShortTitle as SSTitle,
			a.ID_Issue,
			i.Title as ITitle,
			i.IsActive as IIsActive,
			rl.LastDate
		FROM 
			articles a
			
			INNER JOIN
				issues i ON i.ID_Issue = a.ID_Issue
			
			LEFT JOIN 
				(SELECT
					r.ID_Article, 
					MAX(r.FromExpDate) as LastDate
				FROM
					reviews r
				GROUP BY
					r.ID_Article
				) rl ON a.ID_Article = rl.ID_Article,
			sections s
		WHERE 			
			a.ID_Section=s.ID_Section AND a.IsRevApproved = 'Y' AND i.IsActive = 'Y'
		ORDER BY 
			i.ID_Issue DESC, a.IsRevApproved DESC, a.IsTechApproved DESC, a.ID_Section, a.RecvDate;"
	);

	$data = array();
	foreach ($myrows as $value) {
		$end = time();
		$recv = strtotime($value->RecvDate);

		$ResultData['h_ida'] = $value->ID_Article;
		$ResultData['h_sno'] = $value->SeqNumber;
		$ResultData['h_sec'] = $value->SSTitle;
		$ResultData['h_aut'] = $value->Authors;
		$ResultData['h_pac'] = $value->PageCount;
		$ResultData['h_ids'] = $value->ID_Section;
		$ResultData['h_tit'] = g_cfl($value->Title);
		$ResultData['h_tmd'] = floor(($end - $recv) / (60 * 60 * 24));
		$ResultData['h_ast'] = $value->IsRevApproved . $value->IsTechApproved;
		$ResultData['h_idi'] = $value->ID_Issue;
		$ResultData['h_iti'] = $value->ITitle;
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

function articles_list_late($idsec)
{
	$wsc = g_wsc($idsec);

	global $wpdb;
	$myrows =  $wpdb->get_results(

		"SELECT *
		FROM
			(SELECT 
				a.ID_Article,
				s.ShortTitle as SSTitle,
				MAX(r.ToAuthDate) as LateToAuthDate,
				a.CorName,
				a.RemDate,
				a.Comments,
				a.Authors,
				a.Title
			FROM 
				reviews r, articles a, sections s, issues i
			WHERE 
				a.ID_Article = r.ID_Article AND a.ID_Section = s.ID_Section AND a.ID_Issue = i.ID_Issue AND
				i.IsActive = 'Y' AND
				a.IsRevApproved = 'N' AND
				r.ID_Verdict <> 1 AND
				r.ToAuthDate IS NOT NULL AND r.FromAuthDate IS NULL AND
				DATE_ADD(r.ToAuthDate, INTERVAL 20 DAY) <= CURDATE() AND
				(a.RemDate IS NULL OR DATE_ADD(a.RemDate, INTERVAL 7 DAY) <= CURDATE())
				{$wsc}
			GROUP BY 
				a.ID_Article) f
		ORDER BY 
			f.LateToAuthDate DESC"
	);


	foreach ($myrows as $value) {
		$ResultData['h_ida'] = $value->ID_Article;
		$ResultData['h_sec'] = $value->SSTitle;
		$ResultData['h_cor'] = $value->CorName;
		$ResultData['h_tad'] = date('d-m-Y', strtotime($value->LateToAuthDate));
		$ResultData['h_lad'] = date('d-m-Y', strtotime($value->LateToAuthDate . '+31 days'));
		$ResultData['h_com'] = $value->Comments;
		$ResultData['h_aut'] = $value->Authors;
		$ResultData['h_tit'] = g_cfl($value->Title);
		$ResultData['h_rad'] = g_fnd($value->RemDate);
		$data[] = $ResultData;
	}

	return json_encode($data);
}

add_action('wp_ajax_articles_list_for_expert', 'articles_list_for_expert');
function articles_list_for_expert()
{
	$ID_Expert = g_si($_GET['ide']);

	global $wpdb;

	$myrows =  $wpdb->get_results(
		"SELECT 
			a.ID_Article,
			a.Title,
			a.ID_Issue,
			a.IsRevApproved
		FROM 
			articles a INNER JOIN reviews r ON a.ID_Article = r.ID_Article 
		WHERE 			
			r.ID_Expert = {$ID_Expert}
		GROUP BY 
			a.ID_Article
		ORDER BY
			a.IsRevApproved"
	);

	$data = array();
	foreach ($myrows as $value) {
		$ResultData['h_ida'] = $value->ID_Article;
		$ResultData['h_tit'] = g_cfl($value->Title);
		$ResultData['h_idi'] = $value->ID_Issue;
		$ResultData['h_ira'] = $value->IsRevApproved;
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
