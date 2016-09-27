<?php

session_start();
if(isset($_SERVER['userId'])){
    unset($_SESSION['userdId']);
    
}header('Location: login.php');

