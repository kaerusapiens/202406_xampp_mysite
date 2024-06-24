<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello World!</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&display=swap">
    <link rel="stylesheet" href="app/views/styles/index.css">
</head>

<body>
    <h2>Hello World!</h2>
    <?php if (isset($_SESSION['user_id'])): ?>
        <p>Hello, <?php echo $_SESSION['user_id']; ?>!</p>
        <form action="/logout" method="post">
            <button type="submit">Logout</button>
        </form>
    <?php else: ?>
        <p>You are not logged in.</p>
        <a href="/login">Login</a>
        <a href="/register">Register</a>
    <?php endif; ?>
</body>
</html>