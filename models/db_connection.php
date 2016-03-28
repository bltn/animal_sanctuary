<?php
    try {
        $db = new PDO("mysql:host=localhost;dbname=animal_sanctuary", "cwk", "8G9vRCwzDdESFaJA");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $ex) {
        // handle error 
    }
?>
