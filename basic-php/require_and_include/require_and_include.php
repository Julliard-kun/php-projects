<?php
    /*
    Key Differences between require and include:

    1. Error Handling:
       - require: Produces a FATAL ERROR if file not found (stops script execution)
       - include: Produces a WARNING if file not found (continues script execution)

    2. Usage:
       - require: Use for essential files (classes, configurations, etc.)
       - include: Use for optional files (templates, widgets, etc.)

    3. Variants:
       - require_once: Ensures file is included only once
       - include_once: Same as include but checks if already included
    */

    echo "<h2>Example 1: Using require for essential files</h2>";
    
    // Using require for critical configuration file
    require "file.php";  // If file.php doesn't exist, script stops here
    
    echo "Website Name: " . SITE_NAME . "<br>";
    echo "Version: " . VERSION . "<br>";
    
    // Using functions from the required file
    $price = 1234.56;
    echo "Formatted price: " . formatCurrency($price) . "<br>";
    echo sayHello("John") . "<br><br>";

    echo "<h2>Example 2: Using include for optional content</h2>";
    
    // Include a file that might not exist (for demonstration)
    include "optional_header.php";  // Will only show warning if file missing
    
    echo "Main content continues even if include fails<br><br>";

    echo "<h2>Example 3: Using require_once</h2>";
    
    // First require_once
    require_once "file.php";
    echo "First require_once executed<br>";
    
    // Second require_once - file won't be included again
    require_once "file.php";
    echo "Second require_once executed - file was not included again<br><br>";

    echo "<h2>Example 4: Practical database connection example</h2>";
    
    // Using database configuration from required file
    echo "Database Configuration:<br>";
    echo "Host: " . $dbConfig['host'] . "<br>";
    echo "Database: " . $dbConfig['database'] . "<br>";

    // Note: In real applications, never display database credentials!
?>
