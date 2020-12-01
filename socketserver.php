<?php
include_once "controller/WebSocket/WebSocket.php";

$WebSocket = new WebSocket('localhost',9199);
$WebSocket->start();
?>