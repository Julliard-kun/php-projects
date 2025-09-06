<?php
    "This is about associative arrays.";

    "Associative arrays are used to store multiple values 
    that are associated with keys
    in a single variable";

    /*
    Syntax:
    $array_name = array(key1 => value1, key2 => value2, key3 => value3, ...);
    
    "PHP also provides another syntax to create an associative array:
    $array_name = [key1 => value1, key2 => value2, key3 => value3, ...];
    "
    */

    $age_arr = array("John" => 25, "Jane" => 30, "Jim" => 35, "Jill" => 40);
    $age_arr2 = ["John" => 25, "Jane" => 30, "Jim" => 35, "Jill" => 40];

    // Accessing the values of the array using keys:
    echo $age_arr["John"] , "<br>";

    // Accessing all values of the array using loop:
    foreach ($age_arr as $key => $value) {
        echo "Name is " , $key , " and age is " , $value , " years old." , "<br>";
    }   

    // Accessing the value of the other syntax:
    echo $age_arr2["John"] , "<br>";

?>