<?php

class CustomerUser {

    private $email;
    private $password;

    public function __construct($email, $password) {
        $this->email = $email;
        $this->password = $password;
    }

    public function log_in() {
        require(__DIR__.'/../db_connection.php');
        $sanitised_email = $db->quote($this->email);
        try {
            $user = $db->query("select * from user where email=$sanitised_email");
            $row = $user->fetch();
        } catch (PDOException $e) {
            throw $e;
        }
        $_SESSION['email'] = $row['email'];
        $_SESSION['logged_in'] = true;
        $_SESSION['id'] = $row['userID'];
        $logged_in = true;
    }

    public function save() {
        require(__DIR__.'/../db_connection.php');
        $saved = false;
        $sanitised_email = $db->quote($this->email);
        $hashed_password = md5($this->password);
        try {
            $db->exec("INSERT INTO user (email, staff, password) VALUES ($sanitised_email, false, '$hashed_password')");
            $saved = true;
        } catch (PDOException $e) {
            $_SESSION['error_message'] = $e->getMessage();
        }
        return $saved;
    }

    public static function exists($email, $password) {
        require(__DIR__.'/../db_connection.php');
        $clashes = array();
        $sanitised_email = $db->quote($email);
        $hashed_password = md5($password);

        try {
            $email_matches = $db->query("select * from user where email=$sanitised_email");
            if ($email_matches->rowCount() > 0) {
                $clashes[] = "That email is already taken.";
            }
        } catch (PDOException $e) {
            throw $e;
        }
        try {
            $pwd_matches = $db->query("select * from user where password='$hashed_password'");
            if ($pwd_matches->rowCount() > 0) {
                $clashes[] = "Password is already taken.";
            }
        } catch (PDOException $e) {
            throw $e;
        }
        return $clashes;
    }
}
