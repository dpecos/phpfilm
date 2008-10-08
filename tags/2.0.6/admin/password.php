<?
include "../language.php";

$var=$HTTP_POST_VARS;
print "<html><body><center>\n";
print "<h1>$t_passwd</h1>\n";

if ($var['user']) {
  $f=file('.htpasswd');
  $user="";
  $n=0;
  while (!$user &&  $n <= count($f)) {
    $f_div=explode(':',$f[$n]);
    $user=$f_div[0];
    $salt=substr($f_div[1],0,2);
    if ($user!=$var['user'])
      $user="";
    $n++;
  }
  if ($user) {
    if ($var['old_passwd']){
      if (crypt($var['old_passwd'],$salt)==trim($f_div[1])) {
        if ($var['npasswd1']==$var['npasswd2'] && $var['npasswd1']!="") {
          $f2=fopen('.htpasswd','w');
	  $n=0;
          $npasswd=crypt($var['npasswd1'],$salt);
	  while ($n <= count($f)) {
            $f_div=explode(':',$f[$n]);
	    if($user!=$f_div[0])
	      fputs($f2,$f[$n]);
	    else
	      fputs($f2,"$user:$npasswd\n");
	    $n++;
	  }
          fclose($f2);
          print "$update_suc\n<br>\n";
        } else 
          print $pass_err_1."<br>\n";
      } else 
        print $pass_err_2."<br>\n";
    } else {
      //delete user
      $f2=fopen('.htpasswd','w'); 
      $n=0;
      while ($n <= count($f)) {
        $f_div=explode(':',$f[$n]);
        if($user!=$f_div[0])
	  fputs($f2,$f[$n]);
	$n++;
      }
      fclose($f2);
      print "$user_del\n<br>\n";
    }
  } else if (!$var['old_passwd'] && $var['npasswd1'] && $var['npasswd2']) {
    if ($var['npasswd1']==$var['npasswd2']) {
      $f=fopen('.htpasswd','a');
      $npasswd=crypt($var['npasswd1'],$salt);
      fputs($f,$var['user'].":$npasswd\n");
      fclose($f);
      print "$user_add\n<br>\n";
    }
  } else 
    print "$no_user\n<br>\n";
    
} else if ($var['list']) {
  print "<br><table border=1>\n";
  print "<tr><td><h3>$users</h3></td></tr>\n";
  $f=file('.htpasswd');
  $n=0;
  while ($n < count($f)) {
    $f_div=explode(':',$f[$n]);
    $user=$f_div[0];
    $n++;
    print "<tr><td align=\"center\">$user</td></tr>\n";
  }
  print "</table>\n";
} else {
  print "<form action=\"password.php\" method=\"post\">\n";
  print "<br><table>\n";
  print "<tr><td align=\"right\">$user</td><td>&nbsp;&nbsp;</td><td><input type=\"text\" name=\"user\"></td></tr>\n";
  print "<tr><td align=\"right\">$old_password</td><td></td><td><input type=\"password\" name=\"old_passwd\"></td></tr>\n";
  print "<tr><td align=\"right\">$new_password</td><td></td><td><input type=\"password\" name=\"npasswd1\"></td></tr>\n";
  print "<tr><td align=\"right\">$new_password</td><td></td><td><input type=\"password\" name=\"npasswd2\"></td></tr>\n";
  print "<tr><td colspan=3 align=\"center\"><br><br><input type=\"submit\" value=\"$send\"></td></tr>\n";
  print "</table>\n";
  print "</form>\n";
  print "<br><form action=\"password.php\" method=\"post\">\n";
  print "<input type=\"hidden\" name=\"list\" value=1>\n";
  print "<input type=\"submit\" value=\"$list_users\">\n";
  print "</form><br>\n";	
  print "<table width=\"60%\">\n";
  print "<tr><td align=\"justify\">$passwd_help</td></tr>";
  print "</table>";
}
  print "<br><a href=\"index.php\"><img src=\"../img/back.png\" border=0></a>\n";
  print "</center></body></html>\n";
?>
