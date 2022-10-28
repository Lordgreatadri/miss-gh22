<?php
    $serverName = "";
    $databaseName = "miss_ghana"; #"gmb";
    $databaseUser = "adri";
    $databasePassword = 'a'; #"#4kLxMzGurQ7Z~";

    $database = mysqli_connect($serverName, $databaseUser, $databasePassword, $databaseName);
    
    // $connect = new PDO("mysql:host=;dbname=love_right;charset=utf8","adri","");//#4kLxMzGurQ7Z~
    // $connect->setAttribute(PDO::ATTR_AUTOCOMMIT,FALSE);

    // if (!$connect) {
    //     die("unable to connect to database");
    // }else
    // {
    // 	//echo "connected";
    // }
