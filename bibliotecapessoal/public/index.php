<?php
require_once '../src/Router.php';
require_once '../src/Database.php';
require_once '../src/Helpers.php';

session_start();

$router = new Router();
$router->handleRequest(); // Assuming this method processes the incoming request and routes it accordingly
?>