<?php
// ============================================
// logout.php - Logout Handler
// Destroys session and clears cookies
// ============================================
require_once 'includes/functions.php';

// Unset all session variables
$_SESSION = [];

// Destroy the session cookie in the browser
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy the session on the server
session_destroy();

// Clear the remember-me cookie too
clearRememberCookie();

// Redirect to home page
header("Location: index.php?bye=1");
exit();
?>
