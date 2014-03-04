<?php

set_error_handler('error_handler', E_ALL);

function error_handler($errNo, $errStr, $errFile, $errLine)
{
  // cancella output generato
  if(ob_get_length()) ob_clean();
  // output messaggio errore
  $error_message = 'ERRNO: ' . $errNo . chr(10) .
                   'TEXT: ' . $errStr . chr(10) .
                   'LOCATION: ' . $errFile . 
                   ', line ' . $errLine;
  echo $error_message;
  exit;
}
?>
