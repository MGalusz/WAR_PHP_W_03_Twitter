<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header('Location:login.php');
}

require_once 'src/Comment.php';
require_once 'src/Tweet.php';
require_once 'src/User.php';
require_once 'connection.php';
require_once 'src/Message.php';
require_once 'message.php';


$cuentyUser = $_SESSION['userId'];
echo '<a href="showUser.php?userId=' . $cuentyUser . '">Pokaz moj profil </a> </div>';

$allusers = User::loadAllUser($conn);
foreach ($allusers as $user) {
    echo '<div id="usershow" ><h2>' . $user->getName() . '</h2>';
    echo '<a href="message.php?userId=' . $user->getId().'?currentUser='.$cuentyUser.'">Wyslij Wiadomosc</a> </div>';


    echo '<br>';
}

echo '
    <form action="#" method = "POST">
    <input type="hidden" name="forms" value="adding_tweet">
    <input type="text" name="tweet_text">
    <input type="submit" value="Wyslij tweeta">

    <form action="logout.php">
    <input type="submit" value="Wyloguj">
    </form>
    <br>
';
foreach ((Tweet::loadAllTweets($conn))as $tweet) {
    echo '<div class="date"> Czas dodania: ' . $tweet->getCreationDate() . '</div>';
    echo '<div class="tweet">' . $tweet->getText() . '</div>';
    echo '
            <form method="POST" >
                <input type="hidden" name="forms" value="adding_comment">
                <input type="text" name="comment">
                <input type="hidden" name="tweet_id" value="' . $tweet->getID() . '">
                <input type="submit" value="Dodaj komentarz">
            </form>
           <form action="message.php">
                <input type="submit" value="Sprawdź wiadomośći">
            </form>
        ';
}

$comment_counter = 0; //
foreach (Comment::loadCommentByTweetID($conn, $tweet->getID()) as $comment) {
    $comment_counter++; //zliczanie ilosci komentarzy
}
$user = User::loadUserbyId($conn, $cuentyUser);

echo '<div class="comment">Ilość komentarzy: ' . $comment_counter . '<a href="show_post.php?tweetId=' . $tweet->getID() . '&userName=' . $user->getName() . '"> POKAŻ WIĘCEJ</a></div>';






if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['forms'] == 'adding_tweet') {
    if ($_POST['tweet_text'] != null) {
        $tweet = new Tweet();
        $tweet->setUserId($cuentyUser);
        $tweet->setCreationDate(date('Y-m-d'));
        $tweet->setText($_POST['tweet_text']);
        var_dump($tweet);

        if ($tweet->savcToBD($conn)) {
            echo 'Dodano Tweeta ' . $_POST['tweet_text'] . "<br>";
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['forms'] == 'adding_comment') {

    $coment = new Comment;
    $coment->setId_post($_POST['tweet_id']);
    $coment->setId_usera($cuentyUser);
    $coment->setCreationcommentDate(date('Y-m-d'));
    $coment->setComent($_POST['comment']);
    if ($coment->addComment($conn)) {
        echo 'dodano Komentarz';
    }
}
?>



<html>
    <head></head>
    <body>
        Strona główna
    </body>
</html>