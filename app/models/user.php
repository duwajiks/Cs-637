<?php
require_once  __DIR__ . '/../utils/db.php';
class User{
    public function getUserByEmail($email) {
        $db = Database::connect();

        $query = "SELECT id, username, email FROM users WHERE email = :email";

        try {
            $stmt = $db->prepare($query);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    public function createUser($username, $email) {
        $db = Database::connect();

        $query = "INSERT INTO users (username, email) VALUES (:username, :email)";

        try {
            $stmt = $db->prepare($query);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>