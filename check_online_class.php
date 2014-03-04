<?php
require_once('error_handler.php');
include('db_accesso_chat.php');

function getOnline(){
		global $db;
		
		$query='SELECT COUNT(*) as cont_online 
				FROM  chat_users where online=1';
	  	$result=mysql_query($query, $db) or die(mysql_error($db));
	  	$row = mysql_fetch_array($result);
	  	extract($row);
	  	
	  	if($cont_online == 0){
	  		$temp = "Nessun utente ONLINE.";
	  	}else{
			$query='SELECT user_name
				FROM  chat_users where online=1';
	  		$result_online=mysql_query($query, $db) or die(mysql_error($db));
			
	  		$temp='';
    		while($row_online = mysql_fetch_array($result_online)){
	   			extract($row_online);
				$temp .=' &raquo; '. $user_name . '<br />';
	 		}
	  	}
		return $temp;
}
	
?>
