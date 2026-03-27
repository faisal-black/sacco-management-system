<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/middleware/AuthMiddleware.php';
require_once __DIR__ . '/../../app/models/LoanModel.php';

// Only Admin or Treasurer
checkAuth($pdo, ['admin', 'treasurer']);

$loanModel = new LoanModel($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Basic validation
    $member_id = $_POST['member_id'] ?? null;
    $principal = floatval($_POST['principal'] ?? 0);
    $interest_rate = floatval($_POST['interest_rate'] ?? 0);
    $issued_date = $_POST['issued_date'] ?? date('Y-m-d');

    if (!$member_id || $principal <= 0 || $interest_rate < 0) {
        die('Invalid input.');
    }

    // Calculate total loan
    $total_amount = $principal + ($principal * $interest_rate / 100);

    // Prepare data
    $data = [
        'member_id'     => $member_id,
        'principal'     => $principal,
        'interest_rate' => $interest_rate,
        'total_amount'  => $total_amount,
        'issued_date'   => $issued_date,
        'status'        => 'active'
    ];

    // Store in DB
    if ($loanModel->createLoan($data)) {
        header('Location: ../dashboard.php?msg=loanissue_success');
        exit();
    } else {
        die('Error issuing loan.');
    }
}
