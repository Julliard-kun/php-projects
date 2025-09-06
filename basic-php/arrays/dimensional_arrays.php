<?php
    "This is about dimensional arrays.";

    "Dimensional arrays are used to store multiple arrays.";

    /*
    Syntax:
    $array_name = array(array1, array2, array3, ...);

    "PHP also provides another syntax to create a dimensional array:
    $array_name = [array1, array2, array3, ...];
    "
    */

    $dimensional_arr = array(array("John", "Jane", "Jim", "Jill"), array("John", "Jane", "Jim", "Jill"), array("John", "Jane", "Jim", "Jill"));
    $dimensional_arr2 = [["John", "Jane", "Jim", "Jill"], ["John", "Jane", "Jim", "Jill"], ["John", "Jane", "Jim", "Jill"]];

    // Accessing the values of the array using index:
    echo $dimensional_arr[0][0] , "<br>";

    // Accessing all values of the array using loop:
    for ($i = 0; $i < count($dimensional_arr); $i++) {
        for ($j = 0; $j < count($dimensional_arr[$i]); $j++) {
            echo $dimensional_arr[$i][$j] , "<br>";
        }
    }
    
    // Accessing the value of the other syntax:
    echo $dimensional_arr2[0][0] , "<br>";

?>
    