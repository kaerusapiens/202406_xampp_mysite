<?php
require 'vendor/autoload.php';
use Symfony\Component\Yaml\Yaml;
set_time_limit(10);
class Database {
    private $host;
    private $user;
    private $pass;
    private $dbname;
    private $dbh;
    private $stmt;
    private $conn;

    public function __construct() {
        error_reporting(E_ALL); // Enable error reporting to see PHP errors
        ini_set('display_errors', 1); // Display errors on screen
        $configFile = __DIR__ . '/../../config/config.yaml';
        $config =  Yaml::parseFile($configFile);
        $this->host = $config['database']['host'];
        $this->user = $config['database']['user_id'];
        $this->pass = $config['database']['password'];
        $this->dbname = $config['database']['dbname'];


        try {
            $conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
            if ($conn->connect_error) {
                throw new Exception("Connection failed: " . $conn->connect_error);
            }
            echo "Connected successfully";
            $conn->close();
        } catch (Exception $e) {
            echo "Connection error: " . $e->getMessage();
        }
    }
    public function __destruct() {
        // Close the MySQLi connection when the object is destroyed
        $this->conn->close();
        echo "Connection closed<br>";
    }

    public function executeQuery($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            die('Prepare statement failed: ' . $this->conn->error);
        }
    
        // Bind parameters if any
        if (!empty($params)) {
            $types = '';
            $bindParams = [];
            foreach ($params as $param) {
                $types .= $param['type'];
                $bindParams[] = &$param['value'];
            }
    
            array_unshift($bindParams, $types);
            call_user_func_array([$stmt, 'bind_param'], $bindParams);
        }
    
        // Execute the statement
        if ($stmt->execute()) {
            return $stmt;
        } else {
            die('Execute statement failed: ' . $stmt->error);
        }
    }

    //SQL parameters binding
    //--$param: sql query
    //--$value: sql query's placeholder.
    //--$type = set data type automatically  return $this; // Return $this for method chaining
    
    //SQL execution
    public function fetchSingle($stmt) {
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    // Example method to fetch all rows
    public function fetchAll($stmt) {
        $result = $stmt->get_result();
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }



}
?>