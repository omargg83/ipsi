let intval=""

onload = ()=> {
	loadContent(location.hash.slice(1));
	if(intval==""){
		intval=setInterval(function(){ sesion_ver(); }, 60000);
	}
	cargando(false);
};


	let url=window.location.href;
	let hash=url.substring(url.indexOf("#")+1);
	if(hash===url || hash===''){
		hash='dash/dashboard';
	}

	window.addEventListener("hashchange", (e)=>{
		loadContent(location.hash.slice(1));
	},false);	///////////////////para el hash


	function loadContent(hash){
		cargando(true);
		let formData = new FormData();
		let arrayDeCadenas = hash.split("?");
		let nhash=arrayDeCadenas[0];
		if(arrayDeCadenas.length>1){
			let query=arrayDeCadenas[1];
			var vars = query.split("&");
			for (var i=0; i < vars.length; i++) {
			var pair = vars[i].split("=");
				formData.append(pair[0],pair[1]);
			}
		}
		if(nhash==''){
			nhash= 'dash/dashboard';
		}
		let destino=nhash + '.php';
		let xhr = new XMLHttpRequest();
		xhr.open('POST',destino);
		xhr.addEventListener('load',(data)=>{
			document.getElementById("contenido").innerHTML =data.target.response;
			var scripts = document.getElementById("contenido").getElementsByTagName("script");
			for (var i = 0; i < scripts.length; i++) {
				eval(scripts[i].innerText);
			}
			cargando(false);
		});
		xhr.onerror = (e)=>{
			cargando(false);
		};
		xhr.send(formData);
	}
	function salir(){
	var formData = new FormData();
	formData.append("function", "salir");
	formData.append("ctrl", "control");
	let xhr = new XMLHttpRequest();
	xhr.open('POST',"control_db.php");
	xhr.addEventListener('load',(data)=>{
		location.href ="login/";
	});
	xhr.onerror = (e)=>{
		console.log(e);
	};
	xhr.send(formData);
}
	function sesion_ver(){
	var formData = new FormData();
	formData.append("function", "ses");
	formData.append("ctrl", "control");

	let xhr = new XMLHttpRequest();
	xhr.open('POST',"control_db.php");
	xhr.addEventListener('load',(data)=>{
		var datos = JSON.parse(data.target.response);
		if (datos.sess=="cerrada"){
			location.href ="login/";
		}
	});
	xhr.onerror = (e)=>{
		console.log(e);
	};
	xhr.send(formData);
}

	/*
		Libreria Propia V.3
		Ruben Omar García
		omargg83@gmail.com
	*/

	$(document).on('click',"[is='menu-link']",function(e){
		let hash=e.currentTarget.hash.slice(1);
		loadContent(hash);

		if(document.querySelector('.activeside')){
			document.querySelector('.activeside').classList.remove('activeside');
			this.classList.add('activeside');
		}
		else{
			this.classList.add('activeside');
		}
	});
	$(document).on('click',"[is*='li-link']",function(e){
		e.preventDefault();
		proceso_db(e);
	});
	$(document).on('click',"[is*='b-link']",function(e){
		e.preventDefault();
		proceso_db(e);
	});
	$(document).on('click',"[is*='a-link']",function(e){
		e.preventDefault();
		proceso_db(e);
	});
	$(document).on('submit',"[is*='f-submit']",function(e){
		e.preventDefault();
		 //////////id del formulario
		 let id=e.currentTarget.attributes.id.nodeValue;
		 let elemento = document.getElementById(id);

		 /////////API que procesa el form
		 let db;
		 (elemento.attributes.db !== undefined) ? db=elemento.attributes.db.nodeValue : db="";

		 /////////funcion del api que procesa el form
		 let fun;
		 (elemento.attributes.fun !== undefined) ? fun=elemento.attributes.fun.nodeValue : fun="";

		 /////////Div de destino despues de guardar
		 let dix;
		 (elemento.attributes.dix !== undefined) ? dix=elemento.attributes.dix.nodeValue : dix="trabajo";

		 /////////div destino despues de guardar
		 let des;
		 (elemento.attributes.des !== undefined) ? des=elemento.attributes.des.nodeValue : des="";

		 let desid;
		 (elemento.attributes.desid !== undefined) ? desid=elemento.attributes.desid.nodeValue : desid="";

		 ////////FORM pertenece a ventanamodal
		 let cmodal;
		 (elemento.attributes.cmodal !== undefined) ? cmodal=elemento.attributes.cmodal.nodeValue : cmodal="";

		 let datos = new Object();
		 datos.des=des+".php";
		 datos.desid=desid;
		 datos.db=db+".php";
		 datos.dix=dix;
		 datos.fun=fun;
		 datos.cmodal=cmodal;
		 var formDestino = new FormData();

		 var formData = new FormData(elemento);
		 formData.append("function", datos.fun);

		 /////////esto es para todas las variables
		 let variables = new Object();
		 for(let contar=0;contar<elemento.attributes.length; contar++){
			 let arrayDeCadenas = elemento.attributes[contar].name.split("_");
			 if(arrayDeCadenas.length>1){
				 formData.append(arrayDeCadenas[1], elemento.attributes[contar].value);
				 formDestino.append(arrayDeCadenas[1], elemento.attributes[contar].value);
			 }
		 }

		 if(db.length>4){
			 Swal.fire({
				 title: '¿Desea procesar los cambios realizados?',
				 showCancelButton: true,
				 confirmButtonColor: '#3085d6',
				 cancelButtonColor: '#d33',
				 confirmButtonText: 'Guardar'
			 }).then((result) => {
				 if (result.value) {

					 let xhr = new XMLHttpRequest();
					 xhr.open('POST',datos.db);
					 xhr.addEventListener('load',(data)=>{
						 if (!isJSON(data.target.response)){
							 console.log(data.target.response);
							 Swal.fire({
								 type: 'error',
								 title: "Error favor de verificar",
								 showConfirmButton: false,
								 timer: 1000
							 });
							 return;
						 }

						 var respon = JSON.parse(data.target.response);
						 if (respon.error==0){
							 if (datos.desid !== undefined && datos.desid.length>0) {
								 document.getElementById(datos.desid).value=respon.id1;
								 formDestino.append(datos.desid, respon.id1);
							 }
							 if (datos.des !== undefined && datos.des.length>4) {
								 redirige_div(formDestino,datos);
							 }
							 if(datos.cmodal==1){
								 $('#myModal').modal('hide');
							 }

							 Swal.fire({
								 type: 'success',
								 title: "Se guardó correctamente ",
								 showConfirmButton: false,
								 timer: 1000
							 });
						 }
						 else{
							 Swal.fire({
								 type: 'info',
								 title: respon.terror,
								 showConfirmButton: false,
								 timer: 1000
							 });
						 }
					 });
					 xhr.onerror =  ()=>{
						 console.log("error");
					 };
					 xhr.send(formData);

				 }
			 });

		 }
		 else{

			 let xhr = new XMLHttpRequest();
			 xhr.open('POST',datos.des);
			 xhr.addEventListener('load',(data)=>{
				 document.getElementById(datos.dix).innerHTML = data.target.response;
			 });
			 xhr.onerror =  ()=>{
				 console.log("error");
			 };
			 xhr.send(formData);
		 }
	});

	//////////////////////////Solo para un proceso antes del flujo ejem. al borrar que primero borre y luego redirive_div
	function proceso_db(e){
		let des;	/////////////el destino
		e.currentTarget.attributes.des!==undefined ? des=e.currentTarget.attributes.des.nodeValue : des="";

		let dix; 	/////////////	el div donde se pone el destino
		e.currentTarget.attributes.dix!==undefined ? dix=e.currentTarget.attributes.dix.nodeValue : dix="";

		let db;		/////////////en caso de base de datos
		e.currentTarget.attributes.db!==undefined ? db=e.currentTarget.attributes.db.nodeValue : db="";

		let fun;	///////////// la funcion a ejecutar
		e.currentTarget.attributes.fun!==undefined ? fun=e.currentTarget.attributes.fun.nodeValue : fun="";

		let tp;	///////////// la funcion a ejecutar
		e.currentTarget.attributes.tp!==undefined ? tp=e.currentTarget.attributes.tp.nodeValue : tp="";

		let tt;	///////////// la funcion a ejecutar
		e.currentTarget.attributes.tt!==undefined ? tt=e.currentTarget.attributes.tt.nodeValue : tt="";

		let iddest;
		e.currentTarget.attributes.iddest!==undefined ? iddest=e.currentTarget.attributes.iddest.nodeValue : iddest="";

		let omodal;
		e.currentTarget.attributes.omodal!==undefined ? omodal=e.currentTarget.attributes.omodal.nodeValue : omodal="";

		let cmodal;
		(e.currentTarget.attributes.cmodal !== undefined) ? cmodal=e.currentTarget.attributes.cmodal.nodeValue : cmodal="0";

		let datos = new Object();
		datos.des=des+".php";
		datos.db=db+".php";
		datos.dix=dix;
		datos.fun=fun;
		datos.tp=tp;
		datos.tt=tt;
		datos.iddest=iddest;
		datos.omodal=omodal;
		datos.cmodal=cmodal;

		/////////esto es para todas las variables
		var variables = new FormData();
		var formData = new FormData();
		for(let contar=0;contar<e.currentTarget.attributes.length; contar++){
			let arrayDeCadenas = e.currentTarget.attributes[contar].name.split("_");
			if(arrayDeCadenas.length>1){
				formData.append(arrayDeCadenas[1], e.currentTarget.attributes[contar].value);
				variables.append(arrayDeCadenas[1], e.currentTarget.attributes[contar].value);
			}
		}
		if(datos.cmodal==1){
			$('#myModal').modal('hide');
			return;
		}
		if(datos.cmodal==2){
			$('#myModal').modal('hide');
		}
		//////////////poner aqui proceso en caso de existir funcion
		if(fun.length>0){
			formData.append("function", datos.fun);
			if(datos.tp.length>0){
				Swal.fire({
					type: 'warning',
					title: datos.tp,
					text: datos.tt,
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Aceptar',
					cancelButtonText: 'Cancelar',
					focusCancel:true
				}).then((result) => {
					if (result.value) {
						let variable=0;
						let xhr = new XMLHttpRequest();
						xhr.open('POST',datos.db);
						xhr.addEventListener('load',(data)=>{
							if (!isJSON(data.target.response)){
								Swal.fire({
									type: 'error',
									title: "Error favor de verificar",
									showConfirmButton: false,
									timer: 1000
								});
								console.log(data.target.response);
								return;
							}
							var respon = JSON.parse(data.target.response);
							if (respon.error==0){
								Swal.fire({
									type: 'success',
									title: "Listo",
									showConfirmButton: false,
									timer: 1000
								});
								if (des.length>0){
									redirige_div(variables,datos);
								}
							}
							else{
								Swal.fire({
									type: 'info',
									title: respon.terror,
									showConfirmButton: false,
									timer: 1000
								});
							}
						});
						xhr.onerror = (e)=>{
						};
						xhr.send(formData);
					}
				});
			}
			else{
				let variable=0;
				let xhr = new XMLHttpRequest();
				xhr.open('POST',datos.db);
				xhr.addEventListener('load',(data)=>{
					if (!isJSON(data.target.response)){
						Swal.fire({
							type: 'error',
							title: "Error favor de verificar",
							showConfirmButton: false,
							timer: 1000
						});
						console.log(data.target.response);
						return;
					}
					var respon = JSON.parse(data.target.response);
					if (respon.error==0){
						Swal.fire({
							type: 'success',
							title: "Listo",
							showConfirmButton: false,
							timer: 1000
						});
						if (des.length>0){
							redirige_div(variables,datos);
						}
					}
					else{
						Swal.fire({
							type: 'info',
							title: respon.terror,
							showConfirmButton: false,
							timer: 1000
						});
					}
				});
				xhr.onerror = (e)=>{
				};
				xhr.send(formData);
			}
		}
		else{
			redirige_div(formData,datos);
		}
	}
	//////////////////////////redirige si es necesario
	function redirige_div(formData,datos){
		//console.log(datos);
		//for(var pair of formData.entries()) {
   		//console.log(pair[0]+ ', '+ pair[1]);
		//}
		cargando(true);
		let xhr = new XMLHttpRequest();
		xhr.open('POST', datos.des);
		xhr.addEventListener('load',(datares)=>{
			if(datares.target.status=="404"){
				Swal.fire({
						type: 'error',
						title: "No encontrado: "+datos.des,
						showConfirmButton: false,
				})
				cargando(false);
				return 0;
			}
			else{
				if(datos.omodal==1){
					$('#myModal').modal('show');
					datos.dix="modal_form";
				}
				document.getElementById(datos.dix).innerHTML = datares.target.responseText;
				var scripts = document.getElementById(datos.dix).getElementsByTagName("script");
				for (var i = 0; i < scripts.length; i++) {
			    eval(scripts[i].innerText);
				}
			}
			cargando(false);
		});
		xhr.onerror = (e)=>{
			cargando(false);
			console.log(e);
		};
		xhr.send(formData);
	}
	function cargando(valor) {
		let element = document.getElementById("cargando_div");
		if(valor){
			element.classList.add("is-active");
		}
		else{
			element.classList.remove("is-active");
		}
	}
	function isJSON (something) {
		if (typeof something != 'string')
				something = JSON.stringify(something);
		try {
				JSON.parse(something);
				return true;
		} catch (e) {
				return false;
		}
	}

///////////////////////////////////////vainija.js
	function editable(e, id){
		let divid=e.id;
		let arrayDeCadenas = divid.split("_");
		let idtext=arrayDeCadenas[1];

		$("#"+e.id).after("<textarea class='form-control' name='texto_"+idtext+"' id='texto_"+idtext+"'>"+e.innerHTML+"</textarea>");
		$("#"+e.id).remove();

		$("#texto_"+idtext).summernote({
			lang: 'es-ES',
			placeholder: 'Texto',
			tabsize: 5,
			height: 200,
			toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
        ]
		});

	}

	////////////change para submit de respuesta del paciente
	$(document).on('change',"[is*='s-submit']",function(e){
			e.preventDefault();

			let id=e.target.form.id;
			let elemento = document.getElementById(id);

			if(e.currentTarget.type=='checkbox'){
				if(e.currentTarget.checked){
					$('.cond_'+e.currentTarget.value).show();
				}
				else{
					$('.cond_'+e.currentTarget.value).hide();
				}
			}
			else if(e.currentTarget.type=='select-one'){
				if ( $( '.cond_'+e.currentTarget.value ).length ) {
					$('.cond_'+e.currentTarget.value).show();
				}
				else{
					$('.cond_'+e.currentTarget.attributes.old.nodeValue).hide();
				}
			}
			procesar_resp(elemento);
	});
	$(document).on('submit',"[is*='resp-submit']",function(e){
		e.preventDefault();
		 //////////id del formulario
		 let id=e.currentTarget.attributes.id.nodeValue;
		 let elemento = document.getElementById(id);
		 procesar_resp(elemento);
	});
	function procesar_resp(elemento){
		/////////API que procesa el form
		let db=elemento.attributes.db.value+".php";
		let fun=elemento.attributes.fun.value;
		let idactividad=elemento.attributes.v_idactividad.value;
		let idpaciente=elemento.attributes.v_idpaciente.value;
		let idcontexto=elemento.attributes.v_idcontexto.value;

		var formData = new FormData(elemento);
		formData.append("function",fun);
		formData.append("idactividad",idactividad);
		formData.append("idpaciente", idpaciente);
		formData.append("idcontexto", idcontexto);

		let xhr = new XMLHttpRequest();
		xhr.open('POST', db);
		xhr.addEventListener('loadstart',(data)=>{

		});
		xhr.addEventListener('load',(data)=>{
			if (!isJSON(data.target.response)){
				Swal.fire({
					type: 'error',
					title: "Error favor de verificar",
					showConfirmButton: false,
					timer: 1000
				});
				return;
			}
			var respon = JSON.parse(data.target.response);
			if (respon.error==0){
				carga_respuesta(idcontexto, idactividad, idpaciente);
				document.getElementById('progreso_'+respon.idsubactividad).innerHTML=respon.progreso;
				document.getElementById('prog_'+respon.idactividad).innerHTML=respon.proact;
				Swal.fire({
					position: 'bottom-start',
					text: "Guardado",
					showConfirmButton: false,
					timer: 100
				});
			}
			else{
				cargando(false);
				Swal.fire({
					type: 'info',
					title: respon.terror,
					showConfirmButton: false,
					timer: 1000
				});
			}
		});
		xhr.onerror =  ()=>{
			cargando(false);
			console.log("error");
		};
		xhr.send(formData);
	}
	function carga_respuesta(idcontexto, idactividad, idpaciente){
		var formData = new FormData();
		formData.append("idcontexto", idcontexto);
		formData.append("idactividad", idactividad);
		formData.append("idpaciente", idpaciente);
		formData.append("function", "upd");
		let xhr = new XMLHttpRequest();
		xhr.open('POST',"a_respuesta/db_.php");
		xhr.addEventListener('load',(data)=>{
			document.getElementById("con_"+idcontexto).innerHTML=data.target.response;
		});
		xhr.onerror = (e)=>{
			console.log(e);
		};
		xhr.send(formData);
	}

	////////////change para submit de respuesta del terapeuta
	$(document).on('submit',"[is*='act-submit']",function(e){
		e.preventDefault();

		 //////////id del formulario
		 let id=e.currentTarget.attributes.id.nodeValue;
		 let elemento = document.getElementById(id);
		 procesar_act(elemento);
	});
	function procesar_act(elemento){

		let db=elemento.attributes.db.value+".php";
		let fun=elemento.attributes.fun.value;
		let idactividad=elemento.attributes.v_idactividad.value;
		let idpaciente=elemento.attributes.v_idpaciente.value;
		let idcontexto=elemento.attributes.v_idcontexto.value;

		var formData = new FormData(elemento);
		formData.append("function",fun);
		formData.append("idactividad",idactividad);
		formData.append("idpaciente", idpaciente);
		formData.append("idcontexto", idcontexto);

		let xhr = new XMLHttpRequest();
		xhr.open('POST', db);

		xhr.addEventListener('load',(data)=>{
			console.log(data.target.response);
			if (!isJSON(data.target.response)){
				cargando(false);
				Swal.fire({
					type: 'error',
					title: "Error favor de verificar",
					showConfirmButton: false,
					timer: 1000
				});
				return;
			}
			var respon = JSON.parse(data.target.response);
			if (respon.error==0){
				cargando(false);
				if(document.getElementById('progreso_'+respon.idsubactividad)){
					document.getElementById('progreso_'+respon.idsubactividad).innerHTML=respon.progreso;
				}
				document.getElementById('prog_'+respon.idactividad).innerHTML=respon.proact;
				carga_contexto(idcontexto, idactividad, idpaciente);
				Swal.fire({
					position: 'bottom-start',
					text: "Guardado",
					showConfirmButton: false,
					timer: 700
				});
			}
			else{
				cargando(false);
				Swal.fire({
					type: 'info',
					title: respon.terror,
					showConfirmButton: false,
					timer: 1000
				});
			}
		});
		xhr.onerror =  ()=>{
			cargando(false);
			console.log("error");
		};
		xhr.send(formData);
	}
	function carga_contexto(idcontexto, idactividad, idpaciente){
		var formData = new FormData();
		formData.append("idcontexto", idcontexto);
		formData.append("idactividad", idactividad);
		formData.append("idpaciente", idpaciente);
		formData.append("function", "upd");
		let xhr = new XMLHttpRequest();
		xhr.open('POST',"a_pacientes/db_.php");
		xhr.addEventListener('load',(data)=>{
			document.getElementById("con_"+idcontexto).innerHTML=data.target.response;
		});
		xhr.onerror = (e)=>{
			console.log(e);
		};
		xhr.send(formData);
	}
	function ver_img(div){
		var x = document.getElementById(div);
		x.style.display = "flex";
	}
	$(document).on('change',".filter_x",function(e){
		let id=e.currentTarget.form.id;
		let elemento = document.getElementById(id);
		let dix;
		(elemento.attributes.dix !== undefined) ? dix=elemento.attributes.dix.nodeValue : dix="trabajo";
		let des;
		(elemento.attributes.des !== undefined) ? des=elemento.attributes.des.nodeValue : des="";
		var formData = new FormData(elemento);
		/////////esto es para todas las variables
		let variables = new Object();
		for(let contar=0;contar<elemento.attributes.length; contar++){
			let arrayDeCadenas = elemento.attributes[contar].name.split("_");
			if(arrayDeCadenas.length>1){
				formData.append(arrayDeCadenas[1], elemento.attributes[contar].value);
			}
		}
		let datos = new Object();
		datos.des=des+".php";
		datos.dix=dix;
		redirige_div(formData,datos);
	});
