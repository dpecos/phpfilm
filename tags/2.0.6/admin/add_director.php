<?
include "../init.php";
$page=page_order($page,"13");
include "../language.php";
include "../config.php";
include "../common.php";

if ($HTTP_POST_VARS['name']) {
  
  $database=Connect();
  $var=$HTTP_POST_VARS;
  foreach($var as $key => $val) {
    if(!$val) $var[$key]="NULL";
  }
  print "<html>\n";
  print "  <head>\n";
  print "    <META HTTP-EQUIV=Expires CONTENT=\"".date("D, j M Y G:i:s")." GMT\">\n";
  print "  </head>\n";
  print "  <body>\n";
  print" <center><h1>".$end."</h1>";
  $sql="INSERT INTO ".$db_prefix."director VALUES (null,'".$var['name']."',".$var['country'].",".$var['year'].");";
  mysql_query($sql);
  $result=mysql_query("SELECT id FROM ".$db_prefix."director WHERE name='".$var['name']."';");
  $id=mysql_fetch_array($result);
  mysql_free_result($result);
  if ($result) print $correct." (".$var['name']." -> ".$id[0].")\n";
  if ($HTTP_POST_VARS['id']) {
    mysql_query("INSERT INTO ".$db_prefix."director_film VALUES (null,".$HTTP_POST_VARS['id'].",".$id[0].");");
    print "<form action=\"edit_film.php\" method=\"post\">\n";
    print "<input type=\"hidden\" name=\"id\" value=\"".$HTTP_POST_VARS['id']."\">\n";
    print "<br><br><input type=\"image\" src=\"../img/back.png\">\n\n";
    print "</form></center>\n";
  } else print "<br><br><a href=\"index.php\"><img src=\"../img/back.png\" border=0></a></center>";

} else {

  $database=Connect();
  print "<html>\n";
  print "  <head>\n";
  print "    <META HTTP-EQUIV=Expires CONTENT=\"".date("D, j M Y G:i:s")." GMT\">\n";
  print "  </head>\n";
  print "  <body>\n";
  print "<center><h1>".$n_director."</h1><form action=\"add_director.php\" method=\"post\">\n";
  print "<table>\n";
  print "<tr><td>".$name.": </td><td><input type=\"text\" name=\"name\"></td></tr>\n";
  print "<tr><td>".$year.": </td><td><input type=\"text\" name=\"year\"></td></tr>\n";
  print "<tr><td>".$country.": </td><td><select name=\"country\">\n";
  $result=mysql_query("SELECT name,id FROM ".$db_prefix."country ORDER BY name;");
  print "<option value=\"\">\n";
  while($arr = mysql_fetch_array ($result))
    print "<option value=\"".$arr[1]."\">".$arr[0]."\n";
  print "</select></td></tr>\n";
  print "</table>";
  if ($HTTP_POST_VARS['id']) {
    print "<input type=\"hidden\" name=\"id\" value=\"".$HTTP_POST_VARS['id']."\">";
  }
  print "<br><input type=\"submit\" value=\"$add\">";
  print "</form>\n";
  if ($HTTP_POST_VARS['id']) {
    print "<form action=\"edit_film.php\" method=\"post\">\n";
    print "<input type=\"hidden\" name=\"id\" value=\"".$HTTP_POST_VARS['id']."\">\n";
    print "<br><input type=\"image\" src=\"../img/back.png\">\n";
    print "</form>\n";
    print "</center></body></html>\n";
  } else print "<br><a href=\"index.php\"><img src=\"../img/back.png\" border=0></a></center></body></html>";
}
?>
