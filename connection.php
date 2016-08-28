<?php


$serverName = 'localhost';
$userName = 'root';
$password = "coderslab";
$database = "WAR_PHP_W_03_Twitter";

$conn =  new mysqli($serverName, $userName, $password, $database);

if($conn->connect_error){
    die("conect error: ".$conn->connect_error);
}
$conn->set_charset('utf8');


