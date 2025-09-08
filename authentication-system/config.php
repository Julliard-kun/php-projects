<?php
    $host = "localhost";

    $dbname = "auth-sys";

    $user = "root";

    $pass = "";

    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

    // if ($conn == true) {
    //     echo "Successfully connected to the database";

    // } else {
    //     echo "Failed to connect to the database";
    // }

 ?>