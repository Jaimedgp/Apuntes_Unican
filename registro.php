<?php
require_once("DB.php");
require_once("utiles.php");
require_once("sesion.php");
require_once("captcha/captcha.php");

if(isset($_GET["i"])){
	$DB = sql_connect();
	if($oracionSesion = $DB->prepare("SELECT IdCodigo FROM Invitacion WHERE BINARY Codigo=?")){

		if(!$oracionSesion->bindParam(1, $_GET["i"], PDO::PARAM_STR)){return "0";}
		if(!$oracionSesion->execute()){return "0";}
		
		
		
		if($oracionSesion->rowCount() > 0){
			//Continua;
		}else{
			die("<h1>403 Forbidden.</h1>");
		}

	}
	$DB=null;
}else{
	die("<h1>403 Forbidden.</h1>");
}

// Si se envía el formulario, lo registramos
if(isset($_POST["enviado"])){

	// Comprobamos el captcha
	if(comprobarCaptcha($_POST["captcha"])){
		$resultado = registro($_POST["nick"], $_POST["password"]);
		switch($resultado){
			case "1":
				echo "OK";
			break;
			case "2":
				echo "Hubo un error grave.";
			break;
			case "3":
				echo "Ya existe ese nick.";
			break;
			default:
			case "5":
				echo "Hubo un error grave.";
			break;
		}
	}else{
		// Con ésto nos aseguramos que no sea viable el envío de pruebas masivas de captcha
		sleep(2);
		echo "Captcha incorrecto!";
	}
}else{
?>
<html>
	<head>
		<title>Registro | <?php echo NOMBRE; ?></title>
		<link rel="stylesheet" href="css/registro.css">
		<script languaje="JavaScript" src="js/ajax.js"></script>
		<script languaje="JavaScript">
		var solicitudEnviada = false;

		var withError = false;
		var register = function(){
			var nick = document.getElementById("nick");
			var pass1 = document.getElementById("passwd");
			var pass2 = document.getElementById("passwd_repeat");
			var captchaText = document.getElementById("captchaText");
			if(withError){
				pass1.style.borderColor="#CCCCCC";
				pass2.style.borderColor="#CCCCCC";
				nick.style.borderColor="#CCCCCC";
				withError = false;
			}
			//Check data
			if(pass1.value != pass2.value || pass1.value == "" || pass1.value === null){ // If passwords missmatch!
				pass1.style.borderColor="#FF0000";
				pass2.style.borderColor="#FF0000";
				withError=true;
			}

			if(pass1.value.length <5){
				document.getElementById("info").innerHTML="Contrase&ntilde;a muy corta... Por favor, utilice al menos 5 caracteres.";
				document.getElementById("info").style.color="#FF0000";
				pass1.style.borderColor="#FF0000";
				pass2.style.borderColor="#FF0000";
				withError=true;
			}

			if(nick.value == "" || nick.value == null){ // If nick name is empty!
				nick.style.borderColor="#FF0000";
				withError=true;
			}

			if(captchaText.value== "" || captchaText.value == null){ // Si el captcha está vacío
				withError = true;
				captchaText.style.borderColor = "#FF0000";
			}
			if(!withError){
				document.getElementById("entrar").value ="Registrandose...";
				//"u="+u+"&p="+md5(p)
				var postHeader = "enviado=1";
				postHeader += "&nick="+nick.value;
				postHeader += "&password="+md5(pass1.value);
				postHeader += "&captcha="+captchaText.value;
				ajaxpost( "registro.php?i=<?php echo $_GET["i"];?>", postHeader,
					function(xhttp){
						
						if(xhttp.responseText.trim() == "OK"){
							document.getElementById("entrar").value ="OK";
							window.location.href="entrar.php?registro=ok";
						}else{
							console.log(xhttp.responseText);
							document.getElementById("entrar").value ="Registrarse";
							document.getElementById("info").innerHTML="Error:"+xhttp.responseText;
							document.getElementById("info").style.color="#FF0000";
							document.getElementById("captcha").src="captcha.php?token="+Date.now();
						}
						solicitudEnviada = false;
					}
				);
			}else{
				solicitudEnviada = false;
			}

		}
		window.onload = function(){
			document.getElementById("form_register").addEventListener("submit", function(e){
					e.preventDefault();
					if(!solicitudEnviada){
						solicitudEnviada = true;
						register();
					}
				}
			);
			document.getElementById("acepto").addEventListener("change",
				function(e){
					document.getElementById("entrar").disabled=!document.getElementById("acepto").checked;
				});
		}
		</script>
		<script languaje="JavaScript" src="md5.js"></script>
	</head>
	<body>
		<div id="contenedor">
			<div id="login">
			<div id="saludo">Registro en <?php echo NOMBRE; ?></div>
			<form id="form_register" method="get">
			<table border="0">
				<tr><td></td><td><span id="info"></span></td></tr>
				<tr><td>Nick:</td><td><input type="text" id="nick"/></td></tr>
				<tr><td>Contrase&ntilde;a:</td><td><input type="password" id="passwd"/></td></tr>
				<tr><td>Repetir contrase&ntilde;a:</td><td><input type="password" id="passwd_repeat"/></td></tr>
				<tr><td><img id="captcha" src="captcha.php" alt="error"></td><td><input type="text" id="captchaText"/></td></tr>
				<tr><td></td><td><input type="checkbox" name="checkbox" id="acepto" />He le&iacute;do, entiendo y <br>
				acepto los <a href="tc.html" target="_blank">t&eacute;rminos y condiciones</a>.</td></tr>
				<tr><td></td><td><input type="submit" id="entrar" value="Registrar" disabled></td></tr>
			</table>
			</form>
			</div>
		</div>
	</body>
</html>
<?php
}
?>