<?
/*
 *	PHPFilm
 *
 *	Copyright (C) 2002 Daniel Pecos Martínez
 *
 *	Licensed under GPL
 */
session_register("page");

function back_to($page) {
  return substr(substr($page,0,strlen($page)-2),strlen($page)-4,2);
}

function page_order($page,$code) {
  if (substr($page,strlen($page)-2,2)!=$code) {
    if ($page!="") {
      $position=strpos($page,$code);
      //print $position;
      if (!($position===false) && $position%2==0) {
        $page=substr($page,0,strlen($page)-2);
      } else {
        $page=$page.$code;
      }
    } else {
        $page=$page.$code;
    }
  }
  return $page;
}

?>
