<?php
//collegamento MySQL
$db=mysql_connect('localhost','root','password') or 
die('Unable to connect. Check your connection parameter');
//selezione come attivo il database appena creato
mysql_select_db('mydatabase',$db) or die(mysql_error($db));
?>