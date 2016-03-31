<ul class="navbar">
<?php
if ($_SESSION['logged_in']) {
    if ($_SESSION['staff'] == 1) {
        echo "<li><a href='/animal_sanctuary/index.php'>Home</a></li>";
        echo "<li><a href='/animal_sanctuary/views/animals/add_animal.php'>Add new animal</a></li>";
        echo "<li><a href='/animal_sanctuary/views/adoption_requests/list_historic_requests.php'>Historic adoption requests</a></li>";
        echo "<li><a href='/animal_sanctuary/views/animals/list_animals.php'>View all animals</a></li>";
        echo "<li><a href=\"/animal_sanctuary/config/router.php?log_out\">Log out</a></li>";
    } else {
    }
} else {
    echo "<li><a href=\"/animal_sanctuary/views/sessions/user_login.php\">Log in</a></li>";
}
?>
</ul>
