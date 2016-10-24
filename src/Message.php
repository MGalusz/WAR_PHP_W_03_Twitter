<?php

class Message {

    private $id;
    private $senderId;
    private $receiverId;
    private $massage;
    private $status;

    public function __construct() {
        $this->id = -1;
        $this->senderId = '';
        $this->receiverId = '';
        $this->massage = '';
        $this->status = '';
    }

    public function addAMassageToTheDB(mysqli $connection) {
        if ($this->id == -1) {
            $query = "INSERT INTO Messages (sender_id, receiver_id, message,message_date,status)
                    VALUES( '$this->senderId', '$this->receiverId', '$this->massage', NOW(), $this->status
                    )";
            var_dump($query);
            
            if ($connection->query($query)) {
                $this->id = $connection->insert_id;
                echo 'Wiadomość wysłana';
                return true;
            } else {
                echo 'Wiadomość Blad';
                return false;
            }
        }
    }

    static public function loadAllSentMassagesByUserId(mysqli $connection, $userId) {
        $query = "SELECT  Messages.id, message, status, message_date, Users.name AS sender, User2.name AS receiver
                 FROM Messages
                 JOIN Users ON Users.id = Messages.sender_id
                JOIN Users AS User2 ON User2.id = Messages.receiver_id
                WHERE Users.id = '" . $connection->real_escape_string($userId) . "'
                ORDER BY message_date DESC";
        
     
        
        $result = $connection->query($query);
        return $result;
//       
    }

    static public function loadAllReceivedMassagesByUserId(mysqli $connection, $userId) {
        $query = "SELECT Messages.id, message, status, message_date, Users.name AS receiver, User2.name AS sender
                 FROM Messages
                 JOIN Users ON Users.id = Messages.receiver_id
                JOIN Users AS User2 ON User2.id = Messages.sender_id
                WHERE Users.id = '" . $connection->real_escape_string($userId) . "'
                ORDER BY message_date DESC";
        
        
        $result = $connection->query($query);
        return $result;
    }

    static public function changeTheStatusOfAMassage(mysqli $connection, $id) {
        $query = "UPDATE Messages SET `message_date` = `message_date`, status = 1 WHERE id = '$id'";
        
        
        if ($connection->query($query)) {
            echo 'dziala';
            return true;
        } else {
            return false;
        }
    }

    static public function loadAMassageByMassageId(mysqli $connection, $massageId) {
        $query = "SELECT message FROM Messages WHERE id = '$massageId'";
        $result = $connection->query($query);
        if ($result == true && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $massageToShow = new Massage();
            $massageToShow->massage = $row['massage'];
            return $massageToShow;
        }
        return null;
    }

    public function getId() {
        return $this->id;
    }

    public function setSenderId($senderId) {
        $this->senderId = $senderId;
    }

    function getSenderId() {
        return $this->senderId;
    }

    function getReceiverId() {
        return $this->receiverId;
    }

    function getMassage() {
        return $this->massage;
    }

    function setReceiverId($receiverId) {
        $this->receiverId = $receiverId;
    }

    function setMassage($massage) {
        $this->massage = $massage;
    }

    function getStatus() {
        return $this->status;
    }

    function setStatus($status) {
        $this->status = $status;
    }

}

