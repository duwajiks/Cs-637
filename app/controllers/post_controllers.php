<?php
require_once __DIR__ . '/../models/post.php';
require_once __DIR__ . '/../models/movie.php';

class PostController {
    public function showAllPosts() {
        $postModel = new Post();
        $posts = $postModel->getAllPosts();

        $movieModel = new Movie();
        $movies = $movieModel->getAllMovies();

        require __DIR__ . '/../views/discussion.php';
    }
}
?>