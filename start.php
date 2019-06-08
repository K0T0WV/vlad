<?php require_once ("admin/config.php") ?> 

<?php 
if(isset($_SESSION['logged_user']) ) : ?>
	<? echo $_SESSION['logged_user'] ->login; ?>
	<? else : ?>
<a href="/login.php">Авторизоваться</a><br>
<a href="/signup.php">Зарегистрироваться</a>
<?php endif; ?>