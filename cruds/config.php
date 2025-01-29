<?php 

    // Inputing details in MySQL connection such as
    // Server Host, Database Name, Username, Password
    //Username and Password are the one use in SQLyog.
    $server_host = "localhost";
    $dbname = "capsys";
    $username = "root";
    $passwd = "";
    
    //Initializing or concat the host and database
    $dsn = "mysql:host={$server_host}; dbname={$dbname}";

    try{ //Using try catch to run test fail code
        
        //Creating PDO Connection between our code to mysql
        $conn = new PDO($dsn, $username, $passwd);

    }
    catch (PDOException $e){ // Catching error
        echo $e->getMessage(); //Fetching error and insert in $er
    }

    date_default_timezone_set('Asia/Manila');

?>