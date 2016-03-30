<?php

class StaffUser {

    public static function exists($email, $password) {
        require(__DIR__.'/../db_connection.php');

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
        require(__DIR__.'/../db_connection.php');
        $sanitised_email = $db->quote($email);
        try {
            $user = $db->query("select * from user where email=$sanitised_email");
            $row = $user->fetch();
        } catch (PDOException $e) {
            throw $e;
        }
        $_SESSION['email'] = $row['email'];
        $_SESSION['logged_in'] = true;
        $_SESSION['id'] = $row['userID'];
        $_SESSION['staff'] = true;
    }
}

?>
