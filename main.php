<?php 
include_once 'database.php';
include_once 'analysis.php';
include_once 'getFileDate.php';
include_once 'insertTxtData.php';
include_once 'insertPdfData.php';
include_once 'setHighLight.php';

function mainScrape($connect) {
	downloadComex($connect);
	sleep(10);
	downloadNymex($connect);
	sleep(10);
	downloadAgs($connect);
	sleep(20);

	autoScrapeComex($connect);
	sleep(10);
	autoScrapeNymex($connect);
	sleep(10);
	autoScrapeAgs($connect);
}

function downloadComex($connect) {
	// ini_set('max_execution_time', '600');
	$fileName_1 = "stlcomex";
	$serverTime_1_old = getServerDate($fileName_1, $connect);
	$serverTime_1 = date("Y-F-d", filemtime("ftp://ftp.cmegroup.com/settle/stlcomex"));

	if($serverTime_1_old != $serverTime_1) {
		file_put_contents("stlcomex.txt", file_get_contents("ftp://ftp.cmegroup.com/settle/stlcomex"));
		$filename_1 = "stlcomex.txt";
    	$filesize_1 = filesize ($filename_1);

    	if($filesize_1 !=0 ) {
			echo ("<br>");
			echo ("stlcomex.txt file was downloaded.");
			echo ("<br>");
		} else {
			downloadComex($connect);
		}
	} else {
		echo ("The stlcomex server was not updated.");
	}
}

function downloadNymex($connect) {
	// ini_set('max_execution_time', '600');
	$fileName_2 = "stlnymex";
	$serverTime_2_old = getServerDate($fileName_2, $connect);
	$serverTime_2 = date("Y-F-d", filemtime("ftp://ftp.cmegroup.com/pub/settle/stlnymex"));

	if($serverTime_2_old != $serverTime_2) {
		file_put_contents("stlnymex.txt", file_get_contents("ftp://ftp.cmegroup.com/pub/settle/stlnymex"));

		$filename_2 = "stlnymex.txt";
    	$filesize_2 = filesize ($filename_2);

    	if($filesize_2 !=0) {	
			echo ("<br>");
			echo ("stlnymex.txt file was downloaded.");
			echo ("<br>");
		} else {
			downloadNymex($connect);
		}
	} else {
		echo ("The stlnymex server was not updated.");
	}
}

function downloadAgs($connect) {
	// ini_set('max_execution_time', '600');
	$fileName_3 = "stlags";
	$serverTime_3_old = getServerDate($fileName_3, $connect);
	$serverTime_3 = date("Y-F-d", filemtime("ftp://ftp.cmegroup.com/pub/settle/stlags"));

	if($serverTime_3_old != $serverTime_3) {
		file_put_contents("stlags.txt", file_get_contents("ftp://ftp.cmegroup.com/pub/settle/stlags"));

		$filename_3 = "stlags.txt";
    	$filesize_3 = filesize ($filename_3);

    	if($filesize_3 !=0) {	
			echo ("<br>");
			echo ("stlags.txt file was downloaded.");
			echo ("<br>");
			echo ("<br>");
		} else {
			downloadAgs($connect);
		}
	} else {
		echo ("The stlags server was not updated.");
	}
}

function autoScrape($connect) {
	autoScrapeComex($connect);
	autoScrapeNymex($connect);
	autoScrapeAgs($connect);
}

function autoScrapeComex($connect) {
	// ini_set('max_execution_time', '600');
	$fileName_1 = "stlcomex";
	$serverTime_1 = date("Y-F-d", filemtime("ftp://ftp.cmegroup.com/settle/stlcomex"));
	$filename_1 = "stlcomex.txt";
	$fileTime_1_old = getFileDate($fileName_1, $connect);
	$file1 = "stlcomex.txt";
	$fileTime_1 = getTxtFileDate($file1);
	
	if($fileTime_1 != "--") {
		if($fileTime_1 != $fileTime_1_old) {
			insertTxtData($file1, $connect, $fileTime_1, $serverTime_1);
		} else {
			echo ("<br>");
			echo ("stlcomex.txt file was not inserted.");
		}
	} else {
		echo ("<br>");
		echo ("The updated stlcomex file is empty.");
	}
}

function autoScrapeNymex($connect) {
	// ini_set('max_execution_time', '600');
	$fileName_2 = "stlnymex";
	$serverTime_2 = date("Y-F-d", filemtime("ftp://ftp.cmegroup.com/pub/settle/stlnymex"));
	$filename_2 = "stlnymex.txt";
	$fileTime_2_old = getFileDate($fileName_2, $connect);
	$file2 = "stlnymex.txt";
	$fileTime_2 = getTxtFileDate($file2);

	if($fileTime_2 != "--") {
		if($fileTime_2 != $fileTime_2_old) {
			insertTxtData($file2, $connect, $fileTime_2, $serverTime_2);
		} else {
			echo ("<br>");
			echo ("stlnymex.txt file was not inserted.");
		}
	} else {
		echo ("<br>");
		echo ("The updated stlnymex file is empty.");
	}
}

function autoScrapeAgs($connect) {
	// ini_set('max_execution_time', '600');
	$fileName_3 = "stlags";
	$serverTime_3 = date("Y-F-d", filemtime("ftp://ftp.cmegroup.com/pub/settle/stlags"));
	$filename_3 = "stlags.txt";
	$fileTime_3_old = getFileDate($fileName_3, $connect);
	$file3 = "stlags.txt";
	$fileTime_3 = getTxtFileDate($file3);

	if($fileTime_3 != "--") {
		if($fileTime_3 != $fileTime_3_old) {
			insertTxtData($file3, $connect, $fileTime_3, $serverTime_3);
		} else {
			echo ("<br>");
			echo ("stlags.txt file was not inserted.");
		} 
	} else {
		echo ("<br>");
		echo ("The updated stlags file is empty.");
	}
}
?>