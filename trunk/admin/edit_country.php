<?
include "../config.php";
if(!isset($lang) || empty($lang) || !file_exists("../lang/"."$lang".".php")) { $lang = "language_en"; }
include "../lang/"."$lang".".php";
include "../common.php";

$database=Connect();

if ($HTTP_POST_VARS['id_country']) {
  $var=$HTTP_POST_VARS;
  $result=mysql_query("UPDATE ".$db_prefix."country SET name='".$var['name']."' WHERE id=".$var['id'].";");
  print" <center><h1>".$end."</h1>"; 
  if ($result) print $correct." (".$var['name'].")\n";
  print "<br><br><a href=\"index.php\"><img src=\"../img/back.png\" border=0></a></center>";

} else if ($HTTP_POST_VARS['id']) {
  $result=mysql_query("SELECT name FROM ".$db_prefix."country WHERE id='".$HTTP_POST_VARS['id']."';");
  $arr = mysql_fetch_array ($result);
  mysql_free_result($result);
  print "<html><body>\n";
  print "<center><h1>".$e_country."</h1><form action=\"edit_country.php\" method=\"post\">\n";
  print "<input type=\"hidden\" name=\"id_country\" value=1>\n";
  print "<input type=\"hidden\" name=\"id\" value=\"".$HTTP_POST_VARS['id']."\">\n";
  print "<table>\n";
  print "<tr><td>".$country.": </td><td><input type=\"text\" name=\"name\" value=\"$arr[0]\"></td></tr>\n";
  print "</table>";
  print "<br><input type=\"submit\" value=\"$change\">";
  print "</form>\n";
  print "<br><a href=\"index.php\"><img src=\"../img/back.png\" border=0></a></center></body></html>";
  
} else {
  print "<html><body>\n";
  print "<center><h1>$e_country</h1><form action=\"edit_country.php\" method=\"post\">\n";
  print $name.": <select name=\"id\">\n";
  $result=mysql_query("SELECT name,id FROM ".$db_prefix."country ORDER BY name;");
  while ($arr = mysql_fetch_array ($result))
    print "<option value=\"".$arr[1]."\">".$arr[0]."\n";
  print "</select>\n";
  mysql_free_result($result);
  print "<br><br><input type=\"submit\" value=\"$edit\">";
  print "</form>\n";
  print "<br><a href=\"index.php\"><img src=\"../img/back.png\" border=0></a></center></body></html>";
}

mysql_close($database);

?>
