<?php
include_once 'database.php';
include_once 'analysis.php';
include_once 'getFileDate.php';

	function setHighLight($fileDate, $lastFileDate, $connect) {
		// $day_before = date( 'Y-m-d', strtotime( $fileDate . ' -1 day' ) );
		for ($m_id=10; $m_id <36 ; $m_id++) {

			// Set Highlight 
			$sql_0 = "UPDATE prices SET act_contract = '' WHERE update_date = '$fileDate' AND market_id = '$m_id'";
			mysqli_query($connect, $sql_0);

			$sql_1 = "SELECT MAX(est_volume) FROM prices WHERE update_date = '$fileDate' AND market_id = '$m_id' ";
			$get_max_result = mysqli_query($connect, $sql_1);
			$value = mysqli_fetch_row($get_max_result);

			if($value[0] != 0) {
				$sql_2 = "UPDATE prices SET act_contract = 'act' WHERE est_volume = '$value[0]' AND update_date = '$fileDate' AND market_id = '$m_id'";
				$result_time = mysqli_query($connect, $sql_2);
			}
			// End of Set Highlight 
		}
	}

	function setMultiplier($fileName, $fileDate, $connect) {
		set_time_limit(600);

		/*
			============= $fileName comment ==============
			$fileName = all => market_id = 10-25, 31-35
			$fielName = stlcomex => market_id = 10, 11, 14
			$fielName = stlnymex => market_id = 12,13,15,16,17,18
			$fielName = stlags => market_id = 19~25, 31~35
			$fielName = CC => market_id = 26
			$fielName = CT => market_id = 27
			$fielName = OJ => market_id = 28
			$fielName = KC => market_id = 29
			$fielName = SB => market_id = 30
			$fielName = futures => market_id = 19~25, 31~35
			$fielName = comex => market_id = 10, 11, 14
			$fielName = nymex => market_id = 12,13,15,16,17,18
			================= END ========================
		*/

		if($fileName == 'stlcomex' || $fileName =='comex')	{
			$market_id = array(10, 11, 14);
		} else if($fileName == 'stlnymex'  || $fileName =='nymex') {
			$market_id = array(12,13,15,16,17,18);
		} else if($fileName == 'stlags'  || $fileName =='futures') {
			$market_id = array(19,20,21,22,23,24,25,31,32,33,34,35);
		} else if($fileName == 'CC') {
			$market_id = array(26);
		} else if($fileName == 'CT') {
			$market_id = array(27);
		} else if($fileName == 'OJ') {
			$market_id = array(28);
		} else if($fileName == 'KC') {
			$market_id = array(29);
		} else if($fileName == 'SB') {
			$market_id = array(30);
		} else if($fileName == 'all') {
			$market_id = array(10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,31,32,33,34,35);
		}

		$market_num = count($market_id);
		$lastFileDate = date('Y-m-d', strtotime($fileDate .' -1 day'));

		for($i = 0; $i < $market_num; $i++) {
			$m_id = $market_id[$i];
			$index = 0;
			$loop_num = 0;

			// ------ Get min date of $m_id market -------

			$sql_19 = "SELECT MIN(update_date) FROM prices WHERE market_id = '$m_id' ";
			$get_max_result = mysqli_query($connect, $sql_19);
			$value = mysqli_fetch_row($get_max_result);

			$min_date = $value[0];

			// ------ End of Get min date of $m_id market -------



			$sql_4 = "SELECT contract_id FROM prices WHERE update_date = '$fileDate' AND market_id = '$m_id' AND act_contract = 'act'";
			$get_current_result = mysqli_query($connect, $sql_4);
			$get_current_contract_id = mysqli_fetch_row($get_current_result);
			$current_contract_id = $get_current_contract_id[0];

			while($index == 0 ) {
				$sql_10 = "SELECT contract_id FROM prices WHERE update_date = '$lastFileDate' AND market_id = '$m_id' AND act_contract = 'act'";
				$get_last_sett = mysqli_query($connect, $sql_10);
				$get_last_contract_id_val = mysqli_fetch_row($get_last_sett);
				$loop_num = $loop_num + 1;


				if(is_null($get_last_contract_id_val)) {
					$lastFileDate = date('Y-m-d', strtotime($lastFileDate .' -1 day'));
					// echo("Get_last_sett is empty");
					// echo("<br>");
				} else {

					// ------ Compare contract_id -------
					$last_contract_id = $get_last_contract_id_val[0];

					if($current_contract_id != $last_contract_id) {
						$sql_7 = "SELECT sett FROM prices WHERE update_date = '$lastFileDate' AND market_id = '$m_id' AND act_contract = 'act'";
						$get_last_sett = mysqli_query($connect, $sql_7);
						$get_last_sett_id = mysqli_fetch_row($get_last_sett);
						$last_sett = $get_last_sett_id[0];

						$sql_8 = "SELECT sett FROM prices WHERE update_date = '$lastFileDate' AND market_id = '$m_id' AND contract_id = '$current_contract_id'";
						$get_current_sett = mysqli_query($connect, $sql_8);
						$get_current_sett_id = mysqli_fetch_row($get_current_sett);
						$current_sett = $get_current_sett_id[0];
						
						if($last_sett == 0) {
							$multiplier = '';
						} else {
							$multiplier = $current_sett / $last_sett;					
						}
						
						$sql_12 = "UPDATE prices SET multiplier = '$multiplier' WHERE market_id = '$m_id' AND act_contract = 'act' AND update_date = '$lastFileDate'";
						mysqli_query($connect, $sql_12);

						$index_y = 0;
						$lastFileDate_val = $lastFileDate;
						$last_contract_id_val = $last_contract_id;
						$multiplier_val = $multiplier;

						while($index_y == 0 ) {
							$lastFileDate_val = date('Y-m-d', strtotime($lastFileDate_val .' -1 day'));

							if($lastFileDate_val < $min_date) {
								$index_y = 1;
							}

							$sql_15 = "SELECT contract_id FROM prices WHERE update_date = '$lastFileDate_val' AND market_id = '$m_id' AND act_contract = 'act'";
							$get_last_settval = mysqli_query($connect, $sql_15);
							$get_last_settval_id = mysqli_fetch_row($get_last_settval);
							if(is_null($get_last_settval_id)) {

							} else {
								$before_contract_id_val = $get_last_settval_id[0];
								
								if($before_contract_id_val == $last_contract_id_val) {
									$sql_11 = "UPDATE prices SET multiplier = '$multiplier_val' WHERE market_id = '$m_id' AND act_contract = 'act' AND update_date = '$lastFileDate_val'";
									mysqli_query($connect, $sql_11);
								} else {
									$last_contract_id_val = $before_contract_id_val;

									$sql_14= "SELECT sett FROM prices WHERE update_date = '$lastFileDate_val' AND market_id = '$m_id' AND act_contract = 'act'";
									$get_last_sett_14 = mysqli_query($connect, $sql_14);
									$get_last_sett_14_id = mysqli_fetch_row($get_last_sett_14);
									$last_sett_val = $get_last_sett_14_id[0];

									$multiplier_val = $current_sett / $last_sett_val;

									$sql_16 = "UPDATE prices SET multiplier = '$multiplier_val' WHERE market_id = '$m_id' AND act_contract = 'act' AND update_date = '$lastFileDate_val'";
									mysqli_query($connect, $sql_16);
								}
							}
						}

						$index = 1;
					} else {
						$index = 1;
					}
				}

				if($loop_num > 20) {
					// echo("<br>");
					// echo ("Not Found Before Data!");
					// echo("<br>");
					$index = 1;
				}
			}
		}
	}
?>