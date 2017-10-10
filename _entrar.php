<?php
require_once("DB.php");
require_once("utiles.php");
require_once("sesion.php");

/**
 *	Si el parámetro salir se envía por el método GET,
 *  se llama a la función salir() incluída en el script sesion.php
 *  para limpiar los datos de la sesión (como cookies o información en la base de datos)
 */

if(isset($_GET["salir"])){

	salir();

}


if(isset($_POST["entrar"]) && $_POST["entrar"] = 1){ // Si se envían los datos de entrada
	//Llamamos a la función entrada() incluida en el script sesion.php para que evalúe los datos de entrada.
	echo entrada(trim($_POST["u"]), trim($_POST["p"]));

}else{
?>
<html>
	<head>
		<title>Entrar | <?php echo NOMBRE; ?></title>
		<link rel="stylesheet" href="css/entrar.css"></style>
		<script languaje="JavaScript" src="js/ajax.js"></script>
		<script languaje="JavaScript">
		var solicitudEnviada = false;

		/**
		Función: login
			Parámetros:
				u: Usuario
				p: Contraseña
			
			Ésta función envía utilizando AJAX el nombre de
			usuario y la contraseña, ésta última la manda 
			encriptada utilizando el hash md5 por motivos de seguridad
			al utilizar el protocolo http.
		*/
		var login = function(u, p){
			document.getElementById("entrar").value ="Entrando...";
			ajaxpost( "_entrar.php",  "entrar=1&u="+u+"&p="+md5(p),
				function(xhttp){
					
					if(xhttp.responseText == "1"){
						document.getElementById("entrar").value ="OK";
						window.location.href="index.php";
					}else{
						console.log(xhttp.responseText);
						document.getElementById("entrar").value ="Entrar";
						document.getElementById("info").innerHTML="Datos err&oacute;neos";
						document.getElementById("info").style.color="#FF0000";
					}
					solicitudEnviada = false;
				}
			);

		}
		/**
		Cargar los eventos JavaScript:
			Cuando se le pulse al boton Enviar, mediante AJAX entramos en el sistema.
		*/
		window.onload = function(){
			<?php
			// Si viene de haberse registrado
			if(isset($_GET["registro"]) && $_GET["registro"]=="ok"){
				?>
				document.getElementById("info").innerHTML="Registro correcto!";
				document.getElementById("info").style.color="#00FF00";
				<?php
			}
			?>
			document.getElementById("formulario_entrar").addEventListener("submit", function(e){
					e.preventDefault();
					if(!solicitudEnviada){
						solicitudEnviada = true;
						login(document.getElementById("usuario").value,document.getElementById("contrasena").value);
					}
				}
			);
		}
		</script>
		<script languaje="JavaScript" src="md5.js"></script>
	</head>
	<body>
		<div id="contenedor">
			<div id="login">
			<div id="saludo">Bienvenido a <?php echo NOMBRE; ?></div>
			<form id="formulario_entrar" method="get">
			<table border="0">
				<tr><td></td><td><span id="info"></span></td></tr>
				<tr><td>Usuario:</td><td><input type="text" id="usuario"/></td></tr>
				<tr><td>Contrase&ntilde;a:</td><td><input type="password" id="contrasena"/></td></tr>
				<tr><td><a href="registro.php">Registrarse</a></td><td><input type="submit" id="entrar" value="Entrar"/></td></tr>
			</table>
			</form>
			</div>
		</div>
	</body>
</html>
<?php
}
?>