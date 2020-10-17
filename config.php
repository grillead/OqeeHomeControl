<?php
$setDevice="ip_player";
$setPort="port_adb_player"; //default 5555
$conn = mysql_connect("ip_bdd:port_bdd", "user_bdd", "pwd_bdd") or die; 
$db = mysql_select_db("nom_bdd");
