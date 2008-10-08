<?
include "../language.php";
include "../config.php";
include "../common.php";

$database=Connect();

if ($HTTP_POST_VARS['id_genre']) {
  $var=$HTTP_POST_VARS;
  $result=mysql_query("UPDATE ".$db_prefix."genre SET name='".$var['name']."' WHERE id=".$var['id'].";");
  print" <center><h1>".$end."</h1>"; 
  if ($result) print $correct." (".$var['name'].")\n";
  print "<br><br><a href=\"index.php\"><img src=\"../img/back.png\" border=0></a></center>";

} else if ($HTTP_POST_VARS['id']) {
  $result=mysql_query("SELECT name FROM ".$db_prefix."genre WHERE id='".$HTTP_POST_VARS['id']."';");
  $arr = mysql_fetch_array ($result);
  mysql_free_result($result);
  print "<html><body>\n";
  print "<center><h1>".$e_genre."</h1><form action=\"edit_genre.php\" method=\"post\">\n";
  print "<input type=\"hidden\" name=\"id_genre\" value=1>\n";
  print "<input type=\"hidden\" name=\"id\" value=\"".$HTTP_POST_VARS['id']."\">\n";
  print "<table>\n";
  print "<tr><td>".$genre.": </td><td><input type=\"text\" name=\"name\" value=\"$arr[0]\"></td></tr>\n";
  print "</table>";
  print "<br><input type=\"submit\" value=\"$change\">";
  print "</form>\n";
  print "<br><a href=\"index.php\"><img src=\"../img/back.png\" border=0></a></center></body></html>";
  
} else {
  print "<html><body>\n";
  print "<center><h1>$e_genre</h1><form action=\"edit_genre.php\" method=\"post\">\n";
  print $genre.": <select name=\"id\">\n";
  $result=mysql_query("SELECT name,id FROM ".$db_prefix."genre ORDER BY name;");
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
