<?php
// add_admin.php
require_once __DIR__ . '../../app/middleware/authmiddleware.php';

// Only admins can access
checkAuth($pdo, 'admin');

require_once __DIR__ . '../../config/database.php';

$message = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // 1️⃣ Basic validation
    if (!$full_name || !$username || !$email || !$password) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters.";
    } else {
        // 2️⃣ Check if email or username already exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email OR username = :username");
        $stmt->execute(['email' => $email, 'username' => $username]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $error = "Email or username already exists.";
        } else {
            // 3️⃣ Insert new admin
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (full_name, username, email, password, role, created_at) VALUES (:full_name, :username, :email, :password, 'admin', NOW())");
            $stmt->execute([
                'full_name' => $full_name,
                'username' => $username,
                'email' => $email,
                'password' => $passwordHash
            ]);

            $message = "New admin created successfully!";
            // Clear form fields
            $full_name = $username = $email = $password = '';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add New Admin</title>
    <link rel="stylesheet" href="assets/css/add_admin.css">

</head>

<body>
    <header>
        <h1>Add New Admin</h1>
        <a href="dashboard.php">Back to Dashboard</a>
    </header>

    <main>
        <?php if ($message): ?>
            <div class="message success"><?= htmlspecialchars($message) ?></div>
        <?php elseif ($error): ?>
            <div class="message error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" novalidate>
            <label>Full Name</label>
            <input type="text" name="full_name" value="<?= htmlspecialchars($full_name ?? '') ?>" required>

            <label>Username</label>
            <input type="text" name="username" value="<?= htmlspecialchars($username ?? '') ?>" required>

            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required>

            <label>Password</label>
            <input type="password" name="password" value="<?= htmlspecialchars($password ?? '') ?>" required>

            <button type="submit">Create Admin</button>
        </form>
    </main>
</body>

</html>