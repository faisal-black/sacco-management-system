<?php

// database credentials
$host = 'localhost';
$dbname = 'sacco_system';
$username = 'root';
$password = '';

// data source name (dsn) string
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

// pdo options
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die("connection failed: " . $e->getMessage());
}
