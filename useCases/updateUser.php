<?php


require_once '../src/User.php';
require_once '../connection.php';

$user = User::loadUserbyId($conn, 1);

$user->setName('user2');
$user->saveToBD($conn);
var_dump($user->saveToBD($conn));
$user = User::loadUserbyId($conn, 1);
var_dump($user);
$conn->close();
$conn = null;