<?php
require_once("configuracion.php");
require_once("DB.php");
require_once("sesion.php");

if(haEntrado()){
	$DB=sql_connect();
	$query="SELECT id FROM cr45 WHERE uid=?";
	$prepare=$DB->prepare($query);
	$prepare->bindParam(1, $USERINFO->IdUsuario , PDO::PARAM_STR);
	$prepare->execute();

	if($fila = $prepare->fetchObject()){
		// Admin site!!!
		?>

<!DOCTYPE html>
<html>
	<head>
	<title>Admin page</title>
	<style type="text/css">
	body {
		overflow:hidden;
		width:100%;
		height:100%;
		padding:0;
		margin:0;
	}
	#menu {
		position:absolute;
		top:0px;
		left:0px;
		bottom:0px;
		width:300px;
		background:#293440;
	}

	#menu_info {
		padding:10px 10px 10px 10px;
		background:#8698a8;
		margin-bottom:10px;
	}

	#menu ul{
		list-style-type: none;
		margin:0;
		margin-left: 10px;
		padding: 0;
		overflow: hidden;
	}

	#menu ul li {
		color:#FFF;
		padding: 10px 10px 10px 10px;
		font-size:20px;
		cursor:pointer;
	}

	#menu ul li:hover {
		background:#8698a8;
	}

	#canvas {
		position:absolute;
		top:0px;
		right:0px;
		bottom:0px;
		overflow-y:auto;
		left:301px;
		background:#EEE;
	}

	#canvas #top {
		padding-top:10px;
		min-height:120px;
		width:100%;
		text-align: center;

	}

	.box_info {
		width:300px;
		padding:10px 10px 10px 10px;
		min-height:100px;
		display: inline-block;
		border:1px solid #CCC;
		border-radius: 5px 5px 5px 5px;
		font-family:Arial;
		background:#FFF;
	}

	.box_info_name {
		font-size:20px;
	}

	.box_info_value {
		font-size:40px;

	}

	.box_info_circle {
		width:200px;
		padding:10px 10px 10px 10px;
		height:200px;
		display: inline-block;
		border:1px solid #CCC;
		border-radius: 5px 5px 5px 5px;
		font-family:Arial;
		background:#FFF;

	}

	.box_info_circle_value {
		width:170px;
		height:170px;
		
	}

	#canvas #bottom {
		margin-top:10px;
		min-height:120px;
		width:100%;
		text-align: center;
		border-top:1px solid #CCC;

		
	}

	.result {
		text-align: left;
		padding:10px 10px 10px 10px;
		font-family:Arial;
		border-bottom:1px solid #CECECE;

	}

	.result_name {
		font-size:24px;
	}

	.result_change {
		color:#00F;
		padding-left:10px;
		cursor:pointer;
	}

	.result_delete {
		color:#F00;
		padding-left:10px;
		cursor:pointer;
	}

	.result_activate {
		color:#0F0;
		padding-left:10px;
		cursor:pointer;
	}

	#edit_title {
		font-size:30px;
	}
	.edit_input {
		width:300px;
		font-size:18px;
		height:20px;
	}

	.edit_textarea {
		width:300px;
		
		height:200px;
	}

	table {
		font-family: Arial;
		font-size:18px;
		width:100%;
	}

	table tr:hover{
		background:#CCC;
	}

	#page_arrows {
		font-size:30px;
		width:100%;
		height:50px;
		border-bottom:1px solid #AAA;

	}

	#page_arrows_left {
		float:left;
		cursor:pointer;
	}


	#page_arrows_right {
		float:right;
		
		cursor:pointer;
	}

	#canvas_cpu {
		border:1px solid #CCC;
		background:#293440;
		float:left;
		width:600px;
		height:200px;
		margin:10px 10px 10px 10px;
	}

	#canvas_ram {
		border:1px solid #CCC;
		background:#293440;
		float:left;
		width:600px;
		height:200px;
		margin:10px 10px 10px 10px;
	}

	#canvas_temp {
		border:1px solid #CCC;
		background:#293440;
		float:left;
		width:600px;
		height:200px;
		margin:10px 10px 10px 10px;
	}
	</style>
	</head>
	<body>
	<div id="menu">
		<div id="menu_info">
		<ul>
			<li>Bienvenido <?php echo $USERINFO->Nombre;?></li>
			<li><?php echo date("d/m/Y");?></li>

			<li>Documentos: <span id="menu_info_doc_num">-</span></li>
			<li>Usuarios: <span id="menu_info_user_num">-</span></li>
			<li>Usuarios activos: <span id="menu_info_active_num">-</span></li>
			<!---<li>Temperatura:</li>
			<li>Carga:</li>---->
		</ul>
		</div>
		<ul>
			<li onClick="page('principal')">Inicio</li>
			<li onClick="page('usuarios')">Usuarios</li>
			<li onClick="page('documentos')">Documentos</li>
			<li class="separator"></li>
			<li onClick="serverAction('restart', this)" style="color:red">Restart</li>
			<li onClick="serverAction('shutdown', this)" style="color:red">Shut down</li>
		</ul>
	</div>
	<div id="canvas">
		<div id="top">
			<div class="box_info" id="box_info_cpu">
				<div class="box_info_name">CPU</div>
				<div class="box_info_value" id="box_info_value_cpu">--</div>
			</div>
			<div class="box_info" id="box_info_ram">
				<div class="box_info_name">RAM</div>
				<div class="box_info_value" id="box_info_value_ram">--</div>
			</div>
			<div class="box_info" id="box_info_temp">
				<div class="box_info_name">TEMP ºC</div>
				<div class="box_info_value" id="box_info_value_temp">--</div>
			</div>
		</div>
		<div id="bottom">
			<div class="box_info_circle" id="box_info_circle_files">
				<div class="box_info_name">Archivos</div>
				<canvas class="box_info_circle_value" width="400" height="400" id="box_info_circle_value_files"></canvas>
			</div>
			<div class="box_info_circle" id="box_info_circle_prop">
				<div class="box_info_name">Usuarios activos</div>
				<canvas class="box_info_circle_value" width="400" height="400" id="box_info_circle_value_prop"></canvas>
			</div>
		</div>

	</div>
	</body>
	<script languaje="JavaScript">
	(function(){
		window.ajaxpost=function(u,p,c){a(u,p,c,0);}
		window.ajaxget = function(u,c){a(u,"",c,1)}
		function a(u,p,c,m){var x=new XMLHttpRequest();x.open(((m==0)?"POST":"GET"),u,true);if(m==0){x.setRequestHeader("Content-type","application/x-www-form-urlencoded");}
x.send(p);x.onreadystatechange=function(){if(x.readyState==4&&x.status==200){c(x.responseText);}}}
	})();
	(function(){

		var requerstAnimationFrame=window.requerstAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame;
		window.statistics={
			i:0,
			ram:[],
			cpu:[],
			temp:[]
		};
		window.currentPage=0;

		window.toDecimal=function(a){
			return (parseInt(parseFloat(a)*100))/100;
		}
		window.writeInfo=function(a,b){
			var c=document.getElementById(a);
			c.innerText=b;
		};

		window.page=function(a){
			window["pagina"+a.charAt(0).toUpperCase()+a.slice(1)]();
			location.hash="#page="+a;
			
		};

		window.writeCpu=function(a){

			var color="rgba(20,200,20,0.5)";
			if(a>90){
				color="rgba(200,20,20,0.5)";
			}else if(a>60){
				color="rgba(200,200,20,0.5)";
			}
			document.getElementById("box_info_cpu").style.background=color;
			window.statistics.cpu[window.statistics.i%100]=a;

			writeInfo("box_info_value_cpu",a);
		};

		window.writeRam=function(a,b){
			var color="rgba(20,200,20,0.5)";
			if(a/b>0.90){
				color="rgba(200,20,20,0.5)";
			}else if(a/b>0.60){
				color="rgba(200,200,20,0.5)";
			}
			document.getElementById("box_info_ram").style.background=color;
			writeInfo("box_info_value_ram",parseInt(100*a/b)+"% de "+b+"Mb");
			window.statistics.ram[window.statistics.i%100]=parseFloat(a)/parseFloat(b);
		};

		window.writeTemp=function(a){
			var color="rgba(20,200,20,0.5)";
			if(a>60){
				color="rgba(200,20,20,0.5)";
			}else if(a>50){
				color="rgba(200,200,20,0.5)";
			}
			document.getElementById("box_info_temp").style.background=color;
			writeInfo("box_info_value_temp",a);
			window.statistics.temp[window.statistics.i%100]=a;
			if(window.statistics.i>=100){window.statistics.i=0;}
			window.statistics.i++;
		};

		window.loadInfo=function(a,b){
			var c=document.getElementById(a);
			c.innerText=b;
		};
		window.getAllBasic=function(){
			ajaxget("fetcher_admin.php?fetch=allBasic", function(a){
				var b = a.split("\|");
				writeCpu(parseFloat(b[2]));
				writeRam(parseFloat(b[1]), parseFloat(b[0]));
				writeTemp(toDecimal(b[3]/1000));

				setTimeout(getAllBasic,2000);
				
				
			});

			ajaxget("fetcher_admin.php?fetch=userNum", function(a){
				document.getElementById("menu_info_user_num").innerText=a;
			});
			ajaxget("fetcher_admin.php?fetch=docNum", function(a){
				document.getElementById("menu_info_doc_num").innerText=a;
			});

			ajaxget("fetcher_admin.php?fetch=activeNum", function(a){
				document.getElementById("menu_info_active_num").innerText=a;
			});

			

		};

		window.userAction=function(e){
			var s=e.target.id.split(/\_/g);
			var elm=document.getElementById(e.target.id);
			if(s[0]=="change"){
				editUserPage(s[1]);
			}
			if(s[0]=="delete"){
				elm.style.color="#F0F";
				elm.innerText="Desactivando...";
				ajaxpost("fetcher_admin.php?fetch=userDel", "romongo="+s[1],function(a){
					if(a=="1"){
						elm.style.color="#0F0";
						elm.innerText="Desactivado";
						elm.setAttribute("id","activate_"+s[1]);
						setTimeout(function(){elm.innerText="Activar"}, 2000);
					}else{
						elm.style.color="#F00";
						elm.innerText="Error";
						setTimeout(function(){elm.innerText="Desactivar"}, 2000);
					}
				});
			}

			if(s[0]=="activate"){
				elm.style.color="#F0F";
				elm.innerText="Activando...";
				ajaxpost("fetcher_admin.php?fetch=userAct", "romongo="+s[1],function(a){
					if(a=="1"){
						elm.style.color="#F00";
						elm.innerText="Activado";
						elm.setAttribute("id","delete_"+s[1]);
						setTimeout(function(){elm.innerText="Desactivar"}, 2000);
					}else{
						elm.style.color="#0F0";
						elm.innerText="Error";
						setTimeout(function(){elm.innerText="Activar"}, 2000);
					}
				});
			}
		};

		window.serverAction=function(action, that){
			that.style.color="#CC0000";
			ajaxpost("fetcher_admin.php?action="+action, "lid=",function(a){
					if(a=="1"){
						setTimeout(that.style.color="#00FF00",1000);
					}
			});
		}

		window.docAction=function(e){
			var s=e.target.id.split(/\_/g);
			var elm=document.getElementById(e.target.id);
			if(s[0]=="change"){
				editDocPage(s[1]);
			}
			if(s[0]=="delete"){
				elm.style.color="#F0F";
				elm.innerText="Desactivando...";
				ajaxpost("fetcher_admin.php?fetch=docDel", "romongo="+s[1],function(a){
					if(a=="1"){
						elm.style.color="#0F0";
						elm.innerText="Desactivado";
						elm.setAttribute("id","activate_"+s[1]);
						setTimeout(function(){elm.innerText="Activar"}, 2000);
					}else{
						elm.style.color="#F00";
						elm.innerText="Error";
						setTimeout(function(){elm.innerText="Desactivar"}, 2000);
					}
				});
			}

			if(s[0]=="activate"){
				elm.style.color="#F0F";
				elm.innerText="Activando...";
				ajaxpost("fetcher_admin.php?fetch=docAct", "romongo="+s[1],function(a){
					if(a=="1"){
						elm.style.color="#F00";
						elm.innerText="Activado";
						elm.setAttribute("id","delete_"+s[1]);
						setTimeout(function(){elm.innerText="Desactivar"}, 2000);
					}else{
						elm.style.color="#0F0";
						elm.innerText="Error";
						setTimeout(function(){elm.innerText="Activar"}, 2000);
					}
				});
			}
		};

		window.saveDocumentUpdate=function(e){
			var id=e.target.id.slice(12);
			console.log(id);
			var postData="romongo="+id+"&titulo="+document.getElementById("edit_1").value;
			postData+="&usuario="+document.getElementById("edit_2").value;
			postData+="&fechasubida="+document.getElementById("edit_3").value;
			postData+="&tipo="+document.getElementById("edit_4").value;
			postData+="&anio="+document.getElementById("edit_5").value;
			postData+="&documento="+document.getElementById("edit_6").value;
			postData+="&hash="+document.getElementById("edit_7").value;
			postData+="&asignatura="+document.getElementById("edit_8").value;
			postData+="&comentario="+document.getElementById("edit_9").value;
			
			e.target.value="Guardando...";
			ajaxpost("fetcher_admin.php?fetch=docChange", postData ,function(a){
					var s=a.split(/\|/g);
					document.getElementById("save_error").innerText="";
					if(s[0]=="1"){
						e.target.value="Guardado!";
						setTimeout(function(){e.target.value="Guardar"},2000);
					}else{
						document.getElementById("save_error").innerText=s[1];
					}
				});


		};

		window.editDocPage = function(id){
			ajaxpost("fetcher_admin.php?fetch=docData", "romongo="+id, function(a){
				var b=document.getElementById("bottom");
				if(a=="0"){ b.innerText = "Error grave!"; return; }

				var data=a.split(/\|/g);
				console.log(a);
				var elm, table, tr, td;


				b.innerHTML="";
				elm=document.createElement("div");
				elm.setAttribute("id","edit_title");
				elm.append(document.createTextNode("Editando documento con id="+id));
				b.append(elm);

				table=document.createElement("table");
				table.setAttribute("id", "edit_page");
				table.setAttribute("border", "0");


				var names = ["Titulo", "Usuario(ID)", "Fecha", "Tipo", "Año", "URI Documento", "Hash", "Asignatura"];


				for(var i=1;i<9;i++){
					tr=document.createElement("tr");
					td=document.createElement("td");
					td.append(document.createTextNode(names[i-1]));
					tr.append(td);
					td=document.createElement("td");
					elm=document.createElement("input");
					elm.className="edit_input";
					elm.setAttribute("id","edit_"+i);
					elm.type="text";
					elm.value=data[i];
					td.append(elm);

					tr.append(td);
					table.append(tr);

				}

				tr=document.createElement("tr");
				td=document.createElement("td");
				td.append(document.createTextNode("Comentario"));
				tr.append(td);

				td=document.createElement("td");
				elm=document.createElement("textarea");
				elm.cols="20";
				elm.rows="10";
				elm.setAttribute("id","edit_9");
				elm.className="edit_textarea";
				elm.value=data[9];
				td.append(elm);

				tr.append(td);
				table.append(tr);

				tr=document.createElement("tr");
				td=document.createElement("td");
				td.setAttribute("id","save_error");
				tr.append(td);

				td=document.createElement("td");
				elm=document.createElement("input");
				elm.type="button"
				elm.setAttribute("id","save_button_"+id);
				elm.className="edit_button";
				elm.onclick=saveDocumentUpdate;
				elm.value="Guardar";
				td.append(elm);

				tr.append(td);
				table.append(tr);



				//table.append(tr);
				

				b.append(table);

			});
		};



		window.saveUserUpdate=function(e){
			var id=e.target.id.slice(12);
			console.log(id);
			var postData="romongo="+id+"&nombre="+document.getElementById("edit_1").value;
			postData+="&apellido1="+document.getElementById("edit_2").value;
			postData+="&apellido2="+document.getElementById("edit_3").value;
			postData+="&password="+document.getElementById("edit_4").value;
			postData+="&nick="+document.getElementById("edit_5").value;
			postData+="&email="+document.getElementById("edit_6").value;
			postData+="&estudios="+document.getElementById("edit_7").value;
			
			e.target.value="Guardando...";
			ajaxpost("fetcher_admin.php?fetch=userChange", postData ,function(a){
					var s=a.split(/\|/g);
					document.getElementById("save_error").innerText="";
					if(s[0]=="1"){
						e.target.value="Guardado!";
						setTimeout(function(){e.target.value="Guardar"},2000);
					}else{
						console.log(a);
						document.getElementById("save_error").innerText=s[1];
					}
				});


		};
		window.editUserPage = function(id){
			ajaxpost("fetcher_admin.php?fetch=userData", "romongo="+id, function(a){
				var b=document.getElementById("bottom");
				if(a=="0"){ b.innerText = "Error grave!"; return; }

				var data=a.split(/\|/g);
				console.log(a);
				var elm, table, tr, td;


				b.innerHTML="";
				elm=document.createElement("div");
				elm.setAttribute("id","edit_title");
				elm.append(document.createTextNode("Editando usuario con id="+id));
				b.append(elm);

				table=document.createElement("table");
				table.setAttribute("id", "edit_page");
				table.setAttribute("border", "0");


				var names = ["Nombre", "Apellido1", "Apellido2", "Password", "Nick", "Email", "Estudios"];


				for(var i=1;i<8;i++){
					tr=document.createElement("tr");
					td=document.createElement("td");
					td.append(document.createTextNode(names[i-1]));
					tr.append(td);
					td=document.createElement("td");
					elm=document.createElement("input");
					elm.className="edit_input";
					elm.setAttribute("id","edit_"+i);
					elm.type="text";
					elm.value=data[i];
					td.append(elm);

					tr.append(td);
					table.append(tr);

				}


				tr=document.createElement("tr");
				td=document.createElement("td");
				td.setAttribute("id","save_error");
				tr.append(td);

				td=document.createElement("td");
				elm=document.createElement("input");
				elm.type="button"
				elm.setAttribute("id","save_button_"+id);
				elm.className="edit_button";
				elm.onclick=saveUserUpdate;
				elm.value="Guardar";
				td.append(elm);

				tr.append(td);
				table.append(tr);



				//table.append(tr);
				

				b.append(table);

			});
		};

		window.dibujaGrafica=function(){
			var canvas_cpu = document.getElementById("canvas_cpu");
			var canvas_ram = document.getElementById("canvas_ram");
			var canvas_temp = document.getElementById("canvas_temp");
			if(canvas_cpu == undefined || canvas_ram == undefined || canvas_temp== undefined){ return; }else{
				var cpu_ctx, ram_ctx, temp_ctx;
				
				// CPU
				cpu_ctx = canvas_cpu.getContext("2d");
				ram_ctx = canvas_ram.getContext("2d");
				temp_ctx = canvas_temp.getContext("2d");

			
				var i=0, l=window.statistics.temp.length, tmin=999, tmax=-999;
				for(;i<l; i++){
					if(tmin>window.statistics.temp[i]){
						tmin=window.statistics.temp[i];
					}
					if(tmax<window.statistics.temp[i]){
						tmax=window.statistics.temp[i];
					}
				}

				cpu_ctx.clearRect(0,0, canvas_cpu.width, canvas_cpu.height);
				ram_ctx.clearRect(0,0, canvas_ram.width, canvas_ram.height);
				temp_ctx.clearRect(0,0, canvas_temp.width, canvas_temp.height);

				cpu_ctx.font = ram_ctx.font = temp_ctx.font = "20px Arial";
				cpu_ctx.fillText("CPU (%)",10,22);
				ram_ctx.fillText("RAM (%)",10,22);
				temp_ctx.fillText("TEMP [RANGE: "+tmin+" - "+tmax+"]",10,22);

				cpu_ctx.beginPath();
				cpu_ctx.strokeStyle="#00FF00";
				cpu_ctx.moveTo(0,(1-(window.statistics.cpu[0]/100))*canvas_cpu.height);

				ram_ctx.beginPath();
				ram_ctx.strokeStyle="#0000FF";
				ram_ctx.moveTo(0,(1-(window.statistics.ram[0]))*canvas_ram.height);

				temp_ctx.beginPath();
				temp_ctx.strokeStyle="#00FFFF";
				temp_ctx.moveTo(0,(1-(window.statistics.temp[0]-tmin)/(tmax-tmin))*canvas_temp.height);

				var c=canvas_cpu.width/100;
				for(i=1;i<window.statistics.i; i++){
					cpu_ctx.lineTo(i*c,(1-(window.statistics.cpu[i]/100))*canvas_cpu.height);
					ram_ctx.lineTo(i*c,(1-(window.statistics.ram[i]))*canvas_ram.height);
					temp_ctx.lineTo(i*c,(1-(window.statistics.temp[i]-tmin)/(tmax-tmin))*canvas_temp.height);
				}
				cpu_ctx.stroke();
				ram_ctx.stroke();
				temp_ctx.stroke();



			}
			requerstAnimationFrame(dibujaGrafica);

		};
		window.paginaPrincipal=function(){
				window.currentPage=0;
				var b=document.getElementById("bottom");
				b.innerHTML="";
				elm=document.createElement("div");
				elm.className="graph_div";
				elm2=document.createElement("canvas");
				elm2.className="graph_canvas";
				elm2.setAttribute("id","canvas_cpu");
				elm2.width="600";
				elm2.height="200";
				elm.append(elm2);


				elm2=document.createElement("canvas");
				elm2.className="graph_canvas";
				elm2.setAttribute("id","canvas_ram");
				elm2.width="600";
				elm2.height="200";
				elm.append(elm2);


				elm2=document.createElement("canvas");
				elm2.className="graph_canvas";
				elm2.setAttribute("id","canvas_temp");
				elm2.width="600";
				elm2.height="200";
				elm.append(elm2);

				b.append(elm);


				
			
				setTimeout(dibujaGrafica, 1000);
		};


		window.paginaUsuarios=function(p){
			if(p==undefined || p<0){p=0;}
			window.currentPage=p;
			ajaxget("fetcher_admin.php?fetch=userList&page="+p, function(a){
				var splitted=a.split(/\|/g);
				var i,l=splitted.length-1;

				console.log(l);
				var elm, div, linkElm, b=document.getElementById("bottom");
				b.innerHTML="";

				elm=document.createElement("div");
				elm.setAttribute("id","page_arrows");
				
				if(p>0){
					elmA=document.createElement("span");
					elmA.onclick=function(){paginaUsuarios(window.currentPage-1);}
					elmA.innerHTML="&#8592;";
					elmA.setAttribute("id","page_arrows_left");
					elm.append(elmA);
				}


				if(l>59){
					elmA=document.createElement("span");
					elmA.onclick=function(){paginaUsuarios(window.currentPage+1);}
					elmA.innerHTML="&#8594;";
					elmA.setAttribute("id","page_arrows_right");
					elm.append(elmA);
				}

				b.append(elm);

				for(i=0; i<l;i+=6){
					div=document.createElement("div");
					div.className="result";
					
					elm=document.createElement("div");
					elm.className="result_name";
					elm.append(document.createTextNode("[ID:"+splitted[i]+"] "+splitted[i+1]+" "+splitted[i+2]));


					linkElm=document.createElement("span");
					linkElm.className="result_change";
					linkElm.setAttribute("id","change_"+splitted[i]);
					linkElm.onclick=userAction;
					linkElm.append(document.createTextNode("Modificar"));
					elm.append(linkElm);

					linkElm=document.createElement("span");
					if(splitted[i+5]=="1"){
						
						linkElm.className="result_delete";
						linkElm.setAttribute("id","delete_"+splitted[i]);
						linkElm.append(document.createTextNode("Desactivar"));
						
						
					}else{

						linkElm.className="result_activate";
						linkElm.setAttribute("id","activate_"+splitted[i]);
						linkElm.style.color="#0F0";
						linkElm.append(document.createTextNode("Activar"));
					}

					linkElm.onclick=userAction;
					elm.append(linkElm);
					div.append(elm);

					elm=document.createElement("div");
					elm.className="result_info_1";
					elm.append(document.createTextNode("Nick: "+splitted[i+3]));
					div.append(elm);

					elm=document.createElement("div");
					elm.className="result_info_2";
					elm.append(document.createTextNode("Mail: "+splitted[i+4]));
					div.append(elm);

					b.append(div);

				}				
			});
		};

		window.paginaDocumentos=function(p){
			if(p==undefined || p<0){p=0;}
			window.currentPage=p;
			ajaxget("fetcher_admin.php?fetch=docList&page="+p, function(a){
				var splitted=a.split(/\|/g);
				var i,l=splitted.length-1;
				console.log("l"+l);
				var elm, elmA, div, linkElm, b=document.getElementById("bottom");
				b.innerHTML="";
				console.log(l);
				elm=document.createElement("div");
				elm.setAttribute("id","page_arrows");
				
				if(p>0){
					elmA=document.createElement("span");
					elmA.onclick=function(){paginaDocumentos(window.currentPage-1);}
					elmA.innerHTML="&#8592;";
					elmA.setAttribute("id","page_arrows_left");
					elm.append(elmA);
				}

				if(l>59){
					elmA=document.createElement("span");
					elmA.onclick=function(){paginaDocumentos(window.currentPage+1);}
					elmA.innerHTML="&#8594;";
					elmA.setAttribute("id","page_arrows_right");
					elm.append(elmA);
				}

				b.append(elm);

				for(i=0; i<l;i+=6){

					div=document.createElement("div");
					div.className="result";
					
					elm=document.createElement("div");
					elm.className="result_name";
					elm.append(document.createTextNode("[ID:"+splitted[i]+"] "+splitted[i+1]));


					linkElm=document.createElement("span");
					linkElm.className="result_change";
					linkElm.onclick=docAction;
					linkElm.setAttribute("id","change_"+splitted[i]);
					linkElm.append(document.createTextNode("Modificar"));
					elm.append(linkElm);

					linkElm=document.createElement("span");
					if(splitted[i+5]=="1"){
						
						linkElm.className="result_delete";
						linkElm.setAttribute("id","delete_"+splitted[i]);
						linkElm.append(document.createTextNode("Desactivar"));
						
						
					}else{

						linkElm.className="result_activate";
						linkElm.setAttribute("id","activate_"+splitted[i]);
						linkElm.style.color="#0F0";
						linkElm.append(document.createTextNode("Activar"));
					}
					linkElm.onclick=docAction;
					elm.append(linkElm);

					div.append(elm);

					elm=document.createElement("div");
					elm.className="result_info_1";
					elm.append(document.createTextNode("Subido por: "+splitted[i+2]+" ("+splitted[i+3]+")"));
					div.append(elm);

					elm=document.createElement("div");
					elm.className="result_info_2";
					elm.append(document.createTextNode("Fecha subida: "+splitted[i+4]));
					div.append(elm);
					b.append(div);

				}
				
			});

		};

		window.setCircleValue=function(elm, values){
			if(values.constructor.name=="Array"){
				// Normalize
				var total=0;
				var m, mCtx, suma, i, left, right, begin, final, l=values.length;
				var colors=["#FF0000","#00FF00","#0000FF"];
				m=document.getElementById(elm);
				
				left=m.width/2;
				right=m.height/2;
				radius=0.8*left;

				mCtx=m.getContext("2d");
				while(l--){
					total+=values[l];
				}
				if(total==1){
					mCtx.beginPath();
					mCtx.lineWidth=8;
					l=values.length;
					begin=0;
					final=0;
					suma=0;
					for(i=0;i<l;i++){
						mCtx.strokeStyle=colors[i%3];
						console.log(values[i]);
						final=values[i]*2*Math.PI;
						mCtx.arc(left, right, radius, begin, final);
						suma+=final-begin;
						begin=final;
					}

					mCtx.stroke();

				}else{
					
					l=values.length;
					
					mCtx.lineWidth=8;

					begin=0;
					final=0;
					suma=0;
					for(i=0;i<l;i++){
						mCtx.beginPath();
						mCtx.strokeStyle=colors[i%3];
						console.log("From"+begin+", to "+values[i]/total*2*Math.PI);
						final=values[i]/total*2*Math.PI;
						mCtx.arc(left, right, radius, begin, final);
						suma+=final-begin;
						begin=final;
						mCtx.stroke();
					}

					

				}
			}else if(values.constructor.name=="Number"){
				// Normalizado
				if(values>=0 && values<=1){

				}

			}else{
				return;
			}
		};
	})();

	window.onload=function(){
		var r=location.hash.slice(1).split(/\&|\=/g);
		var s=r.indexOf("page");
		var page;
		getAllBasic();
		if(s>=0){
			page=r[s+1];
			switch(page){
				case "usuarios":
					paginaUsuarios();
				break;
				case "documentos":
					paginaDocumentos();
				break;
				default:
				case "principal":
					paginaPrincipal();
				break;
			}
		}else{
			getAllBasic();
		}
	}
	</script>
</html>
	<?php
		
	}else{
		die("Si has llegado hasta aqui, ponte en contacto con el administrador.");
	}
}
?>