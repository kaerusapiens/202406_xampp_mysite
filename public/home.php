<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<body>
    <h2>Welcome</h2>
    <?php if (isset($_SESSION['username'])): ?>
        <p>Hello, <?php echo $_SESSION['username']; ?>!</p>
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