<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../config/database.php';
require_once '../../app/models/MembersModel.php';
require_once '../../app/models/SavingsModel.php';
require_once '../../app/controllers/SavingsController.php';

$mModel = new MembersModel($pdo);
$sModel = new SavingsModel($pdo);

$controller = new SavingsController($sModel, $mModel);

// We call the withdrawal specific method
$controller->storeWithdrawal();
