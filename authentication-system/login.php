<?php 
    require "includes/session.php";
    require "includes/header.php";
    require "config.php";

    // Redirect if already logged in
    if (is_logged_in()) {
        header('Location: index.php');
        exit();
    }

    if(isset($_POST['submit'])) {
        $input_username = trim($_POST['username']);
        $input_password = $_POST['password'];

        $errors = [];

        // Basic validation
        if(empty($input_username)) {
            $errors[] = "Username is required";
        }
        if(empty($input_password)) {
            $errors[] = "Password is required";
        }

        if(empty($errors)) {
            try {
                // Prepare statement to prevent SQL injection
                $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
                $stmt->execute([$input_username]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if($user && password_verify($input_password, $user['password'])) {
                    // Set session and redirect
                    set_user_session($user['id'], $user['username']);
                    header('Location: index.php');
                    exit();
                } else {
                    $error = "Invalid username or password";
                }
            } catch(PDOException $e) {
                error_log("Login error: " . $e->getMessage());
                $error = "Login failed. Please try again later.";
            }
        } else {
            $error = implode("<br>", $errors);
        }
    }
?>

<main class="form-signin w-50 m-auto">
    <form method="POST" action="login.php">
        <h1 class="h3 mt-5 fw-normal text-center">Sign In</h1>

        <div class="form-floating">
            <input name="username" type="text" class="form-control" id="floatingUsername" 
                placeholder="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                required autocomplete="username">
            <label for="floatingUsername">Username</label>
        </div>

        <div class="form-floating mb-3">
            <input name="password" type="password" class="form-control" id="floatingPassword" 
                placeholder="Password" required autocomplete="current-password">
            <label for="floatingPassword">Password</label>
        </div>

        <?php if(isset($error)): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <button name="submit" class="w-100 btn btn-lg btn-primary" type="submit">Sign In</button>
        
        <div class="auth-links">
            Don't have an account? <a href="register.php">Create one</a>
        </div>
    </form>
</main>
<?php require "includes/footer.php" ?>