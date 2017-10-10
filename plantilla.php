<?php 
/**
Script: plantilla.php
	Éste script es la plantilla de la página principal. Al ser incluido desde
	index, para no permitir ejecutar directamente ésta página, la variable
	$desdeIndex debe de existir y ser true (se define en index.php).
*/
if(isset($desdeIndex) && $desdeIndex){
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
		<link rel="stylesheet" href="css/plantilla.css"></style>
		<link rel="stylesheet" href="css/documentos.css"></style>
		<script languaje="JavaScript" src="js/ajax.js"></script>
		<script languaje="JavaScript">
		var textoBusqueda;
		var debug = true;
		/** Funciones por implementar...
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
		*/
			window.onload = function(){
				document.getElementById("header_closesesion").addEventListener("click",
					function(){
						window.location.href="entrar.php?salir=1";
						
					}
				);

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

				document.getElementById("header_filtrar").addEventListener("click",
					function(){
						cargarResultados(0);
					}
				);

				document.getElementById("header_search_text").addEventListener("focus",
					function(){
						var elm = document.getElementById("header_search_text");
						if(elm.value=="Buscar..."){
							elm.value = "";
							elm.className="selected";
						}
					}
				);

				document.getElementById("header_search_text").addEventListener("blur",
					function(){
						var elm = document.getElementById("header_search_text");
						if(elm.value==""){
							elm.value = "Buscar...";
							elm.className="";
						}
					}
				);
				document.getElementById("header_search_text").addEventListener("keydown",
					function(e){
						if(e.keyCode == 13){
							buscarPorTexto(document.getElementById("header_search_text").value, -1);
						}
					}
				);
				
				document.getElementById("header_search").addEventListener("click",
					function(){
						buscarPorTexto(document.getElementById("header_search_text").value, -1);
					}
				);

				document.getElementById("header_subir").addEventListener("click",
					function(){
						var newWindow = window.open("subir.php");
  						newWindow.focus();
					}
				);

				
				cargarDatos();
			}

			
			function cargarDatos(){
				cargarGrados();
				cargarCursos();
				cargarAsignaturas("ALL","ALL");
				ultimos();
				escribirPuntos(<?php echo idUsuario(); ?>, document.getElementById("puntos"));
			}
			function cargarGrados(){
				ajaxget( "becario.php?func=estudios",
					function(xhttp){
						
						var dataJSON = JSON.parse(xhttp.responseText);
						if(debug){ console.log("->"+dataJSON.length);}
						document.getElementById("grado").innerHTML='<option value="ALL">Todos</option>';
						var nombre;
						for(var i = 0; i<dataJSON.length;i++){
							if(dataJSON[i].length>20){
								nombre = dataJSON[i].substring(0,17)+"...";
							}else{
								nombre = dataJSON[i];
							}
							document.getElementById("grado").innerHTML+="<option value=\""+i+"\">"+nombre+"</option>";
						}
					}
				);
				
			}

			function cargarCursos(){
				document.getElementById("curso").innerHTML='<option value="ALL">Todos</option>';

				for(var i = 1; i<=4;i++){
					document.getElementById("curso").innerHTML+="<option value=\""+i+"\">"+i+"</option>";
				}
				
				
			}

			function cargarAsignaturas(grado, curso){
				ajaxget( "becario.php?func=asignaturas&grado="+grado+"&curso="+curso,
					function(xhttp){
						
						var dataJSON = JSON.parse(xhttp.responseText);
						if(debug){ console.log(dataJSON);}
						document.getElementById("asignatura").innerHTML='<option value="ALL">Todas</option>';
						for(var i = 0; i<dataJSON.length;i++){
							if(dataJSON[i].Nombre.length>20){
								nombre = dataJSON[i].Nombre;//.substring(0,17)+"...";
							}else{
								nombre = dataJSON[i].Nombre;
							}
							document.getElementById("asignatura").innerHTML+="<option value=\""+dataJSON[i].id+"\" label=\""+dataJSON[i].Nombre+"\">"+nombre+"</option>";
						}
					}
				);
			}


			function mensajeDeError(error){
				var errElm = document.getElementById("mensaje_error");
				errElm.style.display = "block";
				errElm.style.left = (window.innerWidth-342)/2;
				errElm.innerHTML = error;
				var i = 0;
				var opa = 0;
				var mde_timeout = setInterval(
					function(){
						i+=10;
						if(i<=100){
							opa = i/100;
							if(opa>1){opa = 1;}
							errElm.style.opacity = opa;
						}else if(i>= 300 && i<400){
							opa = (400-i)/100;
							if(opa>1){opa = 1;}
							if(opa<0){opa = 0;}
							errElm.style.opacity = opa;
						}else if(i>=400){
							errElm.style.display = "none";
							clearInterval(mde_timeout);
						}
						
					},
				100);
				
			}

			function sinResultados(){
				var resultado = document.createElement("div");
				resultado.className = "sinresultado";

				var nodoTexto = document.createElement("span");   
				nodoTexto.appendChild(document.createTextNode("Sin resultados :/"));
				resultado.appendChild(nodoTexto);				
				document.getElementById("canvas").appendChild(resultado);

			}

			function buscarPorTexto(texto, pagina){
				if(texto == ""){ return 0; }
				if(pagina == -1){ // La pagina es -1 si la busqueda la realiza el usuario
					pagina = 0;
					textoBusqueda = texto;
				}
				

				var tipos = 0;
				/**
				La variable tipos vale:

					Examenes 	Apuntes 	Tipo
					true		true		3
					true		false		2
					false		true		1
				*/
				if(document.getElementById("header_search_check_examenes").checked){
					tipos = 2;
				}
				if(document.getElementById("header_search_check_apuntes").checked){
					tipos++;
				}
				if(tipos>0){
					ajaxget( "becario.php?func=buscar_texto&busqueda="+encodeURI(texto)+"&tipo="+tipos+"&pagina="+pagina,
						function(xhttp){
							if(debug){console.log(xhttp.responseText);}
							var dataJSON = JSON.parse(xhttp.responseText);
							
							var titulo;
							document.getElementById("canvas").innerHTML = "";
							for(var i = 0; i<dataJSON.length;i++){
								appendResult(dataJSON[i]);
							}

							if(dataJSON.length == 0){
								sinResultados();
								return 0;
							}
							
							if(debug){console.log("Mas de 10"+dataJSON.length);}
							if(pagina == 0 && dataJSON.length >= 10){
								anadirBotonesNavegacion("delante", "buscarPorTexto", pagina);
							}
							if(pagina > 0 && dataJSON.length >= 10){
								anadirBotonesNavegacion("ambos", "buscarPorTexto", pagina);
							}
							if(pagina > 0 && dataJSON.length < 10){
								anadirBotonesNavegacion("atras", "buscarPorTexto", pagina);
							}
							
						}
					);
				}else{
					mensajeDeError("Eso no es posible...");
				}

			}

			function ultimos(){

				ajaxget( "becario.php?func=ultimos",
					function(xhttp){
						
						var dataJSON = JSON.parse(xhttp.responseText);

						document.getElementById("canvas").innerHTML = "";
						for(var i = 0; i<dataJSON.length;i++){
							appendResult(dataJSON[i]);
						}
						
					}
				);
			}

			function escribirPuntos(id, elm){

				return ajaxget( "becario.php?func=puntos&id="+id,
					function(xhttp){
						
						var dataJSON = JSON.parse(xhttp.responseText);
						if(debug){console.log(xhttp.responseText);}
						if(dataJSON.length > 0){
							elm.innerHTML = dataJSON.Puntos;
						}else{
							elm.innerHTML = "error";
						}
						
					}
				);
			}



			function irArchivo(id){

				window.location.href="";
			}

			function appendResult(datos){

				var titulo;
				var texto, nodo, nodoTexto;
				if(datos.Titulo.length>50){
						titulo = datos.Titulo.substring(0,47)+"...";
					}else{
						titulo = datos.Titulo;
				}
				var tipoText = "<span class=\""+datos.Tipo+" titlecomment\">"+datos.Tipo+"</span>";

				var resultado = document.createElement("div");                 // Crear elemento resultado
				resultado.className="resultado";

				var leftElm = document.createElement("div");                 // Crear elemento derecha AKA left
				leftElm.className="left";

				var rightElm = document.createElement("div");                 // Crear elemento izquierda AKA right
				rightElm.className="right";

				var nodo = document.createElement("div");                 // Crear elemento Titulo
				nodo.className="titulo";
				nodo.onclick = function(){
					var newWindow = window.open("./vista.php?id="+datos.Id, '_blank');
  					newWindow.focus();
				}
				nodoTexto = document.createElement("span");   
				nodoTexto.className="titlecomment documento_tipo_"+datos.IdTipo;
				nodoTexto.appendChild(document.createTextNode(datos.Tipo));
				nodo.appendChild(document.createTextNode(titulo));
				nodo.appendChild(nodoTexto);
				leftElm.appendChild(nodo);

				var nodo = document.createElement("div");                 // Crear elemento Comentario
				nodo.className="comentario";
				nodo.appendChild(document.createTextNode(datos.Comentario)); 
				leftElm.appendChild(nodo);

				var nodo = document.createElement("div");                 // Crear elemento Asignatura
				nodo.className="asignatura";
				nodo.appendChild(document.createTextNode(datos.Asignatura)); 
				rightElm.appendChild(nodo);

				var nodo = document.createElement("div");                 // Crear elemento Grado 
				nodo.className="grado";
				nodo.appendChild(document.createTextNode(datos.Grado));
				rightElm.appendChild(nodo);

				var nodo = document.createElement("div");                 // Crear elemento Curso
				nodo.className="curso";
				nodo.appendChild(document.createTextNode(datos.Curso)); 
				rightElm.appendChild(nodo);

				
				var nodo = document.createElement("div");                 // Crear elemento Usuario
				nodo.className="nick";
				nodo.appendChild(document.createTextNode(datos.Nick));
				rightElm.appendChild(nodo);

				var nodo = document.createElement("div");                 // Crear elemento Fecha
				nodo.className="fecha";
				nodo.appendChild(document.createTextNode(datos.Fecha));
				rightElm.appendChild(nodo);

				

				resultado.appendChild(leftElm);
				resultado.appendChild(rightElm);

				document.getElementById("canvas").appendChild(resultado);

			}

			function anadirBotonesNavegacion(tipo, funcion, paginaActual){

				var botonesDiv = document.createElement("div");

				var botonSpan;

				botonesDiv.id = "botonesNavegacion";
				if(tipo == "atras" || tipo == "ambos"){
					botonSpan = document.createElement("span");
					botonSpan.id="boton_izquierda";
					if(funcion == "buscarPorTexto"){
						
						botonSpan.onclick = function(){ buscarPorTexto(textoBusqueda, paginaActual-1); };
					}
					if(funcion == "cargarResultados"){
						botonSpan.onclick = function(){ cargarResultados(paginaActual-1); };
					}
					botonSpan.appendChild(document.createTextNode(String.fromCharCode(8592)+"Anterior"));
					botonesDiv.appendChild(botonSpan);
				}

				if(tipo == "delante" || tipo == "ambos"){
					botonSpan = document.createElement("span");
					botonSpan.id="boton_derecha";
					if(funcion == "buscarPorTexto"){
						botonSpan.onclick = function(){ buscarPorTexto(textoBusqueda, paginaActual+1);};
					}
					if(funcion == "cargarResultados"){
						botonSpan.onclick = function(){ cargarResultados(paginaActual+1); };
					}
					botonSpan.appendChild(document.createTextNode("Siguiente"+String.fromCharCode(8594)));
					botonesDiv.appendChild(botonSpan);
				}
				document.getElementById("canvas").appendChild(botonesDiv);


			}
		
			function cargarResultados(pagina){
				if(pagina == undefined || pagina == ""){ pagina = 0; }

				var asignatura = document.getElementById("asignatura").value;
				var grado = document.getElementById("grado").value;
				var curso = document.getElementById("curso").value;
				if(debug){console.log(asignatura);}
				ajaxget( "becario.php?func=filtrar_apuntes&asignatura="+asignatura+"&curso="+curso+"&grado="+grado+"&pagina="+pagina,
					function(xhttp){
						
						var dataJSON = JSON.parse(xhttp.responseText);
						if(debug){console.log(xhttp.responseText);}
						

						document.getElementById("canvas").innerHTML = "";
						for(var i = 0; i<dataJSON.length;i++){
							console.log(dataJSON[i].IdTipo);
							appendResult(dataJSON[i]);
						}
						if(debug){console.log("Mas de 10"+dataJSON.length);}
						if(dataJSON.length == 0){
							sinResultados();
							return 0;
						}
						if(pagina == 0 && dataJSON.next == "true"){
							anadirBotonesNavegacion("delante", "cargarResultados", pagina);
						}
						if(pagina > 0 ){
							if(dataJSON.next == "true"){
								anadirBotonesNavegacion("ambos", "cargarResultados", pagina);
							}else{
								anadirBotonesNavegacion("atras", "cargarResultados", pagina);

							}
						}
					}
				);
			}


		</script>
	</head>
	<body>
		<div id="mensaje_error">
		</div>


		<div id="header">
			<div id="header_left">
				<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>Grado:</td>
						<td>
							<select id="grado">
								<option value="ALL">Todos</option>
							</select>
						</td>
						<td>Curso</td>
						<td>
							<select id="curso">
								<option value="ALL">Todos</option>
							</select>
						</td>
					</tr>
					<tr><td>Asignatura:</td>
					<td>
						<select id="asignatura"  style="max-width:200px;">
							<option value="ALL">Todas</option>
						</select>
					</td></tr>
					<tr><td><div id="header_filtrar" class="puntero">Filtrar</div></td><td></td></tr>
				</table>
			</div>
			<div id="header_middle">
				<div id="header_searchbox">
					<table border="0">
					<tr><td><input type="text" value="Buscar..." id="header_search_text" /></td>
					<td><input type="button" id="header_search" value="Buscar"/></td>
					</tr>
					<tr>
						<td class="pequeno">
						<label><input type="checkbox" id="header_search_check_apuntes" value="1" checked>Apuntes</label>
						<label><input type="checkbox" id="header_search_check_examenes" checked>Examenes</label>
						</td>
					</tr>
					</table>
				</div>
			</div>
			<div id="header_right">
				<div id="header_nombre" class="info">
					<div class="cell username">Hola <?php echo $userInfo->Nombre." ".$userInfo->Apellido1; ?></div>
					<div id="header_closesesion" class="cell closesesion puntero">Salir</div>
				</div>
				<div class="info">
					<div id="header_subir" class="cell textright puntero">Subir archivo</div>
				</div>
				<div class="info">
					<div class="cell textright colorgray">Puntos</div>
					<div class="cell colorgray" id="puntos">-</div>
				</div>
				
			</div>
		</div>
		<div id="canvas">
		</div>
	</body>
</html>

<?php
}
?>