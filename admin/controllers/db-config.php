<?php
    $serverName = "192.168.193.254";
    $databaseName = "miss_ghana"; #"";
    $databaseUser = "adri";
    $databasePassword = 'adRi@1234&5$HaW9(1&Mcc'; #"";

    $database = mysqli_connect($serverName, $databaseUser, $databasePassword, $databaseName);

    if (!$database) {
        die("unable to connect to database");
    }