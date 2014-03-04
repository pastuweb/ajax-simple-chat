<?php
require_once('error_handler.php');
require_once('check_online_class.php');
//il browser non deve memorizzare il risultato in cache
header('Expires: Wed, 23 Dec 1980 00:30:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

$action = $_GET['action'];
if($action == 'GetOnline'){
	$user_online = getOnline();
	echo $user_online;
}else{
	echo 'Errore di comunicazione: il server non comprende il comando.';
}
?>