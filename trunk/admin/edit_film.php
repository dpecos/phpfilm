<?
include "../init.php";
$page=page_order($page,"34");
include "../config.php";
include "../language.php";
include "../common.php";

$database=Connect();

if($HTTP_POST_VARS['add_director']) {
  $var=$HTTP_POST_VARS;
  $result=mysql_query("INSERT INTO ".$db_prefix."director_film VALUES (null,".$var['id'].",".$var['add_director'].");");
} 

if($HTTP_POST_VARS['add_actor']) {
  $var=$HTTP_POST_VARS;
  $result=mysql_query("INSERT INTO ".$db_prefix."actor_film VALUES (null,".$var['id'].",".$var['add_actor'].");");
} 

if($HTTP_POST_VARS['del_director']) {
  $result=mysql_query("DELETE FROM ".$db_prefix."director_film WHERE id='".$HTTP_POST_VARS['del_director']."';");
} 

if($HTTP_POST_VARS['del_actor']) {
  $result=mysql_query("DELETE FROM ".$db_prefix."actor_film WHERE id='".$HTTP_POST_VARS['del_actor']."';");
} 

if($HTTP_POST_VARS['add_argument']) {
  $var=$HTTP_POST_VARS;
  $result=mysql_query("DELETE FROM ".$db_prefix."argument WHERE film_id=".$var['id'].";");
  if ($var['add_argument']!="") $result=mysql_query("INSERT INTO ".$db_prefix."argument VALUES (null,".$var['id'].",'".$var['add_argument']."');");
}  

if($HTTP_POST_VARS['del_argument']) {
  $var=$HTTP_POST_VARS;
  $result=mysql_query("DELETE FROM ".$db_prefix."argument WHERE film_id=".$var['id'].";");
}

if ($HTTP_POST_VARS['title']) {
  $var=$HTTP_POST_VARS;
  foreach($var as $key => $val) 
    if(!$val) $var[$key]="NULL";
  if ($var['web']=="http://" || $var['web']=="") $var['web']="NULL";
  else $var['web']="'".$var['web']."'";
  if ($var['vo_lang']!="NULL") $var['vo_lang']="'".$var['vo_lang']."'";
  if ($var['vo_title']!="NULL") $var['vo_title']="'".$var['vo_title']."'";
  if ($var['country']==0) $var['country']="NULL";
  if ($var['year']==0) $var['year']="NULL";
  if ($var['length']==0) $var['length']="NULL";
 
  if ($var['vo']!="1") $var['vo']="0";
  
  $sql="UPDATE ".$db_prefix."film SET title='".$var['title']."', vo=".$var['vo'].", vo_title=".$var['vo_title'].", vo_lang=".$var['vo_lang'].", country=".$var['country'].", year=".$var['year'];
  $sql=$sql.", length=".$var['length'].", format='".$var['format']."', web=".$var['web'].", genre=".$var['genre'];
  $result=mysql_query("SELECT image FROM ".$db_prefix."film WHERE id=".$var['id'].";");
  $arr = mysql_fetch_assoc ($result);
  mysql_free_result($result);
  $sql=$sql.", image=".$arr['image']." WHERE id=".$var['id'].";";
  $result=mysql_query($sql);
}

if ($edit_image) {

  $var=$HTTP_POST_VARS;
  $result=mysql_query("SELECT image FROM ".$db_prefix."film WHERE id=".$var['id'].";");
  $film=mysql_fetch_assoc($result);
  mysql_free_result($result);
  
  if ($image!="") {
    
    if (file_exists($path."/img/film/".$var['id'].".jpg"))
      unlink($path."/img/film/".$var['id'].".jpg");

    if (copy($image,$path."/img/film/".$var['id'].".jpg")) 
      if ($film['image']=="0")
        mysql_query("UPDATE ".$db_prefix."film SET image=1 WHERE id=".$var['id'].";");
  
  } else { 
  
    if (file_exists($path."/img/film/".$var['id'].".jpg"))
      unlink($path."/img/film/".$var['id'].".jpg");
    if ($film['image']=="1") 
      mysql_query("UPDATE ".$db_prefix."film SET image=0 WHERE id=".$var['id'].";");
  }
}

if ($HTTP_POST_VARS['id']) {
 
  $var=$HTTP_POST_VARS;
  $result=mysql_query("SELECT * FROM ".$db_prefix."film WHERE id=".$var['id'].";");
  $film=mysql_fetch_assoc($result);
  print "<html>\n";
  print "  <head>\n";
  print "    <META HTTP-EQUIV=Expires CONTENT=\"".date("D, j M Y G:i:s")." GMT\">\n";
  print "  </head>\n";
  print "  <body>\n";
  print "<center><h1>$e_film</h1>\n";
  print "<table width=\"80%\"><tr><td width=\"40%\" align=\"center\">\n";
  if ($film['image']=="1")
    print "<img src=\"../img/film/".$var['id'].".jpg\" width=\"95%\">\n";
  else print "<img src=\"../img/noimg.gif\" width=\"95%\">\n";
  print "<br><br><br><br><form action=\"edit_film.php\" method=\"post\" enctype=\"multipart/form-data\">\n";
  print "<input type=\"hidden\" name=\"id\" value=\"".$var['id']."\">\n";
  print "<input type=\"hidden\" name=\"edit_image\" value=\"1\">\n";
  print "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"600000\">\n";
  print "<input type=\"file\" name=\"image\" value=\"-\"><br><br><input type=\"submit\" value=\"$send\">\n";
  print "</form></td>\n";
  
  
  print "<td width=\"60%\" align=\"center\" valign=\"top\">\n";
  print "<h3><font color=\"#0000FF\">$t_data</font></h3>\n";
  print "<form action=\"edit_film.php\" method=\"post\">\n";
  print "<input type=\"hidden\" name=\"id\" value=\"".$var['id']."\">\n";
  print "<table align=\"center\">\n";
  print "<tr><td>$title: </td><td><input type=\"text\" name=\"title\" value=\"".$film['title']."\"></td></tr>\n";
  if ($film['vo']=='1') print "<tr><td>$vo:</td><td> <input type=\"checkbox\" name=\"vo\" value=\"1\" checked></td></tr>\n";
  else print "<tr><td>$vo:</td><td> <input type=\"checkbox\" name=\"vo\" value=\"1\"></td></tr>\n";
  print "<tr><td>$vo_title: </td><td><input type=\"text\" name=\"vo_title\" value=\"".$film['vo_title']."\"></td></tr>\n";
  print "<tr><td>$vo_lang: </td><td><input type=\"text\" name=\"vo_lang\" value=\"".$film['vo_lang']."\"></td></tr>\n";
  print "<tr><td>$genre: </td><td><select name=\"genre\">\n";
  $tmp_result=mysql_query("SELECT name,id FROM ".$db_prefix."genre ORDER BY name;");
  while($arr = mysql_fetch_array ($tmp_result)) {
    if ($film['genre']==$arr[1]) print "<option value=\"".$arr[1]."\" selected>".$arr[0]."\n";
    else print "<option value=\"".$arr[1]."\">".$arr[0]."\n";
  }
  mysql_free_result($tmp_result);
  print "</select></td></tr>\n";
  print "<tr><td>$country: </td><td><select name=\"country\">\n";
  $tmp_result=mysql_query("SELECT name,id FROM ".$db_prefix."country ORDER BY name;");
  print "<option value=\"NULL\">\n";
  while($arr = mysql_fetch_array ($tmp_result)) {
    if ($arr[1]==$film['country']) print "<option value=\"".$arr[1]."\" selected>".$arr[0]."\n";
    else print "<option value=\"".$arr[1]."\">".$arr[0]."\n";
  }
  mysql_free_result($tmp_result);
  print "</select></td></tr>\n";
  print "<tr><td>$year: </td><td><input type=\"text\" name=\"year\" value=\"".$film['year']."\"></td></tr>\n";
  print "<tr><td>$length: </td><td><input type=\"text\" name=\"length\" value=\"".$film['length']."\"></td></tr>\n";
  print "<tr><td>$format: </td><td><input type=\"text\" name=\"format\" value=\"".$film['format']."\"></td></tr>\n";
  if ($film['web']=='') 
    print "<tr><td>$web: </td><td><input type=\"text\" name=\"web\" value=\"http://\"></td></tr>\n";
  else
    print "<tr><td>$web: </td><td><input type=\"text\" name=\"web\" value=\"".$film['web']."\"></td></tr>\n";
  print "</table>";
  print "<br><input type=\"submit\" value=\"$change\">";
  print "</form><br>\n";
  print "</td></tr><tr><td colspan=2><table width=\"100%\">\n";


  print "<tr><td width=\"50%\" align=\"center\" valign=\"top\">";
  print "<h3><font color=\"#0000FF\">$t_director</font></h3>\n";
  $tmp_result=mysql_query("SELECT df.id,df.director_id,d.name FROM ".$db_prefix."director_film df, ".$db_prefix."director d WHERE df.film_id=".$var['id']." AND df.director_id=d.id;");
  while($arr = mysql_fetch_assoc($tmp_result)) {
    print "<form action=\"edit_film.php\" method=\"post\">\n";
    print "<input type=\"hidden\" name=\"id\" value=\"".$var['id']."\">\n";
    print "<input type=\"hidden\" name=\"del_director\" value=\"".$arr['id']."\">\n";
    print "<b>".$arr['name']."</b>&nbsp;&nbsp;<input type=\"submit\" value=\"$del\">";
    print "</form><br>\n";
  }
  mysql_free_result($tmp_result);
  print "<form  action=\"edit_film.php\" method=\"post\">\n";
  print "<input type=\"hidden\" name=\"id\" value=\"".$var['id']."\">\n";
  print $new.":&nbsp;&nbsp;<select name=\"add_director\">\n";
  if($tmp_result=mysql_query("SELECT name,id FROM ".$db_prefix."director ORDER BY name;")) {
    while($arr = mysql_fetch_array ($tmp_result)) {
      if(mysql_num_rows(mysql_query("SELECT id FROM ".$db_prefix."director_film WHERE director_id=".$arr[1]." AND film_id=".$var['id'].";"))==0)
        print "<option value=\"".$arr[1]."\">".$arr[0]."\n";
    }
    mysql_free_result($tmp_result);
  }
  print "</select>&nbsp;&nbsp;<input type=\"submit\" value=\"$add\"><br><br>";
  print "</form>\n";
  print "<form action=\"add_director.php\" method=\"post\">\n";
  print "<input type=\"hidden\" name=\"id\" value=\"".$var['id']."\">\n";
  print "<input type=\"submit\" value=\"$new_dir\">\n";  
  print "</form>\n";

  
  print "</td><td width=\"50%\" align=\"center\" valign=\"top\">";
  print "<h3><font color=\"#0000FF\">$t_actor</font></h3>\n";
  $tmp_result=mysql_query("SELECT af.id,af.actor_id,a.name FROM ".$db_prefix."actor_film af, ".$db_prefix."actor a WHERE af.film_id=".$var['id']." AND af.actor_id=a.id;");
  while($arr = mysql_fetch_assoc ($tmp_result)) {
    print "<form action=\"edit_film.php\" method=\"post\">\n";
    print "<input type=\"hidden\" name=\"id\" value=\"".$var['id']."\">\n";
    print "<input type=\"hidden\" name=\"del_actor\" value=\"".$arr['id']."\">\n";
    print "<b>".$arr['name']."</b>&nbsp;&nbsp;<input type=\"submit\" value=\"$del\">";
    print "</form><br>\n";
  }
  mysql_free_result($tmp_result);  
  print "<form  action=\"edit_film.php\" method=\"post\">\n";
  print "<input type=\"hidden\" name=\"id\" value=\"".$var['id']."\">\n";
  print $new.":&nbsp;&nbsp;<select name=\"add_actor\">\n";
  if ($tmp_result=mysql_query("SELECT name,id FROM ".$db_prefix."actor ORDER BY name;")) {
    while($arr = mysql_fetch_array ($tmp_result)) {
      if(mysql_num_rows(mysql_query("SELECT id FROM ".$db_prefix."actor_film WHERE actor_id=".$arr[1]." AND film_id=".$var['id'].";"))==0)
        print "<option value=\"".$arr[1]."\">".$arr[0]."\n";
    }
    print "<option value=\"".$arr[1]."\">".$arr[0]."\n";
  }
  mysql_free_result($tmp_result);
  print "</select>&nbsp;&nbsp;<input type=\"submit\" value=\"$add\"><br><br>";
  print "</form>\n";
  print "<form action=\"add_actor.php\" method=\"post\">\n";
  print "<input type=\"hidden\" name=\"id\" value=\"".$var['id']."\">\n";
  print "<input type=\"submit\" value=\"$new_act\">\n";  
  print "</form>\n";
  print "</td></tr></table>\n";


  print "</td></tr><tr><td colspan=2 align=\"center\" valign=\"top\">\n";
  print "<h3><font color=\"#0000FF\">$t_arg</font></h3>\n";
  print "<form action=\"edit_film.php\" method=\"post\">\n";
  print "<input type=\"hidden\" name=\"id\" value=\"".$var['id']."\">\n";
  $tmp_result=mysql_query("SELECT argument FROM ".$db_prefix."argument WHERE film_id=".$var['id'].";");
  if (!($arr=mysql_fetch_array ($tmp_result)))
    $arr[0]="";
  mysql_free_result($tmp_result);
  print "<textarea name=\"add_argument\" rows=8 cols=40 wrap=\"virtual\">".$arr[0]."</textarea>\n";
  print "<br><br><input type=\"submit\" value=\"$send\">\n";
  print "</form><br>\n";
  print "<form action=\"edit_film.php\" method=\"post\">\n";
  print "<input type=\"hidden\" name=\"id\" value=\"".$var['id']."\">\n";
  print "<input type=\"hidden\" name=\"del_argument\" value=\"".$var['id']."\">\n";
  print "<input type=\"submit\" value=\"$del\">";
  print "</form>\n";
  print "</td></table>\n";
  
  switch (back_to($page)) {
    case "00":
      print "    <br><br><a href=\"../index.php\"><img src=\"../img/back.png\" border=0></a>\n";
      break;
    case "01":
      print "    <br><br><a href=\"../index_detailed.php\"><img src=\"../img/back.png\" border=0></a><br>\n";
      break;
    case "99":
      print "<br><a href=\"index.php\"><img src=\"../img/back.png\" border=0></a>\n";
      break;
    default:
      print "<br><a href=\"index.php\"><img src=\"../img/back.png\" border=0></a>\n";
      break;
  }
  print "</center></body></html>\n";
			
  mysql_free_result($result);
}

else {
  print "<html><body>\n";
  print "<center><h1>$s_film</h1><form action=\"edit_film.php\" method=\"post\">\n";
  print $title.": <select name=\"id\">\n";
  $result=mysql_query("SELECT title,id FROM ".$db_prefix."film ORDER BY title;");
  while ($arr=mysql_fetch_array($result))
    print "<option value=\"".$arr[1]."\">".$arr[0]."\n";
  mysql_free_result($result);
  print "</select>\n";
  print "<br><br><input type=\"submit\" value=\"$edit\">";
  print "</form>\n";
  print "<br><a href=\"index.php\"><img src=\"../img/back.png\" border=0></a></center></body></html>";
}

mysql_close($database);

?>
