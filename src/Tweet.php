<?php

class Tweet {

    private $id;
    private $userId;
    private $text;
    private $creationDate;

    public function __construct() {
        $this->id = -1;
        $this->userId = "";
        $this->text = "";
        $this->creationDate = "";
    }

    public function getID() {
        return $this->id;
    }

    public function setUserId($userId) {
        if ($userId >= 0) {
            $this->userId = $userId;
        }
    }

    public function getUserId() {

        return $this->userId;
    }

    public function setText($text) {
        if (is_string($text) && strlen(trim($text)) > 0) {
            $this->text = $text;
        }
    }

    public function getText() {
        return $this->text;
    }

    public function setCreationDate($date) {
        $this->creationDate = $date;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    static public function loadTweetById(mysqli $connection, $id) {
        $query = "SELECT * FROM Tweet WHERE id = " . $connection->real_escape_string($id);

        $res = $connection->query($query);
        if ($res && $res->num_rows == 1) {
            $row = $res->fetch_assoc();
            $tweets = new Tweet();
            $tweets->id = $row['id'];
            $tweets->userId = $row['userID'];
            $tweets->text = $row['text'];
            $tweets->creationDate = $row['creationDate'];
            return $tweets;
        } else {
            return NULL;
        }
    }

    static public function loadTweetByUsersID(mysqli $connection, $userID) {


        $query = "SELECT * FROM Tweet WHERE userID = " . $connection->real_escape_string($userID);
       
        
        $tweets = [];

        $res = $connection->query($query);
        if ($res) {
            foreach ($res as $row) {
                $row = $res->fetch_assoc();
                $tweet = new Tweet();
                $tweet->id = $row['id'];
                $tweet->userId = $row['userID'];
                $tweet->text = $row['text'];
                $tweet->creationDate = $row['creationDate'];
                $tweets[] = $tweet;
            }
            return $tweets;
        } else {
            return NULL;
        }
    }

    static public function loadAllTweets(mysqli $connection) {
        $tweets = [];
        $query = "Select * FROM Tweet";
        $res = $connection->query($query);
        if ($res && $res->num_rows > 1) {
            foreach ($res as $row) {
                
            }
        } if ($res) {
            foreach ($res as $row) {
                $row = $res->fetch_assoc();
                $tweet = new Tweet();
                $tweet->id = $row['id'];
                $tweet->userId = $row['userID'];
                $tweet->text = $row['text'];
                $tweet->creationDate = $row['creationDate'];
                $tweets[] = $tweet;
            }
            return $tweets;
        } else {
            
        }
    }

    public function savcToBD(mysqli $connection) {
        if ($this->id == -1) {
            $query = "INSERT INTO Tweet(userID,text,creationDate)"
                    . "VALUES('$this->userId','$this->text','$this->creationDate')";
            
            
            if ($connection->query($query)) {
                $this->id = $connection->insert_id;
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            $query = "UPDATE Tweet"
                    . "SET userID = '$this->userId',text = '$this->text',creationDate = '$this->creationDate'"
                    . "WHERE id = $this->id";
            if ($res = $connection->query($query)) {
                return TRUE;
            } else {
                return false;
            }
        }
    }

    public function delete(mysqli $connetion) {
        if ($this->id != -1) {
            $query = "DELETE FROM Tweet WHERE id = $this->id";
            if ($connetion->query($query)) {
                $this->id = -1;
                return TRUE;
            } else {
                return false;
            }
        }return TRUE;
    }

}
