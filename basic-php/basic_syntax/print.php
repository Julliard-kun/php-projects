<?php
    print ("This is about print.");

    print "It can also be used without open and close parenthesis. <br>";

    print 'It can also be with used with single quote. <br>';


    // 1st difference: print can be stored in a variable.
    $var1 = print ("This is print is stored in a variable. <br>");

    // var2 causes an error because it is not stored in a variable because echo does not return a value.
    // $var2 = echo ("This is echo is stored in a variable. <br>");

    // 2nd difference: print can only take one argument.
    echo "First argument " , "Second argument";

    // With print you need to use commas to separate the arguments.
    // print "First argument " , "Second argument";

?>