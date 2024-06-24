<?php
require_once '../core/database.php';

class User {
    private $db;
    private $table_name = "users";

    public function __construct() {
        $this->db = new Database();
    }
    //  会員登録Method
    public function register($data) {
        $salt = bin2hex(random_bytes(32));
        $hashed_password = password_hash($data['password'] . $salt, PASSWORD_BCRYPT);
        $query = "INSERT INTO {$this->table_name} (user_id, password, password_salt) VALUES (:user_id, :password, :salt)";
        $this->db->query($query);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':password', $hashed_password);
        $this->db->bind(':salt', $salt);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    //  ログインMethod
    public function login($user_id, $password) {
        $query = "SELECT * FROM {$this->table_name} WHERE user_id = :user_id";
        $this->db->query($query);
        $this->db->bind(':user_id', $user_id);
        $row = $this->db->single(); // Fetch single row instead of using resultSet()
        if ($row && password_verify($password . $row->password_salt, $row->password)) {
            return $row;
        } else {
            return false;
        }
    }
}
?>