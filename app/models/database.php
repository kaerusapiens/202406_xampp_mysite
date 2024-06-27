<?php
require_once 'libs/yaml_parser.php'; 
class Database {
    private $host;
    private $user;
    private $pass;
    private $dbname;
    private $dbh;
    private $stmt;

    public function __construct() {

        $config =  YAMLParser::parse('config/config.yml');
    

        $this->host = $config['database']['host'];
        $this->user = $config['database']['user_id'];
        $this->pass = $config['database']['password'];
        $this->dbname = $config['database']['dbname'];


        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        
        //Mysql Connection成功可否
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }

    public function prepareStatement($sql) {
        $this->stmt = $this->dbh->prepare($sql);
    }

    //SQL parameters binding
    //--$param: sql query
    //--$value: sql query's placeholder.
    //--$type = set data type automatically
    public function bind($params = []) {
        foreach ($params as $param => $value) {
            // Determine PDO parameter type based on PHP type
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR; // Default type for strings
            }
    
            // Bind parameter with determined type
            $this->stmt->bindValue($param, $value, $type);
        }
        return $this; // Return $this for method chaining
    }
    
    //SQL execution
    public function execute() {
        return $this->stmt->execute();
    }
    //Get Query result
    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function single() {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }



}
?>