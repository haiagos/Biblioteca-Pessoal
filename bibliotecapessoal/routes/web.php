<?php

use src\Controllers\AuthController;

$router->get('/register', [AuthController::class, 'showRegistrationForm']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/post-registration', [AuthController::class, 'postRegistration']);