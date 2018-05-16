<?php
/**
Incluir para manejar la base de datos
*/
require_once("DB.php");
require_once("configuracion.php");
require_once("utiles.php");
require_once("sesion.php");
if(haEntrado()){
?>
<html>
	<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="cache-control" content="max-age=0" />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="expires" content="0" />
	<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
	<meta http-equiv="pragma" content="no-cache" />
	<title><?php echo NOMBRE; ?></title>
	<style type="text/css">
		body {
			background:#8698A8;
			overflow: hidden;
			font-family:Arial;
		}

		#header {
			position:absolute;
			top:0px;
			left:0px;
			right:0px;
			height:50px;
			color:#FFF;
			background:#293440;
			border-bottom:1px solid #000;

		}

		#header_rightbox {
			position:absolute;
			top:5px;
			right:10px;
			bottom:5px;
			width:auto;
			min-width:50px;
		}

		#header_center {
			text-align:center;
			padding-top:10px;
			font-size:24px;
			width:auto;
			min-width:50px;
		}


		#canvas {
			position:absolute;
			display: table;
			width:100%;
			height:100%;
			overflow:hidden;
			
		}

		#info {
			display: table-cell;
			vertical-align: middle;
			

		}

		#info table {
			margin-left: auto;
			margin-right: auto; 
			width:auto;
			background:#FFFFFF;
			margin-top:-50px;
			padding:20px 20px 20px 20px;
			min-width:300px;
			border-radius: 5px 5px 5px 5px;
			font-size:20px;
		}

		#comentario {
			width:100%;
			min-height:50px;
		}

		#textoComentario {
			display:block;
			width:400px;
			word-wrap: break-word;
			border: 1px solid rgba(100,100,100,.5);
			padding: 10px 10px 10px 10px;
		}
		input[type=text] {
			width:100%;
		}

		#botonAceptar {
			color: #0000FF;
			margin-top:5px;
			
			cursor:pointer;
		}
		</style>
		<script languaje="JavaScript">
		window.onload = function(){
			document.getElementById("botonAceptar").addEventListener("click",
				function(){
					window.location.href = "index.php"
				}
			);

		}
		</script>

<?php

	$DB = sql_connect();
	if(isset($_POST["subir"])){			// Si se ha enviado
		$titulo = $_POST["titulo"];
		$comentario = $_POST["comentario"];
		$archivo = $_FILES["archivo"];
		$asignatura = $_POST["asignatura"];
		$tipoApuntes = $_POST["tipo"];
		$cursoAcademico = $_POST["curso_academico"];

		$nombreTipo = "Error";
		
		// Variable para saber si hay errores en la subida
		$conError = false;

		if($oracion = $DB->prepare("SELECT Nombre FROM Tipo WHERE IdTipo = ?")){
			$oracion->bindParam(1, $tipoApuntes, PDO::PARAM_INT);
			if($oracion->execute()){
				if($fila = $oracion->fetchObject()){
					$nombreTipo = $fila->Nombre;
				}else{
					$conError = true;
					$infoSubida= "Tipo no v&aacute;lido.";
				}
			}else{
				$conError = true;
				$infoSubida= "Tipo no v&aacute;lido.";
			}
		}else{
			$conError = true;
			$infoSubida= "Tipo no v&aacute;lido.";
		}

		if($oracionNombre = $DB->prepare("SELECT Nombre FROM Asignatura WHERE IdAsignatura = ?")){
			$oracionNombre->bindParam(1, $asignatura, PDO::PARAM_INT);
			if($oracionNombre->execute()){
				if($fila = $oracionNombre->fetchObject()){
					$nombreAsignatura = $fila->Nombre;
				}else{
					$conError = true;
					$infoSubida ="Asignatura inexistente!";
				}
			}else{
				$conError = true;
				$infoSubida ="Asignatura inexistente!";
			}
			
		}else{
			$conError = true;
			$infoSubida ="Asignatura inexistente!";
		}


		


		/*	Tratamos la información pasada */
		if(strlen($titulo)>50){	// Si el título es mayor a lo permitivo, cortamos
			$titulo = substr($titulo, 0, 50);
		}

		if(strlen($comentario)>150){	// Si el comentario es mayor a lo permitivo, cortamos
			$comentario = substr($comentario, 0, 300);
		}

		if(is_nan($asignatura)){
			$conError = true;
			$infoSubida= "La asignatura no es v&aacute;lida.";
		}

		// Generamos un nombre secreto para el archivo subido


		if(!$conError){	// Si no hay errores, continuar...

			// Generamos un nombre secreto para el archivo subido.
			$nombreSecreto = generarCodigoSecreto($titulo.$asignatura).".pdf";


			/**
				Comprobación de seguridad: ver si el archivo es un PDF
			*/
			$fp = fopen($archivo["tmp_name"], 'r');
			$primerosBytes = fread($fp, 4);																// Leemos los 4 primeros bytes del archivo
			fclose($fp);

			if($primerosBytes == "%PDF"){															// Miramos si los primeros 4 bytes son de un archivo pdf...


				

				if(move_uploaded_file($archivo["tmp_name"], DIRECTORIO_SECRETO."/".$nombreSecreto)){	// Subida del archivo
					
					chmod(DIRECTORIO_SECRETO."/".$nombreSecreto, 0744);								// Cambiamos los permisos del archivo
					$hashFichero = md5_file(DIRECTORIO_SECRETO."/".$nombreSecreto);

					// Buscamos si existe un archivo con el mismo hash:

					if($oracionNombre = $DB->prepare("SELECT Titulo FROM Documentos WHERE Hash = ?")){
						$oracionNombre->bindParam(1, $hashFichero, PDO::PARAM_STR);
						if($oracionNombre->execute()){
							if($fila = $oracionNombre->fetchObject()){
								$conError = true;
								$infoSubida ="Documento ya existente con el t&iacute;tulo ".$fila->Titulo;
							}
						}else{
							$conError = true;
							$infoSubida ="Error grave: 11.";
						}
						
					}else{
						$conError = true;
						$infoSubida ="Error grave: 10.";
					}
					
					// Obtenemos un nuevo id para el documento:
					$consulta = $DB->query("SELECT MAX(IdDocumento) AS num FROM Documentos");
					if($consulta->execute()){
						$objeto = $consulta->fetchObject();
						$nuevoId = intval($objeto->num)+1;
					}else{
						$infoSubida="Error grave. Error: 1.";
						$conError = true;
					}

					/* Si todo ha ido correctamente, escribimos en la base de datos */

					$idUsuario = idUsuario();
					$oracionSQL = "INSERT INTO Documentos (`IdDocumento`, `Titulo`, `Usuario`, `Tipo`, `Anio`, `Documento`, `Hash`, `Asignatura`, `Comentario`, `Activo` )";
					$oracionSQL .= " VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1)";

					// Si hasta ahora no hay errores...
					if(!$conError){
						if($oracion = $DB->prepare($oracionSQL)){
								$oracion->bindParam(1, $nuevoId, PDO::PARAM_INT);
								$oracion->bindParam(2, $titulo, PDO::PARAM_STR);
								$oracion->bindParam(3, $idUsuario, PDO::PARAM_INT);
								$oracion->bindParam(4, $tipoApuntes, PDO::PARAM_INT);
								$oracion->bindParam(5, $cursoAcademico, PDO::PARAM_INT);
								$oracion->bindParam(6, $nombreSecreto, PDO::PARAM_STR);
								$oracion->bindParam(7, $hashFichero, PDO::PARAM_STR);
								$oracion->bindParam(8, $asignatura, PDO::PARAM_INT);
								$oracion->bindParam(9, $comentario, PDO::PARAM_STR);
							if($oracion->execute()){
								$infoSubida= "Fichero subido correctamente!";

							}else{

								$infoSubida= "Hubo un error al subir el archivo...
								Si éste error persiste, p&oacute;ngase en contacto con el administrador. Error:K_";
								print_r($oracion->errorInfo());
								$conError = true;

								//Borramos el fichero...
								unlink(DIRECTORIO_SECRETO."/".$nombreSecreto);
							}
						}
					}

				}else{																					// Si no se sube el archivo correctamente...
					$infoSubida= "Hubo un error al subir el archivo...
					Si éste error persiste, p&oacute;ngase en contacto con el administrador. Error: 4";
					$conError = true;
				}
			}else{																						// No parece un PDF... No subimos y avisamos...
				$infoSubida= "Hubo un error al subir el archivo...
					Si éste error persiste, p&oacute;ngase en contacto con el administrador. Error: 3";
					$conError = true;
			}
		}
?>
		</head>
		<body>
			<div id="header">
				<div id="header_center">
					Subir documento
				</div>
			</div>

			<div id="canvas">
				<div id="info">
				

							<table border="0" cellspacing="5" cellpadding="0">
							<tr><td colspan="2">
							<?php
								if($conError){
									echo "<font style=\"color:#FF0000;\">$infoSubida</font>"; 
								}else{
									echo "<font style=\"color:#00FF00;\">$infoSubida</font>";
								}  
							?>
							</td></tr>
							<tr><td>Titulo:</td><td><?php echo $titulo; ?></td></tr>
							<tr><td>Comentario:</td><tr></tr></tr>
							<tr><td colspan="2">
								<div id="textoComentario">
								<?php echo $comentario; ?>
								</div>
							</td></tr>
							<tr>
								<td>Asignatura:</td>
								<td>
									<?php echo $nombreAsignatura; ?>
								</td>
							</tr>
							<tr>
								<td>Tipo:</td>
								<td>
									<?php echo $nombreTipo; ?>
								</td>
							</tr>
							<tr>
								<td></td>
								<td>
									<span id="botonAceptar">Aceptar</span>
								</td>
							</tr>

							</table>
				</div>
			</div>
		</body>
	</html>
<?php
		

	}else{

	?>
			<script languaje="JavaScript">

			function ajaxpost( x,  y,z){
				var v = new XMLHttpRequest();
				v.open("POST", x, true);
				v.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				v.send(y);
				xhttp.onreadystatechange = function(){
					if(v.readyState == 4&&v.status == 200){
						z(v.responseText);
					}
				}
			}

			function ajaxget( x,y){
				var v = new XMLHttpRequest();
				v.open("GET", x, true);
				v.send();
				v.onreadystatechange = function(){
					if(v.readyState == 4 && v.status == 200){
						y(v.responseText);
					}
				}
			}


				window.onload = function(){

					document.getElementById("grado").addEventListener("change",
						function(data){
								cargarAsignaturas(document.getElementById("grado").value, document.getElementById("curso").value);
						}
					);

					document.getElementById("curso").addEventListener("change",
						function(data){
							cargarAsignaturas(document.getElementById("grado").value, document.getElementById("curso").value);
						}
					);
					cargarDatos();
				}

				function cargarDatos(){
					cargarGrados();
					cargarCursos();
					cargarCursoAcademico();
					cargarTipos();
					cargarAsignaturas("ALL","ALL");
				}
				function cargarGrados(){
					ajaxget("becario.php?func=grados",
						function(v){
							
							var i,y,x=v.split("\|");
							y=x.length-1;
							document.getElementById("grado").innerHTML='<option value="NINGUNO">---</option>';
							for(i=0;i<y;i+=2){
								document.getElementById("grado").innerHTML+="<option value=\""+x[i]+"\">"+(x[i+1].length>20?x[i+1].substring(0,17)+"...":x[i+1])+"</option>";
							}
						}
					);
					
				}

				function cargarCursoAcademico(){
					document.getElementById("curso_academico").innerHTML='<option value="NINGUNO">---</option>';

					ajaxget( "becario.php?func=cursos",
					function(v){
						var i,y,x=v.split("\|");
							y=x.length-1;
							document.getElementById("curso_academico").innerHTML='<option value="NINGUNO">---</option>';
							for(i=0;i<y;i+=2){
								document.getElementById("curso_academico").innerHTML+="<option value=\""+x[i]+"\">"+(x[i+1].length>20?x[i+1].substring(0,17)+"...":x[i+1])+"</option>";
							}
						}
					);
					
					
				}

				function cargarTipos(){

					ajaxget( "becario.php?func=tipos",
						function(v){
							var i,y,x=v.split("\|");
							y=x.length-1;
							for(i=0;i<y;i+=2){
								document.getElementById("tipo").innerHTML+="<option value=\""+x[i]+"\">"+(x[i+1].length>20?x[i+1].substring(0,17)+"...":x[i+1])+"</option>";
							}
						}
					);
					
					
				}

				function cargarCursos(){
					document.getElementById("curso").innerHTML='<option value="NINGUNO">---</option>';

					for(var i = 1; i<=4;i++){
						document.getElementById("curso").innerHTML+="<option value=\""+i+"\">"+i+"</option>";
					}
					
					
				}


				function cargarAsignaturas(grado, curso){
					ajaxget( "becario.php?func=asignaturas&grado="+grado+"&curso="+curso,
						function(v){
						var i,y,x=v.split("\|");
							y=x.length-1;
							document.getElementById("asignatura").innerHTML='<option value="NINGUNO">---</option>';
							for(i=0;i<y;i+=2){
								document.getElementById("asignatura").innerHTML+="<option value=\""+x[i]+"\">"+(x[i+1].length>20?x[i+1].substring(0,17)+"...":x[i+1])+"</option>";
							}
						}

	
					);
				}



			</script>
		</head>
		<body>
			<div id="header">
				<div id="header_center">
					Subir documento
				</div>
			</div>

			<div id="canvas">
				<div id="info">
					<form enctype="multipart/form-data" method="POST" action="subir.php" >
						<input type="hidden" name="send" value="1" />
					 	<input type="hidden" name="MAX_FILE_SIZE" value="99999999" />
						<table border="0" cellspacing="5" cellpadding="0">
							<tr><td>Titulo:</td><td><input type="text" id="titulo" name="titulo"></td></tr>
							<tr><td>Comentario:</td><tr></tr></tr>
							<tr><td colspan="2"><textarea name="comentario" id="comentario" maxlength="150"></textarea></td></tr>

							<tr>
								<td>Archivo:</td>
								<td>
									<input type="file" name="archivo" id="archivo" accept="application/pdf">
								</td>
							</tr>
							
							<tr>
								<td>A&ntilde;o acad&eacute;mico:</td>
								<td>
									<select id="curso_academico" name="curso_academico">
										<option value="NINGUNO">---</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Grado:</td>
								<td>
									<select id="grado">
										<option value="NINGUNO">---</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Curso:</td>
								<td>
									<select id="curso">
										<option value="NINGUNO">---</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Asignatura:</td>
								<td>
									<select id="asignatura" name="asignatura">
										<option value="NINGUNO">---</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Tipo:</td>
								<td>
									<select id="tipo" name="tipo">
										<option value="NINGUNO">---</option>
									</select>
								</td>
							</tr>
							<tr>
								<td></td>
								<td>
								<input type="submit" name="subir" value="Subir">
								</td>
							</tr>
							</table>
						</form>
				</div>
			</div>
		</body>
	</html>

<?php
} // END POST SEND
}else{
?>
<html>
<head>

<script languaje="JavaScript">
	window.onload = function(){ window.location.href="entrar.php"; };
</script>
</head>
<body>
</body>
</html>
<?php
}
?>
