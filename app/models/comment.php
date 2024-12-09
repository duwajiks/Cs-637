<?php
require_once  __DIR__ . '/../utils/db.php';

class Comment {
    // Add a new comment
    public function addComment($movieId, $userId, $comment) {
        $db = Database::connect();

        $query = "INSERT INTO comments (movie_id, user_id, comment) VALUES (:movie_id, :user_id, :comment)";

        try {
            $stmt = $db->prepare($query);
            $stmt->bindParam(':movie_id', $movieId, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Get comments for a specific movie
    public function getCommentsByMovieId($movieId) {
        $db = Database::connect();

        $query = "
            SELECT c.comment, c.created_at, u.username 
            FROM comments c
            JOIN users u ON c.user_id = u.id
            WHERE c.movie_id = :movie_id
            ORDER BY c.created_at DESC
        ";

        try {
            $stmt = $db->prepare($query);
            $stmt->bindParam(':movie_id', $movieId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
}
