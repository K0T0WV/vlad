<?php require_once ("admin/config.php") ?> 

<?php  
if(isset($_POST['submit'])){ 
if(empty($_POST['login'])){ 
echo"Вы не ввели логин";  
  }elseif(empty($_POST['password'])){ 
echo"Вы не ввели пароль"; 
  }
  else
  {  
  $login = $_POST['login']; 
  $password = md5($_POST['password']); 
  $query = DB::Query("SELECT * FROM `users`  WHERE `login`='$login' AND `password`='$password'"); 
  $row = mysqli_num_rows($query); // считаем количество рядов результата запроса  
  if($row > 0){ //если их больше 0  
echo '<div style = "color: green;">Вы авторизовались<a href="index.php"><br>На главную</a> </div><hr>';
  }
  else
  {  
  echo "Неправильный логин или пароль!"; 
  }
  }
}
?>
<meta charset="UTF-8" /> 
<form action="login.php" method="POST" accept-charset="utf-8">
Логин:<br /><input name="login" type="text" size="20"><br />
Пароль:<br /><input name="password" type="password" size="20"><br />
<input name="submit" type="submit" value="Войти"><br />
</form>