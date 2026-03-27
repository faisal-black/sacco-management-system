<?php
class LoanModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function createLoan($data)
    {
        $sql = "INSERT INTO loans (member_id, principal, interest_rate, total_amount, issued_date, status) 
                VALUES (:member_id, :principal, :interest_rate, :total_amount, :issued_date, :status)";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':member_id'     => $data['member_id'],
            ':principal'     => $data['principal'],
            ':interest_rate' => $data['interest_rate'],
            ':total_amount'  => $data['total_amount'],
            ':issued_date'   => $data['issued_date'],
            ':status'        => $data['status']
        ]);
    }
}
