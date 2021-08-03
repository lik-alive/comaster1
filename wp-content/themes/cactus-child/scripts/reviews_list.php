<?php

include_once __DIR__ . '/general.php';
include_once __DIR__ . '/db_handler.php';


add_action('wp_ajax_reviews_list_for_article', 'reviews_list_for_article');
function reviews_list_for_article()
{
	$ID_Article = g_si($_GET['ida']);

	global $wpdb;
	$reviews = $wpdb->get_results(
		"SELECT 
			r.ID_Review,
			r.ID_Expert,
			r.RevNo,
			e.Name, 
			r.ToExpDate, 
			r.FromExpDate, 
			v.ID_Verdict, v.Title as VTitle, 
			r.ToAuthDate, 
			r.FromAuthDate, 
			r.RemDate,
			r.Comments 
		FROM 
			reviews r LEFT JOIN verdicts v ON r.ID_Verdict=v.ID_Verdict, 
			experts e
		WHERE 
			r.ID_Article={$ID_Article} AND r.ID_Expert=e.ID_Expert
		ORDER BY 
			r.RevNo DESC, r.ID_Expert, r.ID_Review DESC;"
	);

	$lastexpert = null;
	$dest = 0;
	$data0 = array();
	$data1 = array();
	$data2 = array();
	$data3 = array();
	$data4 = array();
	$data5 = array();
	$data6 = array();

	foreach ($reviews as $value) {
		if ($value->ID_Expert != $lastexpert) {
			$lastexpert = $value->ID_Expert;
			$dest = $value->ID_Verdict;
		}
		$ResultData['h_idr'] = $value->ID_Review;
		$ResultData['h_ide'] = $value->ID_Expert;
		$ResultData['h_rno'] = $value->RevNo;
		$ResultData['h_esn'] =  g_sn($value->Name);
		$ResultData['h_ted'] = g_fnd($value->ToExpDate);
		$ResultData['h_fed'] = g_fnd($value->FromExpDate);
		$ResultData['h_vt'] = $value->VTitle;
		$ResultData['h_rfs'] = sizeof(g_lf($ID_Article . '/reviews/' . $value->ID_Review));
		$ResultData['h_tad'] = g_fnd($value->ToAuthDate);
		$ResultData['h_fad'] = g_fnd($value->FromAuthDate);
		$ResultData['h_red'] = g_fnd($value->RemDate);
		$ResultData['h_cm'] = $value->Comments;

		if ($dest == 6) $data6[] = $ResultData; //снят
		else if ($dest == 5) $data5[] = $ResultData; //отказ
		else if ($dest == 4) $data4[] = $ResultData; //не рекомендуется
		else if ($dest == 3) $data3[] = $ResultData; //переделать
		else if ($dest == 2) $data2[] = $ResultData; //подправить
		else if ($dest == 1) $data1[] = $ResultData; //добро
		else $data0[] = $ResultData; //null
	}

	$data = array_merge($data0, $data4, $data3, $data2, $data1, $data5, $data6);
	//$data = $data0;

	$rowscount = sizeof($reviews);
	$json_data = array(
		"draw"            => intval($_REQUEST['draw']),
		"recordsTotal"    => intval($rowscount),
		"recordsFiltered" => intval($rowscount),
		"data"            => $data,
	);

	echo json_encode($json_data);
	exit();
}
