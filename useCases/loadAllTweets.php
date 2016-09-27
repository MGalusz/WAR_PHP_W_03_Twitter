<?php

require_once '../src/Tweet.php';
require_once '../src/User.php';
require_once '../connection.php';

$tweets = Tweet::loadAllTweets($connection);


var_dump($tweets);
$conn->close();
$conn = null;