<?php
//recupero parametri database
include 'db_accesso_chat.php'; 

$query='INSERT INTO chat_users (user_name, password, online) VALUES("'.$_POST['r_txtuser'].'","'.$_POST['r_txtpass'].'",0)';
$result=mysql_query($query, $db) or die(mysql_error($db));

//recupera l'id che MySQL ha generato automaticamente
$last_id = mysql_insert_id();

//CIFRO la password
$query = 'UPDATE chat_users SET password="'.md5($_POST['r_txtpass']).'" WHERE user_id='.$last_id;
$result=mysql_query($query, $db) or die(mysql_error($db));

//seleziono password utente registrato
$query='SELECT password
		FROM  chat_users where user_name="'. $_POST["r_txtuser"] .'"';
$result=mysql_query($query, $db) or die(mysql_error($db));
$row = mysql_fetch_array($result);
extract($row);

	//imposto cookie user e pass per le ALTRE PAGINE
	$valore_chat_u=$_POST['r_txtuser'] ;
	setcookie ("userChat_PW", $valore_chat_u) ; 
	$valore_chat_p=$row['password'] ;
	setcookie ("passChat_PW", $valore_chat_p) ;
	
	//metto a 1 il campo ONLINE (online=1 ---> utente online)
	$query='UPDATE chat_users SET online = 1 WHERE user_name="'. $_POST["r_txtuser"] .'"';
	$result=mysql_query($query, $db) or die(mysql_error($db));

	//redireziono
	header("location: index_chat.php"); 
	exit;
