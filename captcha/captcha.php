<?php
/**
 * Captcha básico.
 *	Crea una imagen con cinco caracteres. Tanto el color de fondo
 *	como el color del texto es aleatorio, dentro de un rango fijo.
 *	Utiliza sesión PHP.
 *
 *	Para utilizarlo:
 *		Incluir el script y llamar a la función generarCaptcha(), que retornará
 *		una imagen en png.
 *
 *	Para comprobar el captcha:
 *		Incluir éste script y llamar a la función comprobarCaptcha(), pasando como
 *		argumento el valor escrito. Retorna true si se verifica.
 */

// Iniciamos la sesión para pasar el texto del captcha.
session_start();

function generarCaptcha(){ // Si se ejecuta el script directamente (no está incluido)
	// Creamos la imagen
	$imagen = imagecreatetruecolor(250, 80);

	// Crear algunos colores
	$fondo = imagecolorallocate($imagen, 128-rand(-30, 30), 128-rand(-30, 30), 128-rand(-30, 30));

	$colorA = imagecolorallocate($imagen, 200-rand(-30, 30), 200-rand(-30, 30), 200-rand(-30, 30));
	$colorB = imagecolorallocate($imagen, 200-rand(-30, 30), 200-rand(-30, 30), 200-rand(-30, 30));
	$colorC = imagecolorallocate($imagen, 200-rand(-30, 30), 200-rand(-30, 30), 200-rand(-30, 30));
	$colorD = imagecolorallocate($imagen, 200-rand(-30, 30), 200-rand(-30, 30), 200-rand(-30, 30));
	$colorE = imagecolorallocate($imagen, 200-rand(-30, 30), 200-rand(-30, 30), 200-rand(-30, 30));


	imagefilledrectangle($imagen, 0, 0, 249, 79, $fondo);


	$letras = "aecdhfijgbe";
	$texto = $letras[rand(0,10)].$letras[rand(0,10)].$letras[rand(0,10)].$letras[rand(0,10)].$letras[rand(0,10)];
	$_SESSION["captcha"] = md5(strtoupper($texto));
	// El texto a dibujar

	// Utilizamos la fuente que se encuentra en el mismo directorio que el script
	$fuente = dirname(__FILE__).'/fuente.ttf';


	// Primera letra
	imagettftext($imagen, rand(40, 60), rand(-10, 10),   5, 60-rand(-10, 10), $colorA, $fuente, $texto[0]);

	// Segunda letra
	imagettftext($imagen, rand(40, 60), rand(-10, 10),  48, 60-rand(-10, 10), $colorE, $fuente, $texto[1]);

	// Tercera letra
	imagettftext($imagen, rand(40, 60), rand(-10, 10),  96, 60-rand(-10, 10), $colorC, $fuente, $texto[2]);

	// Cuarta letra
	imagettftext($imagen, rand(40, 60), rand(-10, 10), 144, 60-rand(-10, 10), $colorD, $fuente, $texto[3]);

	// Quinta letra
	imagettftext($imagen, rand(40, 60), rand(-10, 10), 192, 60-rand(-10, 10), $colorE, $fuente, $texto[4]);



	return $imagen;
}

function comprobarCaptcha($valor){
	if(md5(trim($valor)) == $_SESSION["captcha"]){ // Si coinciden los valores
		return true;
	}
	return false;
}
?>