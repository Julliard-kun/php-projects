<?php 
    require "includes/session.php";
    require "includes/header.php";
    require "config.php";

    // Generate CSRF token if not exists
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    if(isset($_POST['submit'])) {
        // Verify CSRF token
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die('CSRF token validation failed');
        }

        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        $errors = [];
        
        // Validate email
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Please enter a valid email address";
        }
        
        // Validate username (alphanumeric and between 3-20 characters)
        if(!preg_match('/^[a-zA-Z0-9]{3,20}$/', $username)) {
            $errors[] = "Username must be between 3-20 characters and contain only letters and numbers";
        }
        
        // Password strength validation
        if(strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters long";
        }
        if(!preg_match('/[A-Z]/', $password)) {
            $errors[] = "Password must contain at least one uppercase letter";
        }
        if(!preg_match('/[a-z]/', $password)) {
            $errors[] = "Password must contain at least one lowercase letter";
        }
        if(!preg_match('/[0-9]/', $password)) {
            $errors[] = "Password must contain at least one number";
        }
        if(!preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $password)) {
            $errors[] = "Password must contain at least one special character";
        }
        
        // Validate password confirmation
        if($password !== $confirm_password) {
            $errors[] = "Passwords do not match";
        }

        // Check if email already exists
        $email_check = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $email_check->execute([$email]);
        if($email_check->fetchColumn() > 0) {
            $errors[] = "Email already registered";
        }

        // Check if username already exists
        $username_check = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $username_check->execute([$username]);
        if($username_check->fetchColumn() > 0) {
            $errors[] = "Username already taken";
        }

        if(empty($errors)) {
            try {
                $register_query = "INSERT INTO users (email, username, password) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($register_query);
                $stmt->execute([$email, $username, password_hash($password, PASSWORD_DEFAULT)]);
                
                set_user_session($conn->lastInsertId(), $username);
                
                $success = "Account created successfully! Redirecting to dashboard...";
                header("refresh:2;url=index.php");
            } catch(PDOException $e) {
                $errors[] = "Registration failed. Please try again later.";
                // Log the error securely
                error_log("Registration error: " . $e->getMessage());
            }
        }
    }
?>

<main class="form-signin w-50 m-auto">
    <form method="POST" action="register.php">

        <h1 class="h3 mt-5 fw-normal text-center">Register an account?</h1>

        <!-- CSRF Protection -->
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
        
        <div class="form-floating">
            <input name="email" type="email" class="form-control" id="floatingInput" 
                placeholder="name@example.com" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            <label for="floatingInput">Email address</label>
        </div>

        <div class="form-floating">
            <input name="username" type="text" class="form-control" id="floatingInput" 
                placeholder="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
            <label for="floatingInput">Username</label>
        </div>

        <div class="form-floating">
            <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
        </div>

        <div class="form-floating mb-3">
            <input name="confirm_password" type="password" class="form-control" id="floatingConfirmPassword" placeholder="Confirm Password">
            <label for="floatingConfirmPassword">Confirm Password</label>
        </div>

        <?php if(!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if(isset($success)): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <button name="submit" class="w-100 btn btn-lg btn-primary" type="submit">Register</button>
        <h6 class="mt-3">Already have an account? <a href="login.php">Login</a></h6>

    </form>
</main>
<?php require "includes/footer.php"; ?>