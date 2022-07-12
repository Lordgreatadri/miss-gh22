<?php
	include_once 'includes/autoloader.inc.php';

	/**
	* USSD API Development
	*https://mysmsinbox.com/miss_ghana/ussd/miss_ghana_ussd_request.php
	*/
	/**------------------------------------------------------------------------------------------------------------------------------------------------
 * @@Name:              miss_ghana_ussd_request file
 
 * @@Author: 			Lordgreat - Adri Emmanuel <'rexmerlo@gmail.com'>
 
 * @Date:   			2022-05-04 22:10:30
 * @Last Modified by:   Lordgreat -  Adri Emmanuel
 * @Last Modified time: 2022-05-05 22:35:30

 * @Copyright: 			MobileContent.Com Ltd <'owner'>
 
 * @Website: 			https://mobilecontent.com.gh
 *---------------------------------------------------------------------------------------------------------------------------------------------------
 */
// echo "hi";   *711*51#

$ussdRequest     = json_decode(@file_get_contents('php://input')); 

file_put_contents('logs/ussdRequest.log', print_r($ussdRequest, true));

$dataAccessObj = new MissGhanaModel();



if($ussdRequest != NULL) 
{
	
	//Create a response object. 
	$ussdResponse  = new stdClass; 
	$dataAccessObj = new MissGhanaModel();

	if($ussdRequest->Type == "Initiation") //233207743783 0244480008
	{
		// if($ussdRequest->Mobile != '233543645688' && $ussdRequest->Mobile != '233206846412' && $ussdRequest->Mobile != '233244480008' && $ussdRequest->Mobile != '233540116637' && $ussdRequest->Mobile != '233544336599') {
		// 	$ussdResponse->Message = "Welcome to Miss Ghana 2022\nUpdate is currently ongoing. Try again after sometime. Thank you";
		// 	$ussdResponse->Type = "Release";
		// 	// $ussdResponse->ClientState = 'Sequence1';
		// 	header('Content-type: application/json; charset=utf-8');
		// 	echo json_encode($ussdResponse);
		// 	die();
		// }else{
			$ussdResponse->Message = "Miss Ghana 2022\n\nChoose Option\n1. Baroness\n2. Francisca\n3. Irene Vanessa\n4. Rukayatu\n5. Emefa\n6. Rebecca\n00. Next Page\n#. App Link\n99. More info";
			$ussdResponse->Type = "Response";
			$ussdResponse->ClientState = 'Sequence1';
			header('Content-type: application/json; charset=utf-8');
			echo json_encode($ussdResponse);


			$duplicate = 0;
			$duplicate = $dataAccessObj->crossCheckPreviousSession($ussdRequest->Mobile);

			if (trim($duplicate) > 0) 
			{
				$dataAccessObj->purgePreviousSession($ussdRequest->Mobile);
			}
			die();
			die();
		// }
	}














	// ***************** SEQUENCE 2   *****************************
	if($ussdRequest->Sequence == "2")
	{
		#get app link for the user
		if(trim($ussdRequest->Message) == "#" || trim(strtoupper($ussdRequest->Message)) == "APP LINK" ) 
		{
			//https://play.google.com/store/apps/details?id=com.mcc.missghana

			$message = "Dear Voter;\n\nFollow the link below to download Miss Ghana App\nhttps://play.google.com/store/apps/details?id=com.mcc.missghana\nVote online via: bit.ly/missgha";
			// $response = $dataAccessObj->sendAppDownloadLink($message, $ussdRequest->Mobile);
			// $dataAccessObj->logDownloaders($ussdRequest->Mobile, $response);
			
			// $ussdResponse->Message = "Dear Voter:\n\nThe app download link will be sent to you via sms on ".$ussdRequest->Mobile.". Thank you";
			$ussdResponse->Message = "Dear Voter:\n\nThe app download link will be ready soon. Thank you";
			$ussdResponse->Type = "Release";
			// $ussdResponse->ClientState = 'contestant2';
			header('Content-type: application/json; charset=utf-8');
			echo json_encode($ussdResponse);
			die();
		}

		#user select more info
		if(trim($ussdRequest->Message) == "99" || trim(strtoupper($ussdRequest->Message)) == "MORE INFO" ) 
		{
			$ussdResponse->Message = "You can vote online for your favorite nominee via\nbit.ly/missgha\n Thank you";
			$ussdResponse->Type = "Release";
			// $ussdResponse->ClientState = 'contestant2';
			header('Content-type: application/json; charset=utf-8');
			echo json_encode($ussdResponse);
			die();
		}


		#user select next page
		if(trim($ussdRequest->Message) == "00" || trim(strtoupper($ussdRequest->Message)) == "NEXt PAGE" ) 
		{
			$ussdResponse->Message = "Choose Option\n\n7. Mimi\n8. Miriam\n9. Esther\n10. Diana\n11. Florence\n12. Dzifa\n13. Angela\n00. Next Page";
			$ussdResponse->Type = "Response";
			$ussdResponse->ClientState = 'contestant2';
			header('Content-type: application/json; charset=utf-8');
			echo json_encode($ussdResponse);
			die();
		}




		#user selected the nominee to vote for
		if($ussdRequest->ClientState == 'Sequence1')
		{
			$contestantId   = "";
			$contestantName = "";
	        $contestantNum  = "";
	        $category       = "";
	        $fullName       = "";

	        
	        foreach($dataAccessObj->verifyCurrentContestantData($ussdRequest->Message) as $row )
	        {
	        	$contestantId   = $row['contestant_id'];
	            $contestantName = $row['contestant_name'];
	            $contestantNum  = $row['contestant_num'];
	            // $category       = $row['category'];
	            // $fullName       = $row['full_names'];
	            file_put_contents('logs/con_queryTab1.log', print_r($contestantName, true));
	        }

			// file_put_contents('logs/con_queryTab1.log', print_r($contestantName, true));

			#selected nominee exist...................
			if( trim($ussdRequest->Message) == $contestantId || trim(strtoupper($ussdRequest->Message)) == trim(strtoupper($contestantName))  || trim(strtoupper($ussdRequest->Message)) == trim($contestantNum) )  
	        {	
	        	$dataAccessObj->logCurrentSessionData($ussdRequest->Message, $ussdRequest->Mobile, $contestantId, $contestantNum, $contestantName,  "2", '1');//$category, $fullName,


	          	$ussdResponse->Message = "Bulk votes for ".$contestantName."\n1. vote=ghc1\n2. 5 votes=ghc5\n3. 10 votes=ghc10\n4. 50 votes=ghc50\n5. 100 votes=ghc100\n6. 500 votes=ghc500\n7. 1000 votes=ghc1000";
			    $ussdResponse->ClientState = 'PAYMENT1';
			    $ussdResponse->Type = "Response";
			    header('Content-type: application/json; charset=utf-8');
				echo json_encode($ussdResponse);

				die();
	        }else
	        {
	        	$ussdResponse->Message = "Sorry, wrong entry or your nominee is already evicted.\nTry again";
	        	$ussdResponse->ClientState = 'contestant2';
			    $ussdResponse->Type = "Response";
			    header('Content-type: application/json; charset=utf-8');
				echo json_encode($ussdResponse);
				die();
	        }

			header('Content-type: application/json; charset=utf-8');
			echo json_encode($ussdResponse);
			die();
		}else
		{
			$ussdResponse->Message = "Sorry, your selection was wrong. Try again";
			$ussdResponse->Type = "Release";
			header('Content-type: application/json; charset=utf-8');
			echo json_encode($ussdResponse);
			die();
		}
	}























	// ***************** SEQUENCE 3   *****************************
	if($ussdRequest->Sequence == "3")
	{
		#get app link for the user
		if(trim($ussdRequest->Message) == "#" || trim(strtoupper($ussdRequest->Message)) == "APP LINK" ) 
		{
			$ussdResponse->Message = "Dear Voter;\n\nThe app download link will be ready soon. Thank you";
			$ussdResponse->Type = "Release";
			// $ussdResponse->ClientState = 'contestant2';
			header('Content-type: application/json; charset=utf-8');
			echo json_encode($ussdResponse);
			die();
		}


		#user select next page
		if(trim($ussdRequest->Message) == "00" || trim(strtoupper($ussdRequest->Message)) == "NEXt PAGE" ) 
		{
			$ussdResponse->Message = "Choose Option\n\n14. Ayishetu\n15. Esi\n16. Yirenkyiwaa\n17. Cassie\n18. Rocklyn\n#. App Link";
			$ussdResponse->Type = "Response";
			$ussdResponse->ClientState = 'contestant3';
			header('Content-type: application/json; charset=utf-8');
			echo json_encode($ussdResponse);
			die();
		}



		#user was on the second page.................
		if($ussdRequest->ClientState == 'contestant2') 
		{
			#user want to know the onlikne portal link.............
			if(trim($ussdRequest->Message) == '99') 
			{
				$ussdResponse->Message = "Visit:\nbit.ly/missgha\nTo vote online for your favourite nominee.";
			    $ussdResponse->Type = "Release";
			    header('Content-type: application/json; charset=utf-8');
				echo json_encode($ussdResponse);
				die();
			}



			$contestantId   = "";
			$contestantName = "";
	        $contestantNum  = "";
	        $category       = "";
	        $fullName       = "";

	        
	        foreach($dataAccessObj->verifyCurrentContestantData($ussdRequest->Message) as $row )
	        {
	        	$contestantId   = $row['contestant_id'];
	            $contestantName = $row['contestant_name'];
	            $contestantNum  = $row['contestant_num'];
	            // $category       = $row['category'];
	            // $fullName       = $row['full_names'];
	            file_put_contents('logs/con_queryTab2.log', print_r($contestantName, true));
	        }

			// file_put_contents('logs/con_queryTab2.log', print_r($contestantName, true));


			#check if the selected nominee exist...................
			if( trim($ussdRequest->Message) == $contestantId || trim(strtoupper($ussdRequest->Message)) == trim(strtoupper($contestantName))  || trim(strtoupper($ussdRequest->Message)) == trim($contestantNum) ) 
	        {

				$dataAccessObj->logCurrentSessionData($ussdRequest->Message, $ussdRequest->Mobile, $contestantId, $contestantNum, $contestantName,  "3", '2');//$category, $fullName,

	          	$ussdResponse->Message = "Bulk votes for ".$contestantName."\n1. vote=ghc1\n2. 5 votes=ghc5\n3. 10 votes=ghc10\n4. 50 votes=ghc50\n5. 100 votes=ghc100\n6. 500 votes=ghc500\n7. 1000 votes=ghc1000";
			    $ussdResponse->ClientState = 'PAYMENT2';
			    $ussdResponse->Type = "Response";
			    header('Content-type: application/json; charset=utf-8');
				echo json_encode($ussdResponse);

				die();
	        }else
	        {
	        	$ussdResponse->Message = "Sorry, wrong entry or your nominee was already evicted.";
			    $ussdResponse->Type = "Release";
			    header('Content-type: application/json; charset=utf-8');
				echo json_encode($ussdResponse);

				$dataAccessObj->purgePreviousSession($ussdRequest->Mobile);
				die();
	        }
		}//user selected the payment plan................
		elseif($ussdRequest->ClientState == 'PAYMENT1') 
		{
			$contestantId   = "";
			$contestantName = "";
	        $contestantNum  = "";
	        $category       = "";
	        $userEntry      = "";
	        $fullName = "";

			foreach($dataAccessObj->getPreviusSessionData($ussdRequest->Mobile) as $row){
				$contestantId   = $row['contestant_id'];
	            $contestantName = $row['contestant_name'];
	            $contestantNum  = $row['contestant_num'];
	            $userEntry      = $row['user_entry'];
	            $category       = $row['category'];
	            $fullName       = $row['full_names'];
			} 

			// check payment amount.........
			$voteAmount = 0;
			if(trim($ussdRequest->Message) == '1') 
			{
				$voteAmount = '1.00';
			}elseif(trim($ussdRequest->Message) == '2')
			{
				$voteAmount = '5.00';
			}elseif(trim($ussdRequest->Message) == '3')
			{
				$voteAmount = '10.00';
			}elseif(trim($ussdRequest->Message) == '4')
			{
				$voteAmount = '50.00';
			}elseif(trim($ussdRequest->Message) == '5')
			{
				$voteAmount = '100.00';
			}elseif(trim($ussdRequest->Message) == '6')
			{
				$voteAmount = '500.00';
			}
			elseif(trim($ussdRequest->Message) == '7'){
				$voteAmount = '1000.00';
			}
			else
			{

				$ussdResponse->Message = "Wrong entry. Retry\n1. vote=ghc1\n2. 5 votes=ghc5\n3. 10 votes=ghc10\n4. 50 votes=ghc50\n5. 100 votes=ghc100\n6. 500 votes=ghc500\n7. 1000 votes=ghc1000";
			    $ussdResponse->Type    = "Response";
			    $ussdResponse->ClientState = 'PAYMENT2';
			    header('Content-type: application/json; charset=utf-8');
				echo json_encode($ussdResponse);
				die();
			}

			#update user session and pass for vote processing.........., session_level, session_tab

    		$dataAccessObj->updateCurrentSessionData($voteAmount, $voteAmount, $contestantId, $contestantName, $contestantNum, $userEntry, '3', '1', $ussdRequest->Mobile, $fullName);

			// submit request to payment_api_processor..........
			#alert user to authorize payment then pass session data to payment API.............
			$ussdResponse->Message = "Please authorize payment of 'Gh".$voteAmount.".00' on '".$ussdRequest->Mobile."', for ".$contestantName.". Thank you.";
		 	$ussdResponse->Type    = "Release";
		 	exec("php /var/www/html/mysmsinbox/miss_ghana/ussd/request_api_processor.php  > /tmp/MissGhanahtussd.log 2>&1 &");
			header('Content-type: application/json; charset=utf-8');
			echo json_encode($ussdResponse);

			die();			
		}else
		{
			$ussdResponse->Message = 'Sorry your entry was wrong';
			$ussdResponse->Type    = "Release";
			header('Content-type: application/json; charset=utf-8');
			echo json_encode($ussdResponse);

			$dataAccessObj->purgePreviousSession($ussdRequest->Mobile);
			die();
		}
	}


























	// ***************** SEQUENCE 4   *****************************
	if($ussdRequest->Sequence == "4")
	{	
		#get app link for the user
		if(trim($ussdRequest->Message) == "#" || trim(strtoupper($ussdRequest->Message)) == "APP LINK" ) 
		{
			$ussdResponse->Message = "Dear Voter;\n\nThe app download link will be ready soon. Thank you";
			$ussdResponse->Type = "Release";
			// $ussdResponse->ClientState = 'contestant2';
			header('Content-type: application/json; charset=utf-8');
			echo json_encode($ussdResponse);
			die();
		}


		#user was on the second page.................
		if($ussdRequest->ClientState == 'contestant3') 
		{
			#user want to know the onlikne portal link.............
			if(trim($ussdRequest->Message) == '0') 
			{
				$ussdResponse->Message = "Visit:\nbit.ly/missgha\nTo vote online for your favourite nominee.";
			    $ussdResponse->Type = "Release";
			    header('Content-type: application/json; charset=utf-8');
				echo json_encode($ussdResponse);
				die();
			}



			$contestantId   = "";
			$contestantName = "";
	        $contestantNum  = "";
	        $category       = "";
	        $fullName       = "";

	        
	        foreach($dataAccessObj->verifyCurrentContestantData($ussdRequest->Message) as $row )
	        {
	        	$contestantId   = $row['contestant_id'];
	            $contestantName = $row['contestant_name'];
	            $contestantNum  = $row['contestant_num'];
	            $category       = $row['category'];
	            $fullName       = $row['full_names'];
	            file_put_contents('logs/con_queryTab3.log', print_r($contestantName, true));
	        }

			
			// file_put_contents('logs/con_queryTab3.log', print_r($contestantName, true));


			#check if the selected nominee exist...................
			if( trim($ussdRequest->Message) == $contestantId || trim(strtoupper($ussdRequest->Message)) == trim(strtoupper($contestantName))  || trim(strtoupper($ussdRequest->Message)) == trim($contestantNum) ) 
	        {

				$dataAccessObj->logCurrentSessionData($ussdRequest->Message, $ussdRequest->Mobile, $contestantId, $contestantNum, $contestantName, $category, $fullName, "3", '2');

	          	$ussdResponse->Message = "Bulk votes for ".$contestantName."\n1. vote=ghc1\n2. 5 votes=ghc5\n3. 10 votes=ghc10\n4. 50 votes=ghc50\n5. 100 votes=ghc100\n6. 500 votes=ghc500\n7. 1000 votes=ghc1000";
			    $ussdResponse->ClientState = 'PAYMENT3';
			    $ussdResponse->Type = "Response";
			    header('Content-type: application/json; charset=utf-8');
				echo json_encode($ussdResponse);

				die();
	        }else
	        {
	        	$ussdResponse->Message = "Sorry, wrong entry or your nominee was already evicted.";
			    $ussdResponse->Type = "Release";
			    header('Content-type: application/json; charset=utf-8');
				echo json_encode($ussdResponse);

				$dataAccessObj->purgePreviousSession($ussdRequest->Mobile);
				die();
	        }
		}



		
		#user is doing payment from the second page...........
		if($ussdRequest->ClientState == 'PAYMENT2') 
		{
			$contestantId   = "";
			$contestantName = "";
	        $contestantNum  = "";
	        $category       = "";
	        $userEntry      = "";
			$fullName = "";

			foreach($dataAccessObj->getPreviusSessionData($ussdRequest->Mobile) as $row){
				$contestantId   = $row['contestant_id'];
	            $contestantName = $row['contestant_name'];
	            $contestantNum  = $row['contestant_num'];
	            $userEntry      = $row['user_entry'];
	            $category       = $row['category'];
	            $fullName       = $row['full_names'];
			}

			// check payment amount.........
			$voteAmount = 0;
			if(trim($ussdRequest->Message) == '1') 
			{
				$voteAmount = '1.00';
			}elseif(trim($ussdRequest->Message) == '2')
			{
				$voteAmount = '5.00';
			}elseif(trim($ussdRequest->Message) == '3')
			{
				$voteAmount = '10.00';
			}elseif(trim($ussdRequest->Message) == '4')
			{
				$voteAmount = '50.00';
			}elseif(trim($ussdRequest->Message) == '5')
			{
				$voteAmount = '100.00';
			}elseif(trim($ussdRequest->Message) == '6')
			{
				$voteAmount = '500.00';
			}
			elseif(trim($ussdRequest->Message) == '7'){
				$voteAmount = '1000.00';
			}
			else
			{
				$ussdResponse->Message = "Wrong entry. Retry\n1. vote=ghc1\n2. 5 votes=ghc5\n3. 10 votes=ghc10\n4. 50 votes=ghc50\n5. 100 votes=ghc100\n6. 500 votes=ghc500\n7. 1000 votes=ghc1000";
			    $ussdResponse->Type    = "Response";
			    $ussdResponse->ClientState = 'PAYMENT3';
			    header('Content-type: application/json; charset=utf-8');
				echo json_encode($ussdResponse);
				die();
			}

			#update user session and pass for vote processing.........., session_level, session_tab
    		$dataAccessObj->updateCurrentSessionData($voteAmount, $voteAmount, $contestantId, $contestantName, $contestantNum, $userEntry, '4', '2', $ussdRequest->Mobile, $fullName);


			// submit request to payment_api_processor..........
			#alert user to authorize payment then pass session data to payment API.............
			$ussdResponse->Message = "Please authorize payment of 'Gh".$voteAmount.".00' on '".$ussdRequest->Mobile."', for ".$contestantName.". Thank you.";
		 	$ussdResponse->Type    = "Release";
		 	exec("php /var/www/html/mysmsinbox/miss_ghana/ussd/request_api_processor.php  > /tmp/MissGhanahtussd.log 2>&1 &");
			header('Content-type: application/json; charset=utf-8');
			echo json_encode($ussdResponse);


			die();

		}
		else 
		{
			$ussdResponse->Message = "Sorry your entry was wrong\nTry again.";
		    $ussdResponse->Type    = "Release";
		    header('Content-type: application/json; charset=utf-8');
			echo json_encode($ussdResponse);

			$dataAccessObj->purgePreviousSession($ussdRequest->Mobile);
			die();
		}
		
		
	}






























	// ***************** SEQUENCE 5   *****************************
	if($ussdRequest->Sequence == "5")
	{
		if ($ussdRequest->ClientState == "PAYMENT3") 
		{
			#check if user enter valid momo number format...........
			$contestantId   = "";
			$contestantName = "";
	        $contestantNum  = "";
	        $category       = "";
	        $userEntry      = "";
			$fullName       = "";

			foreach($dataAccessObj->getPreviusSessionData($ussdRequest->Mobile) as $row){
				$contestantId   = $row['contestant_id'];
	            $contestantName = $row['contestant_name'];
	            $contestantNum  = $row['contestant_num'];
	            $userEntry      = $row['user_entry'];
	            $category       = $row['category'];
	            $fullName       = $row['full_names'];
			}

			// check payment amount.........
			$voteAmount = 0;
			if(trim($ussdRequest->Message) == '1') 
			{
				$voteAmount = '1.00';
			}elseif(trim($ussdRequest->Message) == '2')
			{
				$voteAmount = '5.00';
			}elseif(trim($ussdRequest->Message) == '3')
			{
				$voteAmount = '10.00';
			}elseif(trim($ussdRequest->Message) == '4')
			{
				$voteAmount = '50.00';
			}elseif(trim($ussdRequest->Message) == '5')
			{
				$voteAmount = '100.00';
			}elseif(trim($ussdRequest->Message) == '6')
			{
				$voteAmount = '500.00';
			}
			elseif(trim($ussdRequest->Message) == '7'){
				$voteAmount = '1000.00';
			}
			else
			{

				$ussdResponse->Message = "Wrong entry. Retry\n1. vote=ghc1\n2. 5 votes=ghc5\n3. 10 votes=ghc10\n4. 50 votes=ghc50\n5. 100 votes=ghc100\n6. 500 votes=ghc500\n7. 1000 votes=ghc1000";
			    $ussdResponse->Type    = "Response";
			    $ussdResponse->ClientState = 'PAYMENT4';
			    header('Content-type: application/json; charset=utf-8');
				echo json_encode($ussdResponse);
				die();
			}



			#update user session and pass for vote processing.........., session_level, session_tab
    		$dataAccessObj->updateCurrentSessionData($voteAmount, $voteAmount, $contestantId, $contestantName, $contestantNum, $userEntry, '5', '3', $ussdRequest->Mobile, $fullName);


			// submit request to payment_api_processor..........
			#alert user to authorize payment then pass session data to payment API.............
			$ussdResponse->Message = "Please authorize payment of 'Gh".$voteAmount.".00' on '".$ussdRequest->Mobile."', for ".$contestantName.". Thank you.";
		 	$ussdResponse->Type    = "Release";
		 	exec("php /var/www/html/mysmsinbox/miss_ghana/ussd/request_api_processor.php  > /tmp/MissGhanahtussd.log 2>&1 &");
			header('Content-type: application/json; charset=utf-8');
			echo json_encode($ussdResponse);


			die();

		} else {
			$ussdResponse->Message = "Sorry your entry was wrong\nTry again.";
		    $ussdResponse->Type    = "Release";
		    header('Content-type: application/json; charset=utf-8');
			echo json_encode($ussdResponse);

			$dataAccessObj->purgePreviousSession($ussdRequest->Mobile);
			die();
		}
		
			
	}


























	// ***************** SEQUENCE 6   *****************************
	if($ussdRequest->Sequence == "6")
	{
		if(trim($ussdRequest->ClientState == "PAYMENT4")) //trim(strlen($ussdRequest->Message)) == 10 && 
		{
			$contestantId   = "";
			$contestantName = "";
	        $contestantNum  = "";
	        $category       = "";
	        $userEntry      = "";
			$fullName       = "";

			foreach($dataAccessObj->getPreviusSessionData($ussdRequest->Mobile) as $row){
				$contestantId   = $row['contestant_id'];
	            $contestantName = $row['contestant_name'];
	            $contestantNum  = $row['contestant_num'];
	            $userEntry      = $row['user_entry'];
	            $category       = $row['category'];
	            $fullName       = $row['full_names'];
			}


			// check payment amount.........
			$voteAmount = 0;
			if(trim($ussdRequest->Message) == '1') 
			{
				$voteAmount = '1.00';
			}elseif(trim($ussdRequest->Message) == '2')
			{
				$voteAmount = '5.00';
			}elseif(trim($ussdRequest->Message) == '3')
			{
				$voteAmount = '10.00';
			}elseif(trim($ussdRequest->Message) == '4')
			{
				$voteAmount = '50.00';
			}elseif(trim($ussdRequest->Message) == '5')
			{
				$voteAmount = '100.00';
			}elseif(trim($ussdRequest->Message) == '6')
			{
				$voteAmount = '500.00';
			}
			elseif(trim($ussdRequest->Message) == '7'){
				$voteAmount = '1000.00';
			}
			else
			{
				//keep trying till you get the valid momo  number...........
				$ussdResponse->Message = "Sorry your entry was wrong.\nTry again later";
				// $ussdResponse->ClientState = $ussdRequest->ClientState;
				$ussdResponse->Type    = "Release";
				header('Content-type: application/json; charset=utf-8');
				echo json_encode($ussdResponse);

				$dataAccessObj->purgePreviousSession($ussdRequest->Mobile);
				die();
			}

			#update user session and pass for vote processing.........., session_level, session_tab
    		$dataAccessObj->updateCurrentSessionData($voteAmount, $voteAmount, $contestantId, $contestantName, $contestantNum, $userEntry, '6', '3', $ussdRequest->Mobile, $fullName);

			// submit request to payment_api_processor..........
			#alert user to authorize payment then pass session data to payment API.............
			$ussdResponse->Message = "Please authorize payment of 'Gh".$voteAmount.".00' on '".$ussdRequest->Mobile."', for ".$contestantName.". Thank you.";
		 	$ussdResponse->Type    = "Release";
		 	exec("php /var/www/html/mysmsinbox/miss_ghana/ussd/request_api_processor.php  > /tmp/MissGhanahtussd.log 2>&1 &");
			header('Content-type: application/json; charset=utf-8');
			echo json_encode($ussdResponse);
			die();

		}else 
		{	//keep trying till you get the valid momo  number...........
			$ussdResponse->Message = "Sorry your entry was wrong.\nTry again later.";
			// $ussdResponse->ClientState = $ussdRequest->ClientState;
			$ussdResponse->Type    = "Release";
			header('Content-type: application/json; charset=utf-8');
			echo json_encode($ussdResponse);
			die();
		}	
	}



















}else{
	$ussdResponse->Message = "Something went wrong. Request body was empty. This should be accessed only on ussd code";
	$ussdResponse->Type = "Release";

	header('Content-type: application/json; charset=utf-8');
	echo json_encode($ussdResponse);
	die();
}
