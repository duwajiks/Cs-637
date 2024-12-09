<?php
require_once '../../app/models/comment.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $movieId = $_GET['movie_id'] ?? 0;

    $commentModel = new Comment();
    $comments = $commentModel->getCommentsByMovieId($movieId);

    header('Content-Type: application/json');
    echo json_encode($comments);
}
?>
