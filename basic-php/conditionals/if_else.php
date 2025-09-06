<?php
    "This is about if else.";

    "If else is used to check if a condition is true or false.";

    /*
    Syntax:
    if (condition) {
        // code to be executed if the condition is true
    } else {
        // code to be executed if the condition is false
    }
    */

    /*
    Syntax:
    if (condition) {
        // code to be executed if the condition is true
    } else if (condition) {
        // code to be executed if the condition is true
    } else {
        // code to be executed if the condition is false
    }
    */
    
    $age = 17;
    $people = 2;

    if ($age >= 18) {
        // code to be executed if the condition is true
        echo "You are an adult. You can vote.";
         
    } else {
        // code to be executed if the condition is false
        echo "You are not an adult. You cannot vote.";
    }

    echo "<br>";

    if ($people == 1) {
        echo "You can only play single player game.";

    } else if ($people >1) {
        echo "You can play multiplayer game.";

    } else {
        echo "There is no one to play the game.";

    }
?>