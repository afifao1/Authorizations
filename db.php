<?php
class Database {
    private $host = "127.0.0.1";
    private $user = "root";
    private $pass = "root1223";
    private $dbname = "auth_system";
    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);

        if ($this->conn->connect_error) {
            die("Database connection failed: " . $this->conn->connect_error);
        }
    }
}

$db = new Database();
?>
