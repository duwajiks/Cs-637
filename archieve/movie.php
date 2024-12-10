<?php
include 'includes/db.php';
if (isset($_GET['id'])) {
    $movie_id = intval($_GET['id']);
    $movie = $db->query("SELECT * FROM movies WHERE id = $movie_id")->fetch();
    $comments = $db->query("SELECT * FROM comments WHERE movie_id = $movie_id ORDER BY created_at DESC");
} else {
    die("Movie not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $movie['title']; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1><?php echo $movie['title']; ?></h1>
    </header>
    <main>
        <p><?php echo $movie['description']; ?></p>
        <h2>Comments</h2>
        <form action="post_comment.php" method="POST">
            <input type="hidden" name="movie_id" value="<?php echo $movie_id; ?>">
            <input type="text" name="username" placeholder="Your Name" required>
            <textarea name="content" placeholder="Your Comment" required></textarea>
            <button type="submit">Post Comment</button>
        </form>
        <ul>
            <?php
            foreach ($comments as $comment) {
                echo "<li><strong>{$comment['username']}</strong>: {$comment['content']} <em>on {$comment['created_at']}</em></li>";
            }
            ?>
        </ul>
    </main>
</body>
</html>
