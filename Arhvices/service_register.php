<?php
session_start();

// DB connection
include 'key_db_connection.php';
//　EMBED Custom CLASS
require_once 'class_login.php';

// Table name
$table = "users";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    //Username,password Validation
    Validator::validate($username, 5,10, 'username');
    Validator::validate($password, 5,10, 'password');

    // Userが存在しているか確認
    if (UserExistsChecker::check($conn, $table, $username)) {
        //既存ユーザー存在
        echo "User already exists!";
        exit; // Stop process
    } else {
        //新規ユーザー作成可能
            // PASSWORD暗号化
            $hashed_password = password_hash($password, PASSWORD_BCRYPT); // Hash the password
            $insert_sql = "INSERT INTO $table (username, password, password_hash) VALUES (?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("sss", $username, $password, $hashed_password); // Bind both plaintext and hashed passwords
            if ($insert_stmt->execute()) {
                echo "Registration successful!";
                $_SESSION['username'] = $username;
            } else {
                echo "Error: " . $insert_sql . "<br>" . $conn->error;
            }
            $insert_stmt->close();
        }

    $conn->close();
}
?>