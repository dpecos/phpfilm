<?
include "../config.php";
if(!isset($lang) || empty($lang) || !file_exists("../lang/"."$lang".".php")) { $lang = "language_en"; }
include "../lang/"."$lang".".php";
include "../common.php";

$database=Connect();
if ($HTTP_POST_VARS['title']) {

  $var=$HTTP_POST_VARS;
  foreach($var as $key => $val)
    if(!$val) $var[$key]="NULL";
  
  if (!$var['vo']) $var['vo']=0;
  if (!$var['image']) $var['image']=0;
  if ($var['web']=="http://") $var['web']="NULL";
  else $var['web']="'".$var['web']."'";
  if ($var['vo_title']!="NULL") $var['vo_title']="'".$var['vo_title']."'"; 
  if ($var['vo_lang']!="NULL") $var['vo_lang']="'".$var['vo_lang']."'"; 
  
  print" <center><h1>".$end."</h1>";
  $sql="INSERT INTO ".$db_prefix."film VALUES (null,'".$var['title']."','".$var['vo']."',".$var['vo_title'].",".$var['vo_lang'].",".$var['country'].",".$var['year'].",".$var['length'].",'".$var['format']."',".$var['web'].",".$var['genre'].",'".$var['image']."',now());";
  if (mysql_query($sql)) {
    if ($result=mysql_query("SELECT id FROM ".$db_prefix."film WHERE title='".$var['title']."';")) {
      $cod=mysql_fetch_array($result);
      print $correct." (".$var['title']." -> ".$cod[0].")\n";
      print "<br><br><form action=\"edit_film.php\" method=\"post\">\n";
      print "<input type=\"hidden\" name=\"id\" value=\"".$cod[0]."\">\n";
      print "<input type=\"submit\" value=\"".$edit."\"></form>\n";
      mysql_free_result($result);
    }
  }
  print "<br><br><a href=\"index.php\"><img src=\"../img/back.png\" border=0></a></center>";

} else {

  print "<html><body>\n";
  print "<center><h1>".$n_film."</h1><form action=\"add_film.php\" method=\"post\">\n";
  print "<table>\n";
  print "<tr><td>".$title.": </td><td><input type=\"text\" name=\"title\"></td></tr>\n";
  print "<tr><td>".$vo.":</td><td> <input type=\"checkbox\" name=\"vo\" value=\"1\"></td></tr>\n";
  print "<tr><td>".$vo_title.": </td><td><input type=\"text\" name=\"vo_title\"></td></tr>\n";
  print "<tr><td>".$vo_lang.": </td><td><input type=\"text\" name=\"vo_lang\"></td></tr>\n";
  print "<tr><td>".$genre.": </td><td><select name=\"genre\">\n";
  $result=mysql_query("SELECT name,id FROM ".$db_prefix."genre ORDER BY name;");
  while ($arr = mysql_fetch_array ($result)) 
    print "<option value=\"".$arr[1]."\">".$arr[0]."\n";
  mysql_free_result($result);
  print "</select></td></tr>\n";
  print "<tr><td>".$country.": </td><td><select name=\"country\">\n";
  $result=mysql_query("SELECT name,id FROM ".$db_prefix."country ORDER BY name;");
  print "<option value=\"NULL\">\n";
  while ($arr = mysql_fetch_array ($result)) 
    print "<option value=\"".$arr[1]."\">".$arr[0]."\n";
  mysql_free_result($result);
  print "</select></td></tr>\n";
  print "<tr><td>".$year.": </td><td><input type=\"text\" name=\"year\"></td></tr>\n";
  print "<tr><td>".$length.": </td><td><input type=\"text\" name=\"length\"></td></tr>\n";
  print "<tr><td>".$format.": </td><td><input type=\"text\" name=\"format\" value=\"DivX\"></td></tr>\n";
  print "<tr><td>".$web.": </td><td><input type=\"text\" name=\"web\" value=\"http://\"></td></tr>\n";
  print "</table>";
  print "<br><br><input type=\"submit\"  value=\"$add\">";
  print "</form>\n";
  print "<br><a href=\"index.php\"><img src=\"../img/back.png\" border=0></a></center></body></html>";
}
?>
