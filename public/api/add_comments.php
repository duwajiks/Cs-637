<?php
require_once '../../app/models/comment.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $movieId = $data['movie_id'] ?? 0;
    $userId = $data['user_id'] ?? 0; // Replace with the logged-in user's ID
    $comment = $data['comment'] ?? '';

    $commentModel = new Comment();
    $success = $commentModel->addComment($movieId, $userId, $comment);

    header('Content-Type: application/json');
    echo json_encode(['success' => $success]);
}
?>