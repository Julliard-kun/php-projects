<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header('Location: session_one.php');
    exit();
}

// Update last activity time
$_SESSION['last_activity'] = time();

// Calculate session duration
$session_duration = time() - $_SESSION['login_time'];
$duration_minutes = floor($session_duration / 60);
$duration_seconds = $session_duration % 60;

// Handle logout
if (isset($_POST['logout'])) {
    // Destroy the session
    session_destroy();
    
    // Redirect to login page
    header('Location: session_one.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        .dashboard-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        .user-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .session-info {
            background-color: #e9ecef;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .admin-section {
            background-color: #fff3cd;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .logout-btn {
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .logout-btn:hover {
            background-color: #c82333;
        }
        .role-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8em;
            font-weight: bold;
            text-transform: uppercase;
        }
        .role-admin {
            background-color: #ffc107;
            color: #000;
        }
        .role-user {
            background-color: #17a2b8;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="header">
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h1>
            <form method="POST" style="display: inline;">
                <button type="submit" name="logout" class="logout-btn">Logout</button>
            </form>
        </div>

        <div class="user-info">
            <h2>User Information</h2>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
            <p><strong>Role:</strong> 
                <span class="role-badge role-<?php echo strtolower($_SESSION['user_role']); ?>">
                    <?php echo htmlspecialchars($_SESSION['user_role']); ?>
                </span>
            </p>
        </div>

        <div class="session-info">
            <h2>Session Information</h2>
            <p><strong>Login Time:</strong> <?php echo date('Y-m-d H:i:s', $_SESSION['login_time']); ?></p>
            <p><strong>Last Activity:</strong> <?php echo date('Y-m-d H:i:s', $_SESSION['last_activity']); ?></p>
            <p><strong>Session Duration:</strong> <?php echo $duration_minutes; ?> minutes <?php echo $duration_seconds; ?> seconds</p>
        </div>

        <?php if ($_SESSION['user_role'] === 'administrator'): ?>
        <div class="admin-section">
            <h2>Administrator Panel</h2>
            <p>As an administrator, you have access to additional features:</p>
            <ul>
                <li>User Management</li>
                <li>System Settings</li>
                <li>Activity Logs</li>
                <li>Security Controls</li>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>