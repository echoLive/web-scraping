<?php

    function insertPdfData ($file, $connect) {

	    /*====== get content from pdf file ======*/
	    include 'pdfparser-master/vendor/autoload.php';

	    // Parse pdf file and build necessary objects.
	    $parser = new \Smalot\PdfParser\Parser();

	    // insertPdfData($pdf1, $connect);
		$pdf = $parser->parseFile($file);
	    $fileDate = getPdfFileDate($file);
	    $fileName = basename($file, ".pdf");

	    // $sql_1 = "SELECT file_date FROM filedate WHERE file_name ='$fileName'";
	    // $fileDate_old = mysqli_query($connect, $sql_1);
	    // $row_time = mysqli_fetch_row($fileDate_old);
	    // $lastFileDate = $row_time[0];

	    $sql_market = "SELECT market_ID FROM markets WHERE shortcut ='$fileName'";
	    $market_ID = mysqli_query($connect, $sql_market);
	    $row_market = mysqli_fetch_row($market_ID);
	    // echo ($row_market[0]);

	    if($fileName == 'CC') {
	    	$market_id = array(26);
	    } else if($fileName == 'CT') {
	    	$market_id = array(27);
	    } else if($fileName == 'OJ') {
	    	$market_id = array(28);
	    } else if($fileName == 'KC') {
	    	$market_id = array(29);
	    } else if($fileName == 'SB') {
	    	$market_id = array(30);
	    }

	    $sql_lastDate = "SELECT contract_id FROM prices WHERE market_id = '$market_id[0]' AND update_date = '$fileDate'";
	    $lastDate_val = mysqli_query($connect, $sql_lastDate);
	    $last_date = mysqli_fetch_row($lastDate_val);
	    
	    $lastFileDate = date('Y-m-d', strtotime($fileDate .' -1 day'));

	    if(is_null($last_date)) {

	    	/*====== insert file date ======*/
	    	$sql_2 = "UPDATE filedate SET file_date = '$fileDate' WHERE file_name = '$fileName'";
	    	$result_time = mysqli_query($connect, $sql_2);

		    /*====== scrape data from pdf ======*/
		    $text = $pdf->getText();
		    $lines = explode("\n",$text);
		    $checkTable = 0;
		    // $current_date = date("d-m-Y");
		   
		    foreach($lines as $line) {
		    	// $row = analysis($line);
			    $stepLine = explode("	",$line);

			    if($fileName == "CT") {
				    if($stepLine[0] == "CT-COTTON FUTURES") {
				    	$checkTable = 1;
				    	continue;
				    } else if($stepLine[0] == "Totals for CT:") {
				    	$checkTable = 0;
				    }
			    }
			    if($fileName == "CC") {
				    if($stepLine[0] == "CC-COCOA FUTURES") {
				    	$checkTable = 1;
				    	continue;
				    } else if($stepLine[0] == "Totals for CC:") {
				    	$checkTable = 0;
				    }
			    }
			    if($fileName == "SB") {
				    if($stepLine[0] == "SB-SUGAR 11 FUTURES") {
				    	$checkTable = 1;
				    	continue;
				    } else if($stepLine[0] == "Totals for SB:") {
				    	$checkTable = 0;
				    }
			    }
			    if($fileName == "OJ") {
				    if($stepLine[0] == "OJ-FCOJ-A FUTURES") {
				    	$checkTable = 1;
				    	continue;
				    } else if($stepLine[0] == "Totals for OJ:") {
				    	$checkTable = 0;
				    }
			    }
			    if($fileName == "KC") {
				    if($stepLine[0] == "KC-COFFEE FUTURES") {
				    	$checkTable = 1;
				    	continue;
				    } else if($stepLine[0] == "Totals for KC:") {
				    	$checkTable = 0;
				    }
			    }

			    if(isset($stepLine[8])) {
				    $stepLine_8 = str_replace(",","",$stepLine[8]);
			    }
			    

			    if($checkTable == 1) {
			    	$lengthFirstVal = count($stepLine);

			    	$contract_ID = strtoupper($stepLine[1]);
			    	$contract_ID = str_replace("/","",$contract_ID);
			    	$contract_ID = str_replace(" ","",$contract_ID);
			    	$contract_ID = str_replace("-","",$contract_ID);
			    	$contract_ID = str_replace("JUL", "JLY", $contract_ID);


			    	if ($lengthFirstVal > 12) {
			    		$sql_result = "INSERT INTO prices 
			    						(
			    							update_date, 
			    							contract_id, 
			    							market_id, 
			    							open, 
			    							high, 
			    							low, 
			    							close, 
			    							sett, 
			    							est_volume
			    						) 
			    						VALUES
			    						(
			    							'$fileDate',
			    							'$contract_ID',
			    							'$row_market[0]',
			    							'$stepLine[2]',
			    							'$stepLine[3]',
			    							'$stepLine[4]',
			    							'$stepLine[5]',
			    							'$stepLine[6]',
			    							'$stepLine_8'
			    						)
			    				 ";
			    		$result_insert = mysqli_query($connect, $sql_result);
			    	}
			    }
		    }
		    echo ("<br>");
		    echo ("<b>".$fileName.".pdf file scrape succeeded! </b>");
		    echo ("<br>");
		    echo ("<br>");
			
			setHighLight($fileDate, $lastFileDate, $connect);
			sleep(3);
			setMultiplier($fileName, $fileDate, $connect);
		} else {
			echo ("<br>");
			echo ($fileName.".pdf file was not updated.");
			echo ("<br>");
		}

	}
?>
