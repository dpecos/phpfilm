<?
include "../config.php";
if(!isset($lang) || empty($lang) || !file_exists("../lang/"."$lang".".php")) { $lang = "language_en"; }
include "../lang/"."$lang".".php";
include "../common.php";

if ($HTTP_POST_VARS['name']) {
  
  $database=Connect();
  $var=$HTTP_POST_VARS;
  print" <center><h1>".$end."</h1>"; 
  $sql="INSERT INTO ".$db_prefix."country VALUES (null,'".$var['name']."');";
  mysql_query($sql);
  $result=mysql_query("SELECT id FROM ".$db_prefix."country WHERE name='".$var['name']."';");
  if ($result) {
    $cod=mysql_fetch_array($result);
    print $correct." (".$var['name']." -> ".$cod[0].")\n";
    mysql_free_result($result);
  }
  print "<br><br><a href=\"index.php\"><img src=\"../img/back.png\" border=0></a></center>";

} else {
  print "<html><body>\n";
  print "<center><h1>".$n_country."</h1><form action=\"add_country.php\" method=\"post\">\n";
  print "<table>\n";
  print "<tr><td>".$country.": </td><td><input type=\"text\" name=\"name\"></td></tr>\n";
  print "</table>";
  print "<br><input type=\"submit\" value=\"$add\">";
  print "</form>\n";
  print "<br><a href=\"index.php\"><img src=\"../img/back.png\" border=0></a></center></body></html>";
}
?>
