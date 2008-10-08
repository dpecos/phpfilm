<?
include "../init.php";
$page=page_order($page,"99");
include "../config.php";
if(!isset($lang) || empty($lang) || !file_exists("../lang/"."$lang".".php")) { $lang = "language_en"; }
include "../lang/"."$lang".".php";

print "<html>\n";
print "  <head>\n";
print "    <META HTTP-EQUIV=Expires CONTENT=\"".date("D, j M Y G:i:s")." GMT\">\n";
print "  </head>\n";
print "  <body>\n";
print "    <center><h1>".$webtitle."</h1></center>\n";
print "    <br><br><center><small><a href=\"http://netpecos.org/projects/phpfilm/\" target=\"_new\">PHP Film ".$version."</a></small></center>\n";
print "    <ul>\n";
print "      <li><a href=\"add_film.php\">".$add."</a>/<a href=\"del_film.php\">".$del."</a>/<a href=\"edit_film.php\">".$edit."</a> ".$film."</li>\n";
print "      <li><a href=\"add_genre.php\">".$add."</a>/<a href=\"del_genre.php\">".$del."</a>/<a href=\"edit_genre.php\">".$edit."</a> ".$genre."</li>\n";
print "      <li><a href=\"add_actor.php\">".$add."</a>/<a href=\"del_actor.php\">".$del."</a>/<a href=\"edit_actor.php\">".$edit."</a> ".$actor."</li>\n";
print "      <li><a href=\"add_director.php\">".$add."</a>/<a href=\"del_director.php\">".$del."</a>/<a href=\"edit_director.php\">".$edit."</a> ".$director."</li>\n";
print "      <li><a href=\"add_country.php\">".$add."</a>/<a href=\"del_country.php\">".$del."</a>/<a href=\"edit_country.php\">".$edit."</a> ".$country."</li>\n";
print "      <br><br>";
print "      <li><a href=\"password.php\">".$passwd_admin."</a>\n";
print "      <li><a href=\"people.php\">".$loan_admin."</a>\n";
print "    </ul>\n";
print "    <center>\n";
switch (back_to($page)) {
  case "00":
    print "    <br><br><a href=\"../index.php\">$simple</a><br>\n";
    break;
  case "01":
    print "    <br><br><a href=\"../index_detailed.php\">$detailed</a><br>\n";
    break;
}
print "    </center>\n";
			
print "</body>\n";
print "</html>\n";
?>
