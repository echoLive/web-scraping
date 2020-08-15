<?php
include_once 'database.php';
include_once 'analysis.php';
include_once 'getFileDate.php';

	$sql_1 = "SELECT MIN(update_date) FROM prices WHERE market_id = '10' ";
			$get_max_result = mysqli_query($connect, $sql_1);
			$value = mysqli_fetch_row($get_max_result);

			echo ($value[0]);

// $lastFileDate = "2020-05-11";
// $fileDate = "2020-05-14";
// $m_id = '32';

// $sql_3 = "SELECT contract_id FROM prices WHERE update_date = '$lastFileDate' AND market_id = '$m_id' AND act_contract = 'act'";
// $get_last_result = mysqli_query($connect, $sql_3);
// $get_last_contract_id = mysqli_fetch_row($get_last_result);
// $last_contract_id = $get_last_contract_id[0];

// $sql_4 = "SELECT contract_id FROM prices WHERE update_date = '$fileDate' AND market_id = '$m_id' AND act_contract = 'act'";
// $get_current_result = mysqli_query($connect, $sql_4);
// $get_current_contract_id = mysqli_fetch_row($get_current_result);
// $current_contract_id = $get_current_contract_id[0];

// $sql_5 = "SELECT multiplier FROM prices WHERE update_date = '$lastFileDate' AND market_id = '$m_id' AND act_contract = 'act'";
// $get_last_result1 = mysqli_query($connect, $sql_5);
// $get_last_multiplier = mysqli_fetch_row($get_last_result1);
// $last_multiplier = $get_last_multiplier[0];

// echo ("last_contract_id :"); 
// echo($last_contract_id);
// echo ("<br>");

// echo ("Current_contract :"); 
// echo($current_contract_id);
// echo ("<br>");

// echo ("last_multiplier :"); 
// echo($last_multiplier);
// echo ("<br>");

// if($last_contract_id != $current_contract_id) {
// 	$sql_7 = "SELECT sett FROM prices WHERE update_date = '$lastFileDate' AND market_id = '$m_id' AND act_contract = 'act'";
// 	$get_last_sett = mysqli_query($connect, $sql_7);
// 	$get_last_sett_id = mysqli_fetch_row($get_last_sett);
// 	$last_sett = $get_last_sett_id[0];

// 	$sql_8 = "SELECT sett FROM prices WHERE update_date = '$lastFileDate' AND market_id = '$m_id' AND contract_id = '$current_contract_id'";
// 	$get_current_sett = mysqli_query($connect, $sql_8);
// 	$get_current_sett_id = mysqli_fetch_row($get_current_sett);
// 	$current_sett = $get_current_sett_id[0];

// 	if($last_sett == 0) {
// 		$multiplier = $last_multiplier;
// 	} else {
// 		$multiplier = $current_sett / $last_sett;					
// 	}

// 	$sql_9 = "UPDATE prices SET multiplier = '$multiplier' WHERE contract_id = '$last_contract_id' AND market_id = '$m_id' AND act_contract = 'act' AND multiplier = ''";
// 	mysqli_query($connect, $sql_9);

// 	$sql_10 = "SELECT multiplier FROM prices WHERE update_date = '$lastFileDate' AND market_id = '$m_id' AND contract_id = '$last_contract_id' AND act_contract = 'act'";
// 	$get_current_sett = mysqli_query($connect, $sql_10);
// 	$get_current_sett_id = mysqli_fetch_row($get_current_sett);
// 	$updated_multiplier = $get_current_sett_id[0];
// }

// echo ("last_sett :"); 
// echo($last_sett);
// echo ("<br>");


// echo ("current_sett :"); 
// echo($current_sett);
// echo ("<br>");

// echo ("multiplier :"); 
// echo($multiplier);
// echo ("<br>");

// echo ("updated_multiplier :"); 
// echo($updated_multiplier);
// echo ("<br>");
// $market_id = array(1,2,3,5);
// $market_num = count($market_id);
// echo("<br>===<br>");
// for($i = 0; $i < $market_num; $i++) {
// 	echo($market_id[$i]);
// 	echo("<br>");
// }

// $index = 0;
// $date="2020-05-01";
// while($index == 0 ) {
// 	$date = date('Y-m-d', strtotime($date .' -1 day'));
// 	echo ($date);
// 	echo("<br>");
// 	if($date < "2020-04-14") {
// 		$index = 1;
// 	}
// }

// $date="2020-05-01";
// $date = date('Y-m-d', strtotime($date .' -1 day'));
// echo ($date);

?>