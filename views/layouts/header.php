<ul class="navbar">
<?php
if ($_SESSION['logged_in']) {
    if ($_SESSION['staff'] == 1) {
        echo "<li><a href='#'>Home</a></li>";
        echo "<li><a href='#'>Historic adoption requests</a></li>";
        echo "<li><a href='#'>View all animals</a></li>";
        echo "<li><a href=\"/animal_sanctuary/config/router.php?log_out\">Log out</a></li>";
    } else {
    }
} else {
    echo "<li><a href=\"/animal_sanctuary/views/sessions/user_login.php\">Log in</a></li>";
}
?>
</ul>
