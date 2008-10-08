<?
include "../language.php";
include "../config.php";
include "../common.php";

$database=Connect();

if ($HTTP_POST_VARS['id_actor']) {
  $var=$HTTP_POST_VARS;
 
  if ($var['year']=='') $var['year']=0;
  if ($var['country']=='') $var['country']='null';
 
  $result=mysql_query("UPDATE ".$db_prefix."actor SET name='".$var['name']."', country=".$var['country'].", year=".$var['year']." WHERE id=".$var['id'].";");
  print" <center><h1>".$end."</h1>"; 
  if ($result) print $correct." (".$var['name'].")\n";
  print "<br><br><a href=\"index.php\"><img src=\"../img/back.png\" border=0></a></center>";

} else if ($HTTP_POST_VARS['id']) {
  $result=mysql_query("SELECT name,country,year FROM ".$db_prefix."actor WHERE id='".$HTTP_POST_VARS['id']."';");
  $arr = mysql_fetch_array ($result);
  mysql_free_result($result);
  print "<html><body>\n";
  print "<center><h1>".$e_actor."</h1><form action=\"edit_actor.php\" method=\"post\">\n";
  print "<input type=\"hidden\" name=\"id_actor\" value=1>\n";
  print "<input type=\"hidden\" name=\"id\" value=\"".$HTTP_POST_VARS['id']."\">\n";
  print "<table>\n";
  print "<tr><td>".$name.": </td><td><input type=\"text\" name=\"name\" value=\"$arr[0]\"></td></tr>\n";
  print "<tr><td>$country: </td><td><select name=\"country\">\n";
  $tmp_result=mysql_query("SELECT name,id FROM ".$db_prefix."country ORDER BY name;");
  print "<option value=\"\">\n";
  while ($arr2 = mysql_fetch_array ($tmp_result))
    if ($arr2[1]==$arr[1]) print "<option value=\"".$arr2[1]."\" selected>".$arr2[0]."\n";
    else print "<option value=\"".$arr2[1]."\">".$arr2[0]."\n";
  print "</select></td></tr>\n";
  mysql_free_result($tmp_result);
  if ($arr[2]==0) $arr[2]="";
  print "<tr><td>".$year.": </td><td><input type=\"text\" name=\"year\" value=\"$arr[2]\"></td></tr>\n";
  print "</table>";
  print "<br><input type=\"submit\" value=\"$change\">";
  print "</form>\n";
  print "<br><a href=\"index.php\"><img src=\"../img/back.png\" border=0></a></center></body></html>";
  
} else {
  print "<html><body>\n";
  print "<center><h1>$e_country</h1><form action=\"edit_actor.php\" method=\"post\">\n";
  print $name.": <select name=\"id\">\n";
  $result=mysql_query("SELECT name,id FROM ".$db_prefix."actor ORDER BY name;");
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
