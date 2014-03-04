<?php
require_once('config.php');
require_once('error_handler.php');

class Chat
{
  private $mMysqli;  
  
  function __construct() {   
    // connessione al database
    $this->mMysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, 
                                                      DB_DATABASE);      
  }
 
  public function __destruct() {
    $this->mMysqli->close();
  }

  public function deleteMessages(){ 
    $query = 'TRUNCATE TABLE chat'; 
    $result = $this->mMysqli->query($query);      
  }
  
  /*
    postMessages inserisce un messaggio nel database
  */ 
  public function postMessage($name, $message, $color){  
    $name = $this->mMysqli->real_escape_string($name);
    $message = $this->mMysqli->real_escape_string($message);
    $color = $this->mMysqli->real_escape_string($color);

    $query = 'INSERT INTO chat(posted_on, user_name, message, color) ' .
             'VALUES (NOW(), "' . $name . '" , "' . $message . 
             '","' . $color . '")'; 

    $result = $this->mMysqli->query($query);      
  }

  /*
    retrieveNewMessages recupera i nuovi messaggi inseriti
  */
  public function retrieveNewMessages($id=0){
    $id = $this->mMysqli->real_escape_string($id);

    if($id>0){
      //recuperiamo i messaggi più nuovi di $id
      $query = 
      'SELECT chat_id, user_name, message, color, ' . 
      '       DATE_FORMAT(posted_on, "%Y-%m-%d %H:%i:%s") ' . 
      '       AS posted_on ' .
      ' FROM chat WHERE chat_id > ' . $id . 
      ' ORDER BY chat_id ASC'; 
    }
    else{
	//al primo caricamento recuperiamo  solo gli ultimi 50 messaggi sul server
	//prima DESC perchè prende i 50 più grandi poi ASC percè vanno dal più vecchio al più nuovo(id più alta)
    	$query = 
      ' SELECT chat_id, user_name, message, color, posted_on FROM ' .
      '    (SELECT chat_id, user_name, message, color, ' . 
 
      '       DATE_FORMAT(posted_on, "%Y-%m-%d %H:%i:%s") AS posted_on ' .
      '     FROM chat ' .
      '     ORDER BY chat_id DESC ' .
      '      LIMIT 50) AS Last50' . 
      ' ORDER BY chat_id ASC';
    } 

    $result = $this->mMysqli->query($query);  

    // costruisci la risposta XML
    $response = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
    $response .= '<response>';  

    $response .= $this->isDatabaseCleared($id);

    if($result->num_rows){      
      // ciclo
      while ($row = $result->fetch_array(MYSQLI_ASSOC)){
      	
        $id = $row['chat_id'];
        $color = $row['color'];
        $userName = $row['user_name'];
        $time = $row['posted_on'];
        $message = $row['message'];
        
        $response .= '<id>' . $id . '</id>' . 
                     '<color>' . $color . '</color>' . 
                     '<time>' . $time . '</time>' . 
                     '<name>' . $userName . '</name>' . 
                     '<message>' . $message . '</message>';
      }
      $result->close();
    }
    
    $response = $response . '</response>';
    return $response;    
  }
  
  /*
    isDatabaseCleared controlla se il database è stato cancellato (deleteMessages) 
  */
  private function isDatabaseCleared($id){
    if($id>0){
           
      $check_clear = 'SELECT count(*) old FROM chat where chat_id<=' . $id;
      $result = $this->mMysqli->query($check_clear);
      $row = $result->fetch_array(MYSQLI_ASSOC);      
            
      // se è stato fatto TRUNCATE
      if($row['old']==0)
        return '<clear>true</clear>';     
    }
    return '<clear>false</clear>';
 
  }
}
?>
