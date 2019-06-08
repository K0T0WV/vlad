<?
require_once("admin/config.php");
if (@$_GET['actions'] == "add_to_cart")
{
if (!is_numeric($_GET['item'])) echo "кривой запрос!";
else
{
$_SESSION['tovar'][] = $_GET['item'];
echo "<SCRIPT LANGUAGE=javascript>history.back()</SCRIPT>";
}
}
/////////////////////////////////// ВЫВОД СПИСКА ТОВАРОВ ////////////////////////////////////
elseif (is_numeric($_GET['id_category']) > 0 && !@$_GET['item'])
{
$num = mysqli_num_rows(DB::Query("SELECT * FROM cat WHERE category = '".$_GET['id_category']."'"));
@$start = page_list ($_GET['page'], $num, $COUNT_SHOW_ITEMS);
$query_cat = DB::Query("SELECT * FROM categories WHERE id = '".$_GET['id_category']."'");
$echo_cat = mysqli_fetch_assoc($query_cat);
$top_title = htmlspecialchars($echo_cat['category_name']);

require_once ("inc/head.inc.php");
echo "<br />
<table width=950 cellpadding=0 cellspacing=0 border=0 align=center>
<tr valign=top>
<td width=326>";
require_once ("inc/category.inc.php");
require_once ("inc/cart.inc.php");
echo "</td><td width=624>";	
$root_category = $echo_cat['root_category'];
while($root_category != 0)
{ 
$query_root_category = DB::Query("SELECT * FROM categories WHERE id = '".$root_category."'");
$cat = mysqli_fetch_assoc($query_root_category); 
$root_category = $cat['root_category']; 
$links[] = "<a href=\"".$h."/cat/".$cat['id']."/\"><span class=\"green b nd\">".$cat['category_name']."</span></a>&nbsp;&rarr;&nbsp;";
}
if (is_array(@$links)) echo implode(" ", array_reverse($links));
if ($echo_cat['root_category'] != 0) echo " <a href=\"".$h."/cat/".$_GET['id_category']."/\"><span class=\"green b nd\">".$echo_cat['category_name']."</span></a><br />";
echo "<br><center><span class=\"bgray nd\">".$echo_cat['category_name']."</span><br />";
$query_subcat = DB::Query ("SELECT * FROM categories WHERE root_category = '".$_GET['id_category']."' ORDER by category_name");
if (mysqli_num_rows($query_subcat))
{
echo "<br />";
while($cat = mysqli_fetch_assoc($query_subcat)) echo "<a href=\"".$h."/cat/".$cat['id']."/\" title=\"".$cat['category_name']."\"><strong class=\"orange decor\">".$cat['category_name']."</strong></a>&nbsp;&nbsp;&nbsp;";
}
echo "<br /><br />";
$query = DB::Query ("SELECT * FROM cat WHERE category = '".$_GET['id_category']."' LIMIT $start,$COUNT_SHOW_ITEMS");
if(mysqli_num_rows($query))
{
echo "<table width=100% align=center border=0 cellpadding=10 cellspacing=10><tr valign=top>";
$td = "0";
if ($COUNT_SHOW_ROWS == 2) $width = "50%";
elseif ($COUNT_SHOW_ROWS == 3) $width = "33%";
elseif ($COUNT_SHOW_ROWS == 4) $width = "25%";
elseif ($COUNT_SHOW_ROWS == 5) $width = "20%";
elseif ($COUNT_SHOW_ROWS == 1) $width = "100%";
while($item = mysqli_fetch_assoc($query))
{
echo "<td width=$width% valign=top bgcolor=\"#F9F9F9\">";
echo "<center><a href=\"".$h."/cat/".$item['category']."/item/".$item['id']."/\" title = \"".$item['name']."\"><strong class=\"green up nd\">".$item['name']."</strong></a></center><br />";
echo $item['short_review']."</span><br /><br />";
echo "<div align=right>
&nbsp;&nbsp;&nbsp;
<span class=\"bred up\">".$item['price']."</span> <span class=\"bgray\">руб.</span><br /><a href=\"".$h."/cat/".$item['category']."/item/".$item['id']."/add_to_cart/\" target=_self><img src=\"".$im."/more.gif\"></a></div><br />";
echo "</td>";
$td++;
if ($td == $COUNT_SHOW_ROWS) { echo "</tr><tr>"; $td = "0"; }
}
echo "</tr></table>";
@show_page_list($_GET['page'], $num, $COUNT_SHOW_ITEMS, $_GET['id_category']);
}
else echo "В данной категории нет товаров";
echo "</td>
</tr>
</table>";
echo "</body>
</html>";
}
/////////////////////////////////// ВЫВОД ОПИСАНИЯ ТОВАРА И КНОПКИ ПОКУПКИ ////////////////////////////////////
elseif(is_numeric($_GET['id_category']) > 0 && is_numeric($_GET['item']) > 0)
{
$query = DB::Query ("SELECT * FROM cat WHERE id = '".$_GET['item']."' LIMIT 1");
$details = mysqli_fetch_array($query);
$query_cat = DB::Query("SELECT * FROM categories WHERE id = '".$_GET['id_category']."'");
$echo_cat = mysqli_fetch_assoc($query_cat);
$top_title = htmlspecialchars($echo_cat['category_name']." | ".$details['name']);
$top_description = htmlspecialchars($echo_cat['category_name']." | ".$details['name']." | ".$details['short_review']);
require_once ("inc/head.inc.php");
echo "<br />
<table width=950 cellpadding=0 cellspacing=0 border=0 align=center>
<tr valign=top>
<td width=326>";
require_once ("inc/category.inc.php");
require_once ("inc/cart.inc.php");
echo "</td><td width=624>";	
$root_category = $echo_cat['root_category'];
while($root_category != 0)
{ 
$query_root_category = DB::Query("SELECT * FROM categories WHERE id = '".$root_category."'");
$cat = mysqli_fetch_assoc($query_root_category); 
$root_category = $cat['root_category']; 
$links[] = "<a href=\"".$h."/cat/".$cat['id']."/\"><span class=\"green b nd\">".$cat['category_name']."</span></a>&nbsp;&rarr;&nbsp;";
}
if (is_array(@$links)) echo implode(" ", array_reverse($links));
if ($echo_cat['root_category'] != 0) echo " <a href=\"".$h."/cat/".$_GET['id_category']."/\"><span class=\"green b nd\">".$echo_cat['category_name']."</span></a><br />";
// выводим категорию, которая открыта в данный момент
echo "<br><center><span class=\"bgray nd\">".$echo_cat['category_name']."</span><br />";
$query_subcat = DB::Query ("SELECT * FROM categories WHERE root_category = '".$_GET['id_category']."' ORDER by category_name");
if (mysqli_num_rows($query_subcat))
{
echo "<br />";
while($cat = mysqli_fetch_assoc($query_subcat)) echo "<a href=\"".$h."/cat/".$cat['id']."/\" title=\"".$cat['category_name']."\"><strong class=\"orange decor\">".$cat['category_name']."</strong></a>&nbsp;&nbsp;&nbsp;";
}
echo "<br /><br />";
echo "<table width=100% align=center border=0 cellpadding=10 cellspacing=10><tr valign=top><td>";
echo "<center><strong class=\"green up nd\">".$details['name']."</strong></center><br />";
echo "<span class=\"gray\">".$details['short_review']."</span><br /><br />";
echo "<span class=\"bgray\">Стоимость</span> <span class=\"bred up\">".$details['price']."</span> <span class=\"bgray\">руб.</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"".$h."/cat/".$details['category']."/item/".$details['id']."/add_to_cart/\" target=_self><img src=\"".$im."/more.gif\"></a>";
echo "</td>";
echo "</td></tr></table>";
echo "</td></tr></table>";
echo "</body></html>";
}
else echo "<HTML><HEAD><META HTTP-EQUIV='Refresh' CONTENT='0; URL=".$h."/'></HEAD></HTML>";
?>
</body>
</html>