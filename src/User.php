<?php

class User {

    private $id;
    private $name;
    private $email;
    private $hashedPassword;

    public function __construct() {
        $this->id = -1;
        $this->name = "";
        $this->email = "";
        $this->hashedPassword = "";
    }

    public function getID() {
        return $this->id;
    }

    public function setName($name) {
        if (is_string($name) && strlen($name) > 0) {
            $this->name = trim($name);
        }
    }

    public function getName() {
        return$this->name;
    }

    public function setEmail($email) {
        if (is_string($email) && strlen($email) >= 5) {
            $this->email = $email;
        }
    }

    public function getEmail() {
        return $this->email;
    }

    public function setPassword($newPassword) {
        if (is_string($newPassword) && strlen($newPassword) > 8) {
            $hased = password_hash($newPassword, PASSWORD_BCRYPT);
            $this->hashedPassword = $hased;
        }
    }

    public function saveToBD(mysqli $connection) {
        if ($this->id == - 1) {
            $query = " INSERT INTO Users(email, name , hased_password)"
                    . "VALUES ('$this->email','$this->name','$this->hashedPassword')";
            if ($connection->query($query)) {
                $this->id = $connection->insert_id;
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            $query = "UPDATE Users "
                    . "SET name ='$this->name', email ='$this->email', hased_password='$this->hashedPassword'"
                    . "WHERE id = $this->id";

            if ($res = $connection->query($query)) {
                return TRUE;
            } else {
                return false;
            }
        }
    }

    static public function loadUserbyId(mysqli $connetionm, $id) {

        $query = "SELECT * FROM Users WHERE id = " . $connetionm->real_escape_string($id);

        $res = $connetionm->query($query);
        if ($res && $res->num_rows == 1) {
            $row = $res->fetch_assoc();
            $user = new User();
            $user->id = $row['id'];

            $user->setName($row['name']);
            $user->setEmail($row['email']);
            $user->hashedPassword = $row['hased_password'];

            return $user;
        } else {

            return NULL;
        }
    }

    static public function loadAllUser(mysqli $connetion) {

        $users = [];
        $query = "SELECT * FROM Users";
        $res = $connetion->query($query);
        if ($res) {
            foreach ($res as $row) {
                $user = new User();
                $user->id = $row['id'];

                $user->setName($row['name']);
                $user->setEmail($row['email']);
                $user->hashedPassword = $row['hased_password'];
                $users[] = $user;
            }
            return $users;
        } else {
            return null;
        }
    }

    public function delete(mysqli $connetion) {
        if ($this->id != -1) {
            $query = "DELETE FROM Users WHERE id = $this->id";
            if ($connetion->query($query)) {
                $this->id = -1;
                return TRUE;
            } else {
                return false;
            }
        }return TRUE;
    }

    static public function loadUserByEmail(mysqli $connection, $email) {
        $query = "SELECT * FROM Users WHERE email = '" . $connection->real_escape_string($email) . "'";
        $res = $connection->query($query);
        if ($res && $res->num_rows == 1) {
            $user = new User();
            $row = $res->fetch_assoc();
            $user->id = $row['id'];
            $user->setName($row['name']);
            $user->setEmail($row['email']);
            $user->hashedPassword = $row['hased_password'];
            return $user;
        }
        return NULL;
    }

    static public function login(mysqli $connection, $email, $password) {
        $user = self::loadUserByEmail($connection, $email);
        if ($user && password_verify($password, $user->hashedPassword)) {
            var_dump($user);

            return $user;
        } else {
            return FALSE;
        }
    }

}
