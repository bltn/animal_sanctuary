<form action="pass_gen.php" method="post">
<input type="password" name="password">
<input type="submit" name="sub">
</form>

<?php 
	if (isset($_POST['sub'])) {
		echo md5($_POST['password']);
	}
?>