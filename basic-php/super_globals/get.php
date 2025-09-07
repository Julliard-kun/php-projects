<?php
    "This is about super global variables.";

    /*
    $_GET is used to get the values of the variables
    through a URL.
    */

    if (isset($_GET['lang'])) {
        $lang = $_GET['lang'];
        echo "Language is " , $lang , "<br>";
    }
?>

<html>
    <head></head>

    <body>
        <a href="get.php?lang=get_php">Get Link</a>

        <a href="post.php?lang=post_php">Get link from post.php</a>
    </body>


</html>