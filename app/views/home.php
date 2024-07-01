<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&display=swap">
</head>

<body>
    <!--SESSION EXIST-->
        <?php if (isset($_SESSION['session_id'])): ?>
            <p>Hello, 
                <?php echo $_SESSION['user_id']; ?>!</p>
                <form action="/logout" method="post">
                    <button type="submit">Logout</button>
                </form>
    <!--SESSION NOT EXIST-->
        <?php else: ?>
            <p>You are not logged in.</p>
        <?php endif; ?>
        <button onclick="location.href='/login'">Login</button><br/>
        <button onclick="location.href='/register'">Register</button>
</body>
</html>