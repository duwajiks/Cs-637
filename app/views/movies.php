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
        <div class="user-info">
            Logged in as: <?= htmlspecialchars($_SESSION['user']['username']) ?>
        </div>
        <section id="search" class="fade-in">
            <input type="text" id="search-bar" placeholder="Search for movies...">
            <button id="search-button">Search</button>
            <select id="genre-filter">
                <option value="">Pick a genre u like 😊</option>
                <?php
                foreach ($genres as $genre) {
                    echo "<option value='{$genre['id']}'>{$genre['genre']}</option>";
                }
                ?>
            </select>
        </section>
        <!-- Movie list handled by JavaScript -->
        <section id="movie-list" class="fade-in"></section>
        <div id="pagination" class="pagination-controls"></div>
        
        <div id="movie-modal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <div id="modal-details"></div>
                <hr>
                <div id="comment-section">
                    <h6>Comments</h6>
                    <div id="comments-list"></div> <!-- List of existing comments -->
                    <textarea id="new-comment" placeholder="Add your comment"></textarea>
                    <button id="submit-comment">Comment</button>
                </div>
            </div>
            
        </div>

        <script>
            // Passing movie data to scripts
            const movies = <?php echo json_encode($movies); ?>;
            const genres = <?php echo json_encode($genres); ?>;
        </script>
        <script type="module" src="/movie/public/assets/scripts/scripts.js"></script>
    </main>
    <footer>
        <p>&copy; 2024 MovieWorld</p>
    </footer>
</body>
</html>
