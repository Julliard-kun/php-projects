<?php
    // Start session if not already started
    if (session_status() === PHP_SESSION_NONE) {
        // Set secure session cookie parameters
        $secure = true; // Only transmit cookie over HTTPS
        $httponly = true; // Prevent JavaScript access to session cookie
        $samesite = 'Strict'; // Prevent CSRF attacks
        
        // Set session cookie parameters
        session_set_cookie_params([
            'lifetime' => 3600, // 1 hour
            'path' => '/',
            'secure' => $secure,
            'httponly' => $httponly,
            'samesite' => $samesite
        ]);
        
        session_start();
    }

    // Regenerate session ID periodically to prevent session fixation
    if (!isset($_SESSION['last_regeneration'])) {
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    } else if (time() - $_SESSION['last_regeneration'] > 1800) {
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }

    // Function to check if user is logged in
    function is_logged_in() {
        return isset($_SESSION['user_id']);
    }

    // Function to require login for protected pages
    function require_login() {
        if (!is_logged_in()) {
            header('Location: /login.php');
            exit();
        }
    }

    // Function to get current user ID
    function get_user_id() {
        return $_SESSION['user_id'] ?? null;
    }

    // Function to get current username
    function get_username() {
        return $_SESSION['username'] ?? null;
    }

    // Function to set user session after successful login/registration
    function set_user_session($user_id, $username) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;
        $_SESSION['last_activity'] = time();
    }

    // Function to clear user session on logout
    function clear_user_session() {
        session_unset();
        session_destroy();
        setcookie(session_name(), '', time() - 3600, '/');
    }

    // Check for session timeout (30 minutes)
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
        clear_user_session();
        header('Location: /login.php?msg=session_expired');
        exit();
    }

    // Update last activity time
    if (isset($_SESSION['last_activity'])) {
        $_SESSION['last_activity'] = time();
    }
?>
