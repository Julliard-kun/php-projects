<?php
    "This is about single vs double quotes.";

    $var1 = "Stored in double quotes.";

    echo '$var1' , "<br>";
    // This will output $var1 not the value of the variable..

    echo "$var1";
    // This will output stored in double quotes.


?>