<?php
include 'db_accesso_chat.php'; 
	
//metto a 0 il campo ONLINE
$query='UPDATE chat_users SET online = 0 WHERE user_name="'. $_COOKIE["userChat_PW"] .'"';
$result=mysql_query($query, $db) or die(mysql_error($db));
	
// svuoto i COOKIE
setcookie ("userChat_PW", "") ;
setcookie ("passChat_PW", "") ;
	
//redireziono
if($_GET["mode"]=="chiuso"){
	
	header("location: chiudi.html"); 
	exit;
}else{
	
	header("location: index.php"); 
	exit;
}
?>