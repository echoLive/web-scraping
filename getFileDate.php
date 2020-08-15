<?php
include_once 'database.php';
include_once 'analysis.php';
include_once 'getFileDate.php';

function getFileDate ($fileName, $connect) {
	$sql_1 = "SELECT file_date FROM filedate WHERE file_name ='$fileName'";
	$fileTime_old = mysqli_query($connect, $sql_1);
	$row_time = mysqli_fetch_row($fileTime_old);
	return $row_time[0];
}

function getServerDate ($fileName, $connect) {
	$sql_1 = "SELECT server_date FROM filedate WHERE file_name ='$fileName'";
	$fileTime_old = mysqli_query($connect, $sql_1);
	$row_time = mysqli_fetch_row($fileTime_old);
	return $row_time[0];
}

function searchData ($market_id, $market_date, $connect) {
	$sql_1 = "SELECT market FROM markets WHERE market_ID ='$market_id'";
	$result_1 = mysqli_query($connect, $sql_1);
	$row_market = mysqli_fetch_row($result_1);


	if( $market_date !="") {
		echo("<br>");
		echo ("Market Name : <b>". $row_market[0]. "</b>");
		echo("<br>");
		echo ("Date : <b>". $market_date. "</b>");
		echo("<br>");
		echo("<br>");
		$sql_2 = "SELECT * FROM prices WHERE update_date ='$market_date' AND market_id = '$market_id' ORDER BY update_date DESC";
	} else {
		echo("<br>");
		echo ("Market Name: <b>". $row_market[0]. "</b>");
		echo("<br>");
		echo ("Date : <b> ALL </b>");
		echo("<br>");
		echo("<br>");
		$sql_2 = "SELECT * FROM prices WHERE market_id = '$market_id' ORDER BY update_date DESC";
	}

	if($result_2 = mysqli_query($connect, $sql_2)){
	    if(mysqli_num_rows($result_2) > 0){
	        echo "<table class= 'search-table'>";
	            echo "<tr>";
	                echo "<th>price_id</th>";
	                echo "<th>update_date</th>";
	                echo "<th>contract_id</th>";
	                echo "<th>market_id</th>";
	                echo "<th>open</th>";
	                echo "<th>high</th>";
	                echo "<th>low</th>";
	                echo "<th>close</th>";
	                echo "<th>sett</th>";
	                echo "<th>est_volume</th>";
	                echo "<th>prior_volume</th>";
	                echo "<th>prior_open_int</th>";
	                echo "<th>act_contract</th>";
	                echo "<th>multiplier</th>";
	            echo "</tr>";
	        while($row = mysqli_fetch_array($result_2)){
	            echo "<tr>";
	                echo "<td>" . $row['price_ID'] . "</td>";
	                echo "<td>" . $row['update_date'] . "</td>";
	                echo "<td>" . $row['contract_id'] . "</td>";
	                echo "<td>" . $row['market_id'] . "</td>";
	                echo "<td>" . $row['open'] . "</td>";
	                echo "<td>" . $row['high'] . "</td>";
	                echo "<td>" . $row['low'] . "</td>";
	                echo "<td>" . $row['close'] . "</td>";
	                echo "<td>" . $row['sett'] . "</td>";
	                echo "<td>" . $row['est_volume'] . "</td>";
	                echo "<td>" . $row['prior_volume'] . "</td>";
	                echo "<td>" . $row['prior_open_int'] . "</td>";
	                echo "<td>" . $row['act_contract'] . "</td>";
	                echo "<td>" . $row['multiplier'] . "</td>";
	                // if($row['multiplier'] == 0 ||  $row['multiplier'] == 'NULL') {
	                // 	echo "<td></td>";
	                // } else {
	                // 	echo "<td>" . $row['multiplier'] . "</td>";
	                // }

	            echo "</tr>";
	        }
	        echo "</table>";
	        ?>

			<?php
	        // Free result_2 set
	        // mysqli_free_result_2($result_2);
	    } else{
	        echo "No markets search found";
	    }
	} else{
	    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
	}

	$sql_3 = "UPDATE search SET search_market_ID = '$market_id', search_date = '$market_date'";
	$result_3 = mysqli_query($connect, $sql_3);
}

function changeData ($price_id,  $update_date,  $contract_id,  $market_id,  $open,  $high,  $low,  $close,  $sett,  $est_volume,  $prior_volume,  $prior_open_int,  $change_button, $connect) {

	if($price_id != '')
	{
		if ($update_date != '') {
			$sql_1 = "UPDATE prices SET update_date = '$update_date' WHERE price_id = '$price_id'";
			mysqli_query($connect, $sql_1);
		}

		if ($contract_id != '') {
			$sql_2 = "UPDATE prices SET contract_id = '$contract_id' WHERE price_id = '$price_id'";
			mysqli_query($connect, $sql_2);
		}

		if ($market_id != '') {
			$sql_3 = "UPDATE prices SET market_id = '$market_id' WHERE price_id = '$price_id'";
			mysqli_query($connect, $sql_3);
		}

		if ($open != '') {
			$sql_4 = "UPDATE prices SET open = '$open' WHERE price_id = '$price_id'";
			mysqli_query($connect, $sql_4);
		}

		if ($high != '') {
			$sql_5 = "UPDATE prices SET high = '$high' WHERE price_id = '$price_id'";
			mysqli_query($connect, $sql_5);
		}

		if ($low != '') {
			$sql_6 = "UPDATE prices SET low = '$low' WHERE price_id = '$price_id'";
			mysqli_query($connect, $sql_6);
		}

		if ($close != '') {
			$sql_7 = "UPDATE prices SET close = '$close' WHERE price_id = '$price_id'";
			mysqli_query($connect, $sql_7);
		}

		if ($sett != '') {
			$sql_8 = "UPDATE prices SET sett = '$sett' WHERE price_id = '$price_id'";
			mysqli_query($connect, $sql_8);
		}

		if ($est_volume != '') {
			$sql_9 = "UPDATE prices SET est_volume = '$est_volume' WHERE price_id = '$price_id'";
			mysqli_query($connect, $sql_9);
		}

		if ($prior_volume != '') {
			$sql_10 = "UPDATE prices SET prior_volume = '$prior_volume' WHERE price_id = '$price_id'";
			mysqli_query($connect, $sql_10);
		}

		if ($prior_open_int != '') {
			$sql_11 = "UPDATE prices SET prior_open_int = '$prior_open_int' WHERE price_id = '$price_id'";
			mysqli_query($connect, $sql_11);
		}

		if ($change_button != '') {
			$sql_12 = "UPDATE prices SET change_button = '$change_button' WHERE price_id = '$price_id'";
			mysqli_query($connect, $sql_12);
		}
	}
}

?>