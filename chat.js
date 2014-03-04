/* chatURL - URL for updating chat messages */
var chatURL = "chat.php";
/* create XMLHttpRequest objects for updating the chat messages and getting the selected color */
var xmlHttpGetMessages = createXmlHttpRequestObject();
/* variables that establish how often to access the server */
var updateInterval = 1000; // how many miliseconds to wait to get new message
// when set to true, display detailed error messages
var debugMode = true;
/* initialize the messages cache */
var cache = new Array();
/* lastMessageID - the ID of the most recent chat message */
var lastMessageID = -1; 

/* creates an XMLHttpRequest instance */
function createXmlHttpRequestObject() 
{
  // will store the reference to the XMLHttpRequest object
  var xmlHttp;
  // this should work for all browsers except IE6 and older
  try
  {
    // try to create XMLHttpRequest object
    xmlHttp = new XMLHttpRequest();
  }
  catch(e)
  {
    // assume IE6 or older
    var XmlHttpVersions = new Array("MSXML2.XMLHTTP.6.0",
                                    "MSXML2.XMLHTTP.5.0",
                                    "MSXML2.XMLHTTP.4.0",
                                    "MSXML2.XMLHTTP.3.0",
                                    "MSXML2.XMLHTTP",
                                    "Microsoft.XMLHTTP");
    // try every prog id until one works
    for (var i=0; i<XmlHttpVersions.length && !xmlHttp; i++) 
    {
      try 
      { 
        // try to create XMLHttpRequest object
        xmlHttp = new ActiveXObject(XmlHttpVersions[i]);
      } 
      catch (e) {}
    }
  }
  // return the created object or display an error message
  if (!xmlHttp)
    alert("Error creating the XMLHttpRequest object.");
  else 
    return xmlHttp;
}
/* --------------------------------------------------------------- */
/* INIZIALIZZO LA CHAT */
function init() 
{
  // get a reference to the text box where the user writes new messages
  var oMessageBox = document.getElementById("messageBox");
  // prevents the autofill function from starting
  oMessageBox.setAttribute("autocomplete", "off");    
  // references the "Text will look like this" message
  var oSampleText = document.getElementById("sampleText");
  // set the default color to black
  oSampleText.style.color = "black";    
  // initiates updating the chat window
  requestNewMessages();
}
/* --------------------------------------------------------------- */

/* --------------------------------------------------------------- */
/* Questa funziona viene chiamata quando clicco sul button "Invia" */
function sendMessage()
{
  // save the message to a local variable and clear the text box
  var oCurrentMessage = document.getElementById("messageBox");
  var currentUser = document.getElementById("userName").value;
  var currentColor = document.getElementById("color").value;
  // don't send void messages
  if (trim(oCurrentMessage.value) != "" &&
      trim(currentUser) != "" && trim (currentColor) != "")
  {
    // if we need to send and retrieve messages
    params =  "mode=SendAndRetrieveNew" +
              "&id=" + encodeURIComponent(lastMessageID) + 
              "&color=" + encodeURIComponent(currentColor) + 
              "&name=" + encodeURIComponent(currentUser) + 
              "&message=" + encodeURIComponent(oCurrentMessage.value);
    // add the message to the queue
    cache.push(params);
    // clear the text box
    oCurrentMessage.value = "";
  }
}
/* --------------------------------------------------------------- */

/* --------------------------------------------------------------- */
/* funzione chiamata quando l'ADMIN clicca su "Cancella tutto" */
function deleteMessages()
{
  // set the flag that specifies we're deleting the messages
  params = "mode=DeleteAndRetrieveNew";  
  // add the message to the queue
  cache.push(params);
}
/* --------------------------------------------------------------- */

/* --------------------------------------------------------------- */
/* richiesta ASINCRONA */
function requestNewMessages()
{  
  // retrieve the username and color from the page
  var currentUser = document.getElementById("userName").value;
  var currentColor = document.getElementById("color").value;
  // only continue if xmlHttpGetMessages isn't void
  if(xmlHttpGetMessages)
  {
    try
    {
      // don't start another server operation if such an operation 
      //   is already in progress 
      if (xmlHttpGetMessages.readyState == 4 || 
          xmlHttpGetMessages.readyState == 0) 
      {
        // we will store the parameters used to make the server request
        var params = "";
        // if there are requests stored in queue, take the oldest one
        if (cache.length>0)
          params = cache.shift();
        // if the cache is empty, just retrieve new messages        
        else
          params = "mode=RetrieveNew" +
                   "&id=" +lastMessageID;
        // call the server page to execute the server-side operation
        xmlHttpGetMessages.open("POST", chatURL, true);
        xmlHttpGetMessages.setRequestHeader("Content-Type", 
                                   "application/x-www-form-urlencoded");
        xmlHttpGetMessages.onreadystatechange = handleReceivingMessages;
 
        xmlHttpGetMessages.send(params);
      }
      else
      {
        // we will check again for new messages 
        setTimeout("requestNewMessages();", updateInterval);
      }
    }
    catch(e)
    {
      displayError(e.toString());
    }
  }
}
/* --------------------------------------------------------------- */

/* --------------------------------------------------------------- */
/* qui gestisco la risposta del serevr */
function handleReceivingMessages() 
{
  // continue if the process is completed
  if (xmlHttpGetMessages.readyState == 4) 
  {
    // continue only if HTTP status is "OK"
    if (xmlHttpGetMessages.status == 200) 
    {
      try
      {
        // risposta del server
        readMessages();
      }
      catch(e)
      {
        // display the error message
        displayError(e.toString());
      }
    } 
    else
    {
      // display the error message
      displayError(xmlHttpGetMessages.statusText);
    }
  }
}
/* --------------------------------------------------------------- */

/* --------------------------------------------------------------- */
/* ricevo la risposta dal server */
function readMessages()
{  
  // retrieve the server's response 
  var response = xmlHttpGetMessages.responseText;
  // server error?
  if (response.indexOf("ERRNO") >= 0 
      || response.indexOf("error:") >= 0
      || response.length == 0)
    throw(response.length == 0 ? "Void server response." : response);
  // retrieve the document element
  response = xmlHttpGetMessages.responseXML.documentElement;
  // retrieve the flag that says if the chat window has been cleared or not 
  clearChat = 
           response.getElementsByTagName("clear").item(0).firstChild.data;
  // if the flag is set to true, we need to clear the chat window 
  if(clearChat == "true")
  {
    // clear chat window and reset the id
    document.getElementById("scroll").innerHTML = "";
    lastMessageID = -1;
 
  }
  // retrieve the arrays from the server's response     
  idArray = response.getElementsByTagName("id");
  colorArray = response.getElementsByTagName("color");
  nameArray = response.getElementsByTagName("name");
  timeArray = response.getElementsByTagName("time");
  messageArray = response.getElementsByTagName("message");
  // add the new messages to the chat window
  displayMessages(idArray, colorArray, nameArray, timeArray, 
                                                       messageArray);
  // the ID of the last received message is stored locally
  if(idArray.length>0)
    lastMessageID = idArray.item(idArray.length - 1).firstChild.data;
  // restart sequence
  setTimeout("requestNewMessages();", updateInterval);
}
/* --------------------------------------------------------------- */

/* --------------------------------------------------------------- */
/* appende(=stampa) un nuovo messaggio nella CHAT */
function displayMessages(idArray, colorArray, nameArray, 
                         timeArray, messageArray)
{
  // each loop adds a new message
  for(var i=0; i<idArray.length; i++)
  {
    // get the message details
    var color = colorArray.item(i).firstChild.data.toString();
    var time = timeArray.item(i).firstChild.data.toString();
    var name = nameArray.item(i).firstChild.data.toString();
    var message = messageArray.item(i).firstChild.data.toString();
    // compose the HTML code that displays the message
    var htmlMessage = "";
    htmlMessage += "<div class=\"item\" style=\"color:" + color + "\">"; 
    htmlMessage += "[" + time + "] <strong style=\"font-size:120%\">" + name + "</strong> said: <br/>";
    htmlMessage += message.toString();
    htmlMessage += "</div>";
    // display the message
    displayMessage (htmlMessage);
  }
}
/* --------------------------------------------------------------- */

/* --------------------------------------------------------------- */
/* visualizza messaggio */
function displayMessage(message)
{
  // get the scroll object
  var oScroll = document.getElementById("scroll");
  // check if the scroll is down
  var scrollDown = (oScroll.scrollHeight - oScroll.scrollTop <= 
                    oScroll.offsetHeight );
  // display the message
  oScroll.innerHTML += message;
  // scroll down the scrollbar
  oScroll.scrollTop = scrollDown ? oScroll.scrollHeight : oScroll.scrollTop;
}
/* --------------------------------------------------------------- */

/* --------------------------------------------------------------- */
/* visualizzo messaggi di errore */
function displayError(message)
{
  // display error message, with more technical details if debugMode is true
  displayMessage("Error accessing the server! "+
                 (debugMode ? "<br/>" + message : ""));
}
/* --------------------------------------------------------------- */

/* --------------------------------------------------------------- */
/* questa funzione gestisce la pressione del tasto della tastiera INVIO */
function handleKey(e) 
{
  // get the event
  e = (!e) ? window.event : e;
  // get the code of the character that has been pressed        
  code = (e.charCode) ? e.charCode :
         ((e.keyCode) ? e.keyCode :
         ((e.which) ? e.which : 0));
  // handle the keydown event       
  if (e.type == "keydown") 
  {
    // if enter (code 13) is pressed
    if(code == 13)
    {
      // send the current message  
      sendMessage();
    }
  }
}
/* --------------------------------------------------------------- */

/* --------------------------------------------------------------- */
/* removes leading and trailing spaces from the string */
function trim(s)
{
    return s.replace(/(^\s+)|(\s+$)/g, "");
}
/* --------------------------------------------------------------- */

/* --------------------------------------------------------------- */
/* eseguita se l'utente cambia il colore del testo modificando la textbox "color" */
function getUserColor(){
	 var colore = document.getElementById("color");
	 
	 // change color
	 var oSampleText = document.getElementById("sampleText");
	 oSampleText.style.color = colore.value;
	
}
/* --------------------------------------------------------------- */
