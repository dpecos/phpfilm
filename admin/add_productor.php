<?
/*
 *	PHPFilm
 *
 *	Copyright (C) 2002 Daniel Pecos Martínez
 *
 *	Licensed under GPL
 */
include "../language.php";
include "../config.php";
include "../common.php";

if ($HTTP_POST_VARS['name']) {
  
  $database=Connect();
  $var=$HTTP_POST_VARS;
  foreach($var as $key => $val) 
    if(!$val) $var[$key]="NULL";
  print" <center><h1>".$end."</h1>";
  $sql="INSERT INTO ".$db_prefix."productor VALUES (null,'".$var['name']."',".$var['country'].");";
  mysql_query($sql);
  $result=mysql_query("SELECT id FROM ".$db_prefix."productor WHERE name='".$var['name']."';");
  if ($result) {
    $cod=mysql_fetch_array($result);
    print $correct." (".$var['name']." -> ".$cod[0].")\n";
    mysql_free_result($result);
  }
  print "<br><br><a href=\"index.php\"><img src=\"../img/back.png\" border=0></a></center>";

} else {

  $database=Connect();
  print "<html><body>\n";
  print "<center><h1>".$n_productor."</h1><form action=\"add_productor.php\" method=\"post\">\n";
  print "<table>\n";
  print "<tr><td>".$name.": </td><td><input type=\"text\" name=\"name\"></td></tr>\n";
  print "<tr><td>".$country.": </td><td><select name=\"country\">\n";
  $result=mysql_query("SELECT name,id FROM ".$db_prefix."country ORDER BY name;");
  while ($arr=mysql_fetch_array($result))
    print "<option value=\"".$arr[1]."\">".$arr[0]."\n";
  mysql_free_result($result);
  print "</select></td></tr>\n";
  print "</table>";
  print "<br><input type=\"submit\" value=\"$add\">";
  print "</form>";
  print "<br><a href=\"index.php\"><img src=\"../img/back.png\" border=0></a></center></body></html>";
}
?>
