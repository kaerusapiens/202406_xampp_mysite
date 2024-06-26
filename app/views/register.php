<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form action="/register" method="post" id="form">
        <input type="text" name="user_id" placeholder="User_id" required><br/>
        <input type="password" name="password" placeholder="Password" required><br/>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required><br/>
        <button type="submit">Register</button>
        <div id="registration-message"></div>
    </form>
</body>

<script>
    // EVENT "submit" Listen
    document.getElementById("form").addEventListener("submit", 
    function(event) {
        event.preventDefault();
        var formData = new FormData(this);
        var xhr = new XMLHttpRequest(); 
        xhr.open("POST", "backend/service_register.php", true);
        xhr.onload = function() {
            if (xhr.status == 200) {
                //HTML形のErrorメッセージを読めるように
                document.getElementById("registration-message").innerHTML = xhr.responseText;
                if (xhr.responseText.includes("Registration successful!")) {
                    setTimeout(function() {
                        window.location.href = '../index.html';}, 2000);
                }
            }
        };
        xhr.send(formData);
    });
</script>

</html>