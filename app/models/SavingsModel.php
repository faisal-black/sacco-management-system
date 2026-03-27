<?php
class SavingsModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * FIX: This is the missing method causing your error.
     * It calculates the net balance: Total Deposits - Total Withdrawals
     */
    public function getMemberBalance($member_id)
    {
        $sql = "SELECT SUM(CASE 
                    WHEN transaction_type = 'deposit' THEN amount 
                    WHEN transaction_type = 'withdrawal' THEN -amount 
                    ELSE 0 
                END) as balance 
                FROM savings 
                WHERE member_id = :member_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':member_id' => $member_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['balance'] ?? 0;
    }

    /**
     * Updated to include the transaction_type column
     */
    public function addRecord($data)
    {
        $sql = "INSERT INTO savings (member_id, transaction_type, amount, saved_at, recorded_by) 
                VALUES (:member_id, :transaction_type, :amount, :saved_at, :recorded_by)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':member_id'        => $data['member_id'],
            ':transaction_type' => $data['transaction_type'],
            ':amount'           => $data['amount'],
            ':saved_at'         => $data['saved_at'],
            ':recorded_by'      => $data['recorded_by']
        ]);
    }
}
