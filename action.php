<?php
require_once 'src/Tweet.php';
require_once 'src/User.php';
require_once 'connection.php';

session_start();
if(!isset($_SESSION['userId'])){
    header('Location:login.php');
}

$cuentyUser = $_SESSION['userId'];

echo ' <form action="action.php" method = "POST">
    <input type = "submit" value = "Dodaj Tweet">
';

echo '
    <form action="#" method = "POST">
    <input type="hidden" name="forms" value="adding_tweet">
    <input type="text" name="tweet_text">
    <input type="submit" value="Wyslij tweeta">
    </form>
    <form action="logout.php">
    <input type="submit" value="Wyloguj">
    </form>
    <br>
';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['forms'] == 'adding_tweet') {
        if ($_POST['tweet_text'] != null) {
            $tweet = new Tweet();
            $tweet ->setUserId($cuentyUser);
            $tweet->setText(date('Y-m-d'));
            $tweet->setText($_POST['tweet_text']);
            $tweet->savcToBD($conn);
            
            
        }
    }
?>