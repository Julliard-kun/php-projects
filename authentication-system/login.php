<?php
    require "includes/header.php";
    require "config.php";

    // Generate CSRF token if not exists
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    // Redirect if already logged in
    if(isset($_SESSION['username'])) {
        header("Location: index.php");
        exit();
    }

    // Initialize login attempts tracking
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
        $_SESSION['last_attempt_time'] = time();
    }

    $errors = [];

    if(isset($_POST['submit'])) {
        // Verify CSRF token
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die('CSRF token validation failed');
        }

        // Check for too many login attempts
        if ($_SESSION['login_attempts'] >= 3 && (time() - $_SESSION['last_attempt_time']) < 900) {
            $wait_time = ceil((900 - (time() - $_SESSION['last_attempt_time'])) / 60);
            $errors[] = "Too many failed attempts. Please wait {$wait_time} minutes before trying again.";
        } else {
            // Reset attempts if timeout has passed
            if ((time() - $_SESSION['last_attempt_time']) >= 900) {
                $_SESSION['login_attempts'] = 0;
            }

            // Sanitize and validate input
            $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
            $password = $_POST['password'];

            if(empty($username)) {
                $errors[] = "Username is required";
            }
            if(empty($password)) {
                $errors[] = "Password is required";
            }

            if(empty($errors)) {
                try {
                    $login_query = "SELECT * FROM users WHERE username = ?";
                    $stmt = $conn->prepare($login_query);
                    $stmt->execute([$username]);
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);

                    if($user && password_verify($password, $user['password'])) {
                        // Successful login
                        $_SESSION['login_attempts'] = 0;
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['email'] = $user['email'];
                        
                        // Regenerate session ID for security
                        session_regenerate_id(true);
                        
                        // Set last activity time
                        $_SESSION['last_activity'] = time();
                        
                        header("Location: index.php");
                        exit();
                    } else {
                        // Failed login attempt
                        $_SESSION['login_attempts']++;
                        $_SESSION['last_attempt_time'] = time();
                        $errors[] = "Invalid username or password";
                    }
                } catch(PDOException $e) {
                    error_log("Login error: " . $e->getMessage());
                    $errors[] = "Login failed. Please try again later.";
                }
            }
        }
    }

?>

<main class="form-signin w-50 m-auto">
    <form method="POST" action="login.php" class="needs-validation" novalidate>
        <h1 class="h3 mt-5 fw-normal text-center">Sign In</h1>

        <!-- CSRF Protection -->
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

        <div class="form-floating mb-3">
            <input name="username" type="text" class="form-control <?php echo isset($errors) && in_array("Username is required", $errors) ? 'is-invalid' : ''; ?>" 
                id="floatingUsername" placeholder="username"
                value="<?php echo isset($_POST['username']) ? htmlspecialchars($username) : ''; ?>"
                required autocomplete="username">
            <label for="floatingUsername">Username</label>
            <div class="invalid-feedback">
                Please enter your username
            </div>
        </div>

        <div class="form-floating mb-3">
            <input name="password" type="password" class="form-control <?php echo isset($errors) && in_array("Password is required", $errors) ? 'is-invalid' : ''; ?>" 
                id="floatingPassword" placeholder="Password"
                required autocomplete="current-password">
            <label for="floatingPassword">Password</label>
            <div class="invalid-feedback">
                Please enter your password
            </div>
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

        <button name="submit" class="w-100 btn btn-lg btn-primary" type="submit">Sign In</button>
        
        <div class="text-center mt-3">
            Don't have an account? <a href="register.php">Create one</a>
        </div>
    </form>
</main>

<!-- Form validation script -->
<script>
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})()
</script>
<?php require "includes/footer.php" ?>