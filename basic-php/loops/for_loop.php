<?php
    "This is about for loops.";

    "For loops are used to execute a block 
    of code multiple times while a condition is true.";

    /*
    Syntax:
    for (initialization; condition; increment/decrement) {
        // code to be executed
    }
    */

    echo "For loop in increment order: <br>";
    for ($i = 0; $i <= 10; $i++) { // i is initialized to 0
        echo "Current value of i is: " , $i , "<br>";
    }

    echo "<br>";

    echo "For loop in decrement order: <br>";
    for ($i = 10; $i >= 0; $i--) { // i is reinitialized to 10
        echo "Current value of i is: " , $i , "<br>";
    }

?>