<?php
session_start();

// Initialize variables
$errors = [];
$success_message = '';
$form_data = [
    'username' => '',
    'email' => '',
    'password' => '',
    'confirm_password' => '',
    'bio' => ''
];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $form_data = [
        'username' => trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING)),
        'email' => trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL)),
        'password' => $_POST['password'] ?? '',
        'confirm_password' => $_POST['confirm_password'] ?? '',
        'bio' => trim(filter_input(INPUT_POST, 'bio', FILTER_SANITIZE_STRING))
    ];

    // Validation
    if (empty($form_data['username'])) {
        $errors['username'] = 'Username is required';
    } elseif (strlen($form_data['username']) < 3) {
        $errors['username'] = 'Username must be at least 3 characters long';
    }

    if (empty($form_data['email'])) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address';
    }

    if (empty($form_data['password'])) {
        $errors['password'] = 'Password is required';
    } elseif (strlen($form_data['password']) < 6) {
        $errors['password'] = 'Password must be at least 6 characters long';
    }

    if ($form_data['password'] !== $form_data['confirm_password']) {
        $errors['confirm_password'] = 'Passwords do not match';
    }

    if (strlen($form_data['bio']) > 500) {
        $errors['bio'] = 'Bio must not exceed 500 characters';
    }

    // If no errors, process the form
    if (empty($errors)) {
        // In a real application, you would:
        // 1. Hash the password
        // 2. Save to database
        // 3. Send confirmation email
        // For this example, we'll just show a success message
        $success_message = 'Registration successful! Welcome ' . htmlspecialchars($form_data['username']);
        
        // Clear form data after successful submission
        $form_data = array_fill_keys(array_keys($form_data), '');
    }
}

// Helper function to display error messages
function displayError($field) {
    global $errors;
    return isset($errors[$field]) ? "<span class=\"error\">{$errors[$field]}</span>" : '';
}

// Helper function to retain form values
function oldValue($field) {
    global $form_data;
    return htmlspecialchars($form_data[$field]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        textarea {
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
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
            background-color: #d4edda;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .password-requirements {
            font-size: 0.875em;
            color: #666;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User Registration</h1>
        
        <?php if ($success_message): ?>
            <div class="success">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="form-group">
                <label for="username">Username:</label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    value="<?php echo oldValue('username'); ?>"
                    placeholder="Enter your username"
                >
                <?php echo displayError('username'); ?>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="<?php echo oldValue('email'); ?>"
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
                <div class="password-requirements">
                    Password must be at least 6 characters long
                </div>
                <?php echo displayError('password'); ?>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input 
                    type="password" 
                    id="confirm_password" 
                    name="confirm_password"
                    placeholder="Confirm your password"
                >
                <?php echo displayError('confirm_password'); ?>
            </div>

            <div class="form-group">
                <label for="bio">Bio (Optional):</label>
                <textarea 
                    id="bio" 
                    name="bio" 
                    rows="4" 
                    placeholder="Tell us about yourself"
                ><?php echo oldValue('bio'); ?></textarea>
                <?php echo displayError('bio'); ?>
            </div>

            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>