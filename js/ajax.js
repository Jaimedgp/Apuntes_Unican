(
	function(){
		window.ajaxpost=function(u,p,c){a(u,p,c,0);}
		window.ajaxget = function(u,c){a(u,"",c,1)}
		function a(u,p,c,m){var x=new XMLHttpRequest();x.open(((m==0)?"POST":"GET"),u,true);if(m==0){x.setRequestHeader("Content-type","application/x-www-form-urlencoded");}
x.send(p);x.onreadystatechange=function(){if(x.readyState==4&&x.status==200){c(x);}}}
	})();