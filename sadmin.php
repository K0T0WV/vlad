<?
define('SITE', true);
include("admin/config.php");
$admin_login_form = "<table align=center><form method=post><tr><td>Логин:</td><td><input type=text name=login></td></tr><tr><td>Пароль:</td><td><input type=password name=password></td></tr><tr><td colspan=2 align=center><input type=submit value=Войти></td></tr></form></table>";
$title = "Панель администратора";
?>
<?
if(@$_GET['action'] == "logout")
{	
if(isset($_SESSION['login']) && isset($_SESSION['password']))
{ 
unset ($_SESSION['login'], $_SESSION['password']); session_destroy();
}
}
if(isset($_POST['login']) && isset($_POST['password']) && !isset($_SESSION['login']) && !isset($_SESSION['password']))
{
$_POST['login'] = addslashes($_POST['login']);
$admins = DB::Query("SELECT * FROM admin WHERE login = '". $_POST['login']."' AND password = '". md5($_POST['password'])."'"); 
if(mysqli_num_rows($admins) == 1)
{
$_SESSION['login'] = $_POST['login']; $_SESSION['password'] = $_POST['password'];
}
else echo "<center>Администратора с данными параметрами входа не существует!<br><br></center>".$admin_login_form;
}
else if(!isset($_SESSION['login']) && !isset($_SESSION['password'])) echo $admin_login_form;
if(isset($_SESSION['login']) && isset($_SESSION['password']))
{
$_SESSION['login'] = addslashes($_SESSION['login']);
$admins = DB::Query("SELECT * FROM admin WHERE login = '". $_SESSION['login']."' AND password = '". md5($_SESSION['password'])."'");
if(mysqli_num_rows($admins) == 1)
{
echo "<br /><br /><table cellpadding=5 cellspacing=5 border=0><tr>";
echo "<td align=center><strong><a href=\"".$h."/enter/\">Главная</a></strong></td>";
echo "<td align=center><strong><a href=\"".$h."/admin/catalog/\">Каталог товаров</a></strong></td>";
echo "<td align=center><strong><a href=\"".$h."/admin/polzovateli/\">Пользователи</a></strong></td>";
echo "<td align=center><strong><a href=\"".$h."/admin/zakaz/\">Непроведённые заказы</a></strong></td>";
echo "<td align=center><strong><a href=\"".$h."/admin/archives/\">Архив заказов</a></strong></td>";
echo "<td align=center><strong><a href=\"".$h."/admin/logout/\">Выйти</a></td>";
echo "</tr></table><br><br>";
if(isset($_GET['action']))
{
if($_GET['action'] == "zakaz") include("admin/szakaz.php");
if($_GET['action'] == "archives") include("admin/sarchives.php");
if($_GET['action'] == "catalog") include("admin/scatalog.php");
if($_GET['action'] == "polzovateli") include("admin/spolzovateli.php");
}
}
else echo "<center>Администратора с данными параметрами входа не существует!<br><br></center>".$admin_login_form;
}
?>