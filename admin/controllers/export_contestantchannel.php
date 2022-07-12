<?php

  session_start();
  // include 'configure.php';
  include_once "db-config.php";


        #*********************** CREATING CONNECT TO DATABASE AND PASSING TO VARIABLE ************
      // $connect = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);//"localhost", "root", "", "unity_report"
if(isset($_GET['nominee'])) 
{
    $ussd_user = trim($_GET['nominee']);
    $channel_type = trim($_GET['channel']);
    // var_dump($ussd_user);
    // var_dump($channel_type);

    $session_id = $_SESSION['session_id'];
    $username   = $_SESSION['username'];


    //prepare the login history stuffs here...........
    $log = "SELECT channel_data_export FROM log_hist WHERE session_id = '$session_id' AND username = '$username' LIMIT 1";
    $data_s = mysqli_query($database, $log);   
    $log_hist  = mysqli_fetch_assoc($data_s);

    $hist_name = "";
    $hist_name = $log_hist['channel_data_export'];


    //log process here.............      
    $history_data = $hist_name.'; '.$ussd_user.' ' .$channel_type.'`s channel data exported';

    $insertUserQuery = "UPDATE log_hist SET channel_data_export = '$history_data' WHERE session_id = '$session_id' AND username = '$username'";
    mysqli_query($database, $insertUserQuery);

    #**********************   CREATE DIRECTORY TO SAVE EXPORTED FILE   *************************
               //note: the user must creat a folder at the location where the script is...........
      $filename = "../data_exports/".date('Y').'-'.strtotime("").$ussd_user.'-'.$channel_type.'-'.date('d-M').'.csv';

    $today_date = date('Y-m-d');
      
          #*************         SQL SELECT STATEMENT        *********************************
    $sql = "SELECT category, contestant_name, `momo_number`, `device`, `vote_count`, `amount`, `tansactions_date` FROM momo_completed_transactions WHERE category = '$ussd_user' AND device = '$channel_type' ORDER BY `tansactions_date` ASC LIMIT 0,1000";//s.date_unsub = '$today_date'
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
          $comma = "";

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
      echo "<p style='text-align:center; margin-top: 200px;'>Your file is ready. You can download it from <a href='$filename'>here!</a>". ' or open file location to view in folder. <a href = "../vote_channels.php"> [ Back <<< ]</a> </p>';
    }
    else
    {
      echo "<p style='text-align:center; margin-top: 200px;'>There is no matching record found for your criteria sort <a href = '../vote_channels.php'>[ Back<<< ]</a></p>";
    }

}else{

}
      
    mysqli_close($database);
?>
