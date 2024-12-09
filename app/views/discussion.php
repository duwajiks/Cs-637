<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Site</title>
    <link rel="stylesheet" href="/movie/public/assets/css/style.css">
</head>
<body>
    <header>
        <h1>Movie Explorer and Ratings Hub</h1>
        <nav>
            <ul>
            <li><a href="/movie/index.php?action=movies">Home</a></li>
            <li><a href="/movie/index.php?action=discussion">Discussion</a></li>
            <li> <a href="/movie/public/logout.php">Log Out</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div id="posts-list">
            <?php foreach ($posts as $post): ?>
                <div class="post-item">
                    <h2><?= htmlspecialchars($post['title']) ?></h2>
                    <p><strong>By:</strong> <?= htmlspecialchars($post['username']) ?></p>
                    <p><?= htmlspecialchars($post['content']) ?></p>
                    <p><em>Posted on: <?= htmlspecialchars($post['created_at']) ?></em></p>
                </div>
            <?php endforeach; ?>
        </div>
        </main>
    <footer>
        <p>&copy; 2024 MovieWorld</p>
    </footer>
</body>
</html>

