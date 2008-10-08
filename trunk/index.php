<?
/*
 *	PHPFilm
 *
 *	Copyright (C) 2002 Daniel Pecos Martínez
 *
 *	Licensed under GPL
 */

include "init.php";
$page=page_order($page,"00");
include "config.php";
if(!isset($lang) || empty($lang) || !file_exists("lang/"."$lang".".php")) { $lang = "language_en"; }
include "lang/"."$lang".".php";
include "common.php";

print_header();

print "  <body bgcolor=\"".$bgcolor."\">\n";
print "    <center>\n";
print "      <h1><font color=\"".$title_color."\">".$webtitle."</font></h1>\n";
print "      <h4><font color=\"".$title_color."\">[ <a href=\"index_detailed.php\">$detailed</a> | <a href=\"admin\">$admin</a> ]\n</font></h4>\n";

$query="SELECT * FROM ".$db_prefix."film ORDER BY title;";
show_index($query);

print "      <br><br>\n";
print "      <small><a href=\"http://netpecos.org/projects/phpfilm/\" target=\"_new\"><font color=\"".$title_color."\">PHP Film ".$version."</font></a></small>\n";
/*print "      <p>\n";
print "        <a href=\"http://validator.w3.org/check/referer\"><img border=\"0\"\n";
print "          src=\"http://www.w3.org/Icons/valid-html401\"\n";
print "          alt=\"Valid HTML 4.01!\" height=\"31\" width=\"88\"></a>\n";
print "      </p>\n";*/
print "    </center>\n";
print "  </body>\n";
print "</html>\n";
?>
