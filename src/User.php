<?php
class User{
    private  $id;
    private $name;
    private $email;
    private $hashedPassword;
    
    public function __construct() {
        $this->id = -1;
        $this->name = "";
        $this->email = "";
        $this->hashedPassword = "";
        
    }
    
    public function getID(){
        return $this->id;
    }
    public function setName($name){
        if(is_string($name) && strlen($name)>0){
            $this->name = trim($name);
            
        }
    }
    
    public function getName(){
        return$this->name;
    }

    public function  setEmail($email){
        if(is_string($email) && strlen($email)>=5){
            $this->email = $email;
        }
            
    }
    public function getEmail(){
        return $this->email;
    }
    public function setPassword($newPassword){
        if(is_string($newPassword) && strlen($newPassword)>8){
            $hased = password_hash($newPassword,PASSWORD_BCRYPT);
            $this->hashedPassword =  $hased;
        }
    }
    
    public function saveToBD(mysqli $connection){
        if($this->id == - 1){
            $query = " INSERT INTO Users(email, name , hased_password)"
                    . "VALUES ('$this->email','$this->name','$this->hashedPassword')";
            if($connection->query($query)){
                $this->id = $connection->insert_id;
                return TRUE;
            }else{
                return FALSE;
            }
        }  else {
            
        }
    }
    
}

