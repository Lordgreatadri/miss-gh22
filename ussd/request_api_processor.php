<?php 
	error_reporting();

	include_once 'includes/autoloader.inc.php';
	$dataAccessObj = new MissGhanaModel();

	$contestantId   = "";
	$contestantName = "";
    $contestantNum  = "";
    $category       = "";
    $amount         = "";
    $initiator      = "";
    $voteCount      = "";
    $fullName       = "";

// var_dump("expression");

	foreach($dataAccessObj->getSChosenData() as $row)
	{
		$contestantId   = $row['contestant_id'];
	    $contestantName = $row['contestant_name'];
	    $contestantNum  = $row['contestant_num'];
	    $userEntry      = $row['user_entry'];
	    $category       = $row['category'];
	    $amount         = $row['amount'];
	    $initiator      = $row['initiator'];
	    $voteCount      = $row['vote_count'];
	    $fullName       = $row['full_names'];

	    // var_dump($row);
	}


	// /check channel type from phone number........
	$channelType = $dataAccessObj->getChannelType($initiator);

	$optCode = rand(100000,999999);

	$momoNumber = $dataAccessObj->_formartMOMONumber($initiator);

	//$dataAccessObj->logOPT($momoNumber, $optCode, $contestantId, $contestantName, $contestantNum, $category, $voteCount, $amount, $channelType);

	// $dataAccessObj->initiateHubtelAPI($channelType, $momoNumber, $amount, $contestantName, $contestantId, $contestantNum , $category, $optCode, $fullName);


		$params = array(
		"service" => "receiveMomoRequest",
        "contestant_id" => $contestantId,
        "channel" => $channelType,  
        "number" => $momoNumber,
        "amount" => $amount,
        "nominee_name" => $contestantName,
        "device" => "USSD",
        "request_date" => date("Y-m-d H:i:s")
	);
	$data = json_encode($params);
	//0240974010  233247954362
	$ch =  curl_init('https://mysmsinbox.com/miss_ghana_api/');
	curl_setopt( $ch, CURLOPT_POST, true );
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Cache-Control: no-cache',
        'Content-Type: application/json',
    ));

    $result = curl_exec($ch);
    $err    = curl_error($ch);
    curl_close($ch);
	
	var_dump($result);


	file_put_contents('logs/momo.log', print_r($result, true));

	$dataAccessObj->purgePreviousSession($initiator);

	$createdTime = date("Y-m-d");
    $file1 = fopen("logs/mass_Request-$createdTime.log",'a');
    fwrite($file1, json_encode($params)."\n");
    fclose($file1);


// {
//     "service": "receiveMomoRequest",
//     "contestant_id": {contestant_id},
//     "channel": {channel},
//     "number": {number},
//     "amount": {amount},
//     "nominees_name": {nominee_name},
//     "device": {device}
   
// }




