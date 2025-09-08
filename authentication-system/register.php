<?php require "includes/header.php"; ?>

<?php require "config.php"; ?>

<?php 
    if(isset($_SESSION['username'])) {
        header("Location: index.php");
    }
    
    if(isset($_POST['submit'])) {
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $register_query = "INSERT INTO users (email, username, password) VALUES (?, ?, ?)";
        
        if($email == "" || $username == "" || $password == "") {
            $error = "All fields are required";

        } else {
            $stmt = $conn->prepare($register_query);
            $stmt->execute([$email, $username, password_hash($password, PASSWORD_DEFAULT)]);
            $success = "Account created successfully";
        }
    }
?>

<main class="form-signin w-50 m-auto">
    <form method="POST" action="register.php">

        <h1 class="h3 mt-5 fw-normal text-center">Register an account?</h1>

        <div class="form-floating">
            <input name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Email address</label>
        </div>

        <div class="form-floating">
            <input name="username" type="text" class="form-control" id="floatingInput" placeholder="username">
            <label for="floatingInput">Username</label>
        </div>

        <div class="form-floating">
            <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
        </div>

        <div class="form-floating">
            <span class="text-danger"><?php if(isset($error)) echo $error; ?></span>
            <span class="text-success"><?php if(isset($success)) echo $success; ?></span>
        </div>

        <button name="submit" class="w-100 btn btn-lg btn-primary" type="submit">register</button>
        <h6 class="mt-3">Already have an account? <a href="login.php">Login</a></h6>

    </form>
</main>
<?php require "includes/footer.php"; ?>