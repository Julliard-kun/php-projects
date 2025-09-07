<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header('Location: session_one.php');
    exit();
}

// Initialize variables
$success_message = '';
$errors = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize input
    $new_name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validate name
    if (empty($new_name)) {
        $errors['name'] = 'Name is required';
    } elseif (strlen($new_name) < 2) {
        $errors['name'] = 'Name must be at least 2 characters long';
    }

    // If changing password
    if (!empty($new_password) || !empty($confirm_password)) {
        // Validate current password (in real app, check against hashed password in database)
        $valid_users = [
            'admin@example.com' => ['password' => 'admin123'],
            'user@example.com' => ['password' => 'user123']
        ];

        if (empty($current_password)) {
            $errors['current_password'] = 'Current password is required';
        } elseif (!isset($valid_users[$_SESSION['user_email']]) || 
                  $valid_users[$_SESSION['user_email']]['password'] !== $current_password) {
            $errors['current_password'] = 'Current password is incorrect';
        }

        // Validate new password
        if (empty($new_password)) {
            $errors['new_password'] = 'New password is required';
        } elseif (strlen($new_password) < 6) {
            $errors['new_password'] = 'New password must be at least 6 characters long';
        }

        // Validate password confirmation
        if ($new_password !== $confirm_password) {
            $errors['confirm_password'] = 'Passwords do not match';
        }
    }

    // If no errors, update the session and "database"
    if (empty($errors)) {
        // Update session data
        $_SESSION['user_name'] = $new_name;
        
        // Update last activity
        $_SESSION['last_activity'] = time();

        $success_message = 'Profile updated successfully!';
        
        // In a real application, you would update the database here
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
    <title>Update Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        .profile-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
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
        .success {
            color: #28a745;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #d4edda;
            border-radius: 4px;
        }
        .nav-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            font-size: 1em;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .password-section {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <h1>Update Profile</h1>

        <?php if ($success_message): ?>
            <div class="success">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="form-group">
                <label for="name">Name:</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="<?php echo htmlspecialchars($_SESSION['user_name']); ?>"
                    placeholder="Enter your name"
                >
                <?php echo displayError('name'); ?>
            </div>

            <div class="form-group">
                <label>Email:</label>
                <p><?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
                <small>(Email cannot be changed)</small>
            </div>

            <div class="password-section">
                <h2>Change Password</h2>
                <p><small>Leave blank if you don't want to change your password</small></p>

                <div class="form-group">
                    <label for="current_password">Current Password:</label>
                    <input 
                        type="password" 
                        id="current_password" 
                        name="current_password"
                        placeholder="Enter current password"
                    >
                    <?php echo displayError('current_password'); ?>
                </div>

                <div class="form-group">
                    <label for="new_password">New Password:</label>
                    <input 
                        type="password" 
                        id="new_password" 
                        name="new_password"
                        placeholder="Enter new password"
                    >
                    <?php echo displayError('new_password'); ?>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm New Password:</label>
                    <input 
                        type="password" 
                        id="confirm_password" 
                        name="confirm_password"
                        placeholder="Confirm new password"
                    >
                    <?php echo displayError('confirm_password'); ?>
                </div>
            </div>

            <div class="nav-buttons">
                <button type="submit" class="btn btn-primary">Update Profile</button>
                <a href="session_two.php" class="btn btn-secondary">Back to Dashboard</a>
            </div>
        </form>
    </div>
</body>
</html>