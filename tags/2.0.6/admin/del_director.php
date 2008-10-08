<?
include "../language.php";
include "../config.php";
include "../common.php";

$database=Connect();

if ($HTTP_POST_VARS['id']) {
  
  $var=$HTTP_POST_VARS;
  print" <center><h1>$end</h1>";
  $result=mysql_query("SELECT name FROM ".$db_prefix."director WHERE id=".$var['id']);
  $cad=mysql_fetch_array ($result);
  mysql_free_result($result);
  $sql="DELETE FROM ".$db_prefix."director WHERE id='".$var['id']."';";
  $result=mysql_query($sql);
  if ($result) print $correct." (".$cad[0].")\n";
  print "<br><br><a href=\"index.php\"><img src=\"../img/back.png\" border=0></a></center>";
 
} else {
  print "<html><body>\n";
  print "<center><h1>$d_director</h1><form action=\"del_director.php\" method=\"post\">\n";
  print $name.": <select name=\"id\">\n";
  $result=mysql_query("SELECT name,id FROM ".$db_prefix."director ORDER BY name;");
  while($arr = mysql_fetch_array ($result))
    print "<option value=\"".$arr[1]."\">".$arr[0]." (".$arr[1].")\n";
  mysql_free_result($result);
  print "</select>\n";
  print "<br><br><input type=\"submit\" value=\"$del\">";
  print "</form>\n";
  print "<br><a href=\"index.php\"><img src=\"../img/back.png\" border=0></a></center></body></html>";
}
?>
