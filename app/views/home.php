<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&display=swap">
</head>

<br>
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
        <h2>Login</h2>
    <form action="/login" method="POST">
        <input type="text" name="user_id" placeholder="User_id" required><br/>
        <input type="password" name="password" placeholder="Password" required><br/>
        <button type="submit">Login</button>
    </form>
        </br>
    <h2>Register</h2>
    <form action="/register" method="POST" id="form">
        <input type="text" name="user_id" placeholder="User_id" required><br/>
        <input type="password" name="password" id="password" placeholder="Password" required><br/>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required><br/>
        <button type="submit">Register</button>
    </form>

    <?php if (!empty($message)): ?>
        <div id="form">
            <?php echo htmlspecialchars($message); ?>
        </div>
<?php endif; ?>
</body>
</html>