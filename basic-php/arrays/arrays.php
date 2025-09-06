<?php
    "This is about arrays.";

    "Arrays are used to store multiple values 
    in a single variable.";

    /*
    Syntax:
    $array_name = array(value1, value2, value3, ...);

    "PHP also provides another syntax to create an array:
    $array_name = [value1, value2, value3, ...];
    "
    */

    $username_arr = array("John", "Jane", "Jim", "Jill");
    $username_arr2 = ["John", "Jane", "Jim", "Jill"];

    // Accessing the values of the array using index:
    echo $username_arr[0] , "<br>";

    // Accessing all values of the array using loop:
    for ($i = 0; $i < count($username_arr); $i++) {
        echo $username_arr[$i] , "<br>";
    }

    // Accessing the value of the other syntax:
    echo $username_arr2[0] , "<br>";
?>
