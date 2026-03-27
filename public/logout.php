<?php
// public/logout.php

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1️⃣ Unset all session variables
$_SESSION = [];

// 2️⃣ Delete session cookie (important for security)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();

    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// 3️⃣ Destroy the session
session_destroy();

// 4️⃣ Regenerate session ID (extra safety)
session_regenerate_id(true);

// 5️⃣ Redirect to login page
header("Location: login.php");
exit;
