<?php
/************************************************************************************************************************************
 * 		Script: becario.php
 *			Escrito por David Iglesias Sánchez.
 *			Aplicación programada y diseñada por Jaime Diez Gonzalez-Pardo
 *
 *		Éste script es el encargado de enlazar las consultas de la base de datos con la página web (mediante AJAX).
 *		Se compone de las siguientes funciones:
 *
 *			Función: obtener_estudios
 *				Se encarga de mostrar los estudios disponibles en la  base de datos.
 *
 *			Función: obtener_asignaturas
 *				Retorna las asignaturas en base al grado y al curso pasado por GET al script.
 *
 *			Función: filtrar_apuntes
 *				Muestra los apuntes aplicando los filtros de búsqueda.
 *
 *			Función: buscar_texto
 *				Retorna los apuntes buscando por título o comentario. Además, seleciona si busca exámenes, apuntes,
 *				o ambos dependiendo de la variable tipo pasada como argumento.
 *			
 *			Función: obtener_ultimos
 *				Retorna los últimos apuntes subidos.
 *
 *			Función: informacion_documento
 *				Retorna la información del documento pasado por su identificador mediante get.
 */
/**
Incluir para manejar la base de datos
*/

// Only ssl!
if(empty($_SERVER['HTTPS'])){die("0");}

require_once("configuracion.php");
require_once("DB.php");
require_once("utiles.php");
require_once("sesion.php");




//Enviar la cabecera con la codificación utf-8 para evitar errores en los caracteres.
header('Content-Type: text/html; charset=utf-8');



//Comprobar si el usuario ha entrado al sistema
if(!haEntrado()){
	die("Err");
}



/**
Función: obtener_estudios
	Retorna los estudios disponibles de la base de datos
*/
function obtener_estudios(){
	$DB = sql_connect();

	if($puntero = $DB->query("SELECT IdEstudios, Nombre FROM Estudios")){
		$i = $puntero->rowCount();
		while($fila = $puntero->fetchObject()){
			echo $fila->IdEstudios."|".$fila->Nombre."|";
		}
	}
	// Close the connection
	$DB=null;

}

/**
Función: obtener_tipos
	Retorna los tipos de apuntes disponibles de la base de datos
*/
function obtener_tipos(){
	$DB = sql_connect();
	if(isset($_GET["tipo"])){
		if($oracion = $DB->prepare("SELECT IdTipo, Nombre FROM Tipo WHERE IdTipo = ?")){
			$oracion->bindParam(1, $_GET["tipo"]);
			$oracion->execute();
				if($fila = $oracion->fetchObject()){
					echo $fila->Nombre;
				}
	
		}
	}else{
		if($oracion = $DB->query("SELECT IdTipo, Nombre FROM Tipo")){
			$i = $oracion->rowCount();
			while($fila = $oracion->fetchObject()){
				echo $fila->IdTipo."|".$fila->Nombre."|";

			}
		}
	}
	// Close the connection
	$DB=null;
}
/**
Función: obtener_cursos
	Retorna la fecha de los cursos
*/
function obtener_cursos(){
	$DB = sql_connect();

	if($puntero = $DB->query("SELECT IdAnio, Anio FROM Anio")){
		$i = $puntero->rowCount();
		while($fila = $puntero->fetchObject()){
			echo $fila->IdAnio."|".$fila->Anio."|";

		}
	}
	// Close the connection
	$DB=null;
}

/**
Funcion: puntos
	Calcula los puntos de un usuario.
*/
function puntos(){
	if(!isset($_GET["id"])){ json_void(); return 0;}
	$idUsuario = $_GET["id"];
	$DB = sql_connect();
	if($oracion = $DB->prepare("SELECT COUNT(*)*10 AS puntos FROM `Documentos` WHERE Usuario = ?")){
		$oracion->bindParam(1, $idUsuario);
		$oracion->execute();
			if($fila = $oracion->fetchObject()){
				echo $fila->puntos;
				return ;
			}
	}
	// Close the connection
	$DB=null;
}

/**
Función: obtener_asignaturas
	Retorna las asignaturas en base al grado y al curso pasado por GET al script.
*/
function obtener_asignaturas(){
	$DB = sql_connect();
	$idGrado = (isset($_GET["grado"])) ? $_GET["grado"] : "ALL";
	$idCurso = (isset($_GET["curso"])) ? $_GET["curso"] : "ALL";


		// Preparamos la sentencia SQL, dependiendo de los parámetros pasados

		$oracionSQL = "SELECT IdAsignatura, Codigo, Nombre, Estudios, Curso FROM Asignatura";

		if($idGrado !== "ALL" && $idCurso !== "ALL"){
			$oracionSQL .= " WHERE Estudios=? AND Curso=?";
		}else{

			if($idGrado !== "ALL"){
				$oracionSQL .= " WHERE Estudios=?";
			}

			if($idCurso !== "ALL"){
				$oracionSQL .= " WHERE Curso=?";
			}
		}

		if($oracion = $DB->prepare($oracionSQL)){

			if($idGrado !== "ALL" && $idCurso !== "ALL"){
				$oracion->bindParam(1, $idGrado, PDO::PARAM_INT);
				$oracion->bindParam(2, $idCurso, PDO::PARAM_INT);
			}else{

				if($idGrado !== "ALL"){
					$oracion->bindParam(1, $idGrado, PDO::PARAM_INT);
				}

				if($idCurso !== "ALL"){
					$oracion->bindParam(1, $idCurso, PDO::PARAM_INT);
				}
			}

			$oracion->execute();

				$i = 0;
				while($fila = $oracion->fetchObject()){
					echo $fila->IdAsignatura."|".$fila->Nombre."|";

				}
	}
	// Close the connection
	$DB=null;

}

/**
Función: obtener_grados
	Retorna los grados disponibles en la plataforma.
*/

function obtener_grados(){
	$DB = sql_connect();
	if($puntero = $DB->query("SELECT IdEstudios, Nombre FROM Estudios")){
			$i = $puntero->rowCount();
			while($fila = $puntero->fetchObject()){
				echo $fila->IdEstudios."|".$fila->Nombre."|";

			}

	}else{
		json_void();
	}
	// Close the connection
	$DB=null;
}

function obtener_anios(){
	echo "1|Primero|2|Segundo|3|Tercero|4|Cuarto";
}
/**
Función: filtrar_apuntes
	Muestra los apuntes aplicandoles filtro de búsqueda.
*/
function filtrar_apuntes(){
	$DB = sql_connect();

	$idAsignatura = isset($_GET["asignatura"]) ? $_GET["asignatura"] : "-1";
	$idCurso = isset($_GET["curso"]) ? $_GET["curso"] : "-1";
	$idGrado = isset($_GET["grado"]) ? $_GET["grado"] : "-1";
	$idTipo = isset($_GET["tipo"]) ? $_GET["tipo"] : "-1";
	$pagina  = isset($_GET["pagina"]) ? $_GET["pagina"] : 0;
	$offset = $pagina*10; 

	if($idAsignatura !== "-1"){
		
		$oracionSQL ="SELECT DISTINCT Documentos.IdDocumento, Documentos.Titulo, Usuario.Nick AS Nick, Documentos.FechaSubida, Tipo.Nombre AS Tipo, Documentos.Tipo AS IdTipo, Anio.Anio, Documento, Asignatura.Nombre AS Asignatura, Documentos.Comentario, Documentos.Usuario AS IdUsuario, Estudios.Nombre AS Grado FROM Documentos, Tipo, Usuario, Anio, Asignatura, Estudios WHERE Documentos.Activo = 1 AND Documentos.Asignatura=? AND ";
		
		if($idTipo != "-1"){
			$oracionSQL.="Tipo.IdTipo=? AND ";
		}

		$oracionSQL.="Documentos.Usuario = Usuario.IdUsuario AND Anio.IdAnio = Documentos.Anio AND Tipo.IdTipo = Documentos.Tipo AND Documentos.asignatura = Asignatura.IdAsignatura AND Asignatura.Estudios = Estudios.IdEstudios ORDER BY FechaSubida, IdDocumento DESC LIMIT ?,11";

		if($oracion = $DB->prepare($oracionSQL)){

			$bindIndex=0;
			$oracion->bindParam(++$bindIndex, $idAsignatura, PDO::PARAM_INT);
			
			if($idTipo !== "-1"){
				$oracion->bindParam(++$bindIndex, $idTipo, PDO::PARAM_INT);
			}

			$oracion->bindParam(++$bindIndex, $offset, PDO::PARAM_INT);
			
			$oracion->execute();
				$i=0;
				while(($fila = $oracion->fetchObject())&&$i<10){
					echo $fila->IdDocumento.'|'.$fila->Titulo.'|'.$fila->Nick.'|'.$fila->IdUsuario.'|'.$fila->Comentario.'|'.$fila->FechaSubida.'|'.$fila->Tipo.'|'.$fila->Anio.'|'.$fila->Grado.'|'.$fila->Asignatura.'|'.$fila->IdTipo.'|';
					$i++;
				}

				
				if($i>=10){ echo "1|";}
				elseif($i>0){echo "0|";}
				if($i==0){json_void();}
		}else{
			json_void();
		}
	}else{
		$oracionSQL = "SELECT DISTINCT Documentos.IdDocumento, Documentos.Titulo, Usuario.Nick AS Nick, Documentos.FechaSubida, Tipo.Nombre AS Tipo, Anio.Anio, Documento, Asignatura.Nombre AS Asignatura, Documentos.Comentario, Documentos.Usuario AS IdUsuario, Estudios.Nombre AS Grado, Documentos.Tipo AS IdTipo FROM Documentos, Tipo, Usuario, Anio, Asignatura, Estudios WHERE Documentos.Activo = 1 AND ";
			if($idCurso !== "-1"){
				$oracionSQL .= "Asignatura.Curso=? AND ";
			}
			if($idGrado !== "-1"){
				$oracionSQL .= "Asignatura.Estudios=? AND ";
			}
			if($idTipo !== "-1"){
				$oracionSQL.="Tipo.IdTipo=? AND ";
			}
		 
		 $oracionSQL .= "Documentos.Usuario = Usuario.IdUsuario AND Anio.IdAnio = Documentos.Anio AND Tipo.IdTipo = Documentos.Tipo AND Documentos.asignatura = Asignatura.IdAsignatura AND Asignatura.Estudios = Estudios.IdEstudios ORDER BY Documentos.FechaSubida, IdDocumento DESC LIMIT 11 OFFSET ?";

		if($oracion = $DB->prepare($oracionSQL)){


		$bindIndex = 0;
		if($idCurso !== "-1"){
			$oracion->bindParam(++$bindIndex, $idCurso, PDO::PARAM_INT);
		}
		if($idGrado !== "-1"){
			$oracion->bindParam(++$bindIndex, $idGrado, PDO::PARAM_INT);
		}
		if($idTipo !== "-1"){
			$oracion->bindParam(++$bindIndex, $idTipo, PDO::PARAM_INT);
		}
			
		$oracion->bindParam(++$bindIndex, $offset, PDO::PARAM_INT);

			$oracion->execute();
				$i=0;

				while(($fila = $oracion->fetchObject()) && $i<10){
					echo $fila->IdDocumento.'|'.$fila->Titulo.'|'.$fila->Nick.'|'.$fila->IdUsuario.'|'.$fila->Comentario.'|'.$fila->FechaSubida.'|'.$fila->Tipo.'|'.$fila->Anio.'|'.$fila->Grado.'|'.$fila->Asignatura.'|'.$fila->IdTipo.'|';
					$i++;

				}
				
				if($i>=10){ echo "1|";}
				elseif($i>0){echo "0|";}
				if($i==0){json_void();}

	
		}else{
			json_void();
		}

	}

	// Close the connection
	$DB=null;

}

/**
Función: buscar_texto
	Retorna los apuntes buscando por título o comentario. Además, seleciona si busca exámenes, apuntes, o ambos dependiendo de la variable tipo
	pasada por GET. Se muestra a continuación la tabla de verdad entre el valor de tipo y la búsqueda de Examenes o Apuntes:
		Examenes 	Apuntes 	Tipo
		true		true		3
		true		false		2
		false		true		1	
*/
function buscar_texto(){
	$DB = sql_connect();					// Nos conectamos con la base de datos

	$query = $_GET["busqueda"];				// Texto de búsqueda

	$idAsignatura = isset($_GET["asignatura"]) ? $_GET["asignatura"] : "-1";
	$idCurso = isset($_GET["curso"]) ? $_GET["curso"] : "-1";
	$idGrado = isset($_GET["grado"]) ? $_GET["grado"] : "-1";
	$idTipo = isset($_GET["tipo"]) ? $_GET["tipo"] : "-1";
	$pagina  = isset($_GET["pagina"]) ? $_GET["pagina"] : 0;
	$offset = $pagina*10; 


	/**
		A partir de éste punto, generamos la consulta SQL dependiendo de los datos recibidos.
	*/
	$oracionSQL = "SELECT DISTINCT Documentos.IdDocumento, Documentos.Titulo, Usuario.Nick AS Nick, Documentos.FechaSubida, Tipo.Nombre AS Tipo, Anio.Anio, Documentos.Documento , Asignatura.Nombre AS Asignatura, Documentos.Comentario, Documentos.Usuario AS IdUsuario, Estudios.Nombre AS Grado, Documentos.Tipo AS IdTipo FROM Documentos, Tipo, Usuario, Anio, Asignatura, Estudios WHERE ( Documentos.Titulo LIKE ? OR Documentos.Comentario LIKE ? ) AND Documentos.Usuario = Usuario.IdUsuario AND Documentos.Activo = 1 AND Anio.IdAnio = Documentos.Anio AND Tipo.IdTipo = Documentos.Tipo AND Documentos.asignatura = Asignatura.IdAsignatura AND ";

	if($idAsignatura !== "-1"){
		$oracionSQL .= "Documentos.asignatura=? AND ";
	}else{

		if($idCurso !== "-1"){
			$oracionSQL .= "Asignatura.Curso=? AND ";
		}
		if($idGrado !== "-1"){
			$oracionSQL .= "Asignatura.Estudios=? AND ";
		}
		
	}
	if($idTipo !== "-1"){
		$oracionSQL.="Tipo.IdTipo=? AND ";
	}


	$oracionSQL .= "Asignatura.Estudios = Estudios.IdEstudios ORDER BY Documentos.FechaSubida, Documentos.IdDocumento LIMIT 11 OFFSET ?";
	if($oracion = $DB->prepare($oracionSQL)){			// Si no hay ningún error al preparar la oración SQL

			/**
				Parseamor la búsqueda, dependiendo del texto:
					· Si la búsqueda empieza y acaba con comillas ("), entonces generamos una consulta donde
					  tenga que aparecer explicitamente la búsqueda.
					· Si la búsqueda no empieza y acaba con comillas, entonces generamos una consulta donde se
					  busquen apuntes cuyo título y/o compentario contengan las palabras en el órden dado.
			*/
			if($query[0] == '"' && $query[strlen($query)-1] == '"'){
				$query_bind = "%".str_replace("\"", "", $query)."%";
			}else{

				$query_palabras = explode(" ", $query);
				$i = 0;
				$query_bind = "";
				while($i<count($query_palabras)){
					$query_bind.="%".$query_palabras[$i];
					$i++;
				}
				$query_bind.="%";
			}

			// Añadimos las cadenas de texto a la consulta y el OFFSET

			$bindIndex = 0;

			$oracion->bindParam(++$bindIndex, $query_bind, PDO::PARAM_STR);
			$oracion->bindParam(++$bindIndex, $query_bind, PDO::PARAM_STR);

			if($idAsignatura !== "-1"){
				$oracion->bindParam(++$bindIndex, $idAsignatura, PDO::PARAM_INT);
			}else{

				if($idCurso !== "-1"){
					$oracion->bindParam(++$bindIndex, $idCurso, PDO::PARAM_INT);
				}
				if($idGrado !== "-1"){
					$oracion->bindParam(++$bindIndex, $idGrado, PDO::PARAM_INT);
				}
				
						
			}
			if($idTipo !== "-1"){
				$oracion->bindParam(++$bindIndex, $idTipo, PDO::PARAM_INT);
			}
			
			
			$oracion->bindParam(++$bindIndex, $offset, PDO::PARAM_INT);

			$oracion->execute();									// Ejecutamos la consulta

				$i=0;
				while(($fila = $oracion->fetchObject())&&$i<10){				// Generamos el código JSON para enviarlo por AJAX.
					echo $fila->IdDocumento.'|'.$fila->Titulo.'|'.$fila->Nick.'|'.$fila->IdUsuario.'|'.$fila->Comentario.'|'.$fila->FechaSubida.'|'.$fila->Tipo.'|'.$fila->Anio.'|'.$fila->Grado.'|'.$fila->Asignatura.'|'.$fila->IdTipo.'|';
					$i++;

				}
				if($i>=10){ echo "1|";}
				elseif($i>0){echo "0|";}
				if($i==0){json_void();}
	}else{
		json_void();
	}

	// Close the connection
	$DB=null;

}

/**
Función: obtener_ultimos
	Retorna los últimos apuntes subidos.
*/
function obtener_ultimos(){

	$DB = sql_connect();
	if($puntero = $DB->query("SELECT DISTINCT Documentos.IdDocumento, Documentos.Titulo, Usuario.Nick AS Nick, Documentos.FechaSubida, Tipo.Nombre AS Tipo, Anio.Anio,Documento , Asignatura.Nombre AS Asignatura, Documentos.Comentario, Documentos.Usuario AS IdUsuario, Estudios.Nombre AS Grado, Documentos.Tipo AS IdTipo FROM Documentos, Tipo, Usuario, Anio, Asignatura, Estudios WHERE Documentos.Usuario = Usuario.IdUsuario AND Anio.IdAnio = Documentos.Anio AND Tipo.IdTipo = Documentos.Tipo AND Documentos.Activo = 1 AND Documentos.asignatura = Asignatura.IdAsignatura AND Asignatura.Estudios = Estudios.IdEstudios ORDER BY Documentos.FechaSubida DESC LIMIT 0,10")){
			$i=0;
				while($fila = $puntero->fetchObject()){
					echo $fila->IdDocumento.'|'.$fila->Titulo.'|'.$fila->Nick.'|'.$fila->IdUsuario.'|'.$fila->Comentario.'|'.$fila->FechaSubida.'|'.$fila->Tipo.'|'.$fila->Anio.'|'.$fila->Grado.'|'.$fila->Asignatura.'|'.$fila->IdTipo.'|';
				//	echo '"Id":"'.$fila->IdDocumento.'",';
				//	echo '"Titulo":"'.$fila->Titulo.'",';
				//	echo '"Nick":"'.$fila->Nick.'",';
				//	echo '"IdUsuario":"'.$fila->IdUsuario.'",';
				//	echo '"Comentario":"'.$fila->Comentario.'",';
				//	echo '"Fecha":"'.$fila->FechaSubida.'",';
				//	echo '"Tipo":"'.$fila->Tipo.'",';
				//	echo '"Curso":"'.$fila->Anio.'",';
				//	echo '"Grado":"'.$fila->Grado.'",';
				//	echo '"Documento":"'.$fila->Documento.'",';
				//	echo '"Asignatura":"'.$fila->Asignatura.'",';
				//	echo '"IdTipo":"'.$fila->IdTipo.'"';
				//	echo "|";
				}
	}else{
		json_void();
	}

	// Close the connection
	$DB=null;

}

/**
Función: informacion_documento
	Retorna la información del documento pasado por su identificador mediante get.
*/
function informacion_documento(){
	$DB = sql_connect();
	//die();
	if(!isset($_GET["id"])){json_void();}else{
		$idApuntes = $_GET["id"];
	
	
	
		if($oracion = $DB->prepare("SELECT DISTINCT Documentos.IdDocumento, Documentos.Titulo, Usuario.Nick AS Nick, Documentos.FechaSubida, Tipo.Nombre AS Tipo, Anio.Anio, Documento, Asignatura.Nombre AS Asignatura, Documentos.Comentario, Documentos.Usuario AS IdUsuario, Estudios.Nombre AS Grado FROM Apuntes, Tipo, Usuario, Anio, Asignatura, Estudios WHERE Documentos.IdDocumento=? AND Documentos.Usuario = Usuario.IdUsuario AND Anio.IdAnio = Documentos.Anio AND Tipo.IdTipo = Documentos.Tipo AND Documentos.Activo = 1 AND Documentos.asignatura = Asignatura.IdAsignatura AND Asignatura.Estudios = Estudios.IdEstudios")){

			$oracion->bindParam(1, $idApuntes, PDO::PARAM_INT);
			$oracion->execute();
				$i=0;
				echo "{";
				while($fila = $oracion->fetchObject()){
					echo "\"$i\":{";
					echo '"Id":"'.$fila->IdDocumentos.'",';
					echo '"Titulo":"'.$fila->Titulo.'",';
					echo '"Nick":"'.$fila->Nick.'",';
					echo '"IdUsuario":"'.$fila->IdUsuario.'",';
					echo '"Comentario":"'.$fila->Comentario.'",';
					echo '"Fecha":"'.$fila->FechaSubida.'",';
					echo '"Tipo":"'.$fila->Tipo.'",';
					echo '"Curso":"'.$fila->Anio.'",';
					echo '"Grado":"'.$fila->Grado.'",';
					echo '"Documento":"'.$fila->Documento.'",';
					echo '"Asignatura":"'.$fila->Asignatura.'"';
					echo "},";
					$i++;

				}
				echo "\"length\":".$oracion->rowCount()."}";
			
		}else{
			json_void();
		}
	}
	// Close connection
	$DB=null;

}


/**
Generar una invitación de registro
*/

function generar_invitacion(){
	$DB = sql_connect();
	$nId=1;
	if($oracion = $DB->query("SELECT MAX(IdCodigo)+1 AS n FROM Invitacion")){
		if($fila = $oracion->fetchObject()){
			$nId=$fila->n;
		}
	}
	if($nId==""){$nId=0;}

	if($oracion = $DB->prepare("INSERT INTO Invitacion (IdCodigo, Codigo, IdUsuario)VALUES(?, ?, ?)")){

		$idUsuario=idUsuario();
		$passPhrase= generarCodigoSecreto($idUsuario.(date("miYsdH")));
		$oracion->bindParam(1, $nId, PDO::PARAM_INT);
		$oracion->bindParam(2, $passPhrase, PDO::PARAM_STR);
		$oracion->bindParam(3, $idUsuario, PDO::PARAM_INT);
		if($oracion->execute()){
			echo $passPhrase;
		}else{
			echo "0";

		}

		
	}else{
		echo "0";
	}
	$DB=null;
}

/**
Enviar información de un error.
*/
function json_error($id_error, $msg_error){
		echo "{\"Error\": true, \"mensaje\": \"".$msg_error."\", \"ErrorCode\": $id_error}";
}

/**
Enviar información vacía.
*/
function json_void(){
		echo "0";
}

if(isset($_GET["func"])){ 
	switch($_GET["func"]){
		case "estudios":
			obtener_estudios();
		break;
		case "asignaturas":
			obtener_asignaturas();
		break;
		case "grados":
			obtener_grados();
		break;
		case "tipos":
			obtener_tipos();
		break;
		case "puntos":
			puntos();
		break;
		case "buscar_texto":
			buscar_texto();
		break;

		case "cursos":
			obtener_cursos();
		break;

		case "anios":
			obtener_anios();
		break;

		case "documento":
			//informacion_documento();
		break;
		case "filtrar_apuntes":
			filtrar_apuntes();
		break;
		case "ultimos":
			obtener_ultimos();
		break;
		case "invitacion":
			generar_invitacion();
		break;
		default:
			json_void();
		break;
	}
}else{
	json_void();
}

?>