<?php

require_once '../src/Tweet.php';
require_once '../src/User.php';
require_once '../connection.php';


$twwet1 = new Tweet();
$twwet1->setText("text1");
$twwet1->setUserId(1);
$twwet1->getCreationDate('2016-07-07');
var_dump($twwet1->savcToBD($conn));


$conn->close();
$conn = null;
