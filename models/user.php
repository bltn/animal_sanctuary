<?php

class StaffUser {

    public static function exists($email, $password) {

        session_start();

        require('db_connection.php');

        $exists = false;

        $sanitised_email = $db->quote($email);
        $hashed_password = md5($password);
        if ($db != null) {
            try {
                $user = $db->query("select * from user where email=$sanitised_email");
                $row = $user->fetch();

                if ($row['password'] == $hashed_password) {
                    $exists = true;
                }
            } catch (PDOException $e) {
                throw new PDOException($e->getMessage());
            }
        }
        return $exists;
    }

    public static function logInUser($email) {
        $_SESSION['email'] = $email;
        $_SESSION['logged_in'] = true;
    }


}

?>
