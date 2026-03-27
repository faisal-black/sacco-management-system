<?php
require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../middleware/AuthMiddleware.php";

class EditMemberController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Load member
    public function getMember(int $id): array|false
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM members WHERE id = ?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update member
    public function update(int $id, array $data): bool
    {
        try {
            $sql = "UPDATE members SET 
                full_name = ?, 
                email = ?, 
                dob = ?, 
                gender = ?, 
                phone = ?, 
                address = ?, 
                status = ?, 
                next_of_kin_name = ?, 
                next_of_kin_phone = ?
                WHERE id = ?";

            $stmt = $this->pdo->prepare($sql);

            return $stmt->execute([
                $data['full_name'],
                $data['email'],
                $data['dob'],
                $data['gender'],
                $data['phone'],
                $data['address'],
                $data['status'],
                $data['next_of_kin_name'],
                $data['next_of_kin_phone'],
                $id
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
