<?php 

	function insertTxtData($file, $connect, $fileTime, $serverDate) {
		// $fileTime = date("F-d-Y-H:i:s", filemtime($file));
		$fileName = basename($file, ".txt");


		$sql_1 = "SELECT file_date FROM filedate WHERE file_name ='$fileName'";
		$fileTime_old = mysqli_query($connect, $sql_1);
		$row_time = mysqli_fetch_row($fileTime_old);
		$lastFileDate = $row_time[0];

			/*====== insert file date ======*/
			$sql_2 = "UPDATE filedate SET file_date = '$fileTime' WHERE file_name = '$fileName'";
			mysqli_query($connect, $sql_2);

			$sql_5 = "UPDATE filedate SET server_date = '$serverDate' WHERE file_name = '$fileName'";
			mysqli_query($connect, $sql_5);

			/*====== text file read ======*/
			$lines = file($file);
			/*====== Separate Several Parts ======*/
			$numTables = 0;
			$tableNumber = 0;
			$checkTable = 0;
			$lineNumber = 0;
			$fileDate = getTxtFileDate($file);
			// $marketID = 0;

			foreach($lines as $line) {
				$splitBySpace = explode("  ",$line);
				$lengthFirstVal = strlen($splitBySpace[0]);
				$firstLetter = $splitBySpace[0];
				$total = substr($line, 0, 5);
				if($lengthFirstVal > 10) {
					$numTables++;  
					
					if((substr($firstLetter, 0, 2) == "GC") && substr($firstLetter, 2,1) == " " ) {
						$checkTable = 1;
						$tableName = $splitBySpace[0];
						$marketID = 10;

					} else if((substr($firstLetter, 0, 2) == "SI") && substr($firstLetter, 2,1) == " " ) {
						$checkTable = 1;
						$tableName = $splitBySpace[0];
						$marketID = 11;

					} else if((substr($firstLetter, 0, 2) == "PL") && substr($firstLetter, 2,1) == " " ) {
						$checkTable = 1;
						$tableName = $splitBySpace[0];
						$marketID = 12;

					} else if((substr($firstLetter, 0, 2) == "PA") && substr($firstLetter, 2,1) == " " ) {
						$checkTable = 1;
						$tableName = $splitBySpace[0];
						$marketID = 13;

					} else if((substr($firstLetter, 0, 2) == "HG") && substr($firstLetter, 2,1) == " " ) {
						$checkTable = 1;
						$tableName = $splitBySpace[0];
						$marketID = 14;

					} else if((substr($firstLetter, 0, 2) == "CL") && substr($firstLetter, 2,1) == " " ) {
						$checkTable = 1;
						$tableName = $splitBySpace[0];
						$marketID = 15;

					} else if((substr($firstLetter, 0, 2) == "RB") && substr($firstLetter, 2,3) == " RB" ) {
						$checkTable = 1;
						$tableName = $splitBySpace[0];
						$marketID = 16;

					} else if((substr($firstLetter, 0, 2) == "HO") && substr($firstLetter, 2,1) == " " ) {
						$checkTable = 1;
						$tableName = $splitBySpace[0];
						$marketID = 17;

					} else if((substr($firstLetter, 0, 2) == "NG") && substr($firstLetter, 2,1) == " " ) {
						$checkTable = 1;
						$tableName = $splitBySpace[0];
						$marketID = 18;

					} else if((substr($firstLetter, 0, 1) == "C") && substr($firstLetter, 1,1) == " " ) {
						$checkTable = 1;
						$tableName = $splitBySpace[0];
						$marketID = 19;

					} else if((substr($firstLetter, 0, 1) == "W") && substr($firstLetter, 1,1) == " " ) {
						$checkTable = 1;
						$tableName = $splitBySpace[0];
						$marketID = 20;

					} else if((substr($firstLetter, 0, 3) == "RRF") && substr($firstLetter, 3,1) == " " ) {
						$checkTable = 1;
						$tableName = $splitBySpace[0];
						$marketID = 21;

					} else if((substr($firstLetter, 0, 1) == "O") && substr($firstLetter, 1,1) == " " ) {
						$checkTable = 1;
						$tableName = $splitBySpace[0];
						$marketID = 22;

					} else if((substr($firstLetter, 0, 1) == "S") && substr($firstLetter, 1,1) == " " ) {
						$checkTable = 1;
						$tableName = $splitBySpace[0];
						$marketID = 23;

					} else if((substr($firstLetter, 0, 2) == "SM") && substr($firstLetter, 2,1) == " " ) {
						$checkTable = 1;
						$tableName = $splitBySpace[0];
						$marketID = 24;

					} else if((substr($firstLetter, 0, 2) == "BO") && substr($firstLetter, 2,1) == " " ) {
						$checkTable = 1;
						$tableName = $splitBySpace[0];
						$marketID = 25;

					} else if((substr($firstLetter, 0, 2) == "LB") && substr($firstLetter, 2,1) == " " ) {
						$checkTable = 1;
						$tableName = $splitBySpace[0];
						$marketID = 31;

					} else if((substr($firstLetter, 0, 2) == "LC") && substr($firstLetter, 2,1) == " " ) {
						$checkTable = 1;
						$tableName = $splitBySpace[0];
						$marketID = 32;

					} else if((substr($firstLetter, 0, 2) == "FC") && substr($firstLetter, 2,1) == " " ) {
						$checkTable = 1;
						$tableName = $splitBySpace[0];
						$marketID = 33;

					} else if((substr($firstLetter, 0, 2) == "LH") && substr($firstLetter, 2,1) == " " ) {
						$checkTable = 1;
						$tableName = $splitBySpace[0];
						$marketID = 34;

					} else if((substr($firstLetter, 0, 2) == "DA") && substr($firstLetter, 2,1) == " " ) {
						$checkTable = 1;
						$tableName = $splitBySpace[0];
						$marketID = 35;

					} else {

						$checkTable = 0;

					}
					$lineNumber = 0;
				} else if($total == "TOTAL") {
					$checkTable = 0;
					$lineNumber = 0;
				} else {
					if(is_numeric((substr($firstLetter, 0, 1)))) {
						$checkTable = 0;
					}
					if($checkTable == 1 && $lineNumber < 24){
						$lineNumber ++;
						$line = str_replace("'", ".", $line);
						$rows[] = analysis($line);
						// $current_date = date("d-m-Y");

						$data = [];
						$data[] = $fileDate;
						$contract_id = '';
						if(isset($rows[$tableNumber][0])) {
							$data_temp = strtoupper($rows[$tableNumber][0]);
							$data_temp = str_replace("/","",$data_temp);
							$data_temp = str_replace(" ","",$data_temp);
							$data_temp = str_replace("-","",$data_temp);
							$data[] = $data_temp;
							$contract_id = $data_temp;
						} else {
							$data[] = 0;
						}
						$data[] = $marketID;
						if(isset($rows[$tableNumber][1])) {
							$lastCharacter = substr($rows[$tableNumber][1], -1);
							if(!is_numeric($lastCharacter)) {
								$realNumber = substr($rows[$tableNumber][1], 0, -1);
								$data[] = $realNumber;
							} else {
								$data[] = $rows[$tableNumber][1];
							}
						} else {
							$data[] = 0;
						}
						if(isset($rows[$tableNumber][2])) {
							$lastCharacter = substr($rows[$tableNumber][2], -1);
							if(!is_numeric($lastCharacter)) {
								$realNumber = substr($rows[$tableNumber][2], 0, -1);
								$data[] = $realNumber;
							} else {
								$data[] = $rows[$tableNumber][2];
							}
						} else {
							$data[] = 0;
						}
						if(isset($rows[$tableNumber][3])) {
							$lastCharacter = substr($rows[$tableNumber][3], -1);
							if(!is_numeric($lastCharacter)) {
								$realNumber = substr($rows[$tableNumber][3], 0, -1);
								$data[] = $realNumber;
							} else {
								$data[] = $rows[$tableNumber][3];
							}
						} else {
							$data[] = 0;
						}
						if(isset($rows[$tableNumber][4])) {
							// $data[] = $rows[$tableNumber][4];
							$lastCharacter = substr($rows[$tableNumber][4], -1);
							if(!is_numeric($lastCharacter)) {
								$realNumber = substr($rows[$tableNumber][4], 0, -1);
								$data[] = $realNumber;
							} else {
								$data[] = $rows[$tableNumber][4];
							}
						} else {
							$data[] = 0;
						}
						if(isset($rows[$tableNumber][5])) {
							$data[] = $rows[$tableNumber][5];
						} else {
							$data[] = 0;
						}
						if(isset($rows[$tableNumber][7])) {
							$data[] = str_replace(",","",$rows[$tableNumber][7]);
						} else {
							$data[] = 0;
						}

						$prior_volume = 0;
						if(isset($rows[$tableNumber][9])) {
							$data[] = $rows[$tableNumber][9];
							$prior_volume = $rows[$tableNumber][9];
						} else {
							$data[] = 0;
						}
						if(isset($rows[$tableNumber][10])) {
							$data[] = $rows[$tableNumber][10];
						} else {
							$data[] = 0;
						}

						$sql_3 = "INSERT INTO prices 
										(
											update_date, 
											contract_id, 
											market_id, 
											open, 
											high, 
											low, 
											close, 
											sett, 
											est_volume, 
											prior_volume, 
											prior_open_int
										) 
										VALUES
										(
											'".implode("', '", $data)."'
										)
								 ";

						mysqli_query($connect, $sql_3);

						$sql_4 = "UPDATE prices SET est_volume = '$prior_volume' WHERE update_date = '$row_time[0]' AND contract_id = '$contract_id' AND market_id = '$marketID'";
						mysqli_query($connect, $sql_4);

						$tableNumber++;
					}
				}
			}
			echo ("<br>");
			echo ("<br>");
			echo ("<b>".$fileName. ".txt file scrape succeeded! </b>");
			echo ("<br>");
			echo ("<br>");

			setHighLight($fileDate, $lastFileDate, $connect);
			sleep(3);
			setMultiplier($fileName, $fileDate, $connect);
	}
 ?>