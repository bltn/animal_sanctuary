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
                     $_SESSION['error_message'] = "Your request has been submitted.";
                } else {
                    $_SESSION['error_message'] = "There was an error processing your adoption request. Please try again.";
                    header('Location: ../views/animals/show_animal.php?id=' . $animal_id);
                }
            } catch (PDOException $e) {
                $_SESSION['error_message'] = $e->getMessage();
                header('Location: ../views/animals/show_animal.php?id=' . $animal_id);
            }
        }

        public function approve_adoption_request($request_id) {
            require(__DIR__.'/../models/adoption_requests/adoption_request.php');
            try {
                $processed = AdoptionRequest::approve($request_id);
                if ($processed) {
                    header('Location: /animal_sanctuary/index.php');
                } else {
                    $_SESSION['error_message'] = "There was an error processing the adoption request. Please try again.";
                    header('Location: /animal_sanctuary/index.php');
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        public function deny_adoption_request($request_id) {
            require(__DIR__.'/../models/adoption_requests/adoption_request.php');
            try {
                $processed = AdoptionRequest::deny($request_id);
                if ($processed) {
                    header('Location: /animal_sanctuary/index.php');
                } else {
                    $_SESSION['error_message'] = "There was an error processing the adoption request. Please try again.";
                    header('Location: /animal_sanctuary/index.php');
                }
            } catch (PDOException $e) {
                $_SESSION['error_message'] = "There was an error processing the adoption request. Please try again.";
                header('Location: /animal_sanctuary/index.php');
            }
        }

        public function closed_index() {
            require_once(__DIR__.'/../models/adoption_requests/adoption_request.php');
            $requests = AdoptionRequest::list_all_closed();
            if ($requests) {
                return $requests;
            }
        }

        public function closed_user_index($user_id) {
            require_once(__DIR__.'/../models/adoption_requests/adoption_request.php');
            $requests = AdoptionRequest::list_closed($user_id);
            if ($requests) {
                return $requests;
            }
        }

        public function pending_index() {
            require_once(__DIR__.'/../models/adoption_requests/adoption_request.php');
            $requests = AdoptionRequest::list_all_pending();
            if ($requests) {
                return $requests;
            }
        }

        public function user_pending_index($user_id) {
            require_once(__DIR__.'/../models/adoption_requests/adoption_request.php');
            $requests = AdoptionRequest::list_pending($user_id);
            if ($requests) {
                return $requests;
            }
        }
    }
?>
