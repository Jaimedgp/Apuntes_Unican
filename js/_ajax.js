/**
	Funciones para el envío utilizando AJAX
**/
function ajaxpost( url,  postsend,  callback){
	var xhttp = new XMLHttpRequest();
	xhttp.open("POST", url, true);
	xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xhttp.send(postsend);
	xhttp.onreadystatechange = function(){
		if(xhttp.readyState == 4 && xhttp.status == 200){
			callback(xhttp);
		}
	}
}

function ajaxget( url,  callback){
	var xhttp = new XMLHttpRequest();
	xhttp.open("GET", url, true);
	xhttp.send();
	xhttp.onreadystatechange = function(){
		if(xhttp.readyState == 4 && xhttp.status == 200){
			callback(xhttp);
		}
	}
}