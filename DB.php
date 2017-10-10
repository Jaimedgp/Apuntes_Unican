<?php
require_once("configuracion.php");

require_once("utiles.php");

function sql_connect(){
	switch(BASEDEDATOS["TIPO"]){
		case "mysql":
			$pdo = new PDO("mysql:host=".BASEDEDATOS["SERVIDOR"].";dbname=".BASEDEDATOS["BASEDEDATOS"].";charset=utf8", BASEDEDATOS["USUARIO"],BASEDEDATOS["CONTRASENA"]);
			return $pdo;
		break;
		case "mssql":
			$pdo = new PDO("sqlsrv:Server=".BASEDEDATOS["SERVIDOR"].";Database=".BASEDEDATOS["BASEDEDATOS"].";charset=utf8", BASEDEDATOS["USUARIO"],BASEDEDATOS["CONTRASENA"]);
			return $pdo;
		break;
	}
}

?>
