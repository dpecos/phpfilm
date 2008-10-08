<? 
// Name of the data base
$db="Films";

// Path to the main php_film directory
$path="/path/to/phpfilm";

// Web title of the main page
$webtitle="Film Collection";

// Host which stores database (normally 'localhost' and 5439)
$host="localhost";
$port="";

// User and password of the database
$user="dbuser";
$passwd="dbpasswd";

// prefix for the table names
$db_prefix="";

$version="2.0.6";

// main page
// 1 if you want to show this field, 0 if not
// NOTE: fields are showed in the order they are in the following lines
$show['id']=0;
$show['title']=1;
$show['vo']=0;
$show['vo_title']=0;
$show['vo_lang']=0;
$show['year']=1;
$show['genre']=1;
$show['director']=0;
$show['actor']=0;
$show['country']=1;
$show['web']=1;
$show['length']=1;
$show['format']=0;
$show['view']=1;
$show['edit']=1;
$show['available']=1;

// set the width or each field on the main table
// NOTE: values can be in one of this format
//    - AutoAdjust to the biggest entry of this field
//   num - Absolute value 
//   "num%" - Relative to the width of the page

$width['id']=0;
$width['title']=0;
$width['vo']=0;
$width['title_vo']=0;
$width['lang_vo']=0;
$width['country']=0;
$width['year']=0;
$width['director']=0;
$width['length']=0;
$width['format']=0;
$width['web']=25;
$width['genre']=0;
$width['director']=0;
$width['actor']=0;
$width['view']="30";
$width['edit']="30";
$width['available']="30";

// Color configuration
$title_color="#3f5e63";
$bgcolor="#778899";
$bgcol_tit="#8ec8cc";
$bgcolor1="#c3e0f7";
$bgcolor2="#9abad3";
?>
