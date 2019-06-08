<?
require_once("admin/config.php");
if (is_numeric($_GET['page']) > 0)
  {
    $query = DB::Query ("SELECT * FROM page WHERE id = '".$_GET['page']."' LIMIT 1");
        if (mysqli_num_rows($query))
          {
           $text = mysqli_fetch_assoc ($query);
           $top_title = htmlspecialchars($text['title']);
           
           require_once ("inc/head.inc.php");
           echo "<br /><table width=950 cellpadding=0 cellspacing=0 border=0 align=center><tr valign=top><td width=326>";
           require_once ("inc/category.inc.php");
           require_once ("inc/cart.inc.php");
           echo "</td><td width=624>";
           echo "<center><span class=\"bgray\">".$text['title']."</span></center><br /><br />";
           echo $text['text'];
           echo "</td></tr></table>";
           echo "</body></html>";
          }
        else echo "Запрашиваемая страница не найдена.";
  }
else echo "<HTML><HEAD><META HTTP-EQUIV='Refresh' CONTENT='0; URL=".$h."/'></HEAD></HTML>";
?>
