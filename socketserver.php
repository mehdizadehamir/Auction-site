<?php
include_once "controller/WebSocket/WebSocket.php";

$WebSocket = new WebSocket('localhost',9898);
$WebSocket->start();
?>