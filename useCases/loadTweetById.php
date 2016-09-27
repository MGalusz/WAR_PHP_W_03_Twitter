<?php

require_once '../src/Tweet.php';
require_once '../src/User.php';
require_once '../connection.php';

$tweets = Tweet:: loadTweetById($connection,1);


var_dump($tweets);
$conn->close();
$conn = null;
