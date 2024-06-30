<?php
require_once 'database.php';


class User {
    private $db;
    private $stmt;
    private $table_name = "users";
    private $userModel;

    public function __construct() {
        $this->db = new Database();
        $this->userModel = new User();
    }

    // Register Method
    public function register($data) {
        require_once 'pw_validation.php';
        // Check if user_id already exists
        if ($this->userModel->getUserById($data['user_id'])) {
            die('User already exists.'); // Show error message
        }
        if (!PasswordValidator::validate($data['password'])) {
            return false; // Password validation failed
        }
        // Generate salt and hash password
        $salt = bin2hex(random_bytes(32));
        $hashed_password = password_hash($data['password'] . $salt, PASSWORD_BCRYPT);
    
        // SQL query and parameters
        $query = "INSERT INTO {$this->table_name} (user_id, password, password_salt) VALUES (:user_id, :password, :salt)";
        $params = [
            ':user_id' => $data['user_id'],
            ':password' => $hashed_password,
            ':salt' => $salt
        ];
    
        // Prepare statement, bind parameters, and execute query
        $this->stmt->executeQuery($query, $params);
        
        // Execute the query and return success/failure
        return $this->db->fetchSingle($this->stmt);
    }

    //  ログインMethod
    public function login($user_id, $password) {
        $query = "SELECT * FROM {$this->table_name} WHERE user_id = :user_id";
        $params = [
            ':user_id' => $user_id
        ];
        $this->stmt->executeQuery($query, $params);
        $row = $this->db->fetchSingle($this->stmt); // Fetch single row 
        if ($row && password_verify($password . $row->password_salt, $row->password)) {
            return $row;
        } else {
            return false;
        }
    }
    // Get User by ID Method
    public function getUserById($user_id) {
        $query = "SELECT * FROM {$this->table_name} WHERE user_id = :user_id";

        $params = [
            ':user_id' => $user_id
        ];
        $this->stmt->executeQuery($query, $params);
        return  $this->db->fetchSingle($this->stmt);; // Return single row or false if not found
    }
}
?>
