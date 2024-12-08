<?php
session_start(); // Start the session to access $_SESSION['user']

require_once 'app/controllers/movie_controllers.php';
require_once 'app/controllers/genre_controllers.php';
require_once 'app/controllers/post_controllers.php';

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user'])) {
    header('Location: /movie/public/login.php');
    exit;
} else {
    error_log('User logged in: ' . print_r($_SESSION['user'], true));
}

$action = $_GET['action'] ?? 'movies'; // Default to movies action

if ($action === 'movies') {
    $movie_presenter = new MoviePresenter();
    $genre_presenter = new GenrePresenter();
    $movie_presenter->showMoviesWithGenres();
    $genre_presenter->showGenres();
} elseif ($action === 'discussion') {
    $postController = new PostController();
    $postController->showAllPosts();
 } else {
    echo "404 Page Not Found";
}
?>
