<?php
require_once __DIR__ . '/../models/User.php';

session_start(); // Ensure the session starts

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email address']);
        exit;
    }

    // Extract username from email
    $username = explode('@', $email)[0];

    // Check if the user already exists; otherwise, create a new user
    $userModel = new User();
    $user = $userModel->getUserByEmail($email);

    if (!$user) {
        $userModel->createUser($username, $email);
    }

    // Set session to indicate the user is logged in
    $_SESSION['user'] = ['username' => $username, 'email' => $email];

    // Redirect to the movie list
    $basePath = '/movie'; // Change 'movie' to your project folder name
    header("Location: {$basePath}/index.php?action=movies");

    session_start();
    error_log('Setting session for user: ' . $email);
    $_SESSION['user'] = ['username' => $username, 'email' => $email];

    exit;
}
?>