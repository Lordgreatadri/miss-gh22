<?php 
/**------------------------------------------------------------------------------------------------------------------------------------------------
 * @@Name: 				filter-votes
 
 * @@Author: 			Lordgreat -  Adri Emmanuel <'rexmerlo@gmail.com'>
 * @@Tell:				+233543645688/+233273593525

 * @Date:   			2021-05-06 02:30:30
 * @Last Modified by:   Lordgreat - Adri Emmanuel
 * @Last Modified time: 2021-05-06 03:35:10

 * @Copyright: 			MobileContent.Com Ltd <'owner'>
 
 * @Website: 			https://mobilecontent.com.gh
 *-------------------------------------------------------------------------------------------------------------------------------------------------
 */

	session_start();
	// include 'configure.php';
	include_once "controllers/db-config.php";

		if(isset($_GET['filter_crowlers'])) 
		{
			$date_from = $_POST['CDateFrom'];
			$date_to = $_POST['CDateTo'];
			if( empty($date_from))
			{
				die("Please select start date to proceed! <a href = 'filter-votes.php'>[ Back <<< ]");
			}elseif(empty($date_to)) 
			{
				die("Please select end date to proceed! <a href = 'filter-votes.php'>[ Back <<< ]");
			}else
			{
				#*********************** CREATING CONNECT TO DATABASE AND PASSING TO VARIABLE ************
			    // $connect = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);//"localhost", "root", "", "unity_report"

			    #**********************   CREATE DIRECTORY TO SAVE EXPORTED FILE   *************************
			               //note: the user must creat a folder at the location where the script is...........
			    $filename = "data_exports/".date('Y').'-'.strtotime("").'_CRAWLERS-FILTER'.date('d-M').'.txt';

			    $today_date = date('Y-m-d');
			      
			          #*************         SQL SELECT STATEMENT        *********************************voting_date
			    $sql = "SELECT `contestant_name` FROM momo_completed_tansactions WHERE (DATE(`tansactions_date`) BETWEEN '$date_from' AND '$date_to' AND `response_code` = '0000' ORDER BY `tansactions_date` DESC";
			    $values = mysqli_query($database, $sql);

			    $num_rows = mysqli_num_rows($values);

		   
		    	//check if indeed record exist based on search cretia and fetch records out............
			    if($num_rows >= 1)
			    {
			      	$row = mysqli_fetch_assoc($values);
			      	$fp = fopen($filename, "w");
			      	$seperator = "";
			      	$comma = "";

			      	//loop through result and splint it....................
			      	foreach ($row as $name => $value)
			        {
			          $seperator .= $comma . '' .str_replace('', '""', $name);
			          $comma = ",";
			        }

			      	$seperator .= "\n";
			      	fputs($fp, $seperator);
			  
			      	mysqli_data_seek($values, 0);
			      	while($row = mysqli_fetch_assoc($values))
			        {
			          $seperator = "";
			          $comma = ",";

			          foreach ($row as $name => $value) 
			            {
			              $seperator .= $comma . '' .str_replace('', '""', $value);
			              $comma = ",";
			            }

			          $seperator .= "\n";
			          fputs($fp, $seperator);
			        }
			  
				    fclose($fp);
				    //promptin the user for a succesful export of file and grant access with link to 
				    //download file if the user is ready to access the file...............
				    echo "<p style='text-align:center; margin-top: 200px;'>Your file is ready. You can download it from <a href='$filename'>here!</a>". ' or open file location to view in folder. <a href = "filter-votes.php">[ Back <<< ]</a></p>';
			    }
			    else
			    {
			      echo "<p style='text-align:center; margin-top: 200px;'>There is no matching record found for your criteria sort <a href = 'filter-votes.php'>[ Back HERRE<<< ]</a></p>";
			    }
			}
		}else
		{

		  	
		        #*********************** CREATING CONNECT TO DATABASE AND PASSING TO VARIABLE ************
		     // $connect = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);//"localhost", "root", "", "unity_report"

		     #**********************   CREATE DIRECTORY TO SAVE EXPORTED FILE   *************************
		               //note: the user must creat a folder at the location where the script is...........
		    $filename = "data_exports/".date('Y').'-'.strtotime("").'_CRAWLERS'.date('d-M').'.txt';

		    $today_date = date('Y-m-d');
		      
		          #*************         SQL SELECT STATEMENT        ********************************* 
		    $sql = "SELECT `contestant_name` FROM momo_completed_transactions WHERE `response_code` = '0000' ORDER BY `tansactions_date` DESC ";
		    $values = mysqli_query($database, $sql);

		    $num_rows = mysqli_num_rows($values);

		   
		    //check if indeed record exist based on search cretia and fetch records out............
		    if($num_rows >= 1)
		    {
		      	$row = mysqli_fetch_assoc($values);
		      	$fp = fopen($filename, "w");
		      	$seperator = "";
		      	$comma = "";

		      	//loop through result and splint it....................
		      	foreach ($row as $name => $value)
		        {
		          $seperator .= $comma . '' .str_replace('', '""', $name);
		          $comma = ",";
		        }

		      	$seperator .= "\n";
		      	fputs($fp, $seperator);
		  
		      	mysqli_data_seek($values, 0);
		      	while($row = mysqli_fetch_assoc($values))
		        {
		          $seperator = "";
		          $comma = ",";

		          foreach ($row as $name => $value) 
		            {
		              $seperator .= '' .str_replace('', '""', $value).$comma ;
		              $comma = ",";
		            }

		          $seperator .= "\n";
		          fputs($fp, $seperator);
		        }
		  
		      fclose($fp);
		      //promptin the user for a succesful export of file and grant access with link to 
		      //download file if the user is ready to access the file...............
		      echo "<p style='text-align:center; margin-top: 200px;'>Your file is ready. You can download it from <a href='$filename'>here!</a>". ' or open file location to view in folder. <a href = "filter-votes.php">[ Back <<< ]</a></p>';
		    }
		    else
		    {
		      echo "<p style='text-align:center; margin-top: 200px;'>There is no matching record found for your criteria sort <a href = 'filter-votes.php'>[ Back Here<<< ]</a></p>";
		    }
		}

 ?>