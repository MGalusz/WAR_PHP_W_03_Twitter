<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header('Location:login.php');
}

require_once 'src/Tweet.php';
require_once 'src/User.php';
require_once 'connection.php';


$cuentyUser = $_SESSION['userId'];


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
echo'
    <form action = "index.php" method = "GET" >
    Wybierz posty uzytkownika ktorgo chcesz posty zobaczyc:';
echo''
 . '<fom action "index.php" method="POST" name = "userID">';
foreach (User::loadAllUser($conn) as $user) {
    echo '<input type="checkbox" value="' . $user->getID() . '" name="userID">' . $user->getName() . '<input type="submit" value="wybierz">';
}
echo "</form>" . "<br>";


if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['userID'] ){
   $userTweets = $_GET['userID'];
       var_dump($_GET['userID']);
       $allUserTweets = Tweet::loadTweetByUsersID($conn, $userTweets);
       echo '<table><td><tr> Wiadomosc </tr><tr> Data </tr><td>';
      var_dump($allUserTweets );
    foreach ($allUserTweets  as $singletweett ){
        var_dump($singletweett->getText());
        
        
        echo  '<td><tr>1'.$singletweett->getText().'</tr><tr>2'.$singletweett->getCreationDate().'</tr><td>';
    }
    echo '</table>';
  
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['forms'] == 'adding_tweet') {
    if ($_POST['tweet_text'] != null) {
        $tweet = new Tweet();
        $tweet->setUserId($cuentyUser);
        $tweet->setCreationDate(date('Y-m-d'));
        $tweet->setText($_POST['tweet_text']);
        var_dump($tweet);
        
        if($tweet->savcToBD($conn)){
            echo 'Dodano Tweeta ' . $_POST['tweet_text'] . "<br>";
        }
        
    }
}
?>

<html>
    <head></head>
    <body>
        Strona główna
    </body>
</html>