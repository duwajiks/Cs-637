<?php
require_once  __DIR__ . '/../utils/db.php';

class Movie {
    public function getAllMovies() {
        $db = Database::connect();
        $query = "SELECT * FROM movies";

        try {
            $stmt = $db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
            return [];
        }
    }

    public function getMovieWithGenres($movieId) {
        $db = Database::connect();
        $query = "SELECT * FROM movie WHERE id = :movieId";

        try {
            $stmt = $db->prepare($query);
            $stmt->bindParam(':movieId', $movieId, PDO::PARAM_INT);
            $stmt->execute();
            $movie = $stmt->fetch();

            // Fetch genres for this movie
            if ($movie) {
                $genreModel = new Genre();
                $movie['genres'] = $genreModel->getGenresByMovieId($movieId);
            }

            return $movie;
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
            return null;
        }
    }

    public function getMoviesWithGenres() {
        $db = Database::connect();

        $query = "
            SELECT 
                m.id AS movie_id,
                m.series_title,
                m.released_year,
                m.poster_link,
                m.imdb_rating,
                m.overview,
                GROUP_CONCAT(g.id) AS genre_ids
            FROM movies m
            LEFT JOIN movies_genres mg ON m.id = mg.movie_id
            LEFT JOIN genres g ON mg.genre_id = g.id
            GROUP BY m.id
        ";

        try {
            $stmt = $db->prepare($query);
            $stmt->execute();
            $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Convert the comma-separated genre_ids to an array
            foreach ($movies as &$movie) {
                $movie['genres'] = $movie['genre_ids'] ? array_map('intval', explode(',', $movie['genre_ids'])) : [];
                unset($movie['genre_ids']); // Remove the raw genre_ids column
            }

            return $movies;
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
            return [];
        }
    }
}
?>