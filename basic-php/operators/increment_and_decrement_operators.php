<?php
    "This is about increment and decrement operators.";

    "Increment and decrement operators are used to increment and decrement the value of a variable.";

    "There are 2 increment and decrement operators in PHP.";

    "These are ++ and --.";

    "When we use ++ or -- before the variable, the variable is incremented or decremented before the value is used.";

    $comparison = 1;
    $pre_increment = 1;

    echo "Pre-increment: " , var_dump($comparison == ++$pre_increment) , "<br>";

    echo "<br>";

    "When we use ++ or -- after the variable, the variable is incremented or decremented after the value is used.";

    $post_increment = 1;

    echo "Post-increment: " , var_dump($comparison == $post_increment++) , "<br>";

    echo "<br>";

    $pre_decrement = 1;

    echo "Pre-decrement: " , var_dump($comparison == --$pre_decrement) , "<br>";

    echo "<br>";

    $post_decrement = 1;

    echo "Post-decrement: " , var_dump($comparison == $post_decrement--) , "<br>";

?>