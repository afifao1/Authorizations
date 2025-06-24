<?php
namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
require __DIR__ . '/Message.php';

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $messageModel;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->messageModel = new Message();
        echo "WebSocket server started\n";
    }

    public function onOpen(ConnectionInterface $conn) {
        $queryParams = [];
        parse_str($conn->httpRequest->getUri()->getQuery(), $queryParams);
        $userId = $queryParams['user_id'] ?? null;
        $username = $queryParams['username'] ?? 'Guest';

        if (!$userId) {
            echo "Connection rejected: user_id not provided.\n";
            $conn->close();
            return;
        }

        $conn->userData = (object) [
            'userId' => $userId,
            'username' => $username
        ];

        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId}) - User: {$username}\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $this->messageModel->saveMessage($from->userData->userId, $msg);

        $data = [
            'username' => $from->userData->username,
            'message' => htmlspecialchars($msg)
        ];
        $jsonData = json_encode($data);

        foreach ($this->clients as $client) {
            $client->send($jsonData);
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} (User: {$conn->userData->username}) has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Error: {$e->getMessage()}\n";
        $conn->close();
    }
}
