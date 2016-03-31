<?php
class AdoptionRequest {
    private $user_id;
    private $animal_id;

    public function __construct($user_id, $animal_id) {
        $this->user_id = $user_id;
        $this->animal_id = $animal_id;
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
            echo "DONE";
        } catch (PDOException $e) {
            throw $e;
        }
        return $saved;
    }

    public static function list_all_pending() {
        require_once(__DIR__.'/../db_connection.php');
        try {
            $rows = $db->query("SELECT * from adoptionRequest");
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
