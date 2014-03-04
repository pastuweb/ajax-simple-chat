<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Login chat - PastuWeb</title>
	<meta name="keywords" content="PastuWeb, www.pastuweb.com, Francesco Pasturenzi, Login chat" />
	<link rel="Shortcut Icon" type="image/x-icon" href="/loghi_pw/icone/favicon.ico" />
	<meta name="author" content="Pasturenzi Francesco, www.pastuweb.com" />
	<meta name="description" content="Login chat - PastuWeb" />
	
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" type="text/css" href="stile_login.css" />
	
	<script type="text/javascript">
	/* --------------------------------------------------------------- */
	/* eseguita se l'utente clicca sul pulsante REGISTRATI */
	function getRegistrati(){
		 var divReg = document.getElementById("registrati");
	 
	 	 divReg.className = "display_on";
	
	}
	/* --------------------------------------------------------------- */
	</script>
	
<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
<?php  include '../ready_jquery.php'; ?>

<script type="text/javascript" src="../my_functions.js"></script>

</head>

<body>
	<?php include_once("../analyticstracking.php") ?>
	<div id="centrato">
	
		<?php require 'intestazione.php';?>
	
		<div id="corpo">
			<p style="text-align:center;"><strong style="color:#FF0000;">Solo i PRESCELTI possono entrare. </strong></p>
			<form name="formLOGIN" method="post" action="admin.php">
				<p style="text-align:center;">UserName:<br />
				<input  id ="txtuser" name="txtuser" type="text" value=""  size="30" /></p>
				<p style="text-align:center;">Password:<br />
				<input  id = "txtpass" name="txtpass" type="password" value=""  size="30" /></p>
				<p style="text-align:center;">
				<input  type="submit"  value="Accedi" /> 
				<input  type="reset"  value="Reset" /> 
				<input  type="button"  value="Registrati" onclick="getRegistrati()" /></p>
			</form>
			<br />
			<div id="registrati" class="display_off">
				<fieldset>
				<legend>Registrati:</legend>
					<form name="formReg" method="post" action="registrati.php">
					<p style="text-align:center;">UserName:<br />
					<input  id ="r_txtuser" name="r_txtuser" type="text" value=""  size="30" /></p>
					<p style="text-align:center;">Password:<br />
					<input  id = "r_txtpass" name="r_txtpass" type="password" value=""  size="30" /></p>
					<p style="text-align:center;"><input  type="submit"  value="Salva" /> <input  type="reset"  value="Reset" /></p>
					</form>
				</fieldset>
				<br />
			</div>
			
					<noscript>
					<p class="Avvisi" style="color:#000">
					<strong>Attenzione: </strong>Il tuo JavaScript NON E' ATTIVO! <br />
					Alcune cose potrebbero non funzionare.
					</p>
					</noscript>
		</div>
		<div id="pie-di-pagina">
			<?php require 'frm_footer.php';?>
		</div>
	</div>
	
	<?php require '../frm_dialogs.php';?>
	
</body>
</html>
