<?
/*
 *	PHPFilm
 *
 *	Copyright (C) 2002 Daniel Pecos Martínez
 *
 *	Licensed under GPL
 */

function connect() {
  include "config.php";
  if ($user!='' && $passwd!='') {
    if ($port!='')
      $database=mysql_connect($host.":".$port,$user,$passwd) or die("Could not connect");
    else
      $database=mysql_connect($host,$user,$passwd) or die("Could not connect");
  } 
  mysql_select_db($db) or die($db." Not found!");
  return $database;
}

function correct_char($char) {
     switch ($char) {
        case 'á': $c_char='a'; break;
        case 'é': $c_char='e'; break;
        case 'í': $c_char='i'; break;
        case 'ó': $c_char='o'; break;
        case 'ú': $c_char='u'; break;
        case 'à': $c_char='a'; break;
        case 'è': $c_char='e'; break;
        case 'ì': $c_char='i'; break;
        case 'ò': $c_char='o'; break;
        case 'ù': $c_char='u'; break;
        case 'Á': $c_char='A'; break;
        case 'É': $c_char='E'; break;
        case 'Í': $c_char='I'; break;
        case 'Ó': $c_char='O'; break;
        case 'Ú': $c_char='U'; break;
        case 'À': $c_char='A'; break;
        case 'È': $c_char='E'; break;
        case 'Ì': $c_char='I'; break;
        case 'Ò': $c_char='O'; break;
        case 'Ù': $c_char='U'; break;
        case 'ñ': $c_char='n'; break;
        case 'Ñ': $c_char='N'; break;
        default : $c_char=$char; break;
     }
     return $c_char;
}

function print_header() {
  include "config.php";
  print "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">";
  print "<html>\n";
  print "  <head>\n";
  print "    <title>".$webtitle."</title>\n";
  print "    <META HTTP-EQUIV=Expires CONTENT=\"".date("D, j M Y G:i:s")." GMT\">\n";
  print "    <META NAME=\"Title\" CONTENT=\"".$webtitle."\">\n";
  print "    <META http-equiv=\"Content-Style-Type\" content=\"text/css\">\n";
  print "    <LINK type=\"text/css\" rel=\"stylesheet\" href=\"style.css\">\n";
  print "  </head>\n\n";
}

function show_index($query) { 
  include "language.php";
  include "config.php";
  $database=connect();
  $result=mysql_query($query);
  
  $char='';
  /* Prints the quick access bar */
  print "\n      [&nbsp;&nbsp;\n";
  while ($arr = mysql_fetch_assoc($result)) {
    if ($char!=$arr['title'][0]) {
      $char=$arr['title'][0];
      $char=correct_char($char);
      print "        <a href=\"#".$char."\">".$char."</a>&nbsp;&nbsp;\n";
    }
  }
  print "      ]<br><br>\n\n";
  /* Reset data pointer to begin */
  if (mysql_num_rows($result)>0)
    mysql_data_seek($result,0);
  
  print "      <table width=\"95%\" cellspacing=\"1\">\n";
  print "        <tr>\n";
  foreach($show as $key => $val)
    if ($val) 
      if ($key != "id")
	 print "         <th align=\"center\" bgcolor=\"".$bgcol_tit."\" width=\"".$width[$key]."\">".$$key."</th>\n";
      else
	 print "         <th align=\"center\" bgcolor=\"".$bgcol_tit."\" width=\"".$width[$key]."\">#</th>\n";


  print "        </tr>\n";
  
  $num_row=-1; // counter for the rows
  $char='';
  
  /* Starts list */
  print "\n";
  while ($arr = mysql_fetch_assoc($result)) {  
    $num_row++;
    
    /* Parse certain fields of each film */
    foreach($arr as $key => $val)
      if(!$val) $arr[$key]="&nbsp;";
    if ($arr["country"]=="&nbsp;") $arr["country"]="";
    if ($arr["web"]=="&nbsp;") $arr["web"]="";
    if ($num_row%2==0) print "        <tr bgcolor=\"".$bgcolor1."\">\n";
    else print "        <tr bgcolor=\"".$bgcolor2."\">\n";
  
    /* Starts printing data */
    foreach($show as $key => $val) {
      if ($key=="id" && $val)
        print "          <td align=\"center\">".$arr['id']."</td>\n";
      if ($key=="title" && $val){
        print "          <td align=\"left\">";
        if ($char!=$arr['title'][0]) {
          $char=$arr['title'][0];
          $char=correct_char($char);          
          print "<a name=\"".$char."\"></a>";
        }
	print "&nbsp;&nbsp;&nbsp;&nbsp;<b>".$arr['title']."</b></td>\n";
      }

      if ($key=="vo" && $val)
        if ($arr["vo"]=="1")
          print "          <td align=\"center\"><img src=\"img/tick.gif\"></td>\n";
        else 
          print "          <td align=\"center\">&nbsp;</td>\n";
	
      if ($key=="vo_title" && $val) 
        print "          <td align=\"left\">&nbsp;&nbsp;".$arr['vo_title']."</td>\n";
    
      if ($key=="vo_lang" && $val) 
        print "          <td align=\"center\">".$arr['vo_lang']."</td>\n";
    
      if ($key=="country" && $val) {
        if ($arr["country"]) {
	  $tmp_query="SELECT name FROM ".$db_prefix."country WHERE id=".$arr['country'].";";
          $tmp_result=mysql_query($tmp_query);
	  $tmp = mysql_fetch_array($tmp_result);
	  mysql_free_result($tmp_result);
        } else $tmp[0]="&nbsp;";
        print "          <td align=\"center\">".$tmp[0]."</td>\n";
      }
    
      if ($key=="year" && $val) 
        print "          <td align=\"center\">".$arr['year']."</td>\n";
      
      if ($key=="length" && $val) 
        print "          <td align=\"center\">".$arr['length']."</td>\n";
    
      if ($key=="format" && $val) 
        print "          <td align=\"center\">".$arr['format']."</td>\n";
      
      if ($key=="web" && $val) {
        print "          <td align=\"center\">";
        if ($arr['web']) print "<a href=\"".$arr['web']."\"><img src=\"img/tick.gif\" alt=\"\"></a>";
        else print "&nbsp;";
        print "</td>\n";
      }

      if ($key=="genre" && $val) { 
        if ($arr["genre"]) {
          $tmp_query="SELECT name FROM ".$db_prefix."genre WHERE id=".$arr['genre'].";";
          $tmp_result=mysql_query($tmp_query);
          $tmp = mysql_fetch_array($tmp_result);
          mysql_free_result($tmp_result);
        } else $tmp[0]="&nbsp;";
        print "          <td align=\"center\">".$tmp[0]."</td>\n";
      }
    
      if ($key=="director" && $val) {
        print "          <td align=\"center\">";
        $tmp_query="SELECT director_id FROM ".$db_prefix."director_film WHERE film_id=".$arr['id'].";";
        $tmp_result=mysql_query($tmp_query);
        if (mysql_num_rows($tmp_result)>0) {
	  $num_act=0;
          while ($tmp = mysql_fetch_array($tmp_result)) {
            $tmp_query2="SELECT name FROM ".$db_prefix."director WHERE id=".$tmp[0].";";
            $tmp_result2=mysql_query($tmp_query2);
            if (mysql_num_rows($tmp_result2)) 
	      $tmp2 = mysql_fetch_array ($tmp_result2);
            if (!$tmp2[0]) 
	      print "&nbsp;";
	    else 
	      print $tmp2[0];
	    if ($num_act!=mysql_num_rows($tmp_result)-1) print "<br>";
            mysql_free_result($tmp_result2);
	  }
        } else print "&nbsp;";
        mysql_free_result($tmp_result);
        print "</td>\n";
      }
    
      if ($key=="actor" && $val) {
        print "          <td align=\"center\">";
        $tmp_query="SELECT actor_id FROM ".$db_prefix."actor_film WHERE film_id=".$arr['id'].";";
        $tmp_result=mysql_query($tmp_query);
        if (mysql_num_rows($tmp_result)>0) {
	  $num_act=0;
          while ($tmp = mysql_fetch_array($tmp_result)) {
            $tmp_query2="SELECT name FROM ".$db_prefix."actor WHERE id=".$tmp[0].";";
            $tmp_result2=mysql_query($tmp_query2);
            if (mysql_num_rows($tmp_result2)) 
	      $tmp2 = mysql_fetch_array ($tmp_result2);
            if (!$tmp2[0]) 
	      print "&nbsp;";
	    else 
	      print $tmp2[0];
	    if ($num_act!=mysql_num_rows($tmp_result)-1) print "<br>";
            mysql_free_result($tmp_result2);
	  }
        } else print "&nbsp;";
        mysql_free_result($tmp_result);
        print "</td>\n";
      }
    
      if ($key=="view" && $val) {
        print "          <td align=\"center\">\n";
        print "            <form action=\"view_film.php\" method=\"post\">\n";
        print "              <input type=hidden name=\"id\" value=\"".$arr['id']."\">\n";
        print "              <input type=image src=\"img/view.gif\">\n";
        print "            </form>\n";
	print "          </td>\n";
      }
    
      if ($key=="edit" && $val) {
        print "          <td align=\"center\">\n";
        print "            <form action=\"admin/edit_film.php\" method=\"post\">\n";
        print "              <input type=hidden name=\"id\" value=\"".$arr['id']."\">\n";
        print "              <input type=image src=\"img/edit.gif\">\n";
        print "            </form>\n";
	print "          </td>\n";
      }
      
      if ($key=="available" && $val) {
        $tmp_query="SELECT person_id FROM ".$db_prefix."loan where film_id=".$arr['id'].";";
        $tmp_result=mysql_query($tmp_query);
        print "          <td align=\"center\">\n";
	if (mysql_num_rows($tmp_result)>0) {
	  $tmp = mysql_fetch_array($tmp_result);
	  print "            <form action=\"admin/people.php\" method=\"post\">\n";
	  print "              <input type=hidden name=\"user\" value=\"".$tmp[0]."\">\n";
	  print "              <input type=image src=\"img/stop.png\">\n";
	  print "            </form>\n";
	  mysql_free_result($tmp_result);
	} else 
	  print "            &nbsp;\n";
        print "          </td>\n";
      }
      
    } // end printing data for this film
    print "        </tr>\n";
    print "\n        <!-- ************** END FILM ************** -->\n\n";
  
  } // no more films to show
  print "      </table>\n";
  print "      <br>\n";
  print "      <h3><font color=\"".$title_color."\">(".mysql_num_rows($result)." ".$count.")</font></h3>\n";

  mysql_free_result($result);
  mysql_close($database);
}

/******************************************************************
*
*
*
*
*******************************************************************/

function show_index_detailed($query) {
  include "language.php";
  include "config.php";

  $database=Connect();
  $result=mysql_query($query);
 
  $char='';
  print "      [&nbsp;&nbsp;\n";
  while ($arr = mysql_fetch_assoc($result)) {
    if ($char!=$arr['title'][0]) {
      $char=$arr['title'][0];
      $char=correct_char($char);
      print "        <a href=\"#".$char."\">".$char."</a>&nbsp;&nbsp;\n";
    }
  }
  print "      ]\n";
  if (mysql_num_rows($result)>0)
    mysql_data_seek($result,0);
				
  print "      <table width=\"85%\">\n";
  for ($num_row=0; $num_row < mysql_num_rows($result); $num_row++) {
    $arr = mysql_fetch_array ($result);
    foreach($arr as $key => $val)
      if(!$val) $arr[$key]="&nbsp;";
    if ($arr["country"]=="&nbsp;") $arr["country"]="";
    if ($arr["web"]=="&nbsp;") $arr["web"]="";
  
    print "        <tr>\n";
    print "          <td width=\"40%\" align=\"center\">\n";
    if ($arr['image']=='1') 
      print "          <img src=\"img/film/".$arr['id'].".jpg\" width=\"70%\" alt=\"\">\n";
    else 
      print "          <img src=\"img/noimg.gif\">\n";
    print "          </td>\n";
    
    print "          <td valign=\"top\">\n";
    print "            <table width=\"100%\" cellspacing=\"1\">\n";
    foreach($show as $key => $val) {
   
      if ($key=="title" && $val) {
        print "              <tr bgcolor=\"".$bgcolor1."\">\n";
	print "                <td width=\"40%\">";
        if ($char!=$arr['title'][0]) {
          $char=$arr['title'][0];
          $char=correct_char($char);
          print "<a name=\"".$char."\">";
        }
	print "&nbsp;&nbsp;&nbsp;$title</td>\n";
	print "                <td align=\"center\"><b>".$arr['title']."</b></td>\n";
	print "              </tr>\n";
      }
      
      if ($key=="vo" && $val)
        if ($arr["vo"]=="1")
          print "              <tr bgcolor=\"".$bgcolor1."\"><td>&nbsp;&nbsp;&nbsp;$vo</td><td align=\"center\"><img src=\"img/tick.gif\"></td></tr>\n";
        else 
          print "              <tr bgcolor=\"".$bgcolor1."\"><td>&nbsp;&nbsp;&nbsp;$vo</td><td align=\"center\">&nbsp;</td></tr>\n";
	
      if ($key=="vo_title" && $val) 
        print "              <tr bgcolor=\"".$bgcolor1."\"><td>&nbsp;&nbsp;&nbsp;$vo_title</td><td align=\"center\">&nbsp;&nbsp;".$arr['vo_title']."</td></tr>\n";
    
      if ($key=="vo_lang" && $val) 
        print "              <tr bgcolor=\"".$bgcolor1."\"><td>&nbsp;&nbsp;&nbsp;$vo_title</td><td align=\"center\">".$arr['vo_lang']."</td></tr>\n";
    
      if ($key=="country" && $val) {
        if ($arr["country"]) {
          $tmp_result=mysql_query("SELECT name FROM ".$db_prefix."country WHERE id=".$arr['country'].";");
          $tmp = mysql_fetch_array ($tmp_result);
	  mysql_free_result($tmp_result);
        } else $tmp[0]="&nbsp;";
        print "              <tr bgcolor=\"".$bgcolor1."\"><td>&nbsp;&nbsp;&nbsp;$country</td><td align=\"center\">".$tmp[0]."</td></tr>\n";
      }
    
      if ($key=="year" && $val) 
        print "              <tr bgcolor=\"".$bgcolor1."\"><td>&nbsp;&nbsp;&nbsp;$year</td><td align=\"center\">".$arr['year']."</td></tr>\n";
      
      if ($key=="length" && $val) 
        print "              <tr bgcolor=\"".$bgcolor1."\"><td>&nbsp;&nbsp;&nbsp;$length</td><td align=\"center\">".$arr['length']."</td></tr>\n";
    
      if ($key=="format" && $val) 
        print "              <tr bgcolor=\"".$bgcolor1."\"><td>&nbsp;&nbsp;&nbsp;$format</td><td align=\"center\">".$arr['format']."</td></tr>\n";
      
      if ($key=="web" && $val) {
        print "              <tr bgcolor=\"".$bgcolor1."\"><td>&nbsp;&nbsp;&nbsp;$web</td><td align=\"center\">";
        if ($arr['web']) print "<a href=\"".$arr['web']."\"><img src=\"img/tick.gif\" alt=\"\"></a>";
        else print "&nbsp;";
        print "</td></tr>\n";
      }

      if ($key=="genre" && $val) { 
        if ($arr["genre"]) {
          $tmp_result=mysql_query("SELECT name FROM ".$db_prefix."genre WHERE id=".$arr['genre'].";");
          $tmp = mysql_fetch_array ($tmp_result);
	  mysql_free_result($tmp_result);
        } else $tmp[0]="&nbsp;";
        print "              <tr bgcolor=\"".$bgcolor1."\"><td>&nbsp;&nbsp;&nbsp;$genre</td><td align=\"center\">".$tmp[0]."</td></tr>\n";
      }
    
      if ($key=="director" && $val) {
        print "              <tr bgcolor=\"".$bgcolor1."\"><td>&nbsp;&nbsp;&nbsp;$director</td><td align=\"center\">\n";
        $tmp_result=mysql_query("SELECT df.id,d.name FROM ".$db_prefix."".$db_prefix."".$db_prefix."".$db_prefix."director_film df, director d WHERE film_id=".$arr['id']." AND df.director_id=d.id;");
	while($tmp = mysql_fetch_array ($tmp_result)) {
	    print "                ".$tmp[1]."<br>\n";
        }
	mysql_free_result($tmp_result);
        print "              </td></tr>\n";
      }

      if ($key=="actor" && $val) {
        print "              <tr bgcolor=\"".$bgcolor1."\"><td>&nbsp;&nbsp;&nbsp;".$actor."</td><td align=\"center\">\n";
	$tmp_result=mysql_query("SELECT af.id,a.name FROM ".$db_prefix."actor_film af, actor a WHERE film_id=".$arr['id']." AND af.actor_id=a.id;");       
	while($tmp = mysql_fetch_array ($tmp_result)) {
          print "                ".$tmp[1]."<br>\n";
	}
	mysql_free_result($tmp_result);
	print "              </td></tr>\n";
      }

    } /* Ends printing data about this film */
    
    print "              <tr><td colspan=\"2\"><br></td></tr>\n";
    print "              <tr>\n";
    print "                <td colspan=\"2\">\n";
    print "                  <table width=\"100%\">\n";
    print "                    <tr bgcolor=\"".$bgcolor2."\">\n";
    if ($show['view'] && $show['edit']) 
        print "                      <td width=\"15%\" bgcolor=\"".$bgcolor."\"></td>\n";
    if ($show['view']){
        print "                      <td align=\"center\" width=\"15%\">\n";
        print "                        <form action=\"view_film.php\" method=\"post\">\n";
        print "                          <input type=hidden name=\"id\" value=".$arr['id'].">\n";
        print "                          <input type=image src=\"img/view.gif\">\n";
        print "                        </form>\n";
	print "                      </td>\n";
    }
    if ($show['view'] && $show['edit']) 
        print "                      <td align=\"center\" width=\"20%\" bgcolor=\"".$bgcolor."\">\n";
        if ($show["available"]) {
          $tmp_result=mysql_query("SELECT person_id FROM ".$db_prefix."loan WHERE film_id=".$arr['id'].";");
	  if (mysql_num_rows($tmp_result)>0) {
	    $cod = mysql_fetch_array ($tmp_result);
	    print "                      <form action=\"admin/people.php\" method=\"post\">\n";
	    print "                        <input type=hidden name=\"user\" value=\"".$cod[0]."\">\n";
	    print "                        <input type=image src=\"img/stop.png\">\n";
	    print "                      </form>\n";
	  }  
	  mysql_free_result($tmp_result);
        print "                      </td>\n";
      }
    if ($show['edit']) {
        print "                      <td align=\"center\" width=\"15%\">\n";
        print "                        <form action=\"admin/edit_film.php\" method=\"post\">\n";
        print "                          <input type=hidden name=\"id\" value=".$arr['id'].">\n";
        print "                          <input type=image src=\"img/edit.gif\">\n";
        print "                        </form>\n";
	print "                      </td>\n";
    }
    if ($show['view'] && $show['edit']) 
        print "                      <td width=\"15%\" bgcolor=\"".$bgcolor."\"></td>\n";
    print "                    </tr>\n";
    print "                  </table>\n";
    print "                </td>\n";
    print "              </tr>\n";
    print "            </table>\n";
    print "          </td>\n";
    print "        </tr>\n";
  }
  print "      </table>\n";
  print "      <br>\n";
  print "      <h3><font color=\"".$title_color."\">(".mysql_num_rows($result)." ".$count.")</font></h3>\n";
  mysql_free_result($result);
  mysql_close($database);

}
?>


