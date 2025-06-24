<?php
namespace MyApp;

class Message
{
    protected $db;

    public function __construct()
    {
        require_once dirname(__DIR__) . '/db.php';
        $this->db = new \Database();
    }

    public function saveMessage($userId, $message)
    {
        $stmt = $this->db->conn->prepare("INSERT INTO messages (user_id, message) VALUES (?, ?)");
        if ($stmt === false) {
            error_log("Failed to prepare statement: " . $this->db->conn->error);
            return false;
        }
        $stmt->bind_param("is", $userId, $message);
        $success = $stmt->execute();
        if ($success === false) {
            error_log("Failed to execute statement: " . $stmt->error);
        }
        $stmt->close();
        return $success;
    }

    public function getMessages()
    {
        $sql = "SELECT u.username, m.message, m.created_at 
                FROM messages m 
                JOIN users u ON m.user_id = u.id 
                ORDER BY m.created_at ASC LIMIT 100";
        $result = $this->db->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
} 