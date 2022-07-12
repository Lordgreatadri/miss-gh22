<?php
// include_once '../helpers/Database.php';
include_once "db-config.php";
// include_once '../helpers/HelperFunctions.php';

if($_SERVER['REQUEST_METHOD'] == 'GET') 
{
	$startDate = $_GET['startDate'];
	$endDate = $_GET['endDate'];
    $filterKey = $_GET['rawcriteria'];
	$output = "";

    $response = array();
    $votesArray = array();
    $allVotesArray = array();

    if (($startDate != "" || $endDate != "") && $filterKey != "") 
    {
        //query to get the categories
        $query = "SELECT * FROM transactions_completed  WHERE  (DATE(`transaction_date`) BETWEEN '$startDate' AND '$endDate') AND `momo_number` = '$filterKey' AND response_code = '0000' ORDER BY trans_comp_id ASC";

        $result = mysqli_query($database, $query);

        if (mysqli_num_rows($result) > 0) 
        {
            $output .= '"Mobile number","Payment channel", "Amount Billed","Contestant Name","Number Of Votes","Reference","Date"'."\n";

            while ($row = mysqli_fetch_assoc($result)) {
                $number = (string)$row['momo_number'];
                $channel = $row['payment_network'];
                $amount = $row['amount'];
                $nominee = $row['contestant_name'];
                $number_of_votes = $row['number_of_votes'];
                $client_reference = $row['device'];
                $date = $row['transaction_date'];

                $output .= '"'.$number.'",'.'"'.$channel.'",'.'"'.$amount.'",'.'"'.$nominee.'",'.'"'.$number_of_votes.'",'.'"'.$client_reference.'",'.'"'.$date.'"'."\n";
            }

            $filename = "rawbm_Vote_Data.csv";

            header('Content-Type: application/csv');
            header('Content-Disposition: attachment, filename='.$filename);
            echo $output;

            mysqli_close($database);
        } else {
            
            mysqli_close($database);
            echo "<script>
                alert('no data found for date range');
                window.history.back();
            </script>";
        }
    } else if (($startDate == "" && $endDate == "") && $filterKey != "") {
        //query to get the categories
        $query = "SELECT * FROM transactions_completed WHERE `momo_number` = '$filterKey' AND response_code = '0000' ORDER BY trans_comp_id ASC";

        $result = mysqli_query($database, $query);

        if (mysqli_num_rows($result) > 0) {
            $output .= '"Mobile number","Payment channel", "Amount Billed","Contestant Name","Number Of Votes","Reference","Date"'."\n";

            while ($row = mysqli_fetch_assoc($result)) {
               $number = (string)$row['momo_number'];
                $channel = $row['payment_network'];
                $amount = $row['amount'];
                $nominee = $row['contestant_name'];
                $number_of_votes = $row['number_of_votes'];
                $client_reference = $row['device'];
                $date = $row['transaction_date'];

                $output .= '"'.$number.'",'.'"'.$channel.'",'.'"'.$amount.'",'.'"'.$nominee.'",'.'"'.$number_of_votes.'",'.'"'.$client_reference.'",'.'"'.$date.'"'."\n";
            }

            $filename = "ms_Vote_Data.csv";

            header('Content-Type: application/csv');
            header('Content-Disposition: attachment, filename='.$filename);
            echo $output;

            mysqli_close($database);
        } else {
            
            mysqli_close($database);
            echo "<script>
                alert('no data found for keyword');
                window.history.back();
            </script>";
        }
    } else if (($startDate != "" && $endDate != "") && $filterKey == "") {
        //query to get the categories
        $query = "SELECT * FROM transactions_completed WHERE DATE(`transaction_date`) BETWEEN '$startDate' AND '$endDate' AND response_code = '0000' ORDER BY trans_comp_id ASC";

        $result = mysqli_query($database, $query);

        if (mysqli_num_rows($result) > 0) {
            $output .= '"Mobile number","Payment channel", "Amount Billed","Contestant Name","Number Of Votes","Reference","Date"'."\n";

            while ($row = mysqli_fetch_assoc($result)) {
                $number = (string)$row['momo_number'];
                $channel = $row['payment_network'];
                $amount = $row['amount'];
                $nominee = $row['contestant_name'];
                $number_of_votes = $row['number_of_votes'];
                $client_reference = $row['device'];
                $date = $row['transaction_date'];

                $output .= '"'.$number.'",'.'"'.$channel.'",'.'"'.$amount.'",'.'"'.$nominee.'",'.'"'.$number_of_votes.'",'.'"'.$client_reference.'",'.'"'.$date.'"'."\n";
            }

            $filename = "bmp_Vote_Data.csv";

            header('Content-Type: application/csv');
            header('Content-Disposition: attachment, filename='.$filename);
            echo $output;

            mysqli_close($database);
        } else {
            
            mysqli_close($database);
            echo "<script>
                alert('no data found for date range');
                window.history.back();
            </script>";
        }
    } else {
        //query to get the categories
        $query = "SELECT * FROM transactions_completed WHERE  response_code = '0000'  ORDER BY trans_comp_id ASC";

        $result = mysqli_query($database, $query);

        if (mysqli_num_rows($result) > 0) {
            $output .= '"Mobile number","Payment channel", "Amount Billed","Contestant Name","Number Of Votes","Reference","Date"'."\n";

            while ($row = mysqli_fetch_assoc($result)) {
                $number = (string)$row['momo_number'];
                $channel = $row['payment_network'];
                $amount = $row['amount'];
                $nominee = $row['contestant_name'];
                $number_of_votes = $row['number_of_votes'];
                $client_reference = $row['device'];
                $date = $row['transaction_date'];

                $output .= '"'.$number.'",'.'"'.$channel.'",'.'"'.$amount.'",'.'"'.$nominee.'",'.'"'.$number_of_votes.'",'.'"'.$client_reference.'",'.'"'.$date.'"'."\n";
            }

            $filename = "rawVote_Data.csv";

            header('Content-Type: application/csv');
            header('Content-Disposition: attachment, filename='.$filename);
            echo $output;

            mysqli_close($database);
        } else {
            
            mysqli_close($database);
            echo "<script>
                alert('no data found');
                window.history.back();
            </script>";
        }
    }
}


?>