<?php
    $serverName = "192.168.193.254";
    $databaseName = "miss_ghana"; #"gmb";
    $databaseUser = "adri";
    $databasePassword = 'adRi@1234&5$HaW9(1&Mcc'; #"#4kLxMzGurQ7Z~";

    $database = mysqli_connect($serverName, $databaseUser, $databasePassword, $databaseName);
    
    // $connect = new PDO("mysql:host=192.168.193.254;dbname=love_right;charset=utf8","adri","adRi@1234&5$HaW9(1&Mcc");//#4kLxMzGurQ7Z~
    // $connect->setAttribute(PDO::ATTR_AUTOCOMMIT,FALSE);

    // if (!$connect) {
    //     die("unable to connect to database");
    // }else
    // {
    // 	//echo "connected";
    // }
