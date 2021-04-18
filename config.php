<?php

$setDevice="xxx.xxx.xxx.xxx"; //IP player
$setPort="xxxx"; //Port ADB Player - Default 5555

$hostname = "localhost"; // Default localhost
$numPort = "3306"; //Port DB - default 3306
$username = "UsernameDB"; //Username to access the DB
$password = "PasswordDB"; //Passsword to access the DB
$dbname = "chaines";//Name of the DB (chaines.sql -> Name : "chaines")
$dbh =null;

try {
    $dbh = new PDO("mysql:host=$hostname;dbname=$dbname;port=$numPort", $username, $password);
}
catch(PDOException $e)
{
	echo 'Connection failed: ' . $e->getMessage();
}

