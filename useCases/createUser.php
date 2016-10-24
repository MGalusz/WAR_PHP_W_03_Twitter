<?php

require_once '../src/User.php';
require_once '../connection.php';

//$user1 = new User();
//$user1->setName('Lukasz');
//$user1->setEmail('mail@gmail');
//$user1->setPassword('password1');
//
//var_dump($user1->saveToBD($conn));
$user2 = new User();
$user2->setName('Michal');
$use2->setEmail('michal@gmail');
$user2->setPassword('password2');

var_dump($user2->saveToBD($conn));
$user3 = new User();
$user3->setName('Lukasz');
$user3->setEmail('mail@gmail');
$user3->setPassword('password1');

var_dump($user3->saveToBD($conn));

$conn->close();
$conn = null;
