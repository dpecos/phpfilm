#!/bin/sh

chmod 644 *.php style.css
chmod 755 index.php index_detailed.php view*
chmod 711 img admin
chmod 755 admin/*.php
chmod 644 admin/.htaccess
chmod 666 admin/.htpasswd
chmod 644 img/*
chmod 777 img/film
chmod 644 lang/*

echo "Permissions have been set"
