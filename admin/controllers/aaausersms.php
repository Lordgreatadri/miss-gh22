
<?php

include_once "db-config.php";

$query = "SELECT DISTINCT momo_number FROM momo_completed_transactions WHERE response_code = '0000' AND (contestant_num != 'JANET' AND contestant_num !='ANNABELLE' AND contestant_num !='PRISCILLA'  AND contestant_num !='GETRUDE') GROUP BY momo_number";

$result = mysqli_query($database, $query);

function format_number($voter_number)
{
	//first check if the number recieved in 233 format........
	$myNew_value=null;
	$voting_number ='';//count($striped_num)
	if(strlen($voter_number) == 10)
	{	
		//convert your string into array
		$array_num = str_split($voter_number);

		for($i = 1; $i <count($array_num) ; $i++)
		{	     
		    $myNew_value .= $array_num[$i];
		}
		 
		$voting_number = '233'. $myNew_value;
	}else
	{
		$voting_number = $voter_number;	
	}

	return $voting_number;
}



function sendSMS($msisdn)
{
	// $msisdn = "233544336599";
	$message = "Akyem Most Beautiful:\nHello cherished voter, Thank you for voting for your favorite contestant so far. Another eviction is almost at the corner. Keep voting for your favorite nominee to keep her in the contest. Thank you.";
    $message = urlencode($message);//200.2.168.175:2199 54.163.215.114
    $url = "http://34.230.90.80:2788/Receiver?User=mycloudhttp&Pass=M1C2T3&From=1470&To=$msisdn&Text=$message";
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $url
    ));
   
    $result = curl_exec($curl);
    $error = curl_error($curl);

    if ($error) {
        echo "There was an: ". $error;
    } else{
        // var_dump($result);
    }
    // echo json_encode($result);
    curl_close($curl);

    return $result;
}


while($row = mysqli_fetch_assoc($result)) 
{
	$number = (string)$row['momo_number'];
	
	$msisdn = format_number($number);
	$returns = sendSMS($msisdn);
	var_dump($msisdn.'=>'.$returns.'<br>');
}




