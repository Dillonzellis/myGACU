<?php
  
    // echo "Welcome to Connecting of DB Tutorial!";
    // echo "<br>";

    // 1. PDO - Php Data Objects
    // 2. MySQLi extension

    // Set Connection Variable
    $server = "localhost";
    $username = "MyGAcu";
    $password = "myGADB2021";
    $database = "hallc2";

    // Create A Connection
    $con = mysqLi_connect($server, $username, $password, $database);

     // Check For Connection
     if(!$con){
        die ("Connection Terminated! by Die() function". mysqLi_connect_error());
       
    }
    else {
        echo "Connection Succefully Happened! <br>";
    }


    ?>