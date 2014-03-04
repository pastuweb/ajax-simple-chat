//memorizza un'istanza
var xmlHttp = createXmlHttpRequestObject();

var serverAddress = "check_online.php?action=GetOnline";
var updateInterval=5; //secondi di attesa tra un messaggio e l'altro
var errorRetryInterval = 30; //secondi di attesa dopo un errore
var debugMode = true; //per il debug


//restituisce l'oggetto XMLHttpRequest
function createXmlHttpRequestObject(){
	//memorizza il riferimento 
	var xmlHttp;
	//Internet Explorer
	if(window.ActiveXObject){
		try{
			xmlHttp= new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(e){
			xmlHttp = false;
		}
	}
	//Mozilla o altri
	else{
		try{
			xmlHttp = new XMLHttpRequest();
		}
		catch(e){
			xmlHttp = false;
		}
	}
	if(!xmlHttp){
		alert("Errore durante la creazione dell'oggetto XMLHttpRequest.");
	}else{
		return xmlHttp;
	}
}

//visulaizza un messaggio 
function display($message){
	myDiv = document.getElementById("myDivElement");
	myDiv.innerHTML = $message + "<br/>";
}

//visulaizza un messaggio di ERRORE
function displayError($message){
	//se debugMode = true
	display("Errore nella ricezione della News! Riprovero' fra " + errorRetryInterval + " secondi." + (debugMode ? "<br/>" + $message : ""));
	//riavvio la sequenza 
	setTimeout("process();", errorRetryInterval * 1000);
}

//chiama server ASINCRONAMENTE
function process(){
	if(xmlHttp){
		try{
			display("Ricezione di un nuovo messaggio dal server...");
			xmlHttp.open("GET", serverAddress, true);
			xmlHttp.onreadystatechange = handleGettingNews;
			xmlHttp.send(null);
		}catch(e){
			displayError(e.toString());
		}
	}
}

function handleGettingNews(){
	if(xmlHttp.readyState == 4){
		if(xmlHttp.status == 200){
			try{
				getOnline();
			}catch(e){
				displayError(e.toString());
			}
		}else{
			displayError(xmlHttp.statusText);
		}
	}
}

function getOnline(){
	var response = xmlHttp.responseText;
	if(response.indexOf("ERRNO") >= 0 || response.indexOf("error") >= 0 || response.length == 0){
		throw(response.length == 0 ? "Errrore sul server." : response);
	}
	display(response);
	setTimeout("process();", updateInterval * 1000);
}

