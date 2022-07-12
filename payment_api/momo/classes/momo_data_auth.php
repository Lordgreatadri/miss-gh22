<?php 

	include_once 'includes/autoloader.inc.php';

	/**
	 * 
	 */
	class momo_data_auth  extends db_config
	{
		
		// logging the request..........
		public function logPaymentRequest($transaction_id, $transaction_status, $response_code, $momo_number, $channel, $amount, $vote_count, $contestant_id, $contestant_name, $contestant_num, $device, $description, $category)
		{
			try 
			{
				$stmnt = "INSERT INTO momo_transactions_initiate(transaction_id, transaction_status, response_code, momo_number, channel, amount, vote_count, contestant_id, contestant_name, contestant_num, device, description, category) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$values = array($transaction_id, $transaction_status, $response_code, $momo_number, $channel, $amount, $vote_count, $contestant_id, $contestant_name, $contestant_num, $device, $description, $category);
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
		public function logPaymentCallbackResponse($transaction_id, $external_transaction_id, $response_code, $amount_after_charges, $charges, $momo_number, $channel, $amount, $contestant_name, $contestant_num, $contestant_id, $vote_count, $device, $description, $client_reference, $category)
		{
			try 
			{
				$stmnt = "INSERT INTO momo_completed_transactions(transaction_id, external_transaction_id, response_code, amount_after_charges, charges, momo_number, channel, amount, contestant_name, contestant_num, contestant_id, vote_count, device, description, client_reference, category) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$values = array($transaction_id, $external_transaction_id, $response_code, $amount_after_charges, $charges, $momo_number, $channel, $amount, $contestant_name, $contestant_num, $contestant_id, $vote_count, $device, $description, $client_reference, $category);
				$query = $this->db_conn->prepare($stmnt);
				$query->execute($values);
			    $rowcount=$query->rowCount();
			    return $rowcount;
			} catch (Exception $exc) 
			{
				echo __LINE__ . $exc->getMessage();
			}
		}





		//update initiator's tranasaction status...............
		public function update_initiator_status($transaction_status, $updated_at, $transaction_id)
		{
			try 
			{
				$stmnt = "UPDATE momo_transactions_initiate SET transaction_status=:transaction_status, updated_at=:updated_at WHERE transaction_id=:transaction_id";
				$query = $this->db_conn->prepare($stmnt);
				$value = array('transaction_status'=>$transaction_status, 'updated_at'=>$updated_at, 'transaction_id'=>$transaction_id);
				
				$query->execute($value);

				//count number of row affected
				$count_row = $query->rowCount();
				return $count_row;
			} catch (Exception $e) 
			{
				echo __LINE__ . $e->getMessage();
			}
		}






		// fetch initial record for processing...........
		public function get_user_data($transaction_id)
		{
			try 
			{
				$query =  $this->db_conn->query("SELECT * FROM momo_transactions_initiate WHERE transaction_id = '$transaction_id' LIMIT 0,1");
				$query->execute();

				// set the resulting array to associative
				$result = $query->setFetchMode(PDO::FETCH_ASSOC);
				// return  $query->rowCount(); 
				return $query->fetchAll();
				
			} catch (Exception $ex) {
				return $ex->getMessage();
			}
		}





		// get chosen contestant's data to update votes.............
		public function get_current_contestant_data($contestant_id, $contestant_num)
		{
			try 
			{
				$query =  $this->db_conn->query("SELECT * FROM contestants WHERE contestant_id = '$contestant_id' LIMIT 0,1");//' AND contestant_num = '$group_alias'
				$query->execute();

				// set the resulting array to associative
				$result = $query->setFetchMode(PDO::FETCH_ASSOC);
				// return  $query->rowCount();
				return $query->fetchAll();
			} catch (Exception $ex) {
				return $ex->getMessage();
			}
		}






		// update current contestant vote ............
		public function update_vote_counts($vote_count, $contestant_id, $contestant_num, $updated_at)
		{
			try 
			{

				$stmnt = "UPDATE contestants SET vote_count=:vote_count, updated_at=:updated_at WHERE contestant_id=:contestant_id AND contestant_num=:contestant_num";//
				$query = $this->db_conn->prepare($stmnt);
				$value = array('vote_count'=>$vote_count, 'updated_at'=> $update_at, 'contestant_id'=>$contestant_id, 'contestant_num'=>$contestant_num);
				
				$query->execute($value);

				//count number of row affected
				$count_row = $query->rowCount();
				return $count_row;
			} catch (Exception $e) 
			{
				echo __LINE__ . $e->getMessage();
			}
		}




		// get chosen contestant's weekly data to update votes.............
		public function get_contestant_weekly_data($contestant_id, $contestant_num)
		{
			try 
			{
				$query =  $this->db_conn->query("SELECT * FROM contestants_weekly WHERE contestant_id = '$contestant_id' LIMIT 0,1");//' AND contestant_num = '$group_alias'
				$query->execute();

				// set the resulting array to associative
				$result = $query->setFetchMode(PDO::FETCH_ASSOC);
				// return  $query->rowCount();
				return $query->fetchAll();
			} catch (Exception $ex) {
				return $ex->getMessage();
			}
		}

		// update current contestant weekly vote ............
		public function update_weekly_vote_counts($vote_count, $contestant_id, $contestant_num, $last_voted)
		{
			try 
			{
				$stmnt = "UPDATE contestants_weekly SET vote_count=:vote_count, updated_at=:updated_at WHERE contestant_id=:contestant_id AND contestant_num=:contestant_num";//
				$query = $this->db_conn->prepare($stmnt);
				$value = array('vote_count'=>$vote_count, 'updated_at'=> $last_voted, 'contestant_id'=>$contestant_id, 'contestant_num'=>$contestant_num);//
				
				$query->execute($value);

				//count number of row affected
				$count_row = $query->rowCount();
				return $count_row;
			} catch (Exception $e) 
			{
				echo __LINE__ . $e->getMessage();
			}
		}





		// get chosen contestant's channel_votes data to update votes.............
		public function get_channel_votes_data($contestant_id, $contestant_num)
		{
			try 
			{
				$query =  $this->db_conn->query("SELECT * FROM channel_votes WHERE contestant_id = '$contestant_id' LIMIT 0,1");//' AND contestant_num = '$group_alias'
				$query->execute();

				// set the resulting array to associative
				$result = $query->setFetchMode(PDO::FETCH_ASSOC);
				// return  $query->rowCount();
				return $query->fetchAll();
			} catch (Exception $ex) {
				return $ex->getMessage();
			}
		}

		// update current channel_votes ............
		public function update_channel_votes_counts($vote_count, $contestant_id, $contestant_num, $channel_name, $channel_vote, $last_voted)
		{
			try 
			{
				$stmnt = "UPDATE channel_votes SET vote_count=:vote_count, `$channel_name`=:channel_name, update_at=:update_at WHERE contestant_id=:contestant_id AND contestant_num=:contestant_num";//
				$query = $this->db_conn->prepare($stmnt);
				$value = array('vote_count'=>$vote_count, 'channel_name'=>$channel_vote, 'update_at'=>$last_voted, 'contestant_id'=>$contestant_id, 'contestant_num'=>$contestant_num);//
				


				// $stmnt = "UPDATE channel_votes SET vote_count=:vote_count, last_voted=:last_voted WHERE contestant_id=:contestant_id AND contestant_num=:contestant_num";//
				// $query = $this->db_conn->prepare($stmnt);
				// $value = array('vote_count'=>$vote_count, 'last_voted'=> $last_voted, 'contestant_id'=>$contestant_id, 'contestant_num'=>$contestant_num);
				$query->execute($value);

				//count number of row affected
				$count_row = $query->rowCount();var_dump($count_row);
				return $count_row;
			} catch (Exception $e) 
			{
				echo __LINE__ . $e->getMessage();
			}
		}





		// function for sms notification to the user after callback.......
		public function sendUserResponse($user_number, $message)
		{
			try 
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
	            $message = urlencode($message);//200.2.168.175:2199 54.163.215.114 34.230.90.80
	            $url = "http://54.163.32.178:2788/Receiver?User=mycloudhttp&Pass=M1C2T3&From=1470&To=$msisdn&Text=$message";
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
	            return $result;

	        }catch (Exception $exc) 
	        {
	            echo __LINE__ . $exc->getMessage();
	        }
		}


		// format the user msisdn to the required format...........
	    public function _formart_number($voter_number)
	    {
	        $myNew_value = null;
	        $voting_number = '';
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
	}