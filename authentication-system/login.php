<?php require "includes/header.php"; ?>

<?php require "config.php"; ?>

<?php 
    if(isset($_SESSION['username'])) {
        header("Location: index.php");
    }

    if(isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if($username == "" || $password == "") {
            $error = "All fields are required";
        }

        $login_query = "SELECT * FROM users WHERE username = ?";

        $stmt = $conn->prepare($login_query);
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($stmt->rowCount() > 0) {
            if(password_verify($password, $user['password'])) {
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];

                header("Location: index.php");
            } else {
                $error = "Invalid username or password";
            }

        } else {
            $error = "Invalid username or password";
        }
    }   

?>

<main class="form-signin w-50 m-auto">
    <form method="POST" action="login.php">
        <!-- <img class="mb-4 text-center" src="/docs/5.2/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
        <h1 class="h3 mt-5 fw-normal text-center">Please sign in</h1>

        <div class="form-floating">
            <input name="username" type="text" class="form-control" id="floatingInput" placeholder="user.name">
            <label for="floatingInput">Username</label>
        </div>
        <div class="form-floating">
            <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
        </div>
        <span class="text-danger"><?php if(isset($error)) echo $error; ?></span>
        <button name="submit" class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>

        <h6 class="mt-3">Don't have an account <a href="register.php">Create your account</a></h6>
    </form>
</main>
<?php require "includes/footer.php" ?>