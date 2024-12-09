<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/movie/public/assets/css/styles.css">
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        <form action="/movie/app/utils/login_handler.php" method="POST">
            <label for="email">Enter your email address:</label>
            <input type="email" id="email" name="email" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
