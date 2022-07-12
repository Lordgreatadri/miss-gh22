<?php

    include_once "db-config.php";

    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        $response = array();
        $votesArray = array();
        $allVotesArray = array();

        //query to get the categories
        // $query = "SELECT * FROM `track_pay` ORDER BY track_id DESC LIMIT 50";

        $query = "SELECT * FROM transactions_completed WHERE response_code = '0000' OR (response_code = '00' AND payment_network = 'VISA') ORDER BY transaction_date DESC LIMIT 0,800";

        $result = mysqli_query($database, $query);

        if (mysqli_num_rows($result) > 0) 
        {
            while ($row = mysqli_fetch_assoc($result)) 
            {
                $votesArray['number'] = $row['momo_number'];
                $votesArray['channel'] = $row['payment_network'];
                $votesArray['amount'] = $row['amount'];
                $votesArray['nominee_name'] = $row['contestant_name'];
                // $votesArray['category'] = $row['category'];
                $votesArray['transaction_date'] = $row['transaction_date'];

                array_push($allVotesArray, $votesArray);
            }

            $response['success'] = true;
        	$response["message"] = 'stats got';
        	$response["data"] = $allVotesArray;

            mysqli_close($database);

            header('Content-Type: application/json');
		    echo json_encode($response);
        } else {
            
        	$response['success'] = false;
            $response["message"] = 'No data';
            $response["data"] = $allVotesArray;

            mysqli_close($database);

            header('Content-Type: application/json');
		    echo json_encode($response);
        }
    }