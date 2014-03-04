<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Errore - PastuWeb Chat</title>
	<meta name="author" content="Pasturenzi Francesco www.pastuweb.com" />
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" type="text/css" href="stile_login.css" />
	
	<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
	<?php  include '../ready_jquery.php'; ?>

</head>


<body>
	<div id="centrato">
		<div id="intestazione">
		<p class="intesta"><a class="titolo" href="http://www.chat.pastuweb.com">PastuWeb Chat</a></p>
		<p class="pensiero">"...quello che l'occhio vede, l'orecchio sente, la mente crede..."</p>
		</div>
	
		<div id="corpo">
			<div id="colonna-2">
				<p class="Avvisi"> Errore tu NON PUOI ENTRARE!!</p>
				<br />
				<noscript>
				<p class="Avvisi" style="color:#000"><strong>Attenzione: </strong>Il tuo JavaScript NON E' ATTIVO!</p>
				</noscript>
			</div>
		</div>
		<div id="pie-di-pagina">
			<?php require 'frm_footer.php';?>
		</div>
	</div>
	
	<?php require '../frm_dialogs.php';?>
	
</body>
</html>
