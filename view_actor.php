<?
/*
 *	PHPFilm
 *
 *	Copyright (C) 2002 Daniel Pecos Martínez
 *
 *	Licensed under GPL
 */
include "init.php";
$page=page_order($page,"03");
include "config.php";
if(!isset($lang) || empty($lang) || !file_exists("lang/"."$lang".".php")) { $lang = "language_en"; }
include "lang/"."$lang".".php";
include "common.php";

$database=Connect();

$var=$HTTP_POST_VARS;
$result=mysql_query("SELECT name, country, year FROM ".$db_prefix."actor WHERE id='".$var['actor_id']."';");
$arr = mysql_fetch_array ($result);

print "<html><head>\n";
print "<title>".$webtitle."</title>\n";
print "<META NAME=\"Title\" CONTENT=\"".$webtitle."\">\n";
print "<META http-equiv=\"Content-Style-Type\" content=\"text/css\">\n";
print "<LINK type=\"text/css\" rel=\"stylesheet\" href=\"style.css\">\n";
print "</head>\n";
print "<body bgcolor=\"$bgcolor\"><center>\n";
print "<h1><font color=\"".$title_color."\">".$t_view_actor."</font></h1><br>\n";
print "<table width=\"40%\" border=0 cellspacing=0 cellpadding=1 ><tr><td>\n";
print "<table width=\"100%\" border=0 cellspacing=1 cellpadding=5>\n";
print "  <tr bgcolor=\"".$bgcolor1."\">\n";
print "    <td width=\"35%\">&nbsp;&nbsp;&nbsp;$name:</td><td><b>&nbsp;&nbsp;&nbsp;".$arr[0]."</b></td>\n";
print "  <tr>\n";
$tmp_result=mysql_query("SELECT name FROM ".$db_prefix."country WHERE id=".$arr[1].";");
$arr2 = mysql_fetch_array ($tmp_result);
mysql_free_result($tmp_result);
print "  <tr bgcolor=\"".$bgcolor1."\">\n";
print "    <td>&nbsp;&nbsp;&nbsp;$country:</td><td>&nbsp;&nbsp;&nbsp;".$arr2[0]."</td>\n";
print "  <tr>\n";
print "  <tr bgcolor=\"".$bgcolor1."\">\n";
print "    <td>&nbsp;&nbsp;&nbsp;$year:</td><td>&nbsp;&nbsp;&nbsp;".$arr[2]."</td>\n";
print "  <tr>\n";
print "</table></td></tr></table><br><br>\n";
print "<br><br>\n";
print "<h3><font color=\"".$title_color."\">".$t_actor_films."</font></h3><br>\n";
$query="SELECT f.* FROM ".$db_prefix."film f,".$db_prefix."actor_film af WHERE af.actor_id=".$var['actor_id']." and f.id=af.film_id ORDER BY f.title;"; 
show_index($query);
print "<form action=\"view_film.php\" method=\"post\">\n";
print "<input type=\"hidden\" name=\"id\" value=\"".$var['film_id']."\">\n";
print "<input type=\"image\" src=\"img/back.png\">\n";
print "</form>\n";
print "</center></body></html>\n";
mysql_free_result($result);
?>
