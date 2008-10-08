<?
include "../config.php";
if(!isset($lang) || empty($lang) || !file_exists("../lang/"."$lang".".php")) { $lang = "language_en"; }
include "../lang/"."$lang".".php";
include "../common.php";

$database=Connect();

if ($HTTP_POST_VARS['id']) {
  
  $var=$HTTP_POST_VARS;
  print" <center><h1>$end</h1>";
  $result=mysql_query("SELECT title,image FROM ".$db_prefix."film WHERE id=".$var['id']);
  $cad=mysql_fetch_array ($result);
  mysql_free_result($result);
  mysql_query("DELETE FROM ".$db_prefix."actor_film WHERE film_id='".$var['id']."';");
  mysql_query("DELETE FROM ".$db_prefix."director_film WHERE film_id='".$var['id']."';");
  mysql_query("DELETE FROM ".$db_prefix."argument WHERE film_id='".$var['id']."';");
  mysql_query("DELETE FROM ".$db_prefix."loan WHERE film_id='".$var['id']."';");
  mysql_query("DELETE FROM ".$db_prefix."film WHERE id='".$var['id']."';");
  
  if ($cad[1]=="1") unlink($path."/img/film/".$var['id'].".jpg");
  $result=mysql_query("SELECT title,image FROM ".$db_prefix."film WHERE id=".$var['id']);
  if (mysql_num_rows($result)==0) print $correct." (".$cad[0].") \n";
  else mysql_free_result($result);
  print "<br><br><a href=\"index.php\"><img src=\"../img/back.png\" border=0></a></center>";
 
} else {
  print "<html><body>\n";
  print "<center><h1>$d_film</h1><form action=\"del_film.php\" method=\"post\">\n";
  print $title.": <select name=\"id\">\n";
  $result=mysql_query("SELECT title,id FROM ".$db_prefix."film ORDER BY title;");
  while ($arr = mysql_fetch_array ($result))
    print "<option value=\"".$arr[1]."\">".$arr[0]." (".$arr[1].")\n";
  mysql_free_result($result);
  print "</select>\n";
  print "<br><br><input type=\"submit\" value=\"$del\">";
  print "</form>\n";
  print "<br><a href=\"index.php\"><img src=\"../img/back.png\" border=0></a></center></body></html>";
}
?>
