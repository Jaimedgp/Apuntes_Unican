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
?><!DOCTYPE html><html><head><title>Entrar|<?php echo NOMBRE; ?></title><style type="text/css">#c,body,html{height:100%;background:#8698A8}#s,table{margin-left:auto;margin-right:auto}body{font-family:Arial;margin:0 auto;font-size:16px;display:table}#c{display:table-cell;vertical-align:middle}#l{min-width:100px;height:auto;margin-top:-100px;padding:50px 20px;background:#293440;color:#FFFFFF;overflow:hidden;border-radius:10px;border:1px solid #AAA}#s{text-align:center;font-size:20px}table{font-size:20px}input{background:#FFF;width:200px;border:0;font-size:20px}#e{cursor:pointer;background:#52687F;color:#FFF}#i{display:inline-block;width:200px}a{color:#EEEEEE;text-decoration:none}</style><script languaje="JavaScript" src="js/ajax.js"></script><script languaje="JavaScript">function f(x){return document.getElementById(x);}var a,c,d;a=false;function l(u, p){c=f("e");c.value ="Entrando...";ajaxpost("entrar.php","entrar=1&u="+u+"&p="+p,function(x){console.log(x.responseText);if(x.responseText == "1"){c.value ="OK";window.location.href="<?php if(isset($_GET["action"])){echo $_GET["action"];}else{echo "index.php";}?>";}else{c.value ="Entrar";d.innerHTML="Datos err&oacute;neos";d.style.color="#FF0000";}a=false;});}window.onload=function(){d=f("i");<?php if(isset($_GET["registro"]) && $_GET["registro"]=="ok"){?>d.innerHTML="Registro correcto!";d.style.color="#00FF00";<?php }?>f("f").addEventListener("submit", function(e){e.preventDefault();if(!a){a=true;l(f("u").value,f("n").value);}});}</script></head><body><div id="c"><div id="l"><div id="s">Bienvenido a <?php echo NOMBRE; ?></div><form id="f" method="get"><table border="0"><tr><td></td><td><span id="i"></span></td></tr><tr><td>Usuario:</td><td><input type="text" id="u"/></td></tr><tr><td>Contrase&ntilde;a:</td><td><input type="password" id="n"/></td></tr><tr><td></td><td><input type="submit" id="e" value="Entrar"/></td></tr></table></form></div></div></body></html><?php
}
?>