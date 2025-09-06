<?php
    /**
     * PHP Functions Example
     * This file demonstrates various aspects of PHP functions
     */

    // 1. Basic function with type declarations and return type
    function calculateArea(float $length, float $width): float {
        return $length * $width;
    }

    // 2. Function with default parameters
    function greet(string $name = "Guest", string $greeting = "Hello"): string {
        return "$greeting, $name!";
    }

    // 3. Function demonstrating variable scope
    function demonstrateScope(): void {
        $localVar = "I'm local";
        global $globalVar;
        $globalVar = "I'm global";
        
        echo "Inside function: $localVar<br>";
        echo "Global variable set to: $globalVar<br>";
    }

    // 4. Function with validation and multiple parameters
    function calculateDiscount(float $price, float $discountPercent, bool $formatAsCurrency = true): string {
        // Validate input
        if ($price < 0 || $discountPercent < 0 || $discountPercent > 100) {
            return "Invalid input parameters";
        }

        $discountAmount = $price * ($discountPercent / 100);
        $finalPrice = $price - $discountAmount;

        if ($formatAsCurrency) {
            return "$" . number_format($finalPrice, 2);
        }
        return (string)$finalPrice;
    }

    // 5. Function that accepts variable number of arguments
    function calculateAverage(...$numbers): float {
        if (empty($numbers)) {
            return 0.0;
        }
        return array_sum($numbers) / count($numbers);
    }

    // Examples of using the functions
    echo "<h2>PHP Functions Examples</h2>";

    // Example 1: Using calculateArea
    $area = calculateArea(5.5, 3.2);
    echo "Area of rectangle (5.5 x 3.2): $area square units<br><br>";

    // Example 2: Using greet with different parameters
    echo greet() . "<br>";  // Uses default parameters
    echo greet("John") . "<br>";  // Custom name, default greeting
    echo greet("Maria", "Good morning") . "<br><br>";

    // Example 3: Demonstrating scope
    demonstrateScope();
    echo "Outside function, global variable: $globalVar<br><br>";

    // Example 4: Using calculateDiscount
    $originalPrice = 100.00;
    $discountPercent = 20;
    echo "Original price: $100.00<br>";
    echo "Price after {$discountPercent}% discount: " . 
         calculateDiscount($originalPrice, $discountPercent) . "<br><br>";

    // Example 5: Using calculateAverage
    $average = calculateAverage(10, 20, 30, 40, 50);
    echo "Average of numbers (10, 20, 30, 40, 50): $average<br>";
?>