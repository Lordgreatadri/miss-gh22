<?php

    include_once "db-config.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = mysqli_real_escape_string($database, trim($_POST['username']));
        $password = mysqli_real_escape_string($database, trim($_POST['password']));

        // query to check the existence of username
        $checkUsernameQuery = "SELECT * FROM admins WHERE username = '$username'";

        $checkUsernameResult = mysqli_query($database, $checkUsernameQuery);
        
        $hashedsession = md5(date('YmdHis'));

        if (mysqli_num_rows($checkUsernameResult) > 0) {
            $checkUsernameRow = mysqli_fetch_assoc($checkUsernameResult);

            $databasePassword = $checkUsernameRow['user_password'];
            $hashedPassword = md5($password);
            $userRole = $checkUsernameRow['user_role'];


            if ($databasePassword == $hashedPassword){
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['user_role'] = $userRole;
                $_SESSION['session_id'] = $hashedsession;
                $_SESSION['DUserLoggedIn'] = true;

                //login history tracking............
                $insertUserQuery = "INSERT INTO log_hist(username, session_id) VALUES('$username', '$hashedsession')";
                mysqli_query($database, $insertUserQuery);


                $response['success'] = true;
                $response["message"] = 'login successful';

                header('Content-Type: application/json');
                echo json_encode($response);
            } else {
                $response['success'] = false;
                $response["message"] = 'wrong user password entered';

                mysqli_close($database);

                header('Content-Type: application/json');
                echo json_encode($response);
            }
            
        } else {
            $response['success'] = false;
            $response["message"] = 'wrong username or password';

            mysqli_close($database);

            header('Content-Type: application/json');
            echo json_encode($response);
            
        }
        
    }