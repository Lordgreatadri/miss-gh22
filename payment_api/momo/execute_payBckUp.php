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

			$database = mysqli_connect("127.0.0.1", "root", "#4kLxMzGurQ7Z~", "gadangme");
			$getCodeQuery = "SELECT * FROM  opt_code WHERE momo_number = '$momo_number' AND opt_code = '$opt_code' ORDER BY date_stamp DESC LIMIT 1";

	        $getCodeResult = mysqli_query($database, $getCodeQuery);

	        if (mysqli_num_rows($getCodeResult) > 0) {
	            
	            while ($row = mysqli_fetch_assoc($getCodeResult)) {

	            	$databaseCode = $row['opt_code'];	
	            }


	            if (trim($databaseCode == $opt_code)) 
	            {
			        $delete_Code = "DELETE FROM opt_code WHERE momo_number = '$momo_number' "; 
			        mysqli_query($database, $delete_Code);


					if (trim(strlen($_POST['channel'])) == 'visa_card') 
					{
						// process visa payment here...........

					} else
					{
						if (trim(strlen($_POST['number'])) == 10 ) 
						{

							$result = $data_Obj->hubtel_api_request($current_network, $_POST['number'], $_POST['amount'], "DANGME", $_POST['device'],  $_POST['api_key'], $_POST['contestant_id'], $_POST['contestant_name'], $_POST['contestant_num'], $_POST['category']); //$callback_url, $service_description,

							$response['Success'] = true;
							$statusArray['Message'] = 'Vote is being processed. Check and confirm payment!';
							$statusArray['ResponseCode'] = '301';
							$response['Data'] = $statusArray;				

				            header('Content-Type: application/json');
						    echo json_encode($response);
						} else {
							$response['Success'] = false;
							$statusArray['Message'] = 'Wrong momo number format.';
							$statusArray['ResponseCode'] = '400';
							$response['Data'] = $statusArray;				

				            header('Content-Type: application/json');
						    echo json_encode($response);
						}
					}
	            } else {
	            	$response['Success'] = false;
					$statusArray['Message'] = 'The code '.$_POST['opt_code']. " you entered is not correct!";
					$statusArray['ResponseCode'] = '400';
					$response['Data'] = $statusArray;				

		            header('Content-Type: application/json');
				    echo json_encode($response);
	            }
	            
	        }else
	        {
	        	$response['Success'] = false;
				$statusArray['Message'] = 'The code '.$_POST['opt_code']. " you entered does not exist or has been used already.";
				$statusArray['ResponseCode'] = '400';
				$response['Data'] = $statusArray;				

	            header('Content-Type: application/json');
			    echo json_encode($response);
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
	