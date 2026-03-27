<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Checks if a user is logged in and optionally has a required role(s)
 * 
 * @param PDO $pdo
 * @param string|array|null $allowedRoles Single role (e.g., 'treasurer') or array (e.g., ['treasurer', 'chairperson'])
 */
function checkAuth(PDO $pdo, string|array|null $allowedRoles = null): void
{
    // 1. Check if user is logged in at all
    if (!isset($_SESSION['user_id'])) {
        header('Location: /sacco-management-system/public/login.php');
        exit;
    }

    // 2. If specific roles are required for this page
    if ($allowedRoles !== null) {
        // Fetch current role from DB to ensure it hasn't changed or been deleted
        $stmt = $pdo->prepare("SELECT role FROM users WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // If user no longer exists in DB, kill session and boot to login
        if (!$user) {
            session_destroy();
            header('Location: /sacco-management-system/public/login.php');
            exit;
        }

        // --- THE MAGIC PART ---
        // If the user is an ADMIN, they get a "Master Key" to every page automatically
        if ($user['role'] === 'admin') {
            $_SESSION['user_role'] = 'admin'; // Sync session
            return; // Let them in!
        }

        // Normalize allowed roles to an array
        $roles = is_array($allowedRoles) ? $allowedRoles : [$allowedRoles];

        // Check if the user's role is in the allowed list
        if (!in_array($user['role'], $roles)) {
            // Instead of die() or exit(), send them to the BEAUTIFUL error page
            header('Location: /sacco-management-system/public/403.php');
            exit;
        }

        // Sync session role for template use
        $_SESSION['user_role'] = $user['role'];
    }
}
