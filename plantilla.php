<?php 
/**
Script: plantilla.php
	Éste script es la plantilla de la página principal. Al ser incluido desde
	index, para no permitir ejecutar directamente ésta página, la variable
	$desdeIndex debe de existir y ser true (se define en index.php).
*/
if(isset($desdeIndex) && $desdeIndex){
	$text=file_get_contents("estilo.html");
	$text=str_replace("{Titulo}","Unipuntes",$text);
	$text=str_replace("{idUsuario}",$userInfo->IdUsuario,$text);
	$text=str_replace("{Nombre}", $userInfo->Nick, $text);
	echo $text;
?>
<?php
}
?>