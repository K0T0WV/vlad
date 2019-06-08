<? 
require_once("admin/config.php");
require_once ("inc/head.inc.php");
echo "<br />
<table width=950 cellpadding=0 cellspacing=0 border=0 align=center>
<tr valign=top>
<td width=326>";
require_once ("inc/category.inc.php");
require_once ("inc/cart.inc.php");
echo "</td>
<td align=center width=624>";
////////////////////// ВЫВОД ФОРМЫ ДЛЯ ОФОРМЛЕНИЕ ЗАКАЗА ///////////////////////////////////////////
if (@$_GET['actions'] == "buy" && !@$_GET['op']) 
{
?>
<form method=post action="<?=$h?>/cart/buy/send/">
<div align="center" class="bgray">Заполните контактную форму:</div>
<br />
<table width="80%" class="gray b" border="0" cellpadding="15" cellspacing="12" align="center">
<tr valign="middle" bgcolor="#F9F9F9">
<td align="center">Ваше Ф.И.О.:<span class="bred">*</span><br />
<br />
<input type=text name=name size=50></td>
</tr>
<tr valign="middle" bgcolor="#F9F9F9">
<td align="center">Ваш телефон для подтверждения заказа:<span class="bred">*</span><br />
<br />
<input type=text name=phone size=50></td>
</tr>
<tr valign="middle" bgcolor="#F9F9F9">
<td align="center">E-mail, если есть:<br />
<br />
<input type=text name=email size=50></td>
</tr>
<tr valign="middle" bgcolor="#F9F9F9">
<td align="center">Комментарии к заказу:<br />
<br />
<textarea name=text rows="5" cols="49"></textarea>
</td>
</tr>
</table>
<br />
<div align="center" class="bred">Поля, обязательные для заполнения отмечены [*]</div>
<table width="80%" border="0" cellpadding="5" cellspacing="2" align="center">
<tr valign="middle">
<td align="center"><input type=submit value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Отправить заказ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" class="longok w50" ></td>
</tr>
</table>
</form>
<?
}
////////////////////// КОНЕЦ ВЫВОДА ФОРМЫ ДЛЯ ОФОРМЛЕНИЕ ЗАКАЗА //////////////////////////////////////////
////////////////////// ОФОРМЛЕНИЕ ЗАКАЗА /////////////////////////
else if (isset($_GET['op']) && $_GET['op'] == "send") 
{
{
} 
if ($_POST['name'] && $_POST['phone'])
{
$name = htmlspecialchars(substr($_POST['name'],0,250));
$phone = htmlspecialchars(substr($_POST['phone'],0,250));
if (isset($_POST['email'])) $email = htmlspecialchars(substr($_POST['email'],0,64));
if (isset($_POST['text'])) $text = htmlspecialchars(substr($_POST['text'],0,255));
$query = DB::Query("INSERT clients SET name = '".$name."', phone = '".$phone."', email = '".$email."', text = '".$text."', date = NOW()");
if (!$query) die("<center><strong>Не удалось занести Ваши данные в базу данных. Попробуйте еще раз</strong></center>");
$id_last_insert = mysqli_insert_id(DB::$link);
if ($query)
{
if ($_SESSION['tovar'])
{
foreach($_SESSION['tovar'] as $id_in_sess => $znachenie)
{
$query_1 = DB::Query("INSERT tovar SET id_clients = '".$id_last_insert."', id_tovara = '".$znachenie."', end = 'no', date = NOW(), time = NOW()");
if (!$query_1) die("<center><strong>Не удалось занести заказ в базу данных. Попробуйте еще раз</strong></center>");
}
}
else die("<center><strong>Не удалось занести заказ в базу данных. Попробуйте еще раз</strong></center>"); 

// выбираем товары последнего клиента
$query_2 = DB::Query("SELECT * FROM tovar WHERE id_clients = '".$id_last_insert."'"); 
if (mysqli_num_rows($query_2))
{
while($all_tovars = mysqli_fetch_array($query_2))
{                                                         

  // выбираем товары
$query_3 = DB::Query ("SELECT * FROM cat WHERE id = '".$all_tovars['id_tovara']."'");
if (mysqli_num_rows($query_3))
{	
while ($tovar_for_mail = mysqli_fetch_array ($query_3))
{
}
}
}
echo "<br /><br /><br /><center><strong>Спасибо за заказ. Менеджер свяжется с Вами в ближайшее время</strong></center>";	
$summa = 0;
$send = "";
}
}
else {echo "<br /><br /><br /><br /><center><strong>Не удалось занести заказ в базу данных!</strong></center>";}
}
else die ("<br /><br /><br /><br /><center><strong>Недостаточно введенных данных, для оформления заказа!</strong></center>");
}
////////////////////// КОНЕЦ БЛОКА ОФОРМЛЕНИЯ ЗАКАЗА ////////

////////////////////// УДАЛЕНИЕ ОДНОЙ ПОЗИЦИИ ИЗ КОРЗИНЫ ///////////////////////////////////////////
elseif (isset($_GET['actions']) && $_GET['actions'] == "drop_id" && isset($_GET['id_pos_in_sess'])) 
{
if (is_numeric($_GET['id_pos_in_sess']))
{	
$get_id_pos = $_GET['id_pos_in_sess'];
foreach($_SESSION['tovar'] as $id_in_sess => $znachenie) 
{
if ($id_in_sess == $get_id_pos) 
unset($_SESSION['tovar'][$id_in_sess]); // удаляем эту позицию из сессии
echo "<HTML><HEAD><META HTTP-EQUIV='Refresh' CONTENT='0; URL=".$h."/cart/'></HEAD></HTML>";
}
}
else { echo "кривой запрос!"; }
}
////////////////////// КОНЕЦ БЛОКА УДАЛЕНИЯ ОДНОЙ ПОЗИЦИИ ИЗ КОРЗИНЫ /////////////

////////////////////// ОЧИСТКА КОРЗИНЫ ///////////////////////////////////////////
else if (isset($_GET['actions']) && $_GET['actions'] == "clear_cart") 
{
unset($_SESSION['tovar']); // очищаем
echo "<HTML><HEAD><META HTTP-EQUIV='Refresh' CONTENT='0; URL=".$h."/cart/'></HEAD></HTML>";
}
//////////////////////КОНЕЦ БЛОКА ОЧИСТКИ КОРЗИНЫ //////////////////////////////////////

////////////////////// ВЫВОД ПОЗИЦИЙ ТОВАРОВ ///////////////////////////////////////////
else if (!$_GET) // если в GETе ничего не пришло, коннектимся к БД и выводим инфу
{
if (isset($_SESSION['tovar']) && $_SESSION['tovar'] != "")
{
$summa = 0;
echo "<center><span class=\"bgray\">Корзина покупателя</center><br />";
echo "<table width=100% align=center border=0 cellpadding=10 cellspacing=3><tr valign=top bgcolor=#F9F9F9>";
echo "<td width=40% valign=top><center><span class=\"bgreen\">Наименование</span></center>";
echo "</td>";
echo "<td width=35% valign=top><center><span class=\"bgreen\">Категория</span></center>";
echo "</td>";
echo "<td width=20% valign=top><center><span class=\"bgreen\">Цена</span></center>";
echo "</td>";
echo "<td width=5% valign=top> ";
echo "</td></tr>";
foreach($_SESSION['tovar'] as $id_in_sess => $znachenie) //перебираем массив
{
$count_pos = count($_SESSION['tovar']);  // считаем общую сумму за товары в корзине
$total_price = DB::Query("SELECT SUM(price) AS total_price FROM cat where id = '".$znachenie."'");
$sum = mysqli_fetch_array($total_price); // выводим инфу о товарах	
$query = DB::Query("select * from cat where id = '".$znachenie."'"); 
$ar= mysqli_fetch_array ($query);
$num = mysqli_num_rows ($query); // узнаем категорию товара	
$query_cat = DB::Query("select * from categories where id = '".$ar['category']."'");
$ar_cat = mysqli_fetch_array ($query_cat);
echo "<tr valign=top>";
echo "<td width=40% valign=top bgcolor=#FFFFFF>";
echo "<a href=\"".$h."/cat/".$ar_cat['id']."/item/".$znachenie."/\">";
echo "<span class=\"gray decor\">".$ar['name']."</span>";
echo "</a>";
echo "</td>";
echo "<td width=35% valign=top bgcolor=#FFFFFF>";
echo "<a href=\"".$h."/cat/".$ar_cat['id']."/\"><span class=\"orange decor\">".$ar_cat['category_name']."</span></a>";
echo "</td>";
echo "<td width=20% valign=top bgcolor=#FFFFFF align=center>";
echo "<span class=\"red b\">".$ar['price']."</span> <span class=\"gray b\">руб.</span>";
echo "</td>";
$summa = $summa + $ar['price'];
echo "<td width=5% bgcolor=#FFFFFF align=center>";
echo "<a href=\"".$h."/cart/drop_id/".$id_in_sess."/\" title=\"Удалить это наименование из корзины\">
<img alt=\"Удалить это наименование из корзины\" src=\"".$im."/drop.gif\">
</a>";
echo "</td></tr>";
}
echo "</table>";
}
if (@$num > 0)
{
echo "<center>";
echo "<br><span class=\"gray b\">Позиций в Вашей корзине:</span> <span class=\"red b\">".$count_pos."</span> <span class=\"gray b\">, на сумму</span> <span class=\"red b\">".$summa." руб.</span><br /><br /> 
<a href=\"".$h."/cart/buy/\"><span class=\"green b\"><img src=\"".$im."/more.gif\"></span></a>";
echo "<br /><br><a href=\"".$h."/cart/clear_cart/\"><span class=\"orange\">Очистить корзину</span></a> ";
echo "</center>";
}
else echo "<br /><br /><br /><center><strong>Ваша корзина пуста.</strong></center>";
}
////////////////////// КОНЕЦ БЛОКА ВЫВОДА ПОЗИЦИЙ ТОВАРОВ ///////////////////////////////////////////

else echo "<HTML><HEAD><META HTTP-EQUIV='Refresh' CONTENT='0; URL=".$h."/'></HEAD></HTML>";
echo "</td></tr></table>";
echo "</body></html>";
?>