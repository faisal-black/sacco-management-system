<?php
//db connection....
require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . '/../middleware/AuthMiddleware.php';

checkAuth($pdo, 'admin');
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === 'POST') {

    $errors = [];

    //capture and sanitize input....
    $data = [
        'member_no' => trim($_POST['member_no'] ?? ''),
        'id_number' => trim($_POST['id_number'] ?? ''),
        'full_name' => trim($_POST['full_name'] ?? ''),
        'email' => filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL),
        'dob' => $_POST['dob'] ?? null,
        'gender' => $_POST['gender'] ?? '',
        'phone' => trim($_POST['phone'] ?? ''),
        'address'           => trim($_POST['address'] ?? ''),
        'joined_date'       => $_POST['joined_date'] ?? date('Y-m-d'),
        'status'            => $_POST['status'] ?? 'active',
        'next_of_kin_name'  => trim($_POST['next_of_kin_name'] ?? ''),
        'next_of_kin_phone' => trim($_POST['next_of_kin_phone'] ?? '')
    ];

    //validation 
    if (empty($data['member_no'])) {
        $errors[] = 'member number is required';
    }
    if (empty($data['full_name'])) {
        $errors[] = 'Full name is required';
    }
    if (empty($data['next_of_kin_name'])) {
        $errors[] = 'Next of kin Name is required';
    }

    if (!empty($errors)) {
        echo json_encode(['success' => false, 'errors' => $errors]);
        exit();
    }

    //now lets insert member data in the database....
    try {
        $query = "INSERT INTO members (member_no, id_number, full_name, email, dob, gender, phone, address, joined_date, status, next_of_kin_name, next_of_kin_phone) 
                VALUES (:member_no, :id_number, :full_name, :email, :dob, :gender, :phone, :address, :joined_date, :status, :next_of_kin_name, :next_of_kin_phone)";

        $stmt = $pdo->prepare($query);
        $stmt->execute($data);
        echo json_encode(['success' => true, 'message' => 'Member registered successfully!']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'errors' => ['Database error: ' . $e->getMessage()]]);
    }
}
