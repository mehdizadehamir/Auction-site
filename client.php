<?php
include_once "controller/WebSocket/php-websocket-master/src/Client.php";

$client = new \Bloatless\WebSocket\Client;
$client->connect('localhost', 9768, '/demo', 'foo.lh');
$client->sendData([
    'action' => 'echo',
    'data' => 'Hello Wolrd!'
]);



?>

