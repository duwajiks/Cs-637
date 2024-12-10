<?php
require_once __DIR__ . '/../models/genre.php';

class GenrePresenter {
    public function showGenres() {
        $genreModel = new Genre();
        $genres = $genreModel->getAllGenres();

        // require '../app/views/movie.php';
    }
}
?>