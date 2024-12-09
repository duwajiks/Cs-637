<?php
require_once __DIR__ . '/../models/post.php';

class PostController {
    public function showAllPosts() {
        $postModel = new Post();
        $posts = $postModel->getAllPosts();

        // Include the view
        require __DIR__ . '/../views/discussion.php';
    }
}
?>