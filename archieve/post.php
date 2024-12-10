<?php
include 'includes/db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $movie_id = intval($_POST['movie_id']);
    $username = htmlspecialchars($_POST['username']);
    $content = htmlspecialchars($_POST['content']);
    $stmt = $db->prepare("INSERT INTO comments (movie_id, username, content, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$movie_id, $username, $content]);
    header("Location: movie.php?id=$movie_id");
    exit();
}
?>
