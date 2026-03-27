<?php
// app/controllers/AddUserController.php

require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../middleware/AuthMiddleware.php";

checkAuth($pdo, 'admin');

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $full_name = trim($_POST['full_name'] ?? '');
    $username  = trim($_POST['username'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $password  = trim($_POST['password'] ?? '');

    if (!$full_name || !$username || !$email || !$password) {
        $errors[] = "All fields are required.";
    }

    // Check if username/email exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username OR email = :email LIMIT 1");
    $stmt->execute(['username' => $username, 'email' => $email]);

    if ($stmt->fetch()) {
        $errors[] = "Username or email already exists.";
    }

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $insert = $pdo->prepare("
            INSERT INTO users (full_name, username, email, password, role)
            VALUES (:full_name, :username, :email, :password, 'user')
        ");
        $insert->execute([
            'full_name' => $full_name,
            'username'  => $username,
            'email'     => $email,
            'password'  => $hashed_password
        ]);

        // Redirect back to addUser.php with success
        header("Location: ../../public/addUser.php?success=1");
        exit;
    } else {
        // Redirect back with error messages
        $error_str = implode('|', $errors);
        header("Location: ../../public/addUser.php?error={$error_str}");
        exit;
    }
}
