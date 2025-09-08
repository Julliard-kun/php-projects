<?php
    try {
        // Database configuration
        $host = "localhost";
        $dbname = "auth-sys";
        $user = "root";
        $pass = "";

        // Set PDO options for better error handling and security
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        // Create PDO instance
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass, $options);

    } catch(PDOException $e) {
        // Log error details securely
        error_log("Database connection error: " . $e->getMessage());
        
        // Show generic error message to user
        die("Sorry, there was a problem connecting to the database. Please try again later.");
    }
?>