<?php
session_start();

// Initialize variables
$errors = [];
$success_message = '';

// Sample user data (in real application, this would come from a database)
$valid_users = [
    'admin@example.com' => [
        'password' => 'admin123', // In real app, this would be hashed
        'name' => 'Admin User',
        'role' => 'administrator'
    ],
    'user@example.com' => [
        'password' => 'user123', // In real app, this would be hashed
        'name' => 'Regular User',
        'role' => 'user'
    ]
];

// Check if user is already logged in
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    header('Location: session_two.php');
    exit();
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    // Validate input
    if (empty($email)) {
        $errors['email'] = 'Email is required';
    }
    if (empty($password)) {
        $errors['password'] = 'Password is required';
    }

    // Check credentials
    if (empty($errors)) {
        if (isset($valid_users[$email]) && $valid_users[$email]['password'] === $password) {
            // Set session variables
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_name'] = $valid_users[$email]['name'];
            $_SESSION['user_role'] = $valid_users[$email]['role'];
            $_SESSION['login_time'] = time();
            $_SESSION['last_activity'] = time();

            // Redirect to dashboard
            header('Location: session_two.php');
            exit();
        } else {
            $errors['login'] = 'Invalid email or password';
        }
    }
}

// Helper function to display error messages
function displayError($field) {
    global $errors;
    return isset($errors[$field]) ? "<span class=\"error\">{$errors[$field]}</span>" : '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .login-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .error {
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 5px;
            display: block;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #0056b3;
        }
        .demo-credentials {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 4px;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="form-group">
                <label for="email">Email:</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                    placeholder="Enter your email"
                >
                <?php echo displayError('email'); ?>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password"
                    placeholder="Enter your password"
                >
                <?php echo displayError('password'); ?>
            </div>

            <?php echo displayError('login'); ?>

            <button type="submit">Login</button>
        </form>

        <div class="demo-credentials">
            <strong>Demo Credentials:</strong><br>
            Admin: admin@example.com / admin123<br>
            User: user@example.com / user123
        </div>
    </div>
</body>
</html>