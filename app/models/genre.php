<?php
require_once __DIR__ . '/../utils/db.php';

class Genre {
    public function getAllGenres() {
        $db = Database::connect();
        $query = "SELECT * FROM genres";

        try {
            $stmt = $db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(); 
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
            return [];
        }
    }

    public function getGenresByMovieId($movieId) {
        $db = Database::connect();
        $query = "
            SELECT g.id, g.genre
            FROM genres g
            INNER JOIN movie_genres mg ON g.id = mg.genre_id
            WHERE mg.movie_id = :movieId
        ";

        try {
            $stmt = $db->prepare($query);
            $stmt->bindParam(':movieId', $movieId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(); // Return genres associated with the movie
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
            return [];
        }
    }

    
}
?>
