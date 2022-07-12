<?php 
	include_once 'includes/autoloader.inc.php';

	/**
	* USSD API Development
	*/
	/**------------------------------------------------------------------------------------------------------------------------------------------------
 * @@Name:              MissGhanaModel file
 
 * @@Author: 			Lordgreat - Adri Emmanuel <'rexmerlo@gmail.com'>
 
 * @Date:   			2022-04-11 08:10:30
 * @Last Modified by:   Lordgreat -  Adri Emmanuel
 * @Last Modified time: 2011-04-12 02:35:30

 * @Copyright: 			MobileContent.Com Ltd <'owner'>
 
 * @Website: 			https://mobilecontent.com.gh
 *---------------------------------------------------------------------------------------------------------------------------------------------------
 */
//DataAuth





	class MissGhanaModel extends DbClass 
	{

		public function purgeSessionTable($senderAddress)
		{
			try 
			{
				$stmnt = "DELETE FROM track_session WHERE initiator=:initiator";
				$query = $this->db_conn->prepare($stmnt);
				$value = array('initiator'=>$senderAddress);				
				$query->execute($value);
				//count number of row affected
				return $query->rowCount();
			} catch (Exception $e) 
			{
				echo __LINE__ . $e->getMessage();
			}
		}



		// verify chosen contestant's data to update votes.............
		public function verifyCurrentContestantData($contestant)
		{
			try 
			{
				$query =  $this->db_conn->prepare("SELECT * FROM contestants WHERE status = 'not_evicted' AND (contestant_id = '$contestant' OR contestant_name = '$contestant' OR contestant_num = '$contestant') LIMIT 0,1");
				// var_dump($query);

				$query->execute();


				// set the resulting array to associative
				$query->setFetchMode(PDO::FETCH_ASSOC);
				// return  $query->rowCount();
				$result =  $query->fetchAll();
				// var_dump($result);
				return $result;
			} catch (Exception $ex) {
				return $ex->getMessage();
			}
		}



		// verify chosen contestant's data to update votes.............
		public function crossCheckPreviousSession($senderAddress)
		{
			try 
			{
				$query =  $this->db_conn->prepare("SELECT * FROM track_session WHERE initiator = '$senderAddress'");
				$query->execute();


				// set the resulting array to associative
				$query->setFetchMode(PDO::FETCH_ASSOC);
				return  $query->rowCount();
				// $result =  $query->fetchAll();
				// var_dump($result);
			} catch (Exception $ex) {
				return $ex->getMessage();
			}
		}



		// verify chosen contestant's data to update votes.............
		public function purgePreviousSession($senderAddress)
		{
			try 
			{
				$query =  $this->db_conn->prepare("DELETE FROM track_session WHERE initiator = '$senderAddress'");
				$query->execute();


				// set the resulting array to associative
				$query->setFetchMode(PDO::FETCH_ASSOC);
				return  $query->rowCount();
				// $result =  $query->fetchAll();
				// var_dump($result);
			} catch (Exception $ex) {
				return $ex->getMessage();
			}
		}



		// logging the callback response..........completed_tansactions
		public function logCurrentSessionData($userEntry, $initiator, $contestantId, $contestantNum, $contestantName,  $sessionLevel, $sessionTab)//$category, $full_names,
		{
			try 
			{
				$stmnt = "INSERT INTO track_session(user_entry, initiator, contestant_id, contestant_num, contestant_name, session_level, session_tab) VALUES(?, ?, ?, ?, ?, ?, ?)";//category, full_names, , ?, ?
				$values = array($userEntry, $initiator, $contestantId, $contestantNum, $contestantName,  $sessionLevel, $sessionTab);//$category, $full_names,
				$query = $this->db_conn->prepare($stmnt);
				$query->execute($values);
			    $rowcount = $query->rowCount();
			    return $rowcount;
			} catch (Exception $exc) 
			{
				echo __LINE__ . $exc->getMessage();
			}
		}



		// logging the callback response..........completed_tansactions
		public function logOPT($momoNumber, $optCode, $contestantId, $contestantName, $contestantNum, $category, $voteCount, $amount, $channelType)
		{
			try 
			{
				$stmnt = "INSERT INTO opt_code(momo_number, opt_code, contestant_id, contestant_name, contestant_num, category, vote_count, amount, channel) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$values = array($momoNumber, $optCode, $contestantId, $contestantName, $contestantNum, $category, $voteCount, $amount, $channelType);
				$query = $this->db_conn->prepare($stmnt);
				$query->execute($values);
			    return $query->rowCount();
			} catch (Exception $exc) 
			{
				echo __LINE__ . $exc->getMessage();
			}
		}


		// verify chosen contestant's data to update votes.............
		public function getPreviusSessionData($senderAddress)
		{
			try 
			{
				$query =  $this->db_conn->prepare("SELECT * FROM track_session WHERE initiator =  '$senderAddress' ORDER BY id DESC LIMIT 0,1");
				// var_dump($query);

				$query->execute();


				// set the resulting array to associative
				$query->setFetchMode(PDO::FETCH_ASSOC);
				// return  $query->rowCount();
				$result =  $query->fetchAll();
				// var_dump($result);
				return $result;
			} catch (Exception $ex) {
				return $ex->getMessage();
			}
		}



		public function updateCurrentSessionData($amount, $voteCount, $contestantId, $contestantName, $contestantNum, $userEntry, $sessionLevel, $sessionTab, $initiator, $fullName)
		{
			try 
			{
				$stmnt = "UPDATE track_session SET amount=:amount, vote_count=:vote_count, contestant_id=:contestant_id, contestant_name=:contestant_name, contestant_num=:contestant_num, user_entry=:user_entry, session_level=:session_level, session_tab=:session_tab, full_names=:full_names WHERE initiator=:initiator";
				$query = $this->db_conn->prepare($stmnt);
				$value = array('amount'=>$amount, 'vote_count'=>$voteCount, 'contestant_id'=>$contestantId, 'contestant_name'=>$contestantName, 'contestant_num'=>$contestantNum, 'user_entry'=>$userEntry, 'session_level'=> $sessionLevel, 'session_tab'=>$sessionTab, 'full_names'=>$fullName,  'initiator'=>$initiator);//
				
				$query->execute($value);

				//count number of row affected
				return $query->rowCount();
			} catch (Exception $e) 
			{
				echo __LINE__ . $e->getMessage();
			}
		}



		// verify chosen contestant's data to update votes.............
		public function getSChosenData()
		{
			try 
			{
				$query =  $this->db_conn->prepare("SELECT * FROM track_session ORDER BY id DESC LIMIT 0,1");
				$query->execute();

				// set the resulting array to associative
				$query->setFetchMode(PDO::FETCH_ASSOC);
				// return  $query->rowCount();
				$result =  $query->fetchAll();
				return $result;
			} catch (Exception $ex) {
				return $ex->getMessage();
			}
		}



		public function initiateHubtelAPI($channel, $payingNumber, $amount, $contestantName, $contestantId, $contestantNum , $category, $optCode, $fullName)
		{
			try 
			{
				$ch =  curl_init('https://mysmsinbox.com/miss_ghana/payment_api/momo/execute_pay.php');  
				curl_setopt( $ch, CURLOPT_POST, true );  
				curl_setopt( $ch, CURLOPT_POSTFIELDS, array('channel' => $channel,'number' => $payingNumber, 'amount' => $amount,'contestant_name' => $contestantName, 'contestant_id' => $contestantId, 'contestant_num'=>$contestantNum, 'category' => $category, 'full_names'=>$fullName, 'api_key' => '33ffc38bcaff137103b94abb0480f966','device' => 'ussd', 'opt_code' =>$optCode));  
				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
				/*
				curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
				    'Authorization: '.$basic_auth_key,
				    'Cache-Control: no-cache',
				    'Content-Type: application/json',
				  ));
				*/

				$result = curl_exec($ch); 
				$err = curl_error($ch);
				curl_close($ch);
			} catch (Exception $e) {
				echo __LINE__ . $e->getMessage();
			}
		}

		// get chosen contestant's data to update votes.............
		public function getCurrentContestantData($contestant_id, $contestant_num)
		{
			try 
			{
				$query =  $this->db_conn->query("SELECT * FROM contestants WHERE contestant_id = '$contestant_id' OR contestant_num = '$contestant_num' LIMIT 0,1");//' AND contestant_num = '$group_alias'
				$query->execute();

				// set the resulting array to associative
				$result = $query->setFetchMode(PDO::FETCH_ASSOC);
				// return  $query->rowCount();
				return $query->fetchAll();
			} catch (Exception $ex) {
				return $ex->getMessage();
			}
		}





		// format the user msisdn to the required format...........
	    public function formartSMSNumber($voterNumber)
	    {
	        $myNewValue = null;
	        $votingNumber = '';
	        if(strlen($voterNumber) == 10)
            {   
                //convert your string into array
                $arrayNum = str_split($voterNumber);

                for($i = 1; $i < count($arrayNum) ; $i++)
                {        
                    $myNewValue .= $arrayNum[$i];
                }
                 
                $votingNumber = '233'. $myNewValue;
            }else
            {
                $votingNumber = $voterNumber; 
            }

	        return $votingNumber;
	    }



	    // format the user msisdn to the required format...........
	    public function _formartMOMONumber($voterNumber)
	    {
	        $myNewValue = null;
	        $votingNumber = '';
	        if(strlen($voterNumber) == 12)
            {   
                //convert your string into array
                $arrayNum = str_split($voterNumber);

                for($i = 3; $i < count($arrayNum) ; $i++)
                {        
                    $myNewValue .= $arrayNum[$i];
                }
                 
                $votingNumber = '0'. $myNewValue;
            }else
            {
                $votingNumber = $voterNumber; 
            }

	        return $votingNumber;
	    }




	    // formating channel type from momo number........
		public function getChannelType($voterNumber) 
		{
			try 
			{
				//first check if the number recieved in 233 format........
				$myNewValue=null;
				$votingNumber ='';//count($striped_num)
				if(strlen($voterNumber) > 10)
				{	
					//convert your string into array
					$arrayNum = str_split($voterNumber);

					for($i = 3; $i < count($arrayNum) ; $i++)
					{	     
					    $myNewValue .= $arrayNum[$i];
					}
					 
					$votingNumber = '0'. $myNewValue;
				}else
				{
					$votingNumber = $voterNumber;	
				}

				//check for channell type.................................
				$result = substr($votingNumber, 0, 3);

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




		// send app link to user

	    
		public function sendAppDownloadLink($message, $user_number)
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
	            return $result;
	        }
	        // echo json_encode($result);
	        curl_close($curl);
		}





		// log downloads
		public function logDownloaders($momoNumber, $response)
		{
			try 
			{
				$stmnt = "INSERT INTO app_downloads(msisdn, response) VALUES(?, ?)";
				$values = array($momoNumber, $response);
				$query = $this->db_conn->prepare($stmnt);
				$query->execute($values);
			    return $query->rowCount();
			} catch (Exception $exc) 
			{
				echo __LINE__ . $exc->getMessage();
			}
		}

	}

