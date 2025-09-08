<?php
    // This file contains common utility functions and configuration

    // Database configuration
    $dbConfig = [
        'host' => 'localhost',
        'user' => 'root',
        'password' => '',
        'database' => 'test_db'
    ];

    // Utility function
    function formatCurrency($amount) {
        return '$' . number_format($amount, 2);
    }

    // Helper function
    function sayHello($name) {
        return "Hello, " . htmlspecialchars($name) . "!";
    }

    // Constants
    define('SITE_NAME', 'My PHP Website');
    define('VERSION', '1.0.0');
?>