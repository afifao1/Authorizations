<?php
require 'core.php';
require 'db.php';
require 'chat/Message.php';

$user_id = $_COOKIE['user_id'];

$user_result = $db->conn->query("SELECT username FROM users WHERE id = " . (int)$user_id);
if ($user_result->num_rows > 0) {
    $user = $user_result->fetch_assoc();
    $username = $user['username'];
} else {
    header("Location: login.php");
    exit();
}

$message_model = new \MyApp\Message();
$messages = $message_model->getMessages();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Live Chat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <div class="logo">Live Chat - Welcome, <?= htmlspecialchars($username) ?>!</div>
        <div class="menu">
            <a href="index.php">Home</a>
            <a href="exit.php">Logout</a>
        </div>
    </div>
    <div class="container">
        <div id="chat-box" style="border:1px solid #ccc; height:400px; overflow-y:auto; padding:10px; margin-bottom:10px;">
            <?php foreach ($messages as $message): ?>
                <p><strong><?= htmlspecialchars($message['username']) ?>:</strong> <?= htmlspecialchars($message['message']) ?></p>
            <?php endforeach; ?>
        </div>
        <input type="text" id="message" placeholder="Type message..." style="width:80%;">
        <button onclick="sendMessage()">Send</button>
    </div>

<script>
    const userId = <?= json_encode($user_id) ?>;
    const username = <?= json_encode($username) ?>;
    const chatBox = document.getElementById('chat-box');

    const conn = new WebSocket(`ws://${window.location.hostname}:8080?user_id=${userId}&username=${username}`);

    conn.onopen = function() {
        console.log('WebSocket connected');
    };

    conn.onerror = function(error) {
        console.log('WebSocket error: ', error);
        chatBox.innerHTML += '<p style="color:red;">Connection error. Please try refreshing the page.</p>';
    };

    conn.onclose = function() {
        console.log('WebSocket disconnected');
        chatBox.innerHTML += '<p style="color:red;">Disconnected from chat. Please try refreshing the page.</p>';
    };

    conn.onmessage = function(e) {
        const data = JSON.parse(e.data);
        chatBox.innerHTML += `<p><strong>${data.username}:</strong> ${data.message}</p>`;
        chatBox.scrollTop = chatBox.scrollHeight;
    };

    function sendMessage() {
        const msgInput = document.getElementById('message');
        const msg = msgInput.value;
        if (msg.trim() !== '') {
            conn.send(msg);
            msgInput.value = '';
        }
    }

    document.getElementById('message').addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });
</script>

</body>
</html>

