<?php

session_start();
require_once 'src/Comment.php';
require_once 'src/Tweet.php';
require_once 'src/User.php';
require_once 'connection.php';

if (!isset($_SESSION['userId'])) {
    header('Location:login.php');
}

echo '
    <form action="index.php">
        <input type="submit" value="Wróć do strony profilowej">
    </form>
';

$singleTweet = Tweet::loadTweetById($conn, $_GET['tweetId']);

$authorTweet = User::loadUserbyId($conn, $singleTweet->getUserId());


echo '<div class="tweet">' . "autor Tweeta" . $authorTweet->getName() . '</div>';

echo '<div class="date"> Czas tweeta: ' . $singleTweet->getCreationDate() . ' Id tweeta: ' . $singleTweet->getID() . '</div>';
echo '<div class="tweet">' . $singleTweet->getText() . '</div>';


foreach (Comment::loadCommentByTweetID($conn, $singleTweet->getID()) as $comment) {
    
    
    $authorComment = User::loadUserbyId($conn, $comment->getId_usera());
    
    
    echo '<div class="date"> Czas komentarza: ' . $comment->getCreationcommentDate() . '</div>';
    echo '<div class="comment">Komentarz : ' . $comment->getComent() . '</div><br>';
    echo '<div class="author">Autor: ' . $authorComment->getName() . '</div><br>';
}