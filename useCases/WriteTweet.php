<?php

session_start();
if(!isset($_SESSION['userId'])){
    header('Location:login.php');
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['tweet']) && strlen(trim($_POST['tweet']))>1){
            require_once 'src/User.php';
            require_once 'connection.php';
            require_once '../src/Tweet.php';
            $tweet = new Tweet();
            $tweet->setText($_POST['tweet']);
            $tweet->setCreationDate($_POST["date"]);
            $tweet->setUserId($_SESSION['userId']);
            $tweet->savcToBD($conn);
            echo"dodano Wpis";
            echo '';
    
        
    }else{
        echo 'podano nieporawne dane';
        
    }
    
}
echo '
    
';



?>
<html>
    <head></head>
    <body>
        <form method="POST">
            <label>
                	Tweet Text:<br>
				<input type="text" name="tweet">
                
            </label>
            <br>
                        <label>
                	Data:<br>
                        <input type="date" name="date">
                
            </label>
            <input type="submit" name="Dodaj">
            
        </form>
                <form method="POST">
            <label>
                	Mesage:<br>
				<input type="text" name="tweet">
                
            </label>
            <br>
                        <label>
                	User Name:<br>
                        <input type="text" name="UserName">
                
            </label>
            <input type="submit" name="Dodaj">
            
        </form>
    </body>
</html>