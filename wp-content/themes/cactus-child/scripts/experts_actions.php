<?php

include_once __DIR__ . '/general.php';
include_once __DIR__ . '/db_handler.php';

add_action('wp_ajax_experts_payment_broadcast', 'experts_payment_broadcast');
function experts_payment_broadcast()
{

	$myrows = experts_payment_interval(7, 12, '2017-01-01', '2017-12-01');

	foreach ($myrows as $value) {
		$totalcount = $value->FirstPublishedCount + $value->FirstOtherCount + $value->SecondPublishedCount + $value->SecondOtherCount;
		if ($totalcount == 0) continue;

		//printf( $value->Name.' '.$value->Mail.' '.$value->FirstPublishedCount.';' ); 
		$expert = db_get_expert($value->ID_Expert);
		letter_toexpert_payment($expert);
		//exit();
	}

	printf('<p class = "bg-success">%s</p>', 'Рассылка выполнена');
	exit();
}
