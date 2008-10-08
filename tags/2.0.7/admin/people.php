<?
include "../config.php";
if(!isset($lang) || empty($lang) || !file_exists("../lang/"."$lang".".php")) { $lang = "language_en"; }
include "../lang/"."$lang".".php";
include "../common.php";

$var=$HTTP_POST_VARS;
$db=Connect();
print "<html><body><center>\n";
print "<h1>$t_loan</h1>\n";

if ($var['del_prest']!="") {
  $result=mysql_query("DELETE FROM ".$db_prefix."loan WHERE film_id='".$var['del_prest']."';");
} else if ($var['add_prest']) {
  $result=mysql_query("INSERT INTO ".$db_prefix."loan VALUES (null,".$var['film_id'].",'".$var['user']."',now());");
}
if ($var['del_user']!="") {
  $result=mysql_query("DELETE FROM ".$db_prefix."loan WHERE person_id=".$var['del_user'].";");
  $result=mysql_query("DELETE FROM ".$db_prefix."person WHERE id=".$var['del_user'].";");
}
if ($var['user']) {
  if ($var['add_user']) {
    $result=mysql_query("INSERT INTO ".$db_prefix."person VALUES (null,'".$var['user']."','".$var['phone']."','".$var['email']."');");
    $result=mysql_query("SELECT id FROM ".$db_prefix."person WHERE name='".$var['user']."';");
    $arr=mysql_fetch_array($result);
    $var['user']=$arr[0];
    mysql_free_result($result);
  }
  print "<center><h3></h3></center>\n";
  if ($result=mysql_query("SELECT name,phone,email,id FROM ".$db_prefix."person WHERE id='".$var['user']."' ORDER BY 1;")) {
    $arr = mysql_fetch_array ($result);
    print "<table border=0>\n";
    print "<tr><td>".$name."</td><td>&nbsp;&nbsp;</td><td><b>".$arr[0]."</b></td></tr>\n";
    print "<tr><td>".$phone."</td><td>&nbsp;&nbsp;</td><td>".$arr[1]."</td></tr>\n";
    print "<tr><td>".$email."</td><td>&nbsp;&nbsp;</td><td>".$arr[2]."</td></tr>\n";
    print "</table>\n";
    print "<br><table border=0>\n";
    if ($tmp_result=mysql_query("SELECT f.title, f.id, l.loan_date FROM ".$db_prefix."film f, ".$db_prefix."loan l WHERE  f.id=l.film_id AND l.person_id=".$var['user']." ORDER BY 1;")) {
      while($arr = mysql_fetch_array ($tmp_result)) {
        print "<tr><td align=\"left\">".$arr[0]."</td><td>&nbsp;&nbsp;&nbsp;</td><td>(".$arr[2].")</td><td>&nbsp;&nbsp;</td>";
        print "<td><form action=\"people.php\" method=\"post\">\n";
        print "<input type=\"hidden\" name=\"del_prest\" value=\"".$arr[1]."\">\n";
        print "<input type=\"hidden\" name=\"user\" value=\"".$var['user']."\">\n";
        print "<input type=\"submit\" value=\"".$del."\"></form>\n";
        print "</td></tr>\n";
      }
      $num=mysql_num_rows($tmp_result);
      mysql_free_result($tmp_result);
    }
    print "</table>\n"; 
    print "<br><h3><font color=\"".$title_color."\">(".$num." ".$count.")</font></h3>\n";
    print "<br><br><center>\n";
    print "<form action=\"people.php\" method=\"post\">\n";
    print "<select name=\"film_id\">\n";
    if ($tmp_result2=mysql_query("SELECT title,id FROM ".$db_prefix."film ORDER BY 1;")) {
      for ($num_row=0; $num_row < mysql_num_rows($tmp_result2); $num_row++) {
        $arr2 = mysql_fetch_array ($tmp_result2);
        $tmp_result3=mysql_query("SELECT id FROM ".$db_prefix."loan WHERE film_id=".$arr2[1].";");
        if (!mysql_num_rows($tmp_result3))
          print "<option value=\"".$arr2[1]."\">".$arr2[0]."\n";
        mysql_free_result($tmp_result3);
      }
      mysql_free_result($tmp_result2);
    }
    print "</select>&nbsp;&nbsp;&nbsp;\n";
    print "<input type=\"hidden\" name=\"add_prest\" value=1>\n";
    print "<input type=\"hidden\" name=\"user\" value=\"".$var['user']."\">\n";
    print "<input type=\"submit\" value=\"".$add."\"></form>\n";
    mysql_free_result($result);
  } else { print "<center><b>$no_user</b></center>"; }
    print "<br><a href=\"people.php\"><img src=\"../img/back.png\" border=0></a>\n";
} else if ($var['add_user_s']) {
  print "<form action=\"people.php\" method=\"post\">\n";
  print "<h3>$add_person</h3><table>\n";
  print "<tr><td align=\"right\">$name</td><td>&nbsp;&nbsp;</td><td><input type=\"text\" name=\"user\"></td></tr>\n";
  print "<tr><td align=\"right\">$phone</td><td></td><td><input type=\"text\" name=\"phone\"></td></tr>\n";
  print "<tr><td align=\"right\">$email</td><td></td><td><input type=\"text\" name=\"email\"></td></tr>\n";
  print "<tr><td colspan=3 align=\"center\"><br><br><input type=\"submit\" value=\"$add\"></td></tr>\n";
  print "</table>\n";
  print "<input type=\"hidden\" name=\"add_user\" value=1>\n";
  print "</form><br>\n";	
  print "<br><a href=\"people.php\"><img src=\"../img/back.png\" border=0></a>\n";
} else {
  print "<center><h3>$people</h3></center>\n";
  print "<br><table border=0>\n";
  if ($result=mysql_query("SELECT name,id FROM ".$db_prefix."person ORDER BY name;")) {
  for ($num_row=0; $num_row < mysql_num_rows($result); $num_row++) {
    $arr = mysql_fetch_array ($result);
    print "<tr><td align=\"center\">".$arr[0]."</td><td>&nbsp;&nbsp;</td>";
    print "<td><form action=\"people.php\" method=\"post\">\n";
    print "<input type=\"hidden\" name=\"user\" value=\"".$arr[1]."\">\n";
    print "<input type=\"submit\" value=\"".$view."\">\n";
    print "</form></td><td>&nbsp;&nbsp;</td>\n";
    print "<td><form action=\"people.php\" method=\"post\">\n";
    print "<input type=\"hidden\" name=\"del_user\" value=\"".$arr[1]."\">\n";
    print "<input type=\"submit\" value=\"".$del."\">\n";
    print "</form></td></tr>\n";
  }
  mysql_free_result($result);
  }
  print "</table><br><br>\n";
  print "<center><form action=\"people.php\" method=\"post\">\n";
  print "<input type=\"hidden\" name=\"add_user_s\" value=1>\n";
  print "<input type=\"submit\" value=\"$add\"></form></center>\n";
  print "<br><a href=\"index.php\"><img src=\"../img/back.png\" border=0></a>\n";
}
  print "</center></body></html>\n";
  mysql_close($db);
?>
