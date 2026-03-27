<?php
require_once __DIR__ . '/../models/LoanModel.php';
require_once __DIR__ . '/../models/MembersModel.php';

class LoanController
{
    private $loanModel;
    private $membersModel;

    public function __construct($loanModel, $membersModel)
    {
        $this->loanModel = $loanModel;
        $this->membersModel = $membersModel;
    }

    public function storeLoan()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $member_id = $_POST['member_id'];
            $principal = floatval($_POST['principal']);
            $interest_rate = floatval($_POST['interest_rate']);
            $issued_date = $_POST['issued_date'];
            $status = 'active';

            // Calculate total amount
            $total_amount = $principal + ($principal * $interest_rate / 100);

            // Prepare data array
            $data = [
                'member_id' => $member_id,
                'principal' => $principal,
                'interest_rate' => $interest_rate,
                'total_amount' => $total_amount,
                'issued_date' => $issued_date,
                'status' => $status
            ];

            if ($this->loanModel->createLoan($data)) {
                header('Location: ../../public/dashboard.php?msg=loan_issue_success');
                exit();
            } else {
                die("Error recording loan.");
            }
        }
    }
}
