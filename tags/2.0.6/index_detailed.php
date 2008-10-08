<?
/*
 *	PHPFilm
 *
 *	Copyright (C) 2002 Daniel Pecos Martínez
 *
 *	Licensed under GPL
 */
include "init.php";
$page=page_order($page,"01");
include "language.php";
include "config.php";
include "common.php";

print_header();

print "  <body bgcolor=\"".$bgcolor."\"><center>\n";

print "<h1><font color=\"".$title_color."\">".$webtitle."</font></h1>\n";
print "<h4><font color=\"".$title_color."\">[ <a href=\"index.php\">$simple</a> | <a href=\"admin\">$admin</a> ]\n</font></h4>";
$query="SELECT * FROM ".$db_prefix."film ORDER BY title;";
show_index_detailed($query);
print "<br><br><small><a href=\"http://phpfilm.netpecos.org\"><font color=\"".$title_color."\">PHP Film ".$version."</font></a></small>\n";
print "</center></body></html>\n";
?>
