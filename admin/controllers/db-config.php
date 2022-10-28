<?php
    $serverName = "";
    $databaseName = "miss_ghana"; #"";
    $databaseUser = "";
    $databasePassword = ''; #"";

    $database = mysqli_connect($serverName, $databaseUser, $databasePassword, $databaseName);

    if (!$database) {
        die("unable to connect to database");
    }
