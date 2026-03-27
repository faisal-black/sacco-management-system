<?php
// app/controllers/AuthController.php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
require_once __DIR__ . '/../../config/database.php';
session_start();

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$email = trim($data['email'] ?? '');
$password = trim($data['password'] ?? '');

if (!$email || !$password) {
    echo json_encode(['success' => false, 'message' => 'Email and password are required']);
    exit;
}

try {
    // 1. Fetch user by email - Now including 'full_name' for your sidebar
    $stmt = $pdo->prepare("SELECT id, full_name, password, role FROM users WHERE email = :email LIMIT 1");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // 2. Set Session Variables
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_name'] = $user['full_name']; // Used for sidebar display

        // 3. Dynamic Redirection (Optional)
        // You can use one dashboard, or redirect specific roles elsewhere
        $redirect = 'dashboard.php';

        echo json_encode([
            'success'  => true,
            'redirect' => $redirect,
            'role'     => $user['role'] // Optional: helps JS handle UI if needed
        ]);
        exit;
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid email or password'
        ]);
        exit;
    }
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error occurred.'
    ]);
    exit;
}