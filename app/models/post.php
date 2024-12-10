<?php
require_once  __DIR__ . '/../utils/db.php';

class Post {
    public function getAllPosts() {
        $db = Database::connect();
    
        $query = "
            SELECT r.title, r.content, r.created_at, u.username, m.series_title 
            FROM reviews r
            JOIN users u ON r.user_id = u.id
            JOIN movies m ON r.movie_id = m.id
            ORDER BY r.created_at DESC
        ";
    
        try {
            $stmt = $db->prepare($query);
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
    
    public function getReviewsByMovieId($movieId) {
        $db = Database::connect();
    
        $query = "
            SELECT r.title, r.content, r.rating, r.created_at, u.username
            FROM reviews r
            JOIN users u ON r.user_id = u.id
            WHERE r.movie_id = :movie_id
            ORDER BY r.created_at DESC
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
    public function addReview($movieId, $userId, $title, $content, $rating) {
        $db = Database::connect();
        
        $query = "
            INSERT INTO reviews (movie_id, user_id, title, content, rating)
            VALUES (:movie_id, :user_id, :title, :content, :rating)
        ";
    
        try {
            $stmt = $db->prepare($query);
            $stmt->bindParam(':movie_id', $movieId, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':content', $content, PDO::PARAM_STR);
            $stmt->bindParam(':rating', $rating, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Error adding review: " . $e->getMessage());
            return false;
        }
    }
    
}