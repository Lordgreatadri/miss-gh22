<?php

    include_once "db-config.php";

    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        $response = array();
        $statsArray = array();

        //query to get the total number contestants
        $getNumberOfContestantsQuery = "SELECT * FROM contestants";
        $getNumberOfContestantsResult = mysqli_query($database, $getNumberOfContestantsQuery);
        $getNumberOfContestants  = mysqli_num_rows($getNumberOfContestantsResult) | 0;

        // query to get the total number of evicted contestants
        $getNumberOfEvictedContestantsQuery = "SELECT * FROM contestants WHERE status ='Evicted'";
        $getNumberOfEvictedContestantsResult = mysqli_query($database, $getNumberOfEvictedContestantsQuery);
        $getNumberOfEvictedContestants  = mysqli_num_rows($getNumberOfEvictedContestantsResult) | 0;

        // query to get the total number of remaining contestants
        $getNumberOfRemainingContestantsQuery = "SELECT * FROM contestants WHERE status ='not_evicted'";
        $getNumberOfRemainingContestantsResult = mysqli_query($database, $getNumberOfRemainingContestantsQuery);
        $getNumberOfRemainingContestants  = mysqli_num_rows($getNumberOfRemainingContestantsResult) | 0;

        // // query to get the total number of valid contestant votes
        // $getNumberOfVotesQuery = "SELECT SUM(num_of_votes) AS num_of_valid_votes FROM contestants";
        // $getNumberOfVotesResult = mysqli_query($database, $getNumberOfVotesQuery);
        // $row = mysqli_fetch_assoc($getNumberOfVotesResult);
        // $getNumberOfValidVotes  = $row['num_of_valid_votes']| 0;


        // query to get the total number of valid contestant votes number_of_votes
        $getNumberOfVotesQuery = "SELECT SUM(`number_of_votes`) AS num_of_valid_votes FROM `transactions_completed` WHERE response_code = '0000'";
        $getNumberOfVotesResult = mysqli_query($database, $getNumberOfVotesQuery);
        $row = mysqli_fetch_assoc($getNumberOfVotesResult);
        $getNumberOfValidVotes  = $row['num_of_valid_votes']| 0;



        // //query to get the total number of votes
        $getTotalNumberOfVotesQuery = "SELECT SUM(`number_of_votes`) as total_vote_num FROM `transactions_completed` WHERE response_code = '0000'";
        $getTotalNumberOfVotesResult = mysqli_query($database, $getTotalNumberOfVotesQuery);
        $row0 = mysqli_fetch_assoc($getTotalNumberOfVotesResult);
        $getTotalNumberOfVotes  = $row0['total_vote_num'] | 0;


         //query to get the total number of votes
        // $getTotalNumberOfVotesQuery = "SELECT SUM(`amount`) as total_vote_num FROM `track_pay` ";
        // $getTotalNumberOfVotesResult = mysqli_query($database, $getTotalNumberOfVotesQuery);
        // $row0 = mysqli_fetch_assoc($getTotalNumberOfVotesResult);
        // $getTotalNumberOfVotes  = $row0['total_vote_num'] | 0;

        // query to get total number of mobile number votes number_of_votes
        $getNumberOfMOMOVotesQuery = "SELECT SUM(`number_of_votes`) as sms_vote_num FROM `transactions_completed` WHERE  response_code = '0000'"; 
        $getNumberOfMOMOVotesResult = mysqli_query($database, $getNumberOfMOMOVotesQuery);
        $row1 = mysqli_fetch_assoc($getNumberOfMOMOVotesResult);
        $getNumberOfMOMOVotes  = $row1['sms_vote_num'] | 0;

        // query to get total number of mobile number votes number_of_votes
        $getNumberOfSMSVotesQuery = "SELECT SUM(`number_of_votes`) as momo_vote_num FROM `transactions_completed` WHERE `payment_channel` = 'sms' AND response_code = '0000'";
        $getNumberOfSMSVotesResult = mysqli_query($database, $getNumberOfSMSVotesQuery);
        $row2 = mysqli_fetch_assoc($getNumberOfSMSVotesResult);
        $getNumberOfSMSVotes  = $row2['momo_vote_num'] | 0;

        // query to get the revenue amount for the momo payment
        $getAmountForMoMoRevenueQuery = "SELECT SUM(number_of_votes) as momo_revenue_amount FROM `transactions_completed` WHERE response_code = '0000' AND vote_channel = 'momo'";
        $getAmountForMoMoRevenueResult = mysqli_query($database, $getAmountForMoMoRevenueQuery);
        $row2 = mysqli_fetch_assoc($getAmountForMoMoRevenueResult);
        $getAmountForMoMoRevenue  = $row2['momo_revenue_amount'] | 0;


        ####################################################################################3
        // $getAmountForCardRevenueQuery = "SELECT SUM(vpc_amount) as visa_revenue_amount FROM `card_pay` WHERE vpc_response_code = '0' AND vpc_message = 'Approved'";
        // $getAmountForCardRevenueResult = mysqli_query($database, $getAmountForCardRevenueQuery);
        // $rowcard = mysqli_fetch_assoc($getAmountForCardRevenueResult);
        // $getAmountForCardRevenue  = $rowcard['visa_revenue_amount'] | 0;

        //visa votes count

        $getNumberOfVISAVotesQuery = "SELECT SUM(`number_of_votes`) as visa_vote_num FROM `transactions_completed` WHERE payment_network = 'VISA' AND response_code = '00'";
        $getNumberOfVISAVotesResult = mysqli_query($database, $getNumberOfVISAVotesQuery);
        $rowv = mysqli_fetch_assoc($getNumberOfVISAVotesResult);
        $getNumberOfVISAVotes  = $rowv['visa_vote_num'] | 0;

        // sum total revenue
        $totalRevenue = $getAmountForMoMoRevenue ;//+ $getAmountForCardRevenue;
        $all_votes = $getTotalNumberOfVotes + $getNumberOfVISAVotes;
        $valid_votes = $getNumberOfValidVotes + $getNumberOfVISAVotes;

        $statsArray["numberOfContestants"] = $getNumberOfContestants;
        $statsArray["numberOfEvictedContestants"] = $getNumberOfEvictedContestants;
        $statsArray["numberOfRemainingContestants"] = $getNumberOfRemainingContestants;
        $statsArray["numberOfValidVotes"] = $valid_votes;
        // $statsArray['numberOfInvalidVotes'] = $all_votes | 0;//($all_votes - $valid_votes) | 0;
        $statsArray["numberOfTotalVotes"] = $all_votes | 0;
        $statsArray["numberOfSMSVotes"] = $getNumberOfVISAVotes;//$getNumberOfSMSVotes;
        $statsArray["numberOfMOMOVotes"] = $getTotalNumberOfVotes | 0;//$getNumberOfMOMOVotes;
        $statsArray["amountForMoMoRevenue"] = $all_votes | 0;//number_format($getAmountForMoMoRevenue);

        // $statsArray["numberOfVISAVotes"] = $getNumberOfVISAVotes;//0;//
        $statsArray["amountForVisaRevenue"] = 0;//number_format($getAmountForCardRevenue);
        $statsArray["amountForTotalRevenue"] = number_format($totalRevenue);

        $response['success'] = true;
        $response["message"] = 'results loaded';
        $response["data"] = $statsArray;

        mysqli_close($database);

        header('Content-Type: application/json');
        echo json_encode($response);
    }