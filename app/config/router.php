<?php

$router = $di->getRouter();

// Define your routes here

<<<<<<< HEAD
// Default route
$router->add('/', ['controller' => 'index', 'action' => 'index']);

// User routes
$router->add('/user/loginpage', ['controller' => 'user', 'action' => 'loginpage']);
$router->add('/user/login', ['controller' => 'user', 'action' => 'login']);
$router->add('/user/signuppage', ['controller' => 'user', 'action' => 'signuppage']);
$router->add('/user/signup', ['controller' => 'user', 'action' => 'signup']);
// $router->add('/user/profile', ['controller' => 'user', 'action' => 'profile']);
$router->add('/user/logout', ['controller' => 'user', 'action' => 'logout']);

$router->handle($_SERVER['REQUEST_URI']);
=======
$router->handle($_SERVER['REQUEST_URI']);
>>>>>>> 2ff15f707e76dcf1ba576d28e0fce4344322ba84
