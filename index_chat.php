<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Chat - PastuWeb</title>
	<meta name="keywords" content="PastuWeb, www.pastuweb.com, Francesco Pasturenzi, Chat" />
	<link rel="Shortcut Icon" type="image/x-icon" href="/loghi_pw/icone/favicon.ico" />
	<meta name="author" content="Pasturenzi Francesco, www.pastuweb.com" />
	<meta name="description" content="Chat - PastuWeb" />

	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link href="chat.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="stile_login.css" />
	
  	<script type="text/javascript" src="chat.js" ></script> 
  	<script type="text/javascript" src="check_online.js" ></script>
  	<script type="text/javascript" src="colore.js"></script>
  	
 	<script type="text/javascript">
		//serve a gestire la CHUSURA DEL BROWSER
		var flag = 0;

		function apriURL(url){
			flag = 1;
			location.href = url;
		}
 	</script>
<?php 
//recupero parametri database
include 'db_accesso_chat.php'; 

//ACCESSO
$query='SELECT user_name, password
		FROM  chat_users where user_name="'. $_COOKIE["userChat_PW"] .'"';
$result=mysql_query($query, $db) or die(mysql_error($db));
$row = mysql_fetch_array($result);
extract($row);

//controllo user e pass
if($_COOKIE["userChat_PW"] != $row['user_name'] || $_COOKIE["passChat_PW"] != $row['password'] &&
	empty($_COOKIE["userChat_PW"]) || empty($_COOKIE["passChat_PW"]) ){
	header("location: errore.php"); 
	exit;
}

if($row['id'] < 0 || empty($row['id'])){
	
}
//funzioni per gestire il colore dei messaggi
include 'crea_colore.php'; 
?>

<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
<?php  include '../ready_jquery.php'; ?>

<script type="text/javascript" src="../my_functions.js"></script>

</head>


<body onload="init(); process();" onunload="if(!flag) window.open('log_offline.php?mode=chiuso');" >
	<?php include_once("../analyticstracking.php") ?>
	<div id="centrato">
		<?php require 'intestazione.php';?>
	
		<div id="corpo" style="font-size: 12px;">
			<div id="colonna-2" >
				<table id="content">
     				 <tr>
      				  	<td>
         				 <div id="scroll"></div>
        				</td>
        				<td id="colorpicker">
          					<table cellspacing="10" cellpadding="0">
          					<tr>
          					<td>
							<table cellspacing="0" cellpadding="0">
							<?php
							$id = 1;
							for( $h = 0; $h < 360; $h += 18 ) { ?>
							<tr>
								<?php for( $b = 255; $b >= 0; $b -= 10 ) {
								$color = hsb2hex( $h, $b / 255, $b );?>
								<td>
								<div id="cp<?php echo( $id ); ?>" 
								style="height:10px; width:10px; border:1px solid white; background:<?php echo( $color ); ?>;" 
								onmouseover="mover('cp<?php echo( $id ); ?>');hover('<?php echo( $color ); ?>');" 
								onmouseout="mout('cp<?php echo( $id ); ?>')" 
								onclick="selectColor('<?php echo( $color ); ?>');">
								</div>
								</td>
								<?php $id += 1;} ?>
							</tr>
							<?php } ?>
							</table>
							</td>
							</tr>
							</table>
          				
          					<br />
          					<input id="color" type="text" maxlength="7" value="#000000" onblur="getUserColor()"/>
          					
          					<span id="sampleText">
            				(colore del testo)
          					</span>
          					
        				</td>
      				</tr>
    			</table>
    			
    			<div style="text-align:center">
      			<input type="text" id="userName" value="<?php echo $_COOKIE["userChat_PW"]; ?>" maxlength="10" size="10" style="display:none;"/>
     			<input type="text" id="messageBox" maxlength="2000" size="100" onkeydown="handleKey(event)" />
      			<input type="button" value="Invia" onclick="sendMessage();" /><br />
      			
      			<?php 
      			//se l'utente loggato  l'ADMIN allora visualizza un pulsante in piu "Delete All"
      				if($_COOKIE["userChat_PW"] == "admin" && $_COOKIE["passChat_PW"] == "15b29ffdce66e10527a65bc6d71ad94d"){
      					echo '<input type="button" value="Delete All" onclick="deleteMessages();"/><br />';
      				}else{
      					echo ' <input type="button" value="Delete All" onclick="deleteMessages();" style="display:none;"/><br />';
      				}
      			?>
      			
      			<form name="formLOGOUT" method="post" action="javascript:apriURL('log_offline.php')">
       				<input type="submit" value="Logout"/>
      			</form>
      			<br />
      			
      			<strong>Utenti on-line:</strong>
      			<div style="margin-left:310px;" id="myDivElement" /></div>
				</div>
				
					<noscript>
					<p class="Avvisi" style="color:#000">
					<strong>Attenzione: </strong>Il tuo JavaScript NON E' ATTIVO! <br />
					Alcune cose potrebbero non funzionare.
					</p>
					</noscript>
			</div>
				
		</div>
		<div id="pie-di-pagina" >
			<?php require 'frm_footer.php';?>
		</div>
		
		<?php require '../frm_dialogs.php';?>

</body>
</html>
