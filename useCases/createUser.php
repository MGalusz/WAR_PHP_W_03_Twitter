<?php

require_once '../src/User.php';
require_once '../connection.php';

$user1 = new User();
$user1->setName('Lukasz');
$user1->setEmail('mail@gmail');
$user1->setPassword('password1');

var_dump($user1->saveToBD($conn));

$conn->close();
$conn = null;
