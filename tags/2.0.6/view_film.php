<?
/*
 *	PHPFilm
 *
 *	Copyright (C) 2002 Daniel Pecos Martínez
 *
 *	Licensed under GPL
 */
include "init.php";
$page=page_order($page,"02");
include "language.php";
include "config.php";
include "common.php";

if ($HTTP_POST_VARS['id']) {
 
  $database=connect();
  
  $var=$HTTP_POST_VARS;
  $query="SELECT * FROM ".$db_prefix."film WHERE id=".$var['id'].";";
  $result=mysql_query($query);
  $tmp=mysql_fetch_assoc($result);
  
  foreach($tmp as $key => $val)
    if(!$val) $tmp[$key]="&nbsp;";
  if ($tmp["country"]=="&nbsp;") $tmp["country"]="";
  if ($tmp["web"]=="&nbsp;") $tmp["web"]="";


  print "<html>\n";
  print "  <head>\n";
  print "    <title>".$webtitle."</title>\n";
  print "    <META HTTP-EQUIV=Expires CONTENT=\"".date("D, j M Y G:i:s")." GMT\">\n";
  print "    <META NAME=\"Title\" CONTENT=\"".$webtitle."\">\n";
  print "    <META http-equiv=\"Content-Style-Type\" content=\"text/css\">\n";
  print "    <LINK type=\"text/css\" rel=\"stylesheet\" href=\"style.css\">\n";
  print "  </head>\n";
  
  // show the image
  print "  <body bgcolor=\"".$bgcolor."\">\n";
  print "    <center>\n";
  print "    <table width=\"80%\" cellspacing=0>\n";
  print "    <tr><td width=\"35%\" align=\"center\" valign=\"center\">\n";
  if ($tmp['image']==1)
    print "      <img src=\"img/film/".$var['id'].".jpg\" width=\"95%\">\n";
  else print "      <img src=\"img/noimg.gif\" width=\"95%\">\n";
  print "    </td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>\n";
  
  // main film data
  print "    <td width=\"60%\" align=\"center\" valign=\"top\">\n";
  print "      <h2><font color=\"".$title_color."\">".$t_data."</font></h2>\n";
  print "      <table width=\"90%\" border=0 cellspacing=1 cellpadding=5>\n";
  print "        <col width=\"50%\"><col>\n";
  print "        <tr bgcolor=\"".$bgcolor1."\"><td>&nbsp;&nbsp;".$title.":</td><td>&nbsp;&nbsp;<b>".$tmp['title']."</b></td></tr>\n";
  if ($tmp['vo']==1) print "        <tr bgcolor=\"".$bgcolor1."\"><td>&nbsp;&nbsp;".$vo.":</td><td>&nbsp;&nbsp;<img src=\"img/smiley.gif\"></td>\n";
  else print "        <tr bgcolor=\"".$bgcolor1."\"><td>&nbsp;&nbsp;".$vo.":</td><td>&nbsp;</td>\n";
  print "        <tr bgcolor=\"".$bgcolor1."\"><td>&nbsp;&nbsp;".$vo_title.":</td><td>&nbsp;&nbsp;".$tmp['vo_title']."</td></tr>\n";
  print "        <tr bgcolor=\"".$bgcolor1."\"><td>&nbsp;&nbsp;".$vo_lang.":</td><td>&nbsp;&nbsp;".$tmp['vo_lang']."</td></tr>\n";
 
  $tmp_query="SELECT name FROM ".$db_prefix."genre WHERE id=".$tmp['genre'].";";
  $tmp_result=mysql_query($tmp_query);
  $tmp2=mysql_fetch_assoc($tmp_result);
  print "        <tr bgcolor=\"".$bgcolor1."\"><td>&nbsp;&nbsp;".$genre.":</td><td>&nbsp;&nbsp;".$tmp2['name']."</td></tr>\n";
  mysql_free_result($tmp_result);

  print "        <tr bgcolor=\"".$bgcolor1."\"><td>&nbsp;&nbsp;".$country.":</td><td>&nbsp;&nbsp;";
  if ($tmp["country"]) {
    $tmp_query="SELECT name FROM ".$db_prefix."country WHERE id=".$tmp['country'].";";
    $tmp_result=mysql_query($tmp_query);
    $tmp2 = mysql_fetch_array($tmp_result);
    mysql_free_result($tmp_result);
  } else $tmp2[0]="&nbsp;";
  print $tmp2[0];
  print "</td></tr>\n";
  
  print "        <tr bgcolor=\"".$bgcolor1."\"><td>&nbsp;&nbsp;".$year.":</td><td>&nbsp;&nbsp;".$tmp['year']."</td></tr>\n";
  print "        <tr bgcolor=\"".$bgcolor1."\"><td>&nbsp;&nbsp;".$length.":</td><td>&nbsp;&nbsp;".$tmp['length']."</td></tr>\n";
  
  print "        <tr bgcolor=\"".$bgcolor1."\"><td>&nbsp;&nbsp;".$format.": </td><td>&nbsp;&nbsp;".$tmp['format']."</td></tr>\n";
  
  print "        <tr bgcolor=\"".$bgcolor1."\"><td>&nbsp;&nbsp;".$web.":</td><td>&nbsp;&nbsp;";
  if ($tmp['web']!='') 
    print "<a href=\"".$tmp['web']."\"><img src=\"img/tick.gif\" border=0></a></td>\n";
  else 
    print "&nbsp</td>\n";

  // end data table
  print "      </table>\n";
   
  print "    </td></tr><br>\n";
  
  // print actors and directors

  print "    <tr><td colspan=3 align=\"center\" valign=\"top\">\n";
  print "      <table width=\"100%\"><tr><td width=\"50%\" align=\"center\" valign=\"top\">\n";
  print "        <h2><font color=\"".$title_color."\">".$t_director."</font></h2>\n";
  print "        <table width=\"80%\" cellspacing=1 cellpadding=5>\n";
  $tmp_query="SELECT director_id FROM ".$db_prefix."director_film WHERE film_id=".$var['id'].";";
  $tmp_result=mysql_query($tmp_query);
  while ($tmp=mysql_fetch_assoc($tmp_result)) {
      $tmp_query2="SELECT name FROM ".$db_prefix."director WHERE id=".$tmp['director_id'].";";
      $tmp_result2=mysql_query($tmp_query2);
      $tmp2 = mysql_fetch_assoc($tmp_result2);
      print "        <tr><td align=\"center\"><form action=\"view_director.php\" method=\"post\">\n";
      print "          <input type=\"hidden\" name=\"director_id\" value=\"".$tmp['director_id']."\">\n";
      print "          <input type=\"hidden\" name=\"film_id\" value=\"".$var['id']."\">\n";
      print "          <input type=\"image\" src=\"img/unknown.png\">\n";
      print "          </form>\n";
      print "        </td><td>&nbsp;</td>\n";
      print "        </td><td align=\"center\" bgcolor=\"".$bgcolor1."\">";
      print "          <b>".$tmp2['name']."</b>";
      print "        </td></tr>\n";
      mysql_free_result($tmp_result2);
  }
  mysql_free_result($tmp_result);
  print "        </table>\n";
  
  print "      </td><td width=\"50%\" align=\"center\" valign=\"top\">\n";
  print "        <h2><font color=\"".$title_color."\">".$t_actor."</font></h2>\n";
  print "        <table width=\"80%\" cellspacing=1 cellpadding=5>\n";
  $tmp_query="SELECT actor_id FROM ".$db_prefix."actor_film WHERE film_id=".$var['id'].";";
  $tmp_result=mysql_query($tmp_query);
  while ($tmp=mysql_fetch_assoc($tmp_result)) {
      $tmp_query2="SELECT name FROM ".$db_prefix."actor WHERE id=".$tmp['actor_id'].";";
      $tmp_result2=mysql_query($tmp_query2);
      $tmp2 = mysql_fetch_assoc($tmp_result2); 
      print "        <tr><td align=\"center\" bgcolor=\"".$bgcolor1."\">";
      print "          <b>".$tmp2['name']."</b></td>";
      print "        <td>&nbsp;</td>\n";
      print "        <td align=\"center\"><form action=\"view_actor.php\" method=\"post\">\n";
      print "          <input type=\"hidden\" name=\"actor_id\" value=\"".$tmp['actor_id']."\">\n";
      print "          <input type=\"hidden\" name=\"film_id\" value=\"".$var['id']."\">\n";
      print "          <input type=\"image\" src=\"img/unknown.png\">\n";
      print "          </form>\n";
      print "        </td></tr>\n";
      mysql_free_result($tmp_result2);
  }
  mysql_free_result($tmp_result);
  print "        </table>\n";
  
  print "      </td></tr></table><br><br>\n";

  print "    </td></tr>\n";
  print "    <tr><td colspan=3 align=\"center\" valign=\"top\">\n";
  print "      <h2><font color=\"".$title_color."\">".$t_arg."</font></h2>\n";

  $tmp_query="SELECT argument FROM ".$db_prefix."argument WHERE film_id=".$var['id'].";";
  $tmp_result=mysql_query($tmp_query);
  if (mysql_num_rows($tmp_result)) $tmp=mysql_fetch_array($tmp_result);
  else $tmp[0]="&nbsp;";
  print "      <table cellpadding=5 border=0 bgcolor=\"".$bgcolor1."\" width=\"80%\">\n";
  print "      <tr><td>\n";
  print "        <p>".$tmp[0]."</p>\n";
  print "      </td></tr></table>\n";
  print "    </td></tr>\n";
  print "    </table>\n";
  
  switch (back_to($page)) {
    case "00":
      print "    <br><br><a href=\"index.php\"><img src=\"img/back.png\" border=0></a><br>\n";
      break;
    case "01":
      print "    <br><br><a href=\"index_detailed.php\"><img src=\"img/back.png\" border=0></a><br>\n";
      break;
    default:
      print "    <br><br><a href=\"index.php\"><img src=\"img/back.png\" border=0></a><br>\n";
      break;
  }
  print "    </center>\n";
  print "  </body>\n";
  print "</html>\n";

  mysql_free_result($result);
  mysql_close($database);

}
?>
