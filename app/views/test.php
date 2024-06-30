<?php
// test_register.php
/*
require_once 'vendor/autoload.php';
use Symfony\Component\Yaml\Parser;
$configFile = __DIR__ . '/../../config/config.yaml';
$yaml = new Parser();
try {
    $data = $yaml->parse(file_get_contents($configFile));
    print_r($data); // Debug output to verify the parsed data
} catch (Exception $e) {
    echo 'Error parsing YAML file: ', $e->getMessage();
}*/

// Database configuration
$servername = "localhost";
$username = "root";
$password= "icandoit";
$dbname= "core";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";




// Example method to fetch a single row


public function __destruct() {
    // Close the MySQLi connection when the object is destroyed
    $this->conn->close();
    echo "Connection closed<br>";
}
}

?>
?>
