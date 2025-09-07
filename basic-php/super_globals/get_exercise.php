<?php
    if(isset($_GET['submit'])) {
        echo "The email is " . $_GET['param'];
    }

?>

<html>
    <head>Get Exercise</head>
    <body>
        <a href="get.php?param=email">Get Email</a>    

    </body>
</html>