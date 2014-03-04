<?php
//recupero parametri database
include 'db_accesso_chat.php'; 

$query='SELECT user_id FROM  chat_users WHERE user_name="'.$_POST['txtuser'].'" and password="'.md5($_POST['txtpass']).'"';
$result=mysql_query($query, $db) or die(mysql_error($db));
$row = mysql_fetch_array($result);
extract($row);
	
if(mysql_num_rows($result) > 0){
	
	//seleziono password utente autenticato
	$query='SELECT password
		FROM  chat_users where user_id='.$row['user_id'];
	$result=mysql_query($query, $db) or die(mysql_error($db));
	$row = mysql_fetch_array($result);
	extract($row);

	//imposto cookie user e pass per le ALTRE PAGINE
	$valore_chat_u=$_POST['txtuser'] ;
	setcookie ("userChat_PW", $valore_chat_u) ; 
	$valore_chat_p=$row['password'] ;
	setcookie ("passChat_PW", $valore_chat_p) ;
	
	//metto a 1 il campo ONLINE (online=1 ---> utente online)
	$query='UPDATE chat_users SET online = 1 WHERE user_name="'. $_POST['txtuser'] .'"';
	$result=mysql_query($query, $db) or die(mysql_error($db));

	//redireziono
	header("location: index_chat.php"); 
	exit;
}else{
	header("location: errore.php"); 
	exit;
}
?> 

