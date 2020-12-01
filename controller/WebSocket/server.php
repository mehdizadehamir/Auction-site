<?php
require 'vendor/autoload.php';

use Ratchet\Server\IoServer;
use ChatApp\Chat;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

include_once __DIR__."/../statics.php";

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    $__SOCKET_SERVER_PORT
);

$server->run();