<?php

    include_once "db-config.php";

    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        $response = array();
        $votesArray = array();
        $allVotesArray = array();

        //query to get the categories
        // $query = "SELECT * FROM `track_pay` ORDER BY track_id DESC LIMIT 50";`t`.`number`,`t`.`channel`, `m`.`device` AS medium,`t`.`amount`,`t`.`nominee_name`,`m`.`when`

        $query = "SELECT * FROM card_pay WHERE vpc_message = 'Approved' ORDER BY `transaction_date` DESC LIMIT 0,300";

        $result = mysqli_query($database, $query);

        if (mysqli_num_rows($result) > 0) 
        {
            while ($row = mysqli_fetch_assoc($result)) 
            {
                $votesArray['number'] = $row['voter_number'];
                $votesArray['channel'] = $row['device'];
                $votesArray['amount'] = $row['vpc_amount'];
                $votesArray['nominee_name'] = $row['contestant_name'];
                $votesArray['when'] = $row['transaction_date'];

                array_push($allVotesArray, $votesArray);
            }

            $response['success'] = true;
        	$response["message"] = 'Record loaded';
        	$response["data"] = $allVotesArray;

            mysqli_close($database);

            header('Content-Type: application/json');
		    echo json_encode($response);
        } else {
            
        	$response['success'] = false;
            $response["message"] = 'No record available';

            mysqli_close($database);

            header('Content-Type: application/json');
		    echo json_encode($response);
        }
    }