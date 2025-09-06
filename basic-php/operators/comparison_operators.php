<?php
    "This is about comparison operators.";

    "Comparison operators are used to compare two values.";

    "There are 6 comparison operators in PHP.";

    "These are ==, ===, !=, !==, >, <, >=, <=.";

    $var1 = 1;

    $var2 = 2;

    $var3 = 1;

    echo "Equal 1 == 2 is " , var_dump($var1 == $var2) , "<br>";

    echo "Equal 1 == 1 is " , var_dump($var1 == $var3) , "<br>";

    echo "Not Equal 1 != 2 is " , var_dump($var1 != $var2) , "<br>";

    echo "Not Equal 1 != 1 is " , var_dump($var1 != $var3) , "<br>";

    echo "Greater Than 1 > 2 is " , var_dump($var1 > $var2) , "<br>";

    echo "Greater Than 1 > 1 is " , var_dump($var1 > $var3) , "<br>";

    echo "Less Than 1 < 2 is " , var_dump($var1 < $var2) , "<br>";

    echo "Less Than 1 < 1 is " , var_dump($var1 < $var3) , "<br>";
    
    echo "Greater Than or Equal To 1 >= 2 is " , var_dump($var1 >= $var2) , "<br>";

    echo "Greater Than or Equal To 1 >= 1 is " , var_dump($var1 >= $var3) , "<br>";

    echo "Less Than or Equal To 1 <= 2 is " , var_dump($var1 <= $var2) , "<br>";

    echo "Less Than or Equal To 1 <= 1 is " , var_dump($var1 <= $var3) , "<br>";
    
?>