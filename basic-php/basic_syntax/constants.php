<?php
    print "This is about constants.";

    "Constants are like variables but they cannot be changed. <br>";

    "To create a constant we use the define function. <br>";

    // The convention for constants is to write them in capital letters and we start with define function.
    define("FIRST_PARAMETER_IS_THE_NAME_OF_THE_CONSTANT_AND_ITS_WRITTEN_IN_CAPITAL_LETTERS",
            "SECOND_PARAMETER_IS_THE_VALUE_OF_THE_CONSTANT", false);
    
    // The third parameter is optional and it is used to check if the constant is case sensitive.
    // If it is true, the constant is case sensitive.
    // If it is false, the constant is case insensitive.
    // The default value is false.

    echo FIRST_PARAMETER_IS_THE_NAME_OF_THE_CONSTANT_AND_ITS_WRITTEN_IN_CAPITAL_LETTERS , "<br>";

    echo SECOND_PARAMETER_IS_THE_VALUE_OF_THE_CONSTANT , "<br>";

    echo "You can also check if a constant is defined using the defined function. <br>";

    echo defined("FIRST_PARAMETER_IS_THE_NAME_OF_THE_CONSTANT_AND_ITS_WRITTEN_IN_CAPITAL_LETTERS");
    
?>