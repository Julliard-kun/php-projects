<?php
    "This is about super global variables.";

    "Super global variables are variables 
    that are always available in all scopes.";

    /*
    $_POST is used to send the values of the variables
    through a form.
    */
     
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];

        echo "Username is " , $username , "<br>";
        echo "Email is " , $email , "<br>";
    }

    if(isset($_GET['lang'])) {
        $lang = $_GET['lang'];
        echo "Language is " , $lang , "<br>";
    }
?>

<html>
    <head></head>

    <body>
        <form method="POST" action="post.php">
            Username <input type="text" name="username" placeholder="Input username">
            <br>
            Email <input type="text" name="email" placeholder="Input email">
            <br>
            
            <input type="submit" name="submit" value="Submit">
        </form>
    
    </body>
</html>