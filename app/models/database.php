<?php
require 'vendor/autoload.php';
use Symfony\Component\Yaml\Yaml;

class Database {
    private $host;
    private $user;
    private $pass;
    private $dbname;
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

        $this->connect();
    }

    private function connect() {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";

        try {
            $this->conn = new PDO($dsn, $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }
    }


    public function executeQuery($sql, $params = []) {
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            die('Execute statement failed: ' . $e->getMessage());
        }
    }

    public function fetchSingle($stmt) {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAll($stmt) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
