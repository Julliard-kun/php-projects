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
    
    if(isset($_POST['submit'])) {
        // Verify CSRF token
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die('CSRF token validation failed');
        }
        // Sanitize inputs
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = $_POST['password']; // Don't sanitize password to allow special characters

        $errors = [];

        // Validate email
        if(empty($email)) {
            $errors[] = "Email is required";
        } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Please enter a valid email address";
        } else {
            // Check if email already exists
            $email_check = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
            $email_check->execute([$email]);
            if($email_check->fetchColumn() > 0) {
                $errors[] = "Email is already registered";
            }
        }

        // Validate username
        if(empty($username)) {
            $errors[] = "Username is required";
        } elseif(!preg_match('/^[a-zA-Z0-9]{3,20}$/', $username)) {
            $errors[] = "Username must be between 3-20 characters and contain only letters and numbers";
        } else {
            // Check if username already exists
            $username_check = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
            $username_check->execute([$username]);
            if($username_check->fetchColumn() > 0) {
                $errors[] = "Username is already taken";
            }
        }

        // Validate password
        if(empty($password)) {
            $errors[] = "Password is required";
        } elseif(strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters long";
        } elseif(!preg_match('/[A-Z]/', $password)) {
            $errors[] = "Password must contain at least one uppercase letter";
        } elseif(!preg_match('/[a-z]/', $password)) {
            $errors[] = "Password must contain at least one lowercase letter";
        } elseif(!preg_match('/[0-9]/', $password)) {
            $errors[] = "Password must contain at least one number";
        } elseif(!preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $password)) {
            $errors[] = "Password must contain at least one special character";
        }

        // If no errors, proceed with registration
        if(empty($errors)) {
            try {
                $register_query = "INSERT INTO users (email, username, password) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($register_query);
                $stmt->execute([
                    $email,
                    $username,
                    password_hash($password, PASSWORD_DEFAULT)
                ]);

                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;

                $success = "Account created successfully! Redirecting...";
                header("refresh:2;url=index.php");
            } catch(PDOException $e) {
                error_log("Registration error: " . $e->getMessage());
                $errors[] = "Registration failed. Please try again later.";
            }
        }
    }
?>

<main class="form-signin w-50 m-auto">
    <form method="POST" action="register.php" class="needs-validation" novalidate>
        <h1 class="h3 mt-5 fw-normal text-center">Create Account</h1>

        <!-- CSRF Protection -->
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

        <div class="form-floating mb-3">
            <input name="email" type="email" class="form-control <?php echo isset($errors) && in_array("Email is required", $errors) ? 'is-invalid' : ''; ?>" 
                id="floatingEmail" placeholder="name@example.com" 
                value="<?php echo isset($_POST['email']) ? htmlspecialchars($email) : ''; ?>"
                required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
            <label for="floatingEmail">Email address</label>
            <div class="invalid-feedback">
                Please enter a valid email address
            </div>
        </div>

        <div class="form-floating mb-3">
            <input name="username" type="text" class="form-control <?php echo isset($errors) && in_array("Username is required", $errors) ? 'is-invalid' : ''; ?>" 
                id="floatingUsername" placeholder="username"
                value="<?php echo isset($_POST['username']) ? htmlspecialchars($username) : ''; ?>"
                required pattern="[a-zA-Z0-9]{3,20}" title="3-20 characters, letters and numbers only">
            <label for="floatingUsername">Username</label>
            <div class="invalid-feedback">
                Username must be 3-20 characters long and contain only letters and numbers
            </div>
        </div>

        <div class="form-floating mb-3">
            <input name="password" type="password" class="form-control <?php echo isset($errors) && strpos(implode(" ", $errors), "Password") !== false ? 'is-invalid' : ''; ?>" 
                id="floatingPassword" placeholder="Password"
                required minlength="8">
            <label for="floatingPassword">Password</label>
        </div>

        <!-- Password Requirements -->
        <div class="password-requirements small text-muted mb-3">
            <p class="mb-2">Password must contain:</p>
            <ul class="ps-3">
                <li>At least 8 characters</li>
                <li>One uppercase letter</li>
                <li>One lowercase letter</li>
                <li>One number</li>
                <li>One special character (!@#$%^&*()-_=+{};:,<.>)</li>
            </ul>
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

        <button name="submit" class="w-100 btn btn-lg btn-primary" type="submit">Create Account</button>
        
        <div class="text-center mt-3">
            Already have an account? <a href="login.php">Sign in</a>
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
<?php require "includes/footer.php"; ?>