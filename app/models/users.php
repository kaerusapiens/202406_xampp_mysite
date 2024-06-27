<?php
require_once 'database.php';

class User {
    private $db;
    private $table_name = "users";

    public function __construct() {
        $this->db = new Database();
    }

    // Password Validator Method
    private function validatePassword($password) {
        // Check if password length is between 1 to 10 characters
        if (strlen($password) < 1 || strlen($password) > 10) {
            return false;
        }
        
        // Check if password contains only allowed characters (alphanumeric + !*#$%)
        if (!preg_match('/^[a-zA-Z0-9!*#$%]+$/', $password)) {
            return false;
        }

        return true;
    }

    // Register Method
    public function register($data) {
        // Validate password before proceeding
        if (!$this->validatePassword($data['password'])) {
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
        $this->db->prepareStatement($query);
        $this->db->bind($params);
        
        // Execute the query and return success/failure
        return $this->db->execute();
    }

    //  ログインMethod
    public function login($user_id, $password) {
        $query = "SELECT * FROM {$this->table_name} WHERE user_id = :user_id";
        $this->db->prepareStatement($query);
        $params = [
            ':user_id' => $user_id
        ];
        $this->db->bind($params);
        $row = $this->db->single(); // Fetch single row 
        if ($row && password_verify($password . $row->password_salt, $row->password)) {
            return $row;
        } else {
            return false;
        }
    }
}
?>
