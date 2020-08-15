<?php

	function analysis( $line ){
		$letters = str_split($line);
		$buffer = '';
		$row = array();
		$space_count = 0;
		$result = '';

		foreach($letters as $letter){
			if( $letter == ' ' ) {
				if( empty($buffer) ){
					if( $space_count >= 10){
						$row[] = '0';
						$buffer = '';
						$space_count = 0;
					} else {
						$space_count++;
					}
				} else { 
					$row[] = $buffer == '----' ? 0 : $buffer;
					$buffer = '';
					$space_count = 0;
				}

			} else {
				$buffer .= $letter;
			}

		}

		if( !empty($buffer) ){
			$row[] = $buffer;
		}
		$result = $row;
		return $result;
	}

	function getTxtFileDate ($file) {
		
		$lines = file($file);
		$lineIndex = 0;

		foreach($lines as $line) {
			if($lineIndex <1) {
				$rows[] = analysis($line);
				$fileDate = $rows[0][5];
				str_replace("/", "-", $fileDate);
				$fileDate = str_replace("/","-", $fileDate);
				$fileDate = substr_replace($fileDate, "20", 6, 0);
			}
			$lineIndex++;
		}
		$month = substr($fileDate,0, 2);
		$day = substr($fileDate,3, 2);
		$year = substr($fileDate,6, 4);
		$fileDate = $year. "-". $month . "-" . $day;
		return $fileDate;
	}

	function getPdfFileDate($file) {

		include 'pdfparser-master/vendor/autoload.php';
		$parser = new \Smalot\PdfParser\Parser();
		$pdf = $parser->parseFile($file);
		$text = $pdf->getText();
		$lines = explode("\n",$text);
		$indexLine = 0;
		foreach($lines as $line) {
			$indexLine++;
	    	// $row = analysis($line);
		    if($indexLine == 7) {
			    $pdfFileDate = $line;
			    break;
		    }
		}

		$pdfFileDate = str_replace("Jan", "01", $pdfFileDate);
		$pdfFileDate = str_replace("Feb", "02", $pdfFileDate);
		$pdfFileDate = str_replace("Mar", "03", $pdfFileDate);
		$pdfFileDate = str_replace("Apr", "04", $pdfFileDate);
		$pdfFileDate = str_replace("May", "05", $pdfFileDate);
		$pdfFileDate = str_replace("Jun", "06", $pdfFileDate);
		$pdfFileDate = str_replace("Jul", "07", $pdfFileDate);
		$pdfFileDate = str_replace("Aug", "08", $pdfFileDate);
		$pdfFileDate = str_replace("Sep", "09", $pdfFileDate);
		$pdfFileDate = str_replace("Oct", "10", $pdfFileDate);
		$pdfFileDate = str_replace("Nov", "11", $pdfFileDate);
		$pdfFileDate = str_replace("Dec", "12", $pdfFileDate);

		$day = substr($pdfFileDate,0, 2);
		$month = substr($pdfFileDate,3, 2);
		$year = substr($pdfFileDate,6, 4);

		$pdfFileDate = $year. "-". $month . "-" . $day;
		
		return $pdfFileDate;
	}
?>