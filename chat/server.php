<?php
require dirname(__DIR__) . '/vendor/autoload.php';

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use MyApp\Chat;

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    8080
);

echo "WebSocket server started on port 8080\n";
$server->run();
