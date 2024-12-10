<?php
session_start();
require_once '../../app/models/post.php';
error_log("Session ID: " . session_id());
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $movieId = $input['movie_id'] ?? 0;
    $userId = $_SESSION['user']['id'] ?? 0; // Assuming logged-in user's ID is in the session
    error_log($_SESSION['user']['id']);
    $title = $input['title'] ?? '';
    $content = $input['content'] ?? '';
    $rating = $input['rating'] ?? 0;

    $postModel = new Post();
    $success = $postModel->addReview($movieId, $userId, $title, $content, $rating);

    header('Content-Type: application/json');
    echo json_encode(['success' => $success]);
}
?>
