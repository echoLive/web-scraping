<?php
include_once 'database.php';
	function getMarkets ($market_ID, $connect) {
		
		$sql_1 = "SELECT market_ID, market FROM markets WHERE market_ID = '$market_ID'";
		$market_info = mysqli_query($connect, $sql_1);
		$markets = mysqli_fetch_row($market_info);
		return $markets;
	}
?>