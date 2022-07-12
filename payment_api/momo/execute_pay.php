<?php 

	require_once 'includes/autoloader.inc.php';

	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		if(!empty($_POST['api_key']) && $_POST['api_key'] == "33ffc38bcaff137103b94abb0480f966")
		{
			$data_Obj = new payment_processor();

			$current_network = $data_Obj->get_channel_type($_POST['number']);
			
			$momo_number = $_POST['number'];
			$opt_code = $_POST['opt_code'];
			$databaseCode = "";
			
			$serverName = "192.168.193.254";
		    $databaseName = "miss_ghana"; 
		    $databaseUser = "adri";
		    $databasePassword = 'adRi@1234&5$HaW9(1&Mcc'; 

		    $database = mysqli_connect($serverName, $databaseUser, $databasePassword, $databaseName);

// 		    if (mysqli_connect_errno()) {
// 		        // die("unable to connect to database");
// 		        echo "Failed to connect to MySQL: " . mysqli_connect_error();
// 		    }else
// 		    {
// 		    	echo "Connected true o....".$databaseName;
// 		    }
// die();

// 			$database = mysqli_connect("192.168.193.254", "adri", "adRi@1234&5$HaW9(1&Mcc", "love_right");// #4kLxMzGurQ7Z~

		    if (trim($_POST['channel']) == 'visa_card') 
			{
				mysqli_close($database);


				// process visa payment here...........
				$params = array(
					"event_name"=>"Miss Ghana",
					"service" => "createOrder",
			        "contestant_id" => $_POST['contestant_id'],
			        "amount" => $_POST['amount'],
			        "nominee_name" =>$_POST['contestant_name'],
			        "number" => $_POST['number'],
			        "description" => "Visa card payment for ".$_POST['contestant_name'],
			        "device" => "online"
				);
				$data = json_encode($params);

				$ch =   curl_init('https://mycedipay.com/');
						curl_setopt( $ch, CURLOPT_POST, true );  
						curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
						curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
						curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					        'Cache-Control: no-cache',
					        'Content-Type: application/json',
					    ));

					$result = curl_exec($ch); 
					$err = curl_error($ch);
					curl_close($ch);

					$json = json_decode($result, true);

					$response['Success'] = true;
					$response['Data'] = $json['result']['payment_link'];	
								
					file_put_contents('logs/VisaPlayload.log', print_r($data, true));
					file_put_contents('logs/VisaResult.log', print_r($json, true));
					file_put_contents('logs/VisaErr.log', print_r($err, true));

		            header('Content-Type: application/json');
				    echo json_encode($response);

			}else
			{



				$getCodeQuery = "SELECT * FROM  opt_code WHERE momo_number = '$momo_number' AND opt_code = '$opt_code' ORDER BY id DESC LIMIT 1";

		        $getCodeResult = mysqli_query($database, $getCodeQuery);

		        if (mysqli_num_rows($getCodeResult) > 0) 
		        {	            
		            while ($row = mysqli_fetch_assoc($getCodeResult)) 
		            { 
		            	$databaseCode = $row['opt_code'];	
		            }

		            if (trim($databaseCode == $opt_code)) 
		            {
				        $delete_Code = "DELETE FROM opt_code WHERE momo_number = '$momo_number' "; 
				        mysqli_query($database, $delete_Code);

						if (trim(strlen($_POST['channel'])) == 'visa_cardsss') 
						{
							// process visa payment here...........
							// $params = array(
							// 	"service" => "receiveMomoRequest",
						 //        "contestant_id" => $_POST['contestant_id'],
						 //        "amount" => (double)$_POST['amount'],
						 //        "device" => "online"
							// );
							// $data = json_encode($params);

							// $ch =   curl_init('https://mycedipay.com/');
							// 		curl_setopt( $ch, CURLOPT_POST, true );  
							// 		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
							// 		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
							// 		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
							// 	        'Cache-Control: no-cache',
							// 	        'Content-Type: application/json',
							// 	    ));

							// 	$result = curl_exec($ch); 
							// 	$err = curl_error($ch);
							// 	curl_close($ch);

						} else
						{
							if (trim(strlen($_POST['number'])) == 10 ) 
							{

								$result = $data_Obj->hubtel_api_request($current_network, $_POST['number'], $_POST['amount'], "MissGhana", $_POST['device'],  $_POST['api_key'], $_POST['contestant_id'], $_POST['contestant_name'], $_POST['contestant_num'], $_POST['category']); //$callback_url, $service_description,

								$response['Success'] = true;
								$statusArray['Message'] = 'Vote is being processed. Check and confirm payment!';
								$statusArray['ResponseCode'] = '301';
								$response['Data'] = $statusArray;				

								mysqli_close($database);

					            header('Content-Type: application/json');
							    echo json_encode($response);
							} else {
								$response['Success'] = false;
								$statusArray['Message'] = 'Wrong momo number format.';
								$statusArray['ResponseCode'] = '400';
								$response['Data'] = $statusArray;				

								mysqli_close($database);

					            header('Content-Type: application/json');
							    echo json_encode($response);
							}
						}
		            } else {
		            	$response['Success'] = false;
						$statusArray['Message'] = 'The code '.$_POST['opt_code']. " you entered is not correct!";
						$statusArray['ResponseCode'] = '400';
						$response['Data'] = $statusArray;				


						mysqli_close($database);


			            header('Content-Type: application/json');
					    echo json_encode($response);
		            }
		            
		        }else
		        {
		        	$response['Success'] = false;
					$statusArray['Message'] = 'The code '.$_POST['opt_code']. " you entered does not exist or has been used already.";
					$statusArray['ResponseCode'] = '400';
					$response['Data'] = $statusArray;				


					mysqli_close($database);


		            header('Content-Type: application/json');
				    echo json_encode($response);
		        }
	    	}









			
			// if (trim(strlen($_POST['channel'])) == 'visa_card') 
			// {
			// 	// process visa payment here...........

			// } else
			// {
			// 	if (trim(strlen($_POST['number'])) == 10 ) 
			// 	{

			// 		$result = $data_Obj->hubtel_api_request($current_network, $_POST['number'], $_POST['amount'], "DANGME", $_POST['device'],  $_POST['api_key'], $_POST['contestant_id'], $_POST['contestant_name'], $_POST['contestant_num'], $_POST['category']); //$callback_url, $service_description,

			// 		$response['Success'] = true;
			// 		$statusArray['Message'] = 'Vote is being processed. Check and confirm payment!';
			// 		$statusArray['ResponseCode'] = '301';
			// 		$response['Data'] = $statusArray;				

		 //            header('Content-Type: application/json');
			// 	    echo json_encode($response);
			// 	} else {
			// 		$response['Success'] = false;
			// 		$statusArray['Message'] = 'Wrong momo number format.';
			// 		$statusArray['ResponseCode'] = '400';
			// 		$response['Data'] = $statusArray;				

		 //            header('Content-Type: application/json');
			// 	    echo json_encode($response);
			// 	}
			// }			
		}else{
			$response['Success'] = false;
			$statusArray['Message'] = 'Non-Authorized Request.';
			$statusArray['ResponseCode'] = '401';
			$response['Data'] = $statusArray;				

            header('Content-Type: application/json');
		    echo json_encode($response);
		}
	} else {
		
	}
	