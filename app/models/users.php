<?php
require_once 'database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
        //⇓ Wrong code. no need to add instace for User(running the code endlessly) 
        // $this->userModel = new User();
    }

    // Register Method
    public function register($data) {
        require_once 'pw_validation.php';
        
        // Check if user_id already exists
        $user = $this->getUserById($data['user_id']);
        if (!$user) {
            // User does not exist, you can insert the user or do something else
        } else {
            echo "User already exists!";
        }


        // Validate password
        $validationResult = PasswordValidator::validate($data['password']);
        if ($validationResult !== true) {
            return $validationResult; // Return error message
        }
        
        // Generate salt and hash password
        $salt = bin2hex(random_bytes(32));
        $hashed_password = password_hash($data['password'] . $salt, PASSWORD_BCRYPT);

        // SQL query and parameters
        $query = "INSERT INTO users (user_id, password, password_salt) VALUES (:user_id, :password, :salt)";
        $params = [
            ':user_id' => $data['user_id'],
            ':password' => $hashed_password,
            ':salt' => $salt
        ];

        // Execute the query
        $stmt = $this->db->executeQuery($query, $params);

        // Return success/failure based on row count
        return $stmt->rowCount() > 0;
    }

    // Login Method
    public function login($user_id, $password) {
        // SQL query and parameters
        $query = "SELECT * FROM users WHERE user_id = :user_id";
        $params = [
            ':user_id' => $user_id
        ];

        // Execute the query
        $stmt = $this->db->executeQuery($query, $params);
        
        // Fetch single row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify password
        if ($row && password_verify($password . $row->password_salt, $row->password)) {
            return $row; // Return user object
        } else {
            return false; // Login failed
        }
    }

    // Get User by ID Method
    public function getUserById($user_id) {
        try {
            // SQL query and parameters
            $query = "SELECT * FROM users WHERE user_id = :user_id";
            $params = [
                ':user_id' => $user_id
            ];
    
            // Execute the query
            $stmt = $this->db->executeQuery($query, $params);
    
            // Fetch single row
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Return user object or false if not found
            return $user ? $user : false;
    
        } catch (PDOException $e) {
            // Handle PDO exceptions (e.g., log error, return false, etc.)
            error_log('PDO Exception: ' . $e->getMessage());
            return false;
        }
    }
}
?>
