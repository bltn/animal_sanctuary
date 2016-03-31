<?php
class AdoptionRequest {
    private $user_id;
    private $animal_id;

    public function __construct($user_id, $animal_id) {
        $this->user_id = $user_id;
        $this->animal_id = $animal_id;
    }

    public static function deny($request_id) {
        require_once(__DIR__.'/../db_connection.php');
        $processed = false;
        try {
            $sanitised_request_id = $db->quote($request_id);
            $request = $db->query("SELECT * from adoptionRequest WHERE adoptionID=$sanitised_request_id");
            $request_details = $request->fetch();
            $animal_id = $request_details['animalID'];
            $db->exec("UPDATE adoptionRequest SET closed=true AND approved=false WHERE adoptionID=$sanitised_request_id");
            $db->exec("UPDATE animal SET available=true WHERE animalID=$animal_id");
            $processed = true;
            echo "DONE";
        } catch (PDOException $e) {
            throw $e;
        }
        return $processed;
    }

    public static function approve($request_id) {
        require_once(__DIR__.'/../db_connection.php');
        $processed = false;
        try {
            $sanitised_request_id = $db->quote($request_id);
            $request = $db->query("SELECT * from adoptionRequest WHERE adoptionID=$sanitised_request_id");
            $request_details = $request->fetch();
            $user_id = $request_details['userID'];
            $animal_id = $request_details['animalID'];
            $db->exec("UPDATE adoptionRequest SET closed=true, approved=true WHERE adoptionID=$sanitised_request_id");
            $db->exec("UPDATE animal SET available=false, userID='$user_id' WHERE animalID='$animal_id'");
            $processed = true;
        } catch (PDOException $e) {
            throw $e;
        }
        return $processed;
    }

    public function save() {
        require_once(__DIR__.'/../db_connection.php');
        $saved = false;
        try {
            $sanitised_user_id = $db->quote($this->user_id);
            $sanitised_animal_id = $db->quote($this->animal_id);
            $db->exec("INSERT INTO adoptionRequest (userID, animalID, approved) VALUES ($sanitised_user_id, $sanitised_animal_id, false)");
            $db->exec("UPDATE animal SET available=false WHERE animalID=$sanitised_animal_id");
            $saved = true;
        } catch (PDOException $e) {
            throw $e;
        }
        return $saved;
    }

    public static function list_all_closed() {
        require_once(__DIR__.'/../db_connection.php');
        try {
            $rows = $db->query("SELECT * from adoptionRequest WHERE closed=true");
            $requests = array();
            foreach($rows as $row) {
                $animal_id = $row['animalID'];
                $user_id = $row['userID'];
                $animal = $db->query("SELECT * from animal WHERE animalID=$animal_id");
                $animal_details = $animal->fetch();
                $row['animal_name'] = $animal_details['name'];
                $user = $db->query("SELECT * from user WHERE userID=$user_id");
                $user_details = $user->fetch();
                $row['owner_email'] = $user_details['email'];
                if ($user_details['staff'] == true) {
                    $row['owner_is_staff'] = true;
                } else {
                    $row['owner_is_staff'] = false;
                }
                $requests[] = $row;
            }
            return $requests;
        } catch (PDOEXception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            return false;
        }
    }

    public static function list_all_pending() {
        require_once(__DIR__.'/../db_connection.php');
        try {
            $rows = $db->query("SELECT * from adoptionRequest WHERE closed=false");
            $requests = array();
            foreach($rows as $row) {
                $animal_id = $row['animalID'];
                $animal = $db->query("SELECT * from animal WHERE animalID=$animal_id");
                $animal_details = $animal->fetch();
                $user_id = $animal_details['userID'];
                $user = $db->query("SELECT * from user WHERE userID=$user_id");
                $user_details = $user->fetch();
                if ($user_details['staff'] == 1) {
                    $row['animal_name'] = $animal_details['name'];
                    $requests[] = $row;
                }
            }
            return $requests;
        } catch (PDOEXception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            return false;
        }
    }
}
?>
