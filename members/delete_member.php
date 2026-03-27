<?php
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../app/middleware/AuthMiddleware.php";

checkAuth($pdo, 'admin');

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    try {
        // Start transaction to ensure both deletes succeed
        $pdo->beginTransaction();

        // 1. Delete savings linked to this member first
        // Note: Check if your column is named 'member_id' or 'user_id'
        $stmt1 = $pdo->prepare("DELETE FROM savings WHERE member_id = :id");
        $stmt1->execute(["id" => $id]);

        // 2. Delete the member
        $stmt2 = $pdo->prepare("DELETE FROM members WHERE id = :id");
        $stmt2->execute(["id" => $id]);

        $pdo->commit();

        header("Location: managemember.php?msg=deleted");
        exit();
    } catch (PDOException $e) {
        // If anything fails, undo the changes
        $pdo->rollBack();
        die("Error deleting: " . $e->getMessage());
    }
}
