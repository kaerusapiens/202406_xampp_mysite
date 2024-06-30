<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form action="/register" method="POST" id="form">
        <input type="text" name="user_id" placeholder="User_id" required><br/>
        <input type="password" name="password" placeholder="Password" required><br/>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required><br/>
        <button type="submit">Register</button>
        <div id="registration-message"></div>
    </form>
</body>


</html>