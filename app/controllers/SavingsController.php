<?php

/**
 * SavingsController
 * Processes member deposits and withdrawals
 */
class SavingsController
{
    private $savingsModel;
    private $membersModel;

    public function __construct($savingsModel, $membersModel)
    {
        $this->savingsModel = $savingsModel;
        $this->membersModel = $membersModel;
    }

    /**
     * Display the Deposit Form
     */
    public function create()
    {
        $members = $this->membersModel->getActiveMember();
        require_once __DIR__ . "/../../public/savings/deposit.php";
    }

    /**
     * Display the Withdrawal Form
     */
    public function withdraw()
    {
        $members = $this->membersModel->getActiveMember();
        require_once __DIR__ . "/../../public/savings/withdrawal.php";
    }

    /**
     * Process Deposit (store_deposit.php calls this via $controller->store())
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'member_id'        => $_POST['member_id'],
                'transaction_type' => 'deposit', // Hardcoded for this method
                'amount'           => $_POST['amount'],
                'saved_at'         => $_POST['saved_at'],
                'recorded_by'      => $_SESSION['user_id']
            ];

            if ($this->savingsModel->addRecord($data)) {
                header('Location: ../../public/dashboard.php?msg=deposit_success');
                exit();
            } else {
                die("Error recording deposit.");
            }
        }
    }

    /**
     * Process Withdrawal (store_withdrawal.php calls this)
     */
    public function storeWithdrawal()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $member_id = $_POST['member_id'];
            $amount    = $_POST['amount'];
            $saved_at  = $_POST['saved_at'];
            $recorded_by = $_SESSION['user_id'];

            // 1. BUSINESS LOGIC: Check if member has enough money
            $current_balance = $this->savingsModel->getMemberBalance($member_id);

            if ($amount > $current_balance) {
                // Redirect back with an error flag
                header("Location: ../../public/savings/withdrawal.php?error=insufficient_funds&balance=" . $current_balance);
                exit();
            }

            // 2. PREPARE DATA
            $data = [
                'member_id'        => $member_id,
                'transaction_type' => 'withdrawal',
                'amount'           => $amount,
                'saved_at'         => $saved_at,
                'recorded_by'      => $recorded_by
            ];

            // 3. SAVE VIA MODEL
            if ($this->savingsModel->addRecord($data)) {
                header('Location: ../../public/dashboard.php?msg=withdrawal_success');
                exit();
            } else {
                die("Error recording withdrawal.");
            }
        }
    }
}
