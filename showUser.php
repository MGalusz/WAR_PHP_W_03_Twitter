<?php

session_start();
require_once 'src/Tweet.php';
require_once 'src/Message.php';
require_once 'src/User.php';
require_once 'connection.php';
require_once 'src/Comment.php';
if (!isset($_GET['userId'])) {
    header('Location:inxex.php');
}
$userToShow = $_GET['userId'];
$cuentyUser = $_SESSION['userId'];

if ($userToShow == $cuentyUser) {


    echo 'Otrzymane wiadomosci' . "<br>";
    foreach (Message::loadAllReceivedMassagesByUserId($conn, $cuentyUser)as $message) {
        $user = User::loadUserbyId($conn, $message['sender_id']);
        echo 'Wiadomosc: ' . $message['message'] . "<br>";
        echo 'data wyslania: ' . $message['message_date'] . "<br>";
        echo 'Nadawca: ' . $message['sender'];

        Message::changeTheStatusOfAMassage($conn, $message['id']);
    }
    echo 'Wyslane  wiadomosci' . "<br>";
    foreach (Message::loadAllSentMassagesByUserId($conn, $cuentyUser)as $message) {
        //$user = User::loadUserbyId($conn, $message['receiver_id']);
        echo 'Wiadomosc: ' . $message['message'] . "<br>";
        echo 'data wyslania: ' . $message['message_date'] . "<br>";
        echo 'odbiorca: ' . $message['receiver'] . "<br>";

        Message::changeTheStatusOfAMassage($conn, $message['id']);
    }
    foreach (Tweet::loadTweetByUsersID($conn, $cuentyUser)as $tweet) {
        echo '<div class="date"> Czas dodania: ' . $tweet->getCreationDate() . '</div>';
        echo '<div class="tweet">' . $tweet->getText() . '</div>';
        echo '<br>';

        $comment_counter = 0; //
        foreach (Comment::loadCommentByTweetID($conn, $tweet->getID()) as $comment) {
            $comment_counter++; //zliczanie ilosci komentarzy
        }
        $user = User::loadUserbyId($conn, $cuentyUser);

        echo '<div class="comment">Ilość komentarzy: ' . $comment_counter . '<a href="show_post.php?tweetId=' . $tweet->getID() . '&userName=' . $user->getName() . '"> POKAŻ WIĘCEJ</a></div>';
    }
}