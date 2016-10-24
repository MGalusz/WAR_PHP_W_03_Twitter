<?php

class Comment {

    private $id;
    private $id_usera;
    private $id_post;
    private $coment;
    private $creationcommentDate;

    public function __construct() {
        $this->id = -1;
        $this->id_usera = "";
        $this->id_post = "";
        $this->coment = "";
        $this->creationcommentDate = "";
    }

    function getId() {
        return $this->id;
    }

    function getId_usera() {
        return $this->id_usera;
    }

    function getId_post() {
        return $this->id_post;
    }

    function getComent() {
        return $this->coment;
    }

    function getCreationcommentDate() {
        return $this->creationcommentDate;
    }

    function setId_usera($id_usera) {
        $this->id_usera = $id_usera;
    }

    function setId_post($id_post) {
        $this->id_post = $id_post;
    }

    function setComent($coment) {
        if (is_string($coment) && strlen(trim($coment)) > 0) {
            $this->coment = $coment;
        }
    }

    function setCreationcommentDate($creationcommentDate) {
        $this->creationcommentDate = $creationcommentDate;
    }

    public function addComment(mysqli $connection) {
        
        if (($this->id == -1)) {
            $query = "INSERT INTO Comment(Id_usera,Id_postu,text,creationDate)"
                    . "VALUES('$this->id_usera','$this->id_post','$this->coment','$this->creationcommentDate')";
            

            if ($connection->query($query)) {
                $this->id = $connection->insert_id;
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            $query = "UPDATE Comment"
                    . "SET Id_usera= '$this->id_usera',Id_postu=$this->id_post',text = '$this->coment',creationDate = '$this->creationcommentDate'"
                    . "WHERE id = $this->id";
            if ($res = $connection->query($query)) {
                return TRUE;
            } else {
                return false;
            }
        }
    }

    static public function loadCommentByUserID(mysqli $connection, $userID) {

        $query = "SELECT * FROM Comment WHERE Id_usera = " . $connection->real_escape_string($userID) . " ORDER BY creationDate desc";
        $comments = [];
        $res = $connection->query($query);
        if ($res) {
            foreach ($res as $row) {
                $row = $res->fetch_assoc();
                $comment = new Comment;
                $comment->id = $row['id'];
                $comment->id_post = $row['Id_postu'];
                $comment->id_usera = $row['Id_usera'];
                $comment->coment = $row['text'];
                $comment->creationcommentDate = $row['creationDate'];
                $comments[] = $comment;
            }
            return $comments;
        } else {
            return NULL;
        }
    }

    static public function loadCommentByTweetID(mysqli $connection, $tweetID) {

        $query = "SELECT * FROM Comment WHERE Id_postu = " . $connection->real_escape_string($tweetID) ;
        
        $comments = [];
        $res = $connection->query($query);
        if ($res) {
            foreach ($res as $row) {
                
                $comment = new Comment;
                $comment->id = $row['id'];
                $comment->id_post = $row['Id_postu'];
                $comment->id_usera = $row['Id_usera'];
                $comment->coment = $row['text'];
                $comment->creationcommentDate = $row['creationDate'];
                $comments[] = $comment;
            }
           
            
            return $comments;
        } else {
            return NULL;
        }
    }


        static public function loadAllComents(mysqli $connection) {
            $comments = [];
            $query = "SELECT * FROM Comment ORDER BY creationDate desc";

            $res = $connection->query($query);
            if ($res && $res->num_rows > 1) {
                foreach ($res as $row) {
                    $row = $res->fetch_assoc();
                    $comment = new Comment;
                    $comment->id = $row['id'];
                    $comment->id_post = $row['Id_postu'];
                    $comment->id_usera = $row['Id_usera'];
                    $comment->coment= $row['text'];
                    $comment->creationcommentDate = $row['creationDate'];
                    $comments[] = $comment;
                }
                return $comments;
            } else {
                return NULL;
            }
        }

    }


