<?php
session_start();

// DB connection
include 'key_db_connection.php';

// EMBED Custom CLASS
require_once 'class_login.php';

// Table name
$table = "users";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate username and password
    Validator::validate($username, 5, 50, 'username');
    Validator::validate($password, 5, 50, 'password');

    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT password_hash FROM $table WHERE username = ?");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Redirect after 2 seconds
            $_SESSION['username'] = $username;
            echo "Login successful";
        } else {
            // Incorrect password
            echo "The Username or Password is Incorrect.";
        }
    } else {
        // Username not found
        echo "The Username or Password is Incorrect.";
    }

    $stmt->close();
} else {
    echo "Invalid request method.";
}

$conn->close();
?>