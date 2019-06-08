<?
require_once("admin/config.php");
if($_POST['search_word']) $search = $_POST['search_word'];
$search = strip_tags($search);
$search = trim($search);
{
require_once ("inc/head.inc.php");
?>
<br /><table width=950 cellpadding=0 cellspacing=0 border=0 align=center><tr valign=top><td width=326>

<?

require_once ("inc/category.inc.php");
require_once ("inc/cart.inc.php");
?>
</td><td width=624><center><h2>Поиск товаров по каталогу</h2></center><div style="padding-left:20px">

<?
if (!get_magic_quotes_gpc()) $search = DB::escape($search);else $search = str_replace("'","`",$search);
$query =  DB::Query("SELECT * FROM cat WHERE name LIKE '%".$search."%' OR short_review LIKE '%".$search."%' OR price LIKE '%".$search."%'");
if ($query) $count_rows = mysqli_num_rows ($query);
if (@$count_rows)
{	
echo "<center><h4>Вы искали \"".$search."\". Найдено позиций: [<strong>".$count_rows."</strong>]</h4></center>";
while($message =  mysqli_fetch_assoc($query))
{	
$message['name'] = eregi_replace($search, "<font color=\"red\"><strong>$search</strong></font>", $message['name']);
echo "&rarr; <a href =\"".$h."/cat/".$message['category']."/item/".$message['id']."/\">".$message['name']."</a><br />";
}
}
else echo "<h4>По Вашему запросу \"<strong>".$search."</strong>\" ничего не найдено.</h4>";
echo "</div></td></tr></table>";
echo "</body></html>";
}
?>