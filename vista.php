<?php
/**
Incluir para manejar la base de datos
*/
require_once("DB.php");
require_once("utiles.php");
require_once("sesion.php");
if(haEntrado()){


	$noEncontrado = false;
	if(!isset($_GET["id"])){
		$noEncontrado = true;
	}else{
		$idDocumento = $_GET["id"];
	}
	
	$DB = sql_connect();
	
		if(!$noEncontrado && $oracion = $DB->prepare("SELECT DISTINCT Documentos.IdDocumento, Documentos.Titulo, Usuario.Nick AS Nick, Documentos.FechaSubida, Tipo.Nombre AS Tipo, Tipo.IdTipo, Anio.Anio, Documento, Asignatura.Nombre AS Asignatura, Documentos.Comentario, Documentos.Usuario AS IdUsuario, Estudios.Nombre AS Grado FROM Documentos, Tipo, Usuario, Anio, Asignatura, Estudios WHERE Documentos.IdDocumento=? AND Documentos.Usuario = Usuario.IdUsuario AND Anio.IdAnio = Documentos.Anio AND Tipo.IdTipo = Documentos.Tipo AND Documentos.Asignatura = Asignatura.IdAsignatura AND Documentos.Activo = 1 AND Asignatura.Estudios = Estudios.IdEstudios")){
			
			$oracion->bindParam(1, $idDocumento);
			
			if($oracion->execute()){
				if($fila = $oracion->fetchObject()){


				}else{
					$noEncontrado = true;
				}			}
		}else{
			$noEncontrado = true;
		}

	?>

<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="cache-control" content="max-age=0" />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="expires" content="0" />
	<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
	<meta http-equiv="pragma" content="no-cache" />
		<title><?php echo NOMBRE; ?></title>
		<link rel="stylesheet" href="css/basico.css">
		<link rel="stylesheet" href="css/documentos.css">
		<style type="text/css">
			body {
				background:#8698A8;
				font-family:Arial;
				font-family:Arial;
				font-size:16px;
			}
			#header {
				position:absolute;
				top:0px;
				left:0px;
				right:0px;
				height:50px;
				background:#293440;
				border-bottom:1px solid #000;
				color:#FFF;

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
				font-size:20px;
				width:auto;
				min-width:50px;
			}


			#canvas {
				position:absolute;
				top:51px;
				left:100px;
				right:100px;
				bottom:0px;
				background:rgba(255,255,255,0.9);
				overflow-y:auto;
				overflow-x:hidden;
			}

			#canvas #preview {
				background:#000;
				position:absolute;
				top:0px;
				left:0px;
				bottom:0px;
				width:auto;

				max-width:50%;
				min-width:50%;
			}

			#canvas #info {
				position:absolute;
				top:0px;
				right:0px;
				bottom:50px;
				height:80%;
				max-width:50%;
				min-width:50%;
				display:table;
			}

			#canvas #info table{
				font-size:22px;
				vertical-align:middle;
  				display: table-cell;

			}

			#canvas #info .name{
				color:#808080;
				padding-left:50px;

			}
			#canvas #info .descarga {
				font-size:24px;
				color:#FE1111;
				padding-left:50px;
				cursor:pointer;
			}

			#canvas #info .descarga:hover {
				text-decoration: underline;
			}

			.titulo {
				font-size:25px;
			}
			.Documento {
				color:#00DD00;
			}

			
			</style>
		<script languaje="JavaScript" src="js/ajax.js"></script>
		<script languaje="JavaScript">
		function getUrlHash(){
			var hash = location.hash.substring(1).split("&");
			var hashObj = {};
			var hashSplitted;
			
			for(var i = 0; i<hash.length; i++){

				hashSplitted = hash[i].split("=");
				hashObj[hashSplitted[0]] = hashSplitted[1];
			}
			return hashObj;
		}

		function addUrlHash(name, data){
			var hashObj = getUrlHash();
			for(var i = 0; i<hash.length; i++){

				hashSplitted = hash[i].split("=");
				hashObj[hashSplitted[0]] = hashSplitted[1];
			}
		}
			window.onload = function(){

			}

			function descargaDocumento(){
				window.location.href="descarga.php?id=<?php echo $_GET["id"]; ?>";
			}

		</script>
	</head>
	<body>
		<div id="header">
			<div id="header_center">
				<?php
				if($noEncontrado){
					echo "Error: No encontrado :/";
				}else{
					echo "<span class=\"titulo\">".__mysqlentities($fila->Titulo)."</span>";
					echo "<span class=\"documento_tipo_".$fila->IdTipo." titlecomment\">". __mysqlentities($fila->Tipo)."</span>";

				}
				?>
			</div>
		</div>
		<div id="canvas">
			<div id="preview">
				<object data="documento.php?id=<?php echo $idDocumento; ?>" type="application/pdf" width="100%" height="100%">
					Error al mostrar el documento!
				</object>
			</div>
			<div id="info">
				<table border="0" cellpadding="0" cellspacing="0">
					<tr><td class="name">Grado<td><?php echo  __mysqlentities($fila->Grado); ?></tr>
					<tr><td class="name">Curso<td><?php echo $fila->Anio ?></tr>
					<tr><td class="name">Asignatura<td><?php echo __mysqlentities($fila->Asignatura); ?></tr>
					<tr><td class="name">Fecha<td><?php echo $fila->FechaSubida; ?></tr>
					<tr><td class="name">Usuario<td><?php echo $fila->Nick; ?></tr>
					<tr><td class="descarga" onClick="descargaDocumento();">Descargar<td></tr>
				</table>
			</div>
		</div>
	</body>
</html>

<?php
}else{
?>
<html>
<head>

<script languaje="JavaScript">
	window.onload = function(){ window.location.href="login.php"; };
</script>
</head>
<body>
</body>
</html>
<?php
}
?>
