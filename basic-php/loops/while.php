<?php
    "This is about while loops.";

    "While loops are used to execute a block of code 
    multiple times while a condition is true.";

    /*
    Syntax:
    while (condition) {
        // code to be executed

        // increment or decrement
    }
    */

    $i = 0;

    echo "While loop in increment order: <br>";
    while ($i <= 10) {
        echo "Number is: " , $i , "<br>";
        $i++;
    }

    echo "<br>";

    echo "While loop in decrement order: <br>";
    while ($i >= 0) {
        echo "Number is: " , $i , "<br>";
        $i--;
    }

?>