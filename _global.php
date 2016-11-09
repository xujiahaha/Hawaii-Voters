<?php
date_default_timezone_set('Pacific/Honolulu');

$sqlHost = 'localhost';
$sqlUser = ''; //*************   create new SQL user in cPanel
$sqlPass = '';
$sqlDatabase = ''; //***********   be sure to connect your new SQL user to your CAMPUS database

$datetime = date('Y-m-d H:i:s');

$conn = mysql_connect($sqlHost, $sqlUser, $sqlPass)
	or die("Couldn't connect to MySQL server on $sqlHost: " . mysql_error() . '.');

$db = mysql_select_db($sqlDatabase, $conn)
	or die("Couldn't select database $sqlDatabase: " . mysql_error() . '.');
	
$menu=<<<EOM

EOM


?>