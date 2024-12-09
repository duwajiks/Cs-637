<?php
require_once __DIR__ . '/../models/movie.php';
require_once __DIR__ . '/../models/genre.php';
class MoviePresenter {
    public function showMovies() {
        $movieModel = new Movie();
        $movies = $movieModel->getAllMovies();
        
        $genreModel = new Genre();
        $genres = $genreModel->getAllGenres(); 
        
        $commentModel = new Comment();
        $comments = $commentModel->getCommentsByMovieId($movieId);

        // Pass data to the view
        require __DIR__ . '/../views/movies.php';
    }

    public function addComment($movieId, $userId, $comment) {
        $commentModel = new Comment();
        $commentModel->addComment($movieId, $userId, $comment);

        // Redirect back to movie details
        // header("Location: /movie.php?id=$movieId");
    }

    public function showMoviesWithGenres() {
        $movieModel = new Movie();
        $movies = $movieModel->getMoviesWithGenres(); // Fetch movies with genres

        $genreModel = new Genre();
        $genres = $genreModel->getAllGenres(); // Fetch all available genres

        // Pass both movies and genres to the view
        require __DIR__ . '/../views/movies.php';
    }
}
?>
