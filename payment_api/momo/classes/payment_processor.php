<?php
	include_once 'includes/autoloader.inc.php';


	class payment_processor //extends momo_data_auth 
	{		

		// call to the generic hubtel momo api...........
		public function hubtel_api_request($current_network, $momo_number, $momo_amount, $service_name, $device, $api_key, $contestant_id, $contestant_name, $contestant_num, $category) //, $callback_url, $service_description
		{
			try 
			{
				$callback_url = 'https://mysmsinbox.com/miss_ghana/payment_api/momo/';
				$service_description = 'Miss Ghana';

				$params = array(
					"service" => "receiveMomoRequest",
			        "contestant_id" => $contestant_id,
			        "channel" => $current_network,  
			        "number" => $momo_number,
			        "amount" => $momo_amount,
			        "nominee_name" => $contestant_name,
			        "device" => "online"
				);
				$data = json_encode($params);

				$ch =   curl_init('https://mysmsinbox.com/miss_ghana_api/');  //mysmsinbox.com https://mysmsinbox.com/generic_api/hubtel_momo/execute_pay.php
						curl_setopt( $ch, CURLOPT_POST, true );  
						// curl_setopt( $ch, CURLOPT_POSTFIELDS, array(
						// 	'current_channel' => $current_network,
						// 	'momo_number'     => $momo_number,
						// 	'momo_amount'     => $momo_amount,//0.1,//
						// 	'service_name'    => $service_name,
						// 	'device'          => $device,
						// 	'callback_url'    => $callback_url,
						// 	'service_description'=> $service_description,
						// 	'api_key'         => "33ffc38bcaff137103b94abb0480f966"
						// ));  
						curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
						curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
						curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					        'Cache-Control: no-cache',
					        'Content-Type: application/json',
					    ));

					$result = curl_exec($ch); 
					$err = curl_error($ch);
					curl_close($ch);

					// var_dump($result);
			        $createdTime = date("Y-m-d");
			        $file1 = fopen("logs/mass_Request-$createdTime.log",'a');
			        fwrite($file1, json_encode($params)."\n");
			        fclose($file1);


			        if ($err) {
			        	$createdTime = date("Y-m-d");
			            $file2 = fopen("logs/mass_Error-$createdTime.log",'a');
			            fwrite($file2, json_encode($err)."\n");
			            fclose($file2);
			        }


			    $json = json_decode($result, true);

	            // file_put_contents('logs/reqResult.log', print_r($json, true));

	            // database object.............
	            $transactions_initiated = new momo_data_auth();
	            // logging to database............
	            $transactions_initiated->logPaymentRequest($json['Data']['TransactionId'], 'Pending', $json['ResponseCode'], $momo_number, $current_network, $momo_amount, $momo_amount, $contestant_id, $contestant_name, $contestant_num, $device, $json['Message'], $category);


	            file_put_contents('logs/jSonResult.log', print_r($json, true));

			} catch (Exception $exc) {
				echo __LINE__ . $exc->getMessage();
			}
		}
















		// formating channel type from momo number........
		public function get_channel_type($voter_number) 
		{
			try 
			{
				//first check if the number recieved in 233 format........
				$myNew_value=null;
				$voting_number ='';//count($striped_num)
				if(strlen($voter_number) > 10)
				{	
					//convert your string into array
					$array_num = str_split($voter_number);

					for($i = 3; $i < count($array_num) ; $i++)
					{	     
					    $myNew_value .= $array_num[$i];
					}
					 
					$voting_number = '0'. $myNew_value;
				}else
				{
					$voting_number = $voter_number;	
				}

				//check for channell type.................................
				$result = substr($voting_number, 0, 3);

				$network = '';
				if(trim($result)  == '054'  || trim($result) == '055' || trim($result) == '024' || trim($result) == '059' || trim($result) == '025')
				{
					$network = 'mtn-gh';
					
				}elseif($result == '027' || $result == '057' || $result == '026' || $result == '056') 
				{
					$network = 'tigo-gh';
				}elseif($result == '020' || $result == '050') 
				{
					$network = 'vodafone-gh-ussd';
				}else{
					$network = 'mtn-gh';
				}

				return $network;
				// var_dump($network);
			} catch (Exception $exc) 
			{
				echo __LINE__ . $exc->getMessage();
			}
		}









 /*
	        Array
			(
			[Message] => Transaction pending. Expect callback request for final state.
			[ResponseCode] => 0001
			[Data] => Array
			    (
			        [TransactionId] => c822726e63e74402bfaf1ef17fefdad2
			        [Description] => Bumper to bumper dance reality show.
			        [ClientReference] => 23214
			        [Amount] => 1
			        [Charges] => 0.02
			        [AmountAfterCharges] => 0.98
			        [AmountCharged] => 1
			        [DeliveryFee] => 0
			    )

			)*/





		
	}