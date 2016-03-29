<?php

session_start();
$_SESSION['error_message'] = "";

if (!isset($_SESSION['logged_in'])) {
    $_SESSION['error_message'] = "You need to be logged in to create an animal.<br>";
    header('Location: ../../views/sessions/user_login.php');
} else {
    newAnimal();
}

function newAnimal() {
    if (isset($_POST['new_animal'])) {
        $errors = array();

        echo "THROUGH";
    }
}

?>



<?php /**sset($_POST['submitted'])){
	// create  an array to store all errors
	$errors = array();
	//get the file
	if ($_FILES["pic"]["error"] > 0) {
		$errors[] = "Error with file upload: " . $_FILES["pic"]["error"] . "<br>";
	} else {
		//set the filename
		$filename = $_FILES["pic"]["name"];
		$type = $_FILES["pic"]["type"];
		//if the type is one of the three image types
 		if (($type == "image/jpeg")||($type == "image/png")||($type == "image/gif")){
 			//move the file to a sub-directory called images
 			move_uploaded_file($_FILES["pic"]["tmp_name"], "images/" . $filename);
 		} else {
 			$errors[] = "Wrong File Type! Only jpeg, png and gid allowed";
 		}
	}
    **/?>
