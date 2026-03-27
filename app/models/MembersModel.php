<?php
class MembersModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getactiveMember()
    {
        $sql = "SELECT id, full_name FROM members WHERE status = 'active'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        // Returns an array of ALL active members
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
