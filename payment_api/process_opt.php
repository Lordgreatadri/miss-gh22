<?php
    $serverName = "192.168.193.254";
    $databaseName = "miss_ghana"; #"";
    $databaseUser = "adri";
    $databasePassword = 'adRi@1234&5$HaW9(1&Mcc'; #"#4kLxMzGurQ7Z~";

    $database = mysqli_connect($serverName, $databaseUser, $databasePassword, $databaseName);

    // if (!$database) {
    //     die("unable to connect to database");
    // }else{
    // 	echo "string";
    // }
    $otpCOde = rand(100000,999999);
    $opt_code= substr($otpCOde, 0, 4);

    
    $momo_number = ucwords(htmlspecialchars(htmlentities(trim(strip_tags($_POST["number"]))))) ;
	// ucwords(htmlspecialchars(htmlentities(trim(strip_tags($_POST["opt_code"])))));
	$contestant_id = htmlspecialchars(htmlentities(trim(strip_tags($_POST["contestant_id"]))));
	$contestant_name = htmlspecialchars(htmlentities(trim(strip_tags($_POST["contestant_name"]))));
	$amount = htmlspecialchars(htmlentities(trim(strip_tags($_POST["amount"]))));
	// $contestant_num = htmlspecialchars(htmlentities(trim(strip_tags($_POST["contestant_num"]))));
	$category = htmlspecialchars(htmlentities(trim(strip_tags($_POST["category"]))));
	$channel = htmlspecialchars(htmlentities(trim(strip_tags($_POST["channel"]))));




    if (strlen($momo_number) != 10) 
    {
        $response['success'] = false;
        $response['message'] = 'Wrong momo number format.';
        $response['ResponseCode'] = '400';             

        mysqli_close($database);
        
        header('Content-Type: application/json');
        echo json_encode($response);

        die();
        die();
    } 
    

    if(trim(!is_numeric($momo_number))) 
    {
        $response['success'] = false;
        $response['message'] = 'Wrong momo number format submitted. Enter correct momo number';
        $response['ResponseCode'] = '400';             

        mysqli_close($database);

        header('Content-Type: application/json');
        echo json_encode($response);

        die();
    }


    
	function sendOTP($message, $user_number)
	{
		$myNew_value = null;
        $raw_number  ='';
        if(strlen($user_number) == 10)
        {   //convert your string into array
            $array_num = str_split($user_number);

            for($i = 1; $i <count($array_num) ; $i++)
            {        
                $myNew_value .= $array_num[$i];
            }
             
            $raw_number = '233'. $myNew_value;

        }else
        {
            $raw_number = $user_number; 
        }
        
        $msisdn = $raw_number;//var_dump($msisdn);
        $message = urlencode($message);//200.2.168.175:2199 54.163.215.114  34.230.90.80
        $url = "http://54.163.32.178:2788/Receiver?User=mycloudhttp&Pass=M1C2T3&From=1413&To=$msisdn&Text=$message";
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
            //var_dump($result);
        }
        // echo json_encode($result);
        curl_close($curl);
	}


    $getclientQuery = "SELECT * FROM opt_code WHERE momo_number = '$momo_number' ORDER BY id ASC";

    $getclientResult = mysqli_query($database, $getclientQuery);

    if (mysqli_num_rows($getclientResult) > 5) 
    {
        $response['success'] = false;
        $response['code'] = "WARNING";
        $response["message"] = 'You have initiated multiple requests without submitting your OTP code. Any further attempt will report your phone number to your network provider =>'.$contestant_name;
        header('Content-Type: application/json');
        echo json_encode($response);

        $date = date("Y-m-d H:i:s");
        mysqli_query($database, "UPDATE opt_code SET warning = 'True', warning_date = '$date' WHERE momo_number = '$momo_number' ");

        $delete_Code = "DELETE FROM opt_code WHERE momo_number = '$momo_number' "; 
        mysqli_query($database, $delete_Code);


        mysqli_close($database);


        die();
        die();
    }


    $insertUserQuery = "INSERT INTO opt_code(momo_number, opt_code, contestant_id, contestant_name, contestant_num, category, vote_count, amount, channel) VALUES('$momo_number', '$opt_code', '$contestant_id', '$contestant_name', '$contestant_id', '$category', '$amount', '$amount', '$channel')";
	// die($insertUserQuery);
	if (mysqli_query($database, $insertUserQuery)){
		$response['success'] = true;
        $response["message"] = 'Enter OTP code sent to your momo number to proceed voting for '.$contestant_name;
        $response['opt'] = 'OPT-'.$opt_code;
        $response['code'] = "";

        $message = "Miss Ghana:\nYour OTP code is ".$opt_code."\nEnter code to verify your momo number. If you did not initiate this transaction, kindly ignore. Thank you.";
        sendOTP($message, $momo_number);

        mysqli_close($database);

        header('Content-Type: application/json');
        echo json_encode($response);
	}