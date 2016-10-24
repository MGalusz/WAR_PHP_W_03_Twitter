<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header('Location:login.php');
}

require_once 'src/Tweet.php';
require_once 'src/Message.php';
require_once 'src/User.php';
require_once 'connection.php';


$cuentyUser = $_SESSION['userId'];

echo '
    <form action="index.php">
        <input type="submit" value="Wróć do strony profilowej">
    </form>
';


if (isset($_GET['userId'])) { //sprawdzenie czy użytkownik został wywołany przez geta czyli ze strony show all users
    $userId = $_GET['userId']; //ustawienie userid na tego wywołanego przez geta
    if ($userId != $_SESSION['userId']) { //jeżeli zalogowany uzytkownik sam nie wchodzi na swoj profil, to może komuś wysłać wiadomość
        echo '
            <form method="POST">
                <input type="hidden" name="forms" value="sending_message">
                <input type="hidden" name="receiver" value="' . $userId . '">
                <input type="text" name="message">
                <input type="submit" value="Wyslij wiadomość">
            </form>
        ';
    }
//                <a href="showUser.php">
//                <div class="button">POKAŻ SWOJ PROFIL</div>
//            </a>
}
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['forms'] == 'sending_message') {
        if ($_POST['message'] != null) {
            $message = new Message;
            $message->setSenderId($cuentyUser);
            $message->setReceiverId($_POST['receiver']);
            $message->setStatus(0);
            $message->setMassage($_POST['message']);
            var_dump($message);
            if($message->addAMassageToTheDB($conn)){
                echo "wyslano wiadomosc";
            }else {
                echo 'nie wudalo wysłać wiadomosci';
            }
           
        }
    }

var_dump(Message::loadAllReceivedMassagesByUserId($conn, $cuentyUser));
foreach ((Message::loadAllReceivedMassagesByUserId($conn, $cuentyUser))as $revivedMesage) {
    var_dump($revivedMesage);
}
