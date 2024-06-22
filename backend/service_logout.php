<?php
session_start();

// Include database connection code
include "key_db_connection.php";

// Unset all session variables
$_SESSION = array();

// Get the session ID
$session_id = session_id();

// Destroy the session
session_destroy();

// Delete the session data from the database
if (!empty($session_id)) {
    $sql = "DELETE FROM sessions WHERE session_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $session_id);
    $stmt->execute();
    $stmt->close();
}

// Redirect to the login page
header("Location: ../index.html");
exit();
?>