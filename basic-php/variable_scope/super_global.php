<?php
    "This is about super global variables.";

    "Super global variables are variables 
    that are always available in all scopes.";

    /*
    There are 10 super global variables in PHP.
    $_GET is used to get the values of the variables
    $_POST is used to send the values of the variables
    $_COOKIE is used to get the values of the cookies
    $_SESSION is used to get the values of the session
    $_SERVER is used to get the values of the server
    $_ENV is used to get the values of the environment variables
    $_FILES is used to get the values of the files
    $_REQUEST is used to get the values of the request
    */
     
    if (isset($_POST['submit'])) {
        echo "Username is " , $_POST['username'] , "<br>";
        echo "Email is " , $_POST['email'] , "<br>";
    }
?>

<html>
    <head></head>

    <body>
        <form method="POST" action="super_global.php">
            Username <input type="text" name="username" placeholder="Input username">
            <br>
            Email <input type="text" name="email" placeholder="Input email">
            <br>
            
            <input type="submit" name="submit" value="Submit">
        </form>
    
    </body>
</html>