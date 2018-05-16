<?php
/**
Script: sesion.php
	Escrito por David Iglesias Sánchez
	Aplicación programada y diseñada por Jaime Diez Gonzalez-Pardo, Guillermo Pascual Cisneros, Mariam

	Éste script maneja las funciones de sesión:
		Functión:	haEntrado()
			Retorna true si el usuario ha entrado o false en cualquier otro caso.

		Función:	informacionUsuario()
			Retorna en forma de objeto la información del usuario

		Función: entrada()
			Verifica la entrada del usuario y si es correcta, envía una cookie al cliente
			con la información de la sesión.

				Argumentos: se le pasa el nombre de usuario y la contraseña encriptada con el
				algoritmo md5.

		Función: registro()
			Registra a un usuario en el sistema.
			Argumentos: se le pasa en nombre, primer apellido, segundo apellido, el nick, la contraseña y el
			e-mail.

		Función: salir()
			Asegura la salida del sistema eliminando la sesión de la base de datos y la cookie en el cliente.


*/
require_once("DB.php");

require_once("utiles.php");
$USERINFO = array();

session_start();

/**
Functión:	haEntrado()
	Retorna true si el usuario ha entrado o false en cualquier otro caso.

	Busca si existe una sesión con la cookie.
*/
function haEntrado(){
	if(!isset($_SESSION["usersession"])){ return false;}
	$usersession = $_SESSION["usersession"];


	//echo "User = ".."<br>";
	$DB = sql_connect();
	if($oracionSesion = $DB->prepare("SELECT IdUsuario FROM Sesion WHERE IdSesion=?")){

		if(!$oracionSesion->bindParam(1, $usersession)){$DB = null;return "0";}
		if(!$oracionSesion->execute()){$DB = null;return "0";}
		
		
		
		if($oracionSesion->rowCount() > 0){
			$filaSesion = $oracionSesion->fetchObject();

			$idUsuario = $filaSesion->IdUsuario;

			if($oracion = $DB->prepare("SELECT IdUsuario, Nombre, Apellido1, Apellido2, Nick, Email FROM Usuario WHERE IdUsuario=? AND Activo=1")){
				$oracion->bindParam(1, $idUsuario);
				$oracion->execute();
				if($oracion->rowCount()>0){

					$GLOBALS["USERINFO"] = $oracion->fetchObject();
					$DB = null;
					return true;
				}
			}

		}

	}

	$DB = null;
	return false;
}

/**
Función:	idUsuario()
	Retorna el id del usuario
*/

function idUsuario(){
	return $GLOBALS["USERINFO"]->IdUsuario;
}


/**
Función:	informacionUsuario()
	Retorna en forma de objeto la información del usuario
*/

function informacionUsuario(){
	return $GLOBALS["USERINFO"];
}

/**
 *Función: entrada()
 *	Verifica la entrada del usuario y si es correcta, envía una cookie al cliente
 *	con la información de la sesión.
 *
 *		Argumentos: se le pasa el nombre de usuario y la contraseña encriptada con el
 *		algoritmo md5.
 *
 */
function entrada($user, $pass){
	$DB = sql_connect();
	if($oracion = $DB->prepare("SELECT IdUsuario FROM Usuario WHERE Nick=? AND Password=? AND Activo=1")){
		$pass=md5($pass);
		$oracion->bindParam(1, $user, PDO::PARAM_STR);
		$oracion->bindParam(2, $pass, PDO::PARAM_STR);
		$oracion->execute();
			if($oracion->rowCount() > 0){
				$fila = $oracion->fetchObject();


				$usersession = generarCodigoSecreto($fila->IdUsuario.$pass);

				//Eliminamos si existe una sesion anterior en la base de datos
				$DB->query("DELETE FROM Sesion WHERE IdUsuario=".$fila->IdUsuario);


				if($oracionSesion = $DB->prepare("INSERT INTO Sesion(IdSesion, IdUsuario, Fecha) VALUES(?, ?, CURRENT_TIMESTAMP)")){

					if(!$oracionSesion->bindParam(1, $usersession, PDO::PARAM_STR)){return "0";}
					if(!$oracionSesion->bindParam(2, $fila->IdUsuario, PDO::PARAM_INT)){return "0";}
					if(!$oracionSesion->execute()){return "0";}

					$_SESSION["usersession"]=$usersession;
					$DB = null;
					return "1";
				}else{
					$DB = null;
					return "Error";
				}
			}else{
				sleep(2);// Amortiguamos en caso de un envío masivo.
				$DB = null;
				return "0";
			}

	}else{
		sleep(2);// Amortiguamos en caso de un envío masivo.
		$DB = null;
		return "0";
	}
	$DB = null;
}

/**
 *	Función: registro()
 *		Registra a un usuario en el sistema.
 *		Argumentos: se le pasa en nombre, primer apellido, segundo apellido, el nick, la contraseña y el e-mail.	
 */
function registro($nick, $password){

	sleep(2); // Amortiguamos en caso de un envío masivo.
	if(isset($nick) && isset($password)){
		$DB = sql_connect();
		if($oracion = $DB->prepare("SELECT Nick FROM Usuario WHERE Nick=?")){
			$oracion->bindParam(1, $nick);
			$oracion->execute();
			
			if($oracion->rowCount()>0){ // If Nick or Email Exists!
				if($fila = $oracion->fetchObject()){
					return 3;
				}
				
			}else{
				if($oracionNum = $DB->prepare("SELECT MAX(IdUsuario)+1 AS num FROM Usuario")){
					if($oracionNum->execute()){
						$filaNum = $oracionNum->fetchObject();
						$IdUsuario = $filaNum->num;
					}else{
						$DB = null;
						return 5;
					}

				}
				if($oracion = $DB->prepare("INSERT INTO `Usuario` (`IdUsuario`, `Nombre`, `Apellido1`, `Apellido2`, `Password`, `Nick`, `Email`, `Activo`) VALUES(?, 'x', 'x', 'x', ?, ?, 'x',1)")){
					$oracion->bindParam(1, $IdUsuario, PDO::PARAM_INT);
					$oracion->bindParam(2, $password, PDO::PARAM_STR);
					$oracion->bindParam(3, $nick, PDO::PARAM_STR);
					if($oracion->execute()){
						$DB = null;
						return 1;

					}else{
						$DB = null;
						return 5;
					}
				}

			}

		}

		$DB = null;	
	}else{
		return 2;
	}
}

/**
 *	Función: salir()
 *		Asegura la salida del sistema eliminando la sesión de la base de datos y la cookie en el cliente.
 */
function salir(){
	$DB = sql_connect();
	if(isset($_SESSION["usersession"])){
		if($oracion = $DB->prepare("DELETE FROM Sesion WHERE idSesion=?")){
			$oracion->bindParam(1, $_SESSION["usersession"], PDO::PARAM_STR);
			if($oracion->execute()){ return true;
				
	    		$_SESSION["usersession"]=null;
			}
		}
	}
	$DB = null;
	return false;
}
?>