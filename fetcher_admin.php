<?php

// Only ssl!
if(empty($_SERVER['HTTPS'])){die("0");}

require_once("configuracion.php");
require_once("DB.php");
require_once("sesion.php");
header("Content-type: text/plain");
class Fetcher {
	public function getTemp(){
		sleep(2);
		echo shell_exec("cat /sys/class/thermal/thermal_zone0/temp");
		
	}

	public function ram(){
		//sleep(2);
		$a=explode(" ", explode("\n", shell_exec("free -h"))[1]);
		echo str_replace("G", "", $a[11]."|".$a[19]);
	}

	public function cpu(){
		//sleep(2);
		$a=explode(" ", shell_exec("grep 'cpu ' /proc/stat"));
		echo number_format((((float)$a[2]+(float)$a[4])*100/((float)$a[2]+(float)$a[4]+(float)$a[5])), 2)."%";
	}

	public function getUserlist($a){
		$DB=sql_connect();
		$sqlQuery="SELECT IdUsuario, Nick, Activo FROM Usuario ORDER BY IdUsuario DESC LIMIT ?,10";
		$sqlPrepare=$DB->prepare($sqlQuery);
		$sqlPrepare->bindParam(1, $a, PDO::PARAM_INT);
		$sqlPrepare->execute();
		while($fila = $sqlPrepare->fetchObject()){
			echo $fila->IdUsuario."|".$fila->Nick."||".$fila->Nick."||".$fila->Activo."|";
		}

	}

	public function getDoclist($a){
		$DB=sql_connect();
		$sqlQuery="SELECT IdDocumento, Titulo, FechaSubida, Nombre, Nick, Documentos.Activo AS Activo FROM Documentos, Usuario WHERE Documentos.Usuario=Usuario.IdUsuario  ORDER BY IdDocumento DESC LIMIT ?,10";
		$sqlPrepare=$DB->prepare($sqlQuery);
		$sqlPrepare->bindParam(1, $a, PDO::PARAM_INT);
		$sqlPrepare->execute();
		while($fila = $sqlPrepare->fetchObject()){
			echo $fila->IdDocumento."|".$fila->Titulo."|".$fila->Nombre."|".$fila->Nick."|".$fila->FechaSubida."|".$fila->Activo."|";
		}

	}

	public function getDocNum(){
		$DB=sql_connect();
		$sqlQuery=$DB->query("SELECT COUNT(*) AS num FROM Documentos");
		if($fila = $sqlQuery->fetchObject()){
			echo $fila->num;
		}else{
			echo "-1";
		}
	}

	public function getUserNum(){
		$DB=sql_connect();
		$sqlQuery=$DB->query("SELECT COUNT(*) AS num FROM Usuario");
		if($fila = $sqlQuery->fetchObject()){
			echo $fila->num;
		}else{
			echo "-1";
		}
	}

	public function activeNum(){
		$DB=sql_connect();
		$sqlQuery=$DB->query("SELECT COUNT(*) AS num FROM Sesion");
		if($fila = $sqlQuery->fetchObject()){
			echo $fila->num;
		}else{
			echo "-1";
		}
	}


	public function deleteUser($id){
		$DB=sql_connect();
		$sqlQuery="UPDATE Usuario SET activo=0 WHERE IdUsuario=?";
		$sqlPrepare=$DB->prepare($sqlQuery);
		$sqlPrepare->bindParam(1, $id, PDO::PARAM_INT);
		if($sqlPrepare->execute()){
			echo "1";
		}else{
			echo "0";
		}
	}

	public function deleteDoc($id){
		$DB=sql_connect();
		$sqlQuery="UPDATE Documentos SET activo=0 WHERE IdDocumento=?";
		$sqlPrepare=$DB->prepare($sqlQuery);
		$sqlPrepare->bindParam(1, $id, PDO::PARAM_INT);
		if($sqlPrepare->execute()){
			echo "1";
		}else{
			echo "0";
		}
	}

	public function activateUser($id){
		$DB=sql_connect();
		$sqlQuery="UPDATE Usuario SET activo=1 WHERE IdUsuario=?";
		$sqlPrepare=$DB->prepare($sqlQuery);
		$sqlPrepare->bindParam(1, $id, PDO::PARAM_INT);
		if($sqlPrepare->execute()){
			echo "1";
		}else{
			echo "0";
		}
	}

	public function activateDoc($id){
		$DB=sql_connect();
		$sqlQuery="UPDATE Documentos SET activo=1 WHERE IdDocumento=?";
		$sqlPrepare=$DB->prepare($sqlQuery);
		$sqlPrepare->bindParam(1, $id, PDO::PARAM_INT);
		if($sqlPrepare->execute()){
			echo "1";
		}else{
			echo "0";
		}
	}

	public function dataUser($id){
		$DB=sql_connect();
		$sqlQuery="SELECT IdUsuario, Nombre, Apellido1, Apellido2, Password, Nick, Email, Estudios FROM Usuario WHERE IdUsuario=?";
		$sqlPrepare=$DB->prepare($sqlQuery);
		$sqlPrepare->bindParam(1, $id, PDO::PARAM_INT);
		if($sqlPrepare->execute()){
			if($fila = $sqlPrepare->fetchObject()){
				echo $fila->IdUsuario."|";
				echo $fila->Nombre."|";
				echo $fila->Apellido1."|";
				echo $fila->Apellido2."|";
				echo $fila->Password."|";
				echo $fila->Nick."|";
				echo $fila->Email."|";
				echo $fila->Estudios;
			}else{
				echo "0";
			}
		}else{
			echo "0";
		}
		//print_r($sqlPrepare->errorInfo());
	}

	public function dataDoc($id){
		$DB=sql_connect();
		$sqlQuery="SELECT IdDocumento, Titulo, Usuario, FechaSubida, Tipo, Anio, Documento, Hash, Asignatura, Comentario, Puntuacion, Activo FROM Documentos WHERE IdDocumento=?";
		$sqlPrepare=$DB->prepare($sqlQuery);
		$sqlPrepare->bindParam(1, $id, PDO::PARAM_INT);
		if($sqlPrepare->execute()){
			if($fila = $sqlPrepare->fetchObject()){
				echo $fila->IdDocumento."|";
				echo $fila->Titulo."|";
				echo $fila->Usuario."|";
				echo $fila->FechaSubida."|";
				echo $fila->Tipo."|";
				echo $fila->Anio."|";
				echo $fila->Documento."|";
				echo $fila->Hash."|";
				echo $fila->Asignatura."|";
				echo $fila->Comentario."|";
				echo $fila->Activo;
			}else{
				echo "0";
			}
		}else{
			echo "0";
		}
	}

	public function changeDoc($id){
		$DB=sql_connect();
		$sqlQuery="UPDATE Documentos SET Titulo=?, Usuario=?, FechaSubida=?, Tipo=?, Anio=?, Documento=?, Hash=?, Asignatura=?, Comentario=? WHERE IdDocumento=?";
		$sqlPrepare=$DB->prepare($sqlQuery);
		$sqlPrepare->bindParam(1, $_POST["titulo"], PDO::PARAM_STR);
		$sqlPrepare->bindParam(2, $_POST["usuario"], PDO::PARAM_STR);
		$sqlPrepare->bindParam(3, $_POST["fechasubida"], PDO::PARAM_STR);
		$sqlPrepare->bindParam(4, $_POST["tipo"], PDO::PARAM_STR);
		$sqlPrepare->bindParam(5, $_POST["anio"], PDO::PARAM_STR);
		$sqlPrepare->bindParam(6, $_POST["documento"], PDO::PARAM_STR);
		$sqlPrepare->bindParam(7, $_POST["hash"], PDO::PARAM_STR);
		$sqlPrepare->bindParam(8, $_POST["asignatura"], PDO::PARAM_STR);
		$sqlPrepare->bindParam(9, $_POST["comentario"], PDO::PARAM_STR);
		$sqlPrepare->bindParam(10, $id, PDO::PARAM_INT);

		if($sqlPrepare->execute()){
			echo "1|OK";
		}else{
			echo "0|";
			print_r($sqlPrepare->errorInfo());
			print_r($_POST);
		}
	}


	public function changeUser($id){
		$DB=sql_connect();
		$sqlQuery="UPDATE Usuario SET Nombre=?, Apellido1=?, Apellido2=?, Password=?, Nick=?, Email=?, Estudios=? WHERE IdUsuario=?";
		$sqlPrepare=$DB->prepare($sqlQuery);
		$sqlPrepare->bindParam(1, $_POST["nombre"], PDO::PARAM_STR);
		$sqlPrepare->bindParam(2, $_POST["apellido1"], PDO::PARAM_STR);
		$sqlPrepare->bindParam(3, $_POST["apellido2"], PDO::PARAM_STR);
		$sqlPrepare->bindParam(4, $_POST["password"], PDO::PARAM_STR);
		$sqlPrepare->bindParam(5, $_POST["nick"], PDO::PARAM_STR);
		$sqlPrepare->bindParam(6, $_POST["email"], PDO::PARAM_STR);
		$sqlPrepare->bindParam(7, $_POST["estudios"], PDO::PARAM_INT);
		$sqlPrepare->bindParam(8, $id, PDO::PARAM_INT);

		if($sqlPrepare->execute()){
			echo "1|OK";
		}else{
			echo "0|";
			print_r($sqlPrepare->errorInfo());
			print_r($_POST);
		}
	}
}

class Action {
	public function shutdown(){
		$this->createControlFile(md5("sAhAuBtBdCoCwDnD"));
		echo "1";
	}

	public function restart(){
		$this->createControlFile(md5("VrZeZsYtYaXrXtW"));
		echo "1";
	}

	private function createControlFile($name){
		file_put_contents("../".$name, "1");
	}

}
$fetcher = new Fetcher();
$action = new Action();

if(haEntrado()){
	$DB=sql_connect();
	$query="SELECT id FROM cr45 WHERE uid=?";
	$prepare=$DB->prepare($query);
	$prepare->bindParam(1, $USERINFO->IdUsuario , PDO::PARAM_STR);
	$prepare->execute();

	if($fila = $prepare->fetchObject()){
		// Admin site!!!

		if(isset($_GET["fetch"])){
			switch($_GET["fetch"]){
				case "ram":
					$fetcher->ram();
				break;
				case "cpu":
					$fetcher->cpu();
				break;
				case "temp":
					$fetcher->getTemp();
				break;
				case "allBasic":
					$fetcher->ram();
					echo "|";
					$fetcher->cpu();
					echo "|";
					$fetcher->getTemp();
				break;

				case "userList":
					if(isset($_GET["page"])){$a=$_GET["page"]*10;}else{$a=0;}
					$fetcher->getUserlist($a);
				break;

				case "docList":
					if(isset($_GET["page"])){$a=$_GET["page"]*10;}else{$a=0;}
					$fetcher->getDoclist($a);
				break;

				case "docNum":
					$fetcher->getDocNum();
				break;

				case "userNum":
					$fetcher->getUserNum();
				break;

				case "userDel":
					$fetcher->deleteUser($_POST["romongo"]);
				break;

				case "docDel":
					$fetcher->deleteDoc($_POST["romongo"]);
				break;

				case "userAct":
					$fetcher->activateUser($_POST["romongo"]);
				break;

				case "docAct":
					$fetcher->activateDoc($_POST["romongo"]);
				break;

				case "userData":
					$fetcher->dataUser($_POST["romongo"]);
				break;

				case "docData":
					$fetcher->dataDoc($_POST["romongo"]);
				break;

				case "userChange":
					$fetcher->changeUser($_POST["romongo"]);
				break;

				case "docChange":
					$fetcher->changeDoc($_POST["romongo"]);
				break;
				case "activeNum":
					$fetcher->activeNum();
				break;


			}
		}

		if(isset($_GET["action"])){
			switch($_GET["action"]){
				case "shutdown":
					$action->shutdown();
				break;
				case "restart":
					$action->restart();
				break;

			}
		}
	}
}else{
	
}
?>