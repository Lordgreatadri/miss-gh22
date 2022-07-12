<?php
    include_once "db-config.php";
    session_start();

    if($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
        $contestantId = $_POST['contestantId'];
        $session_id = $_SESSION['session_id'];
        $username   = $_SESSION['username'];


        // ENABLE DATA LOGS DIRECTORY HERE..................
        $filename = "../data_exports/".date('Y').'-'.rand().'-contestants_weekly-'.date('His').'-'.date('d-M').'.csv';
        $today_date = date('Y-m-d');

        // get the nominee to evict
        $query = "SELECT `contestant_name`, `status` FROM `contestants` WHERE `contestant_id` = $contestantId";

        // load all table data
        $sql = "SELECT contestant_id AS CODE, contestant_name AS 'NAME', status AS STATUS,  vote_count AS VOTES, last_voted AS 'LAST VOTED' FROM contestants_weekly WHERE status = 'Active' ORDER BY vote_count DESC";
        $values = mysqli_query($database, $sql);


        $result = mysqli_query($database, $query);
        if(mysqli_num_rows($result) > 0) 
        {
            // dump data on server before the evictio process is carried out...........
            $num_rows = mysqli_num_rows($values);

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
            }




            //prepare the login history stuffs here...........
            $log = "SELECT evictee_name FROM log_hist WHERE session_id = '$session_id' AND username = '$username' LIMIT 1";
            $data_s = mysqli_query($database, $log);   
            $log_hist  = mysqli_fetch_assoc($data_s);

            $hist_name = "";
            $hist_name = $log_hist['evictee_name'];



            // reset votes to 0...
            $resetvotes_query = "UPDATE `contestants_weekly` SET `vote_count` = '0' ";

            //NOW CARRY  OUT EVICTION PROCESS
            $row  = mysqli_fetch_assoc($result);
            $name = $row['contestant_name'];
            $status = $row['status'];

            if($status == 'Active') 
            {
                $new_status = 'Evicted';
                $update_query = "UPDATE `contestants` SET `status` = '$new_status' WHERE `contestant_id` = $contestantId";

                $update_query1 = "UPDATE `contestants_weekly` SET `status` = '$new_status' WHERE `contestant_id` = $contestantId";

                
                if (mysqli_query($database, $update_query)) 
                {
                    $response['success'] = true;
                    $response["message"] = "Status of '$name' changed to '$new_status' successfully";

                    mysqli_query($database, $update_query1);

                    // execute votes reste.........
                    mysqli_query($database, $resetvotes_query);




                    // log eviction history.............
                    $history_data = $hist_name.', '.$name;

                    $insertUserQuery = "UPDATE log_hist SET eviction_process = 'Eviction Processed', evictee_name = '$history_data' WHERE session_id = '$session_id' AND username = '$username'";
                    mysqli_query($database, $insertUserQuery);

                    mysqli_close($database);


                    header('Content-Type: application/json');
                    echo json_encode($response);
                }
            } else if ($status == 'Evicted') 
            {
                $new_status = 'Active';
                $update_query = "UPDATE `contestants` SET `status` = '$new_status' WHERE `contestant_id` = $contestantId";

                $update_query11 = "UPDATE `contestants_weekly` SET `status` = '$new_status' WHERE `contestant_id` = $contestantId";

                if (mysqli_query($database, $update_query)) {
                    $new_status = 'Active';
                    $response['success'] = true;
                    $response["message"] = "Status of '$name' changed to '$new_status' successfully";

                    mysqli_query($database, $update_query11);

                    // execute votes reste.........
                    # mysqli_query($database, $resetvotes_query);
                    



                    // log eviction history.............
                    $history_data = $hist_name.', '.$name;

                    $insertUserQuery = "UPDATE log_hist SET eviction_process = 'Eviction Processed', evictee_name = '$history_data' WHERE session_id = '$session_id' AND username = '$username'";
                    mysqli_query($database, $insertUserQuery);

                    mysqli_close($database);
                    
                    header('Content-Type: application/json');
                    echo json_encode($response);
                }
            }
        }
    }

    // 0548113285//