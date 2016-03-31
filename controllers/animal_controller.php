<?php
class AnimalController {

    public function __construct() {}

    public function new_animal($name, $dob, $description, $picture) {
        require_once(__DIR__.'/../models/animals/animal.php');

        $animal = new Animal($name, $dob, $description, $picture);
        if ($animal->save()) {
            header('Location: ../index.php');
        } else {
            header('Location: ../views/animals/add_animal.php');
        }
    }

    public function list_user_animals($user_id) {
        require_once(__DIR__.'/../models/animals/animal.php');
        $animals = null;
        $animals = Animal::list_user_animals($user_id);
        if ($animals) {
            return $animals;
        }
    }

    public function search_for_animals($value) {
        require_once(__DIR__.'/../models/animals/animal.php');
        $animals = Animal::search_for_animals($value);
        if ($animals) {
            return $animals;
        }
    }

    public function show($id) {
        require_once(__DIR__.'/../models/animals/animal.php');
        $animal = Animal::find($id);
        if ($animal) {
            return $animal;
        }
    }

    public function index() {
        require_once(__DIR__.'/../models/animals/animal.php');
        $animals = Animal::list_all();
        if ($animals) {
            return $animals;
        }
    }

    public function available_index() {
        require_once(__DIR__.'/../models/animals/animal.php');
        $animals = Animal::list_all_available();
        if ($animals) {
            return $animals;
        }
    }
}
?>
