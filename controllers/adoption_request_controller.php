<?php
    class AdoptionRequestController {

        public function __construct() {}

        public function create_adoption_request($user_id, $animal_id) {
            require(__DIR__.'/../models/adoption_requests/adoption_request.php');
            $saved = false;
            try {
                $request = new AdoptionRequest($user_id, $animal_id);
                $saved = $request->save();
                if ($saved) {
                    header('Location: ../views/animals/show_animal.php?id=' . $animal_id);
                } else {
                    $_SESSION['error_message'] = "There was an error processing your adoption request. Please try again.";
                    header('Location: ../views/animals/show_animal.php?id=' . $animal_id);
                }
            } catch (PDOException $e) {
                $_SESSION['error_message'] = $e->getMessage();
                header('Location: ../views/animals/show_animal.php?id=' . $animal_id);
            }
        }

        public function index() {
            require_once(__DIR__.'/../models/adoption_requests/adoption_request.php');
            $requests = AdoptionRequest::list_all();
            if ($requests) {
                return $requests;
            }
        }
    }
?>
