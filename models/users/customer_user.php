<?php

class CustomerUser {

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
