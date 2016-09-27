<?php

require_once '../src/User.php';
require_once '../connection.php';

$users = User::loadAllUser($conn);
var_dump($users);

$conn->close();
$conn = null;
