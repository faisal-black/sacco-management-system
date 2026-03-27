<?php
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../app/middleware/AuthMiddleware.php";

checkAuth($pdo, 'admin');

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute(["id" => $id]);
        header("Location: manage_user.php?msg=deleted");
        exit();
    } catch (PDOException $e) {
        die("Error deleting" . $e->getMessage());
    }
}
