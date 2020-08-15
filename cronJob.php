<?php
include_once 'database.php';
include_once 'analysis.php';
include_once 'getFileDate.php';
include_once 'insertTxtData.php';
include_once 'insertPdfData.php';
include_once 'setHighLight.php';
include_once 'main.php';

	downloadComex($connect);
	downloadNymex($connect);
	downloadAgs($connect);
	autoScrapeComex($connect);
	autoScrapeNymex($connect);
	autoScrapeAgs($connect);
?>