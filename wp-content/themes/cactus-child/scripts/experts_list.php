<?php

include_once __DIR__ . '/general.php';
include_once __DIR__ . '/db_handler.php';

add_action('wp_ajax_experts_list', 'experts_list');
function experts_list()
{
	$keyword = g_si($_GET['kw']);

	if (mb_strlen($keyword) >= 6)
		$keyword = mb_substr($keyword, 0, mb_strlen($keyword) - 2);

	global $wpdb;

	if ($keyword == '') {
		$myrows =  $wpdb->get_results(
			"SELECT 
				e.ID_Expert, 
				e.Name,
				e.Mail,
				e.Position,
				e.Interests, 
				e.Phone, 
				e.Comments
			FROM 
				experts e 
			WHERE 			
				e.IsActive = 'Y'"
		);
	} else {
		$myrows =  $wpdb->get_results(
			"SELECT 
				e.ID_Expert, 
				e.Name,
				e.Mail,
				e.Interests, 
				e.Phone, 
				e.Comments
			FROM 
				experts e 
				LEFT JOIN reviews r ON e.ID_Expert = r.ID_Expert
				LEFT JOIN articles a ON r.ID_Article = a.ID_Article
			WHERE 			
				e.IsActive = 'Y'
				AND (
					e.Name LIKE '%{$keyword}%' 
					OR e.Interests LIKE '%{$keyword}%'
					OR (
						a.Title LIKE '%{$keyword}%' 
						AND (r.ID_Verdict IS NULL OR r.ID_Verdict <> 5)
						)
					)
			GROUP BY
				e.ID_Expert"
		);
	}

	$data = array();
	foreach ($myrows as $value) {
		$ResultData['h_ide'] = $value->ID_Expert;
		$ResultData['h_nam'] = $value->Name;
		$ResultData['h_eml'] = $value->Mail;
		$ResultData['h_pos'] = $value->Position;
		$ResultData['h_int'] = $value->Interests;
		$ResultData['h_phn'] = $value->Phone;
		$ResultData['h_com'] = $value->Comments;
		$ResultData['h_rat'] = experts_list_rate_inner($value->ID_Expert)[0]['h_rat'];
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

function experts_list_rate_inner($ID_Expert)
{
	global $wpdb;
	$wex = g_wex($ID_Expert);

	$myrows =  $wpdb->get_results(
		"SELECT e.ID_Expert, e.Name,
			rd.CurCount, rf.FiredCount, rl.LeftCount, ra.ApproveCount, rc.CorrectCount,
			rad.AvgDays
		FROM
			experts e 
			
			LEFT JOIN (
			SELECT 
				e.ID_Expert,
				COUNT(e.ID_Expert) as CurCount
			FROM (
				SELECT
					e.ID_Expert
				FROM 
					experts e, articles a INNER JOIN issues i ON a.ID_Issue = i.ID_Issue, reviews r
				WHERE 
					e.ID_Expert = r.ID_Expert AND r.ID_Article = a.ID_Article {$wex}
					AND i.IsActive = 'Y' AND 
					r.ID_Expert NOT IN (
						SELECT
							r1.ID_Expert
						FROM
							reviews r1
						WHERE
							r1.ID_Article = r.ID_Article AND (r1.ID_Verdict = 1 OR r1.ID_Verdict = 5 OR r1.ID_Verdict = 6)
					)
				GROUP BY
					e.ID_Expert, a.ID_Article) e
			GROUP BY
				e.ID_Expert) rd ON e.ID_Expert = rd.ID_Expert
			
			LEFT JOIN
			(SELECT 
				e.ID_Expert,
				COUNT(r.ID_Review) as FiredCount
			FROM 
				experts e, reviews r
			WHERE 
				e.ID_Expert = r.ID_Expert AND r.ID_Verdict = 6 {$wex}
			GROUP BY
				e.ID_Expert) rf ON e.ID_Expert = rf.ID_Expert
			
			LEFT JOIN
			(SELECT 
				e.ID_Expert,
				COUNT(r.ID_Review) as LeftCount
			FROM 
				experts e, reviews r
			WHERE 
				e.ID_Expert = r.ID_Expert AND r.ID_Verdict = 5 {$wex}
			GROUP BY
				e.ID_Expert) rl ON e.ID_Expert = rl.ID_Expert
				
			LEFT JOIN
			(SELECT 
				e.ID_Expert,
				COUNT(r.ID_Review) as ApproveCount
			FROM 
				experts e, reviews r
			WHERE 
				e.ID_Expert = r.ID_Expert AND r.ID_Verdict = 1 {$wex}
			GROUP BY
				e.ID_Expert) ra ON e.ID_Expert = ra.ID_Expert
				
			LEFT JOIN
			(SELECT 
				e.ID_Expert,
				COUNT(r.ID_Review) as CorrectCount
			FROM 
				experts e, reviews r
			WHERE 
				e.ID_Expert = r.ID_Expert AND r.ID_Verdict > 1 AND r.ID_Verdict < 5 {$wex}
			GROUP BY
				e.ID_Expert) rc ON e.ID_Expert = rc.ID_Expert
				
			LEFT JOIN
			(SELECT 
				e.ID_Expert,
				AVG(DATEDIFF(r.FromExpDate, r.ToExpDate)) as AvgDays
			FROM 
				experts e, reviews r
			WHERE 
				e.ID_Expert = r.ID_Expert AND r.ToExpDate IS NOT NULL AND r.FromExpDate IS NOT NULL 
				AND r.ID_Verdict != 5 {$wex}
			GROUP BY
				e.ID_Expert) rad ON e.ID_Expert = rad.ID_Expert
		WHERE 
			e.ID_Expert > 0 {$wex}
		ORDER BY
			e.ID_Expert DESC"
	);

	$data = array();
	foreach ($myrows as $value) {
		$ResultData['h_ide'] = $value->ID_Expert;
		$ResultData['h_nam'] = $value->Name;
		$ResultData['h_cct'] = $value->CurCount;

		$total = $value->CorrectCount + $value->ApproveCount + $value->FiredCount + $value->LeftCount;

		$ResultData['h_tct'] = $total;
		$ResultData['h_avg'] = $total == 0  ? 'n/a' : sprintf("%.0f", $value->AvgDays);

		if ($total == null) $ResultData['h_rat'] = 0;
		else {
			$good = $value->CorrectCount + 0.8 * $value->ApproveCount;
			$bad = 0.5 * $value->LeftCount + 0.1 * $value->FiredCount;

			if ($value->AvgDays > 14) $coef = 14 / $value->AvgDays;
			else $coef = 1;

			$rate = ($good * $coef + $bad) / $total;
			$ResultData['h_rat'] = sprintf("%.0f", $rate * 100);
		}
		$data[] = $ResultData;
	}
	return $data;
}

add_action('wp_ajax_experts_list_rate', 'experts_list_rate');
function experts_list_rate()
{
	$data = experts_list_rate_inner(null);

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

function experts_list_late($idsec)
{
	$wsc = g_wsc($idsec);

	global $wpdb;
	$myrows =  $wpdb->get_results(
		"SELECT 
			r.ID_Article,
			r.ID_Review, 
			s.ShortTitle as SSTitle, 
			e.Name, 
			r.ToExpDate, 
			r.Comments as RComments, 
			a.Authors, 
			a.Title, 
			r.RemDate
		FROM 
			articles a INNER JOIN issues i ON a.ID_Issue = i.ID_Issue, sections s, reviews r, experts e 
		WHERE 
			a.ID_Section=s.ID_Section AND a.ID_Article=r.ID_Article AND r.ID_Expert = e.ID_Expert AND
			i.IsActive = 'Y' AND
			r.ToExpDate IS NOT NULL AND r.FromExpDate IS NULL AND 
			DATE_ADD(r.ToExpDate, INTERVAL 10 DAY) <= CURDATE() AND
			(r.RemDate IS NULL OR DATE_ADD(r.RemDate, INTERVAL 3 DAY) <= CURDATE())
			{$wsc}
		ORDER BY 
			r.ToExpDate DESC, s.ID_Section;"
	);


	foreach ($myrows as $value) {
		$ResultData['h_ida'] = $value->ID_Article;
		$ResultData['h_idr'] = $value->ID_Review;
		$ResultData['h_sec'] = $value->SSTitle;
		$ResultData['h_rsn'] = $value->Name;
		$ResultData['h_ted'] = date('d-m-Y', strtotime($value->ToExpDate));
		$ResultData['h_lrd'] = date('d-m-Y', strtotime($value->ToExpDate . '+14 days'));
		$ResultData['h_rcm'] = $value->RComments;
		$ResultData['h_aut'] = $value->Authors;
		$ResultData['h_tit'] = g_cfl($value->Title);
		$ResultData['h_red'] = g_fnd($value->RemDate);
		$data[] = $ResultData;
	}

	return json_encode($data);
}

$frp = 500;
$srp = 200;

function experts_payment_freview()
{
	global $frp;
	return $frp;
}

function experts_payment_sreview()
{
	global $srp;
	return $srp;
}

function experts_payment_interval($fromIDIssue, $toIDIssue, $fromOtherDate, $toOtherDate)
{
	global $wpdb;

	$query =
		"SELECT e.ID_Expert, e.Name, e.Mail, rfp.FirstPublishedCount, rsp.SecondPublishedCount,
			rfo.FirstOtherCount, rso.SecondOtherCount
		FROM 
			experts e
			
			LEFT JOIN		
			(SELECT
				rc.ID_Expert, COUNT(rc.ID_Expert) as FirstPublishedCount
			FROM
				(SELECT 
					r.ID_Expert, r.ID_Article, MAX(r.ID_Review) as MaxReview
				FROM 
					reviews r INNER JOIN articles a ON r.ID_Article = a.ID_Article
				WHERE
					a.ID_Issue >= {$fromIDIssue} AND a.ID_Issue <= {$toIDIssue}
				GROUP BY
					r.ID_Expert, r.ID_Article
				) rc
			WHERE
				rc.MaxReview NOT IN
					(SELECT 
						r.ID_Review
					FROM 
						reviews r
					WHERE
						r.ID_Verdict > 4
					)
			GROUP BY
				rc.ID_Expert
			) rfp ON e.ID_Expert = rfp.ID_Expert
				
			LEFT JOIN
			(SELECT
				rc.ID_Expert, COUNT(rc.ID_Expert) as SecondPublishedCount
			FROM
				(SELECT 
					r.ID_Expert, r.ID_Article, MAX(r.ID_Review) as MaxReview, COUNT(r.ID_Review) as StageCount
				FROM 
					reviews r INNER JOIN articles a ON r.ID_Article = a.ID_Article
				WHERE
					a.ID_Issue >= {$fromIDIssue} AND a.ID_Issue <= {$toIDIssue} AND r.ID_Verdict > 1
				GROUP BY
					r.ID_Expert, r.ID_Article
				) rc
			WHERE
				rc.MaxReview NOT IN
					(SELECT 
						r.ID_Review
					FROM 
						reviews r
					WHERE
						r.ID_Verdict > 4
					)
				AND 
				rc.StageCount > 1
			GROUP BY
				rc.ID_Expert
			) rsp ON e.ID_Expert = rsp.ID_Expert
			
				
			LEFT JOIN		
			(SELECT
				rc.ID_Expert, COUNT(rc.ID_Expert) as FirstOtherCount
			FROM
				(SELECT 
					r.ID_Expert, r.ID_Article, MAX(r.ID_Review) as MaxReview
				FROM 
					reviews r INNER JOIN articles a ON r.ID_Article = a.ID_Article
				WHERE
					a.ID_Issue >= 1 AND a.ID_Issue <= 2
				GROUP BY
					r.ID_Expert, r.ID_Article
				) rc
			WHERE
				rc.ID_Article IN 
                	(SELECT
                     	r.ID_Article
                     FROM
                     	reviews r
                     WHERE
                     	r.FromExpDate >= '{$fromOtherDate}' AND r.FromExpDate <= '{$toOtherDate}'
                     )
                AND
				rc.MaxReview NOT IN
					(SELECT 
						r.ID_Review
					FROM 
						reviews r
					WHERE
						r.ID_Verdict > 4
					)
			GROUP BY
            	rc.ID_Expert) rfo ON e.ID_Expert = rfo.ID_Expert
				
			LEFT JOIN
			(SELECT
				rc.ID_Expert, COUNT(rc.ID_Expert) as SecondOtherCount
			FROM
				(SELECT 
					r.ID_Expert, r.ID_Article, MAX(r.ID_Review) as MaxReview, COUNT(r.ID_Review) as StageCount
				FROM 
					reviews r INNER JOIN articles a ON r.ID_Article = a.ID_Article
				WHERE
					a.ID_Issue >= 1 AND a.ID_Issue <= 2 AND r.ID_Verdict > 1
				GROUP BY
					r.ID_Expert, r.ID_Article
				) rc
			WHERE
				rc.ID_Article IN 
                	(SELECT
                     	r.ID_Article
                     FROM
                     	reviews r
                     WHERE
                     	r.FromExpDate >= '{$fromOtherDate}' AND r.FromExpDate <= '{$toOtherDate}'
                     )
                AND
				rc.MaxReview NOT IN
					(SELECT 
						r.ID_Review
					FROM 
						reviews r
					WHERE
						r.ID_Verdict > 4
					)
                    AND
				rc.StageCount > 1
			GROUP BY
            	rc.ID_Expert
			) rso ON e.ID_Expert = rso.ID_Expert";

	$myrows =  $wpdb->get_results($query);

	return $myrows;
}

function experts_payment_sum($myrows)
{
	global $frp, $srp;
	$totalPublished = 0;
	$totalOthers = 0;
	foreach ($myrows as $value) {
		$totalPublished += $value->FirstPublishedCount * $frp + $value->SecondPublishedCount * $srp;
		$totalOthers += $value->FirstOtherCount * $frp + $value->SecondOtherCount * $srp;
	}
	return array($totalPublished, $totalOthers);
}

function experts_payment_total()
{
	global $wpdb;

	$res = experts_payment_sum(experts_payment_interval(7, 12, '2017-01-01', '2017-12-01'));

	return $res[0] + $res[1];
}

function experts_payment_prediction()
{
	global $frp, $srp;

	$res = '';
	$sum = 0;
	$maxpayment = 0;
	for ($i = 7; $i <= 12; $i++) {
		$res = experts_payment_sum(experts_payment_interval($i, $i, '2017-01-01', date('Y-m-d')));

		if ($i == 7) $sum += $res[1];

		if ($maxpayment < $res[0]) $maxpayment = $res[0];

		if ($res[0] == 0)
			$sum += $maxpayment;
		else
			$sum += $res[0];
	}

	return $sum;
}

add_action('wp_ajax_experts_list_payment', 'experts_list_payment');
function experts_list_payment()
{
	global $wpdb;

	$myrows = experts_payment_interval(7, 12, '2017-01-01', date('Y-m-d'));

	global $frp, $srp;

	$data = array();
	foreach ($myrows as $value) {
		$totalcount = $value->FirstPublishedCount + $value->FirstOtherCount + $value->SecondPublishedCount + $value->SecondOtherCount;
		if ($totalcount == 0) continue;

		$ResultData['h_ide'] = $value->ID_Expert;
		$ResultData['h_nam'] = $value->Name;
		$ResultData['h_fct'] = $value->FirstPublishedCount + $value->FirstOtherCount;
		$ResultData['h_sct'] = $value->SecondPublishedCount + $value->SecondOtherCount;
		$ResultData['h_pay'] = ($value->FirstPublishedCount + $value->FirstOtherCount) * $frp +
			($value->SecondPublishedCount + $value->SecondOtherCount) * $srp;
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
