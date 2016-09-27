<?php

require_once 'src/User.php';
require_once 'connection.php';

session_start();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['email']) && strlen(trim($_POST['email'])) >= 5
            && isset($_POST['password'])&& isset($_POST['password']) >= 6){
        $email = $_POST['email'];
        $password = $_POST['password'];
        
       $user = User::login($conn, $email, $password);
       
       var_dump($user);
       
        if($user){
            echo "yes";
            $_SESSION['userId'] = $user->getID();
            var_dump($_SESSION);
            
            header('Location: index.php');
            
        }else{
            echo 'Niepoprawne dane logowania';
        }
    }
}
?>
<html>
    <head></head>
    <body>
        <form  method="post">
            <label> E-mail: <br>
                <input type="text" name="email">
            </label>
             <br>
             <label> haslo: <br>
                 <input type="password" name="password">
                 
            </label>
            <br>
            <input type="submit" value="Login">
        </form>
    </body>
</html>

