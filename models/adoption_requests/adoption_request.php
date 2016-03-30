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
            $saved = true;
            echo "DONE";
        } catch (PDOException $e) {
            throw $e;
        }
        return $saved;
    }
}
?>
