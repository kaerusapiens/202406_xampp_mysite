<?php
require_once 'core/Database.php';

class User {
    private $db;
    private $table = "users";
    public function __construct() {
        $this->db = new Database();
    }

    public function register($data) {
        $salt = bin2hex(random_bytes(32));
        $hashed_password = password_hash($data['password'] . $salt, PASSWORD_DEFAULT);

        $this->db->query('INSERT INTO users (username, password, password_salt) VALUES (:username, :password, :salt)');
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', $hashed_password);
        $this->db->bind(':salt', $salt);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function login($username, $password) {
        $this->db->query('SELECT * FROM users WHERE username = :username');
        $this->db->bind(':username', $username);
        $row = $this->db->single();

        if ($row && password_verify($password . $row->password_salt, $row->password)) {
            return $row;
        } else {
            return false;
        }
    }
}
?>

?>
