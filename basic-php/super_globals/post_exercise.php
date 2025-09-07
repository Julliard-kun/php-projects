<?php

    if(isset($_POST['submit'])) {
        echo "The full name is " . $_POST['full_name'];
    }
?>

<html>
    <head>Post Exercise</head>
    <body>
        <form method="POST" action="post_exercise.php">
            Full Name: <input type="text" name="full_name">
            
            <input type="submit" name="submit">
        
        </form>

    </body>
</html>