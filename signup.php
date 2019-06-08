<?php require_once ("admin/config.php") ?> 

<?php  
if(isset($_POST['submit'])){ //выполняем нижеследующий код, только если нажата кнопка 
$query = DB::Query("SELECT * FROM `users`  WHERE `login`='".$_POST['login']."'"); //отправляем запрос на выборку всего содержимого , где поле логин равно переменной $login  
  $row = mysqli_num_rows($query); // считаем количество рядов результата запроса  
if(empty($_POST['login'])){ //если переменная логина пуста или не существует  
echo"Вы не ввели логин"; // выводим сообщение об ошибке   
  }elseif(empty($_POST['password'])){ //если переменная логина пуста или не существует  
echo"Вы не ввели пароль"; // выводим сообщение об ошибке  
  }elseif($row > 0){ //если переменная больше 0  
echo"Такой пользователь уже существует!"; // выводим сообщение об ошибке  
  }elseif(empty($_POST['password2'])){ //если переменная логина пуста или не существует  
echo"Вы не ввели подтверждение пароля"; // выводим сообщение об ошибке  
  }elseif($_POST['password'] != $_POST['password2']){ //если переменная пароля и переенная  повтора пароля не одинаковы  
echo"Вы неправильно ввели подтверждение пароля"; // выводим сообщение об ошибке   

  }else{ //если же ошибок нет  
  $login = $_POST['login']; //присваеваем переменную  
  $password = md5($_POST['password']);//присваеваем переменную и кодируем её в md5 для безопасности  
   
  $insert = DB::Query("INSERT INTO `users` (`login` ,`password`) VALUES ('$login', '$password')"); //выполняем запрос на добавление нового пользователя  
  if($insert == true){  
echo '<div style = "color: green;">Вы зарегистрированы<a href="start.php"><br>Авторизируйтесь</a> </div><hr>';
  }
  else{  
  echo "Непредвиденная ошибка!";  
  }  
   
  }  

}  
?>


<form action="" method="POST" accept-charset="utf-8">
Логин:<br /><input name="login" type="text" size="20"><br />
Пароль:<br /><input name="password" type="password" size="20"><br />
Еще раз пароль:<br /><input name="password2" type="password" size="20"><br />
<input name="submit" type="submit" value="Зарегистрироваться"><br />
</form>
</form>
