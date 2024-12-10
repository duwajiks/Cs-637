<?php
// Database connection
$host = "localhost";
$user = "root";
$password = "";
$database = "movie";

$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch total gross by genre
$query = "
    SELECT g.genre, SUM(m.gross) AS total_gross
    FROM movies_genres mg
    JOIN genres g ON mg.genre_id = g.id
    JOIN movies m ON mg.movie_id = m.id
    GROUP BY g.genre
    ORDER BY total_gross DESC
";
$result = $conn->query($query);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$conn->close();

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
