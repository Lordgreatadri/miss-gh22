<?php 
	include_once 'DbCon.php';
	/**
	 * 
	 */
	class MissGhanaModel //extends AnotherClass
	{
		
		public $db_conn = NULL;
		public function __construct()
		{
			if($this->db_conn == NULL) {
				$db = new DbCon();
				$this->db_conn = $db->connection();

				// var_dump($this->db_conn );
			}
		}

		public function __destruct(){
			$this->db_conn = NULL;
		}

		public function crossCheckPreviousSession($voterNumber)
		{
			try 
			{
				$stmnt = $this->db_conn->prepare("SELECT * FROM track_session WHERE initiator = '$voterNumber' LIMIT 0,1");
				$query->execute();
				// set the resulting array to associative getPreviusSessionData
				$query->setFetchMode(PDO::FETCH_ASSOC);
				// return  $query->rowCount();
				return $query->fetchAll();
			} catch (Exception $e) {
				return $e->getMessage();
			}
		}


		public function purgePreviousSession($voterNumber)
		{
			try 
			{
				$sql = "DELETE FROM track_session WHERE initiator=:initiator";
				$stmnt = $this->db_conn->prepare($stmnt);
				$value = array('initiator' => $voterNumber);				
				$stmnt->execute($value);
				//count number of row affected
				return $stmnt->rowCount();
			} catch (Exception $e) {
				return $e->getMessage();
			}
		}


		// public function logCurrentSessionData($voterNumber, $contestantName, $contestantId, $contestantNum, $category, $fullName, $sessionTab, $sessionLevel)
		// {
		// 	try 
		// 	{
		// 		$stmnt  = "INSERT INTO track_session(initiator, contestant_name, contestant_id, contestant_num, category, full_names, session_tab, session_level) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
		// 		$values = array($voterNumber, $contestantName, $contestantId, $contestantNum, $category, $fullName, $sessionTab, $sessionLevel);
		// 		$query  = $this->db_conn->prepare($stmnt);
		// 		$query->execute($values);
		// 	    return $query->rowCount();
		// 	} catch (Exception $e) {
		// 		return $e->getMessage();
		// 	}
		// }


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



		// public function getChosesContestantData($voterNumber)
		// {
		// 	try 
		// 	{
		// 		$stmnt = $this->db_conn->prepare("SELECT * FROM track_session WHERE initiator = '$voterNumber' LIMIT 0,1");
		// 		$query->execute();
		// 		// set the resulting array to associative
		// 		$query->setFetchMode(PDO::FETCH_ASSOC);
		// 		return  $query->rowCount();
		// 	} catch (Exception $e) {
		// 		return $e->getMessage();
		// 	}
		// }



		


		// public function verifyCurrentContestantData($contestantData)
		// {
		// 	try 
		// 	{
		// 		$stmnt = $this->db_conn->prepare("SELECT * FROM contestants WHERE status = 'Active' AND (contestant_id = '$contestantData' OR contestant_name = '$contestantData' OR contestant_num = '$contestantData') LIMIT 0,1");
		// 		$query->execute();
		// 		// set the resulting array to associative
		// 		$query->setFetchMode(PDO::FETCH_ASSOC);
		// 		return  $query->fetchAll();
		// 	} catch (Exception $e) {
		// 		return $e->getMessage();
		// 	}
		// }
	}
?>