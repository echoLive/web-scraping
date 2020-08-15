<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <!-- SEO Meta Tags -->
    <meta name="description" content="">
    <meta name="author" content="Edrick Lopez">

    <!-- OG Meta Tags to improve the way the post looks when you share the page on LinkedIn, Facebook, Google+ -->
    <meta property="og:site_name" content="" /> <!-- website name -->
    <meta property="og:site" content="" /> <!-- website link -->
    <meta property="og:title" content="" /> <!-- title shown in the actual shared post -->
    <meta property="og:description" content="" /> <!-- description shown in the actual shared post -->
    <meta property="og:image" content="" /> <!-- image link, make sure it's jpg -->
    <meta property="og:url" content="" /> <!-- where do you want your post to link to -->
    <meta property="og:type" content="article" />

    <!-- Website Title -->
    <title>Scrape</title>

    <!-- Styles -->
    <link href="css/jquery.easy_slides.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet">
    
    <?php
        include_once 'main.php';
        include_once 'database.php';
        include_once 'analysis.php';
        include_once 'getMarkets.php';
        include_once 'getFileDate.php';
        include_once 'insertTxtData.php';
        include_once 'insertPdfData.php';
        include_once 'setHighLight.php';
    ?>
</head>

<body>
    <main>
        <form method="post">
            <div class="navbar">
              <div class="dropdown">
                  <select class="dropbtn" id="market-selete" name="market-selete">

                    <?php 
                        for($i= 10; $i<36; $i++) { 
                            $markets = getMarkets($i, $connect);
                    ?>
                            <option value="<?php echo $markets[0]; ?>" id="market-option" name="market-option" class="dropdown-content"><?php echo $markets[1]; ?></option>

                    <?php
                        } 
                    ?>
                  </select>
              </div> 

              <div class="date-fields">
                <span class="date-title">Date : </span>
                <input type="text" name="market-date" class="date-field" placeholder=" (style)  YYYY-MM-DD" /> 
              </div>

              <input type="submit" name="search-button" class="search-button" value="Search"/> 
            </div>
        </form>

        <?php
            if(array_key_exists('search-button', $_POST)) { 
                $market_id = $_POST['market-selete'];
                $market_date = $_POST['market-date'];
                searchData ($market_id, $market_date, $connect);
            }
        ?> 
        <br>

        <?php
            if(array_key_exists('change_button', $_POST)) {

                $price_id = $_POST['price_id'];
                $update_date = $_POST['update_date'];
                $contract_id = $_POST['contract_id'];
                $market_id = $_POST['market_id'];
                $open = $_POST['open'];
                $high = $_POST['high'];
                $low = $_POST['low'];
                $close = $_POST['close'];
                $sett = $_POST['sett'];
                $est_volume = $_POST['est_volume'];
                $prior_volume = $_POST['prior_volume'];
                $prior_open_int = $_POST['prior_open_int'];
                $change_button = $_POST['change_button'];

                changeData ($price_id,  $update_date,  $contract_id,  $market_id,  $open,  $high,  $low,  $close,  $sett,  $est_volume,  $prior_volume,  $prior_open_int,  $change_button, $connect);

                $sql_1 = "SELECT search_market_ID, search_date FROM search";
                $result_1 = mysqli_query($connect, $sql_1);
                $row_market_1 = mysqli_fetch_row($result_1);
                $market_id = $row_market_1[0];
                $market_date = $row_market_1[1];
                searchData ($market_id, $market_date, $connect);
            } 
        ?>

        <?php
            if(array_key_exists('delete-button', $_POST)) { 

                $delete_price_id = $_POST['delete_price_id'];
                $sql_3 = "DELETE FROM prices WHERE price_ID = '$delete_price_id'";
                $result_3 = mysqli_query($connect, $sql_3);

                $sql_2 = "SELECT search_market_ID, search_date FROM search";
                $result_2 = mysqli_query($connect, $sql_2);
                $row_market_2 = mysqli_fetch_row($result_2);
                $market_id = $row_market_2[0];
                $market_date = $row_market_2[1];
                searchData ($market_id, $market_date, $connect);

                $delete_price_id = $_POST['delete_price_id'];

            } 
        ?>

        <div class="change-field">
              <form method="post">
                <input type="text" id="price_id" name="price_id" placeholder=" * ">
                <input type="text" id="update_date" name="update_date">
                <input type="text" id="contract_id" name="contract_id">
                <input type="text" id="market_id" name="market_id">
                <input type="text" id="open" name="open">
                <input type="text" id="high" name="high">
                <input type="text" id="low" name="low">
                <input type="text" id="close" name="close">
                <input type="text" id="sett" name="sett">
                <input type="text" id="est_volume" name="est_volume">
                <input type="text" id="prior_volume" name="prior_volume">
                <input type="text" id="prior_open_int" name="prior_open_int">
                <input type="submit" id="change_button" name="change_button" value="Change">
              </form>
        </div>

        <div class="delete-field">
              <form method="post">
                <input type="text" id="delete_price_id" name="delete_price_id" placeholder=" Enter the price_id ... ">
                <input type="submit" id="delete-button" name="delete-button" value="Delete">
              </form>
        </div>

        <br>
        <?php
            if(array_key_exists('pdf-scrape-button', $_POST)) { 
                // mainScrape($connect);
                
                echo ("========================================");
                /*====== scrape and insert data from modified files ======*/
                $pdf1 = "CT.pdf";
                $pdf2 = "CC.pdf";
                $pdf3 = "KC.pdf";
                $pdf4 = "OJ.pdf";
                $pdf5 = "SB.pdf";

                insertPdfData($pdf1, $connect);
                insertPdfData($pdf2, $connect);
                insertPdfData($pdf3, $connect);
                insertPdfData($pdf4, $connect);
                insertPdfData($pdf5, $connect);
                echo ("========================================");

            }

            if(array_key_exists('txt-scrape-button', $_POST)) { 
                // mainScrape($connect);
                
                echo ("========================================");
                /*====== scrape and insert data from modified files ======*/
                $file1 = "futures.txt";
                $file2 = "comex.txt";
                $file3 = "nymex.txt";

                $fileName_1 = "futures";
                $fileTime_1_old = getFileDate($fileName_1, $connect);
                $fileDate_1 = getTxtFileDate($file1);
                $serverDate = "notServer";
  
                if($fileDate_1 != $fileTime_1_old) {
                    insertTxtData($file1, $connect, $fileDate_1, $serverDate);
                }

                $fileName_2 = "comex";
                $fileTime_2_old = getFileDate($fileName_2, $connect);
                $fileDate_2 = getTxtFileDate($file2);
                
                if($fileDate_2 != $fileTime_2_old) {
                    insertTxtData($file2, $connect, $fileDate_2, $serverDate);
                }

                $fileName_3 = "nymex";
                $fileTime_3_old = getFileDate($fileName_3, $connect);
                $fileDate_3 = getTxtFileDate($file3);
                
                if($fileDate_3 != $fileTime_3_old) {
                    insertTxtData($file3, $connect, $fileDate_3, $serverDate);
                }

                echo ("========================================");

            } 

            if(array_key_exists('server-scrape-button', $_POST)) {
                mainScrape($connect);
            }
        ?> 


      
        <form method="post">
            <br> 
            <input type="submit" name="pdf-scrape-button" class="scrape-button" value="Scraping PDF"/> 
            <input type="submit" name="txt-scrape-button" class="scrape-button" value="Scraping TXT"/> 
            <input type="submit" name="server-scrape-button" class="scrape-button" value="Scraping From Server"/> 
        </form>
  </main>

    <script>
    </script>
</body>
</html>