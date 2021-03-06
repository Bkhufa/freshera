<?php

$router = $di->getRouter();

// Define your routes here

// Default route
$router->add('/', ['controller' => 'index', 'action' => 'index']);

// User routes
$router->add('/user/loginpage', ['controller' => 'user', 'action' => 'loginpage']);
$router->add('/user/login', ['controller' => 'user', 'action' => 'login']);
$router->add('/user/signuppage', ['controller' => 'user', 'action' => 'signuppage']);
$router->add('/user/signup', ['controller' => 'user', 'action' => 'signup']);
// $router->add('/user/profile', ['controller' => 'user', 'action' => 'profile']);
$router->add('/user/logout', ['controller' => 'user', 'action' => 'logout']);
$router->add('/user/manageuser', ['controller' => 'user', 'action' => 'aturuser']);

$router->add('/item/manageitem', ['controller' => 'item', 'action' => 'aturitem']);

$router->handle($_SERVER['REQUEST_URI']);
