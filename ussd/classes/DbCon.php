<?php
/**
* 
**/

    class DbCon{
    	private $server = '';
        private $dbname = 'miss_ghana';
        private $user = '';
        private $pass = '';

    	public function connection(){
    	   try {    	   	
    	   	  $connection = new PDO('mysql:host='.$this->server. ';dbname=' .$this->dbname, $this->user, $this->pass);  
              $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              return $connection;
    	   } catch (PDOException $error) {	   	   
    	   	   echo "Connection failed: ".$error->getMessage();
    	   }          
    	}




        // private function getConnection() {
        //     // Check if connection is already established
        //     if ( $this->connection == NULL ) {
        //         $dsn = "$this->driver:host=$this->host;dbname=$this->name;charset=$this->charset";
        //         try {
        //             $this->connection = new PDO($dsn,$this->user, $this->pass);
        //             $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //             // This line is to remove associate array, then you will get only one object in result set
        //             $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
        //         } catch ( PDOException $error ) {
        //             echo 'Connection failed: ' . $error->getMessage();
        //         }
        //     }
        //     return $this->connection;
        // }
    }
    // echo "string";
?>
