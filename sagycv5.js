	let intval=""

	onload = ()=> {
		loadContent(location.hash.slice(1));
		if(intval==""){
			intval=setInterval(function(){ sesion_ver(); }, 10000);
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

	class MenuLink extends HTMLAnchorElement {
		connectedCallback() {
			this.addEventListener('click', (e) => {cargando(true);

				var formData = new FormData();
				for(let contar=0;contar<e.currentTarget.attributes.length; contar++){
					let arrayDeCadenas = e.currentTarget.attributes[contar].name.split("_");
					if(arrayDeCadenas.length>1){
						formData.append(arrayDeCadenas[1], e.currentTarget.attributes[contar].value);
					}
				}
				let datos = new Object();
				datos.des=e.currentTarget.hash.slice(1)+".php";
				datos.dix="contenido";
				redirige_div(formData,datos);
			});
		}
	}
	customElements.define("menu-link", MenuLink, { extends: "a" });

	class ConfirmLink extends HTMLAnchorElement {
	  connectedCallback() {
	    this.addEventListener('click', (e) => {
	      proceso_db(e);
	    });
	  }
	}
	customElements.define("a-link", ConfirmLink, { extends: "a" });

	class CiLink extends HTMLLIElement {
	  connectedCallback() {
	    this.addEventListener('click', (e) => {
	      proceso_db(e);
	    });
	  }
	}
	customElements.define("li-link", CiLink, { extends: "li" });

	class Buttonlink extends HTMLButtonElement  {
		connectedCallback() {
			this.addEventListener('click', (e) => {
				proceso_db(e);
			});
		}
	}
	customElements.define("b-link", Buttonlink, { extends: "button" });

	class Formsubmit extends HTMLFormElement {
		connectedCallback() {
		 this.addEventListener('submit', (e) => {
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
				//datos.tp=tp;
				//datos.iddest=iddest;
				//datos.omodal=omodal;
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
						text: "ya no se podrá deshacer",
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Guardar'
					}).then((result) => {
						if (result.value) {
							cargando(true);
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
									cargando(false);
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
							cargando(false);
						}
					});
				}
				else{
					cargando(true);
					let xhr = new XMLHttpRequest();
					xhr.open('POST',datos.des);
					xhr.addEventListener('load',(data)=>{
						document.getElementById(datos.dix).innerHTML = data.target.response;
					});
					xhr.onerror =  ()=>{
						console.log("error");
					};
					xhr.send(formData);
					cargando(false);
				}
		 })
		}
	}
	customElements.define("f-submit", Formsubmit, { extends: "form" });

	function loadContent(hash){
		cargando(true);
		if(hash==''){
			hash= 'dash/dashboard';
		}
		let destino=hash + '.php';
		let xhr = new XMLHttpRequest();
		xhr.open('POST',destino);
		xhr.addEventListener('load',(data)=>{
			document.getElementById("contenido").innerHTML =data.target.response;
		});
		xhr.send();
		cargando(false);
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

	//////////////////////////Solo para un proceso antes del flujo ejem. al borrar que primero borre y luego redirive_div
	function proceso_db(e){
		cargando(true);

		let des;	/////////////el destino
		e.currentTarget.attributes.des!==undefined ? des=e.currentTarget.attributes.des.nodeValue : des="";

		let dix; 	/////////////	el div donde se pone el destino
		e.currentTarget.attributes.dix!==undefined ? dix=e.currentTarget.attributes.dix.nodeValue : dix="";

		let db;		/////////////en caso de base de datos
		e.currentTarget.attributes.db!==undefined ? db=e.currentTarget.attributes.db.nodeValue : db="";

		let fun;	///////////// la funcion a ejecutar
		e.currentTarget.attributes.fun!==undefined ? fun=e.currentTarget.attributes.fun.nodeValue : fun="";

		let tp;	///////////// la funcion a ejecutar
		e.currentTarget.attributes.tp!==undefined ? tp=e.currentTarget.attributes.tp.nodeValue : fun="";

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
			cargando(false);
			return;
		}
		if(datos.cmodal==2){
			$('#myModal').modal('hide');
			cargando(false);
		}
		//////////////poner aqui proceso en caso de existir funcion
		if(fun.length>0){
			if(tp==="eliminar"){
				formData.append("function", datos.fun);
				Swal.fire({
					title: '¿Desea eliminar el registro seleccionado?',
					text: "ya no se podrá deshacer",
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Eliminar'
				}).then((result) => {
					if (result.value) {
						let variable=0;
						let xhr = new XMLHttpRequest();
						xhr.open('POST',datos.db);
						xhr.addEventListener('load',(data)=>{
							var respon = JSON.parse(data.target.response);
							if (respon.error==0){
								Swal.fire({
									type: 'success',
									title: "Listo",
									showConfirmButton: false,
									timer: 1000
								});
								redirige_div(variables,datos);
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
			if(tp==="proceso"){
				formData.append("function", datos.fun);
				Swal.fire({
					title: '¿Desea procesar la información?',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Procesar'
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
								redirige_div(variables,datos);
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
		}
		else{
			redirige_div(formData,datos);
		}
		cargando(false);
	}

	//////////////////////////redirige si es necesario
	function redirige_div(formData,datos){
		//console.log(datos);
		//for(var pair of formData.entries()) {
   		//console.log(pair[0]+ ', '+ pair[1]);
		//}
		let xhr = new XMLHttpRequest();
		xhr.open('POST',datos.des);
		xhr.addEventListener('load',(datares)=>{
			if(datares.target.status=="404"){
				Swal.fire({
						type: 'error',
						title: "No encontrado: "+datos.des,
						showConfirmButton: false,
				})
				return 0;
			}
			else{
				if(datos.omodal==1){
					$('#myModal').modal('show');
					datos.dix="modal_form";
				}
				document.getElementById(datos.dix).innerHTML = datares.target.response;
				var scripts = document.getElementById(datos.dix).getElementsByTagName("script");
				for (var i = 0; i < scripts.length; i++) {
			    eval(scripts[i].innerText);
				}
			}
		});
		xhr.onerror = (e)=>{
			console.log(e);
		};
		xhr.send(formData);
		cargando(false);
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

	class HolaMundo extends HTMLElement {
	  constructor() {
	    super();
			this.addEventListener('click',(e)=>{
				alert(e.currentTarget.attributes.lugar.nodeValue);
			});
	  }
	};
	customElements.define('hola-mundo', HolaMundo);

	/////////////////////hasta aca
	$(document).on('submit','#recuperarx',function(e){
		e.preventDefault();
		var telefono=$('#telefono').val();
		telefono=telefono.trim();
		if(telefono.length>2){
			var parametros={
				"ctrl":"control",
				"function":"manda_pass",
				"telefono":telefono
			};
			$.ajax({
				url: "control_db.php",
				type: "POST",
				data: parametros,
				timeout:10000,
				beforeSend: function () {
					cargando(true);
				},
				success:function(response){
					if (response !== "") {
						Swal.fire({
								type: 'error',
								title: response,
								showConfirmButton: false,
								timer: 1000
						})
					} else {
						Swal.fire({
								type: 'success',
								title: 'Se notificó correctamente',
								showConfirmButton: false,
								timer: 1000
						})
					}
				}
			});
		}
		else{
			$( "#telefono" ).focus();
			$( "#telefono" ).val("");
		}
		cargando(false);
	});
	function lista(id) {
		$('#'+id).DataTable({
			dom: 'Bfrtip',
			buttons: [
					{
							extend: 'copy',
							text: 'Copiar'
					},
				'csv', 'excel', 'pdf', 'print'
			],
			"pageLength": 100,
				 "language": {
				"sSearch": "Buscar aqui",
				"lengthMenu": "Mostrar _MENU_ registros",
				"zeroRecords": "No se encontró",
				"info": " Página _PAGE_ de _PAGES_",
				"infoEmpty": "No records available",
				"infoFiltered": "(filtered from _MAX_ total records)",
				"paginate": {
					"first":      "Primero",
					"last":       "Ultimo",
					"next":       "Siguiente",
					"previous":   "Anterior"
				},
			}
		});
	}
	function fechas () {
		$.datepicker.regional['es'] = {
			 closeText: 'Cerrar',
			 yearRange: '1910:2040',
			 prevText: '<Ant',
			 nextText: 'Sig>',
			 currentText: 'Hoy',
			 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
			 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
			 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
			 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
			 weekHeader: 'Sm',
			 dateFormat: 'dd-mm-yy',
			 firstDay: 0,
			 isRTL: false,
			 showMonthAfterYear: false,
			 yearSuffix: ''
		 };

		$.datepicker.setDefaults($.datepicker.regional['es']);
		$(".fechaclass").datepicker();
	};
	function recuperar(){
		$.ajax({
			data:  {
				"ctrl":"control",
				"function":"recuperar_form"
			},
			url:   'control_db.php',
			type:  'post',
			success:  function (response) {
				$("#modal_form").html(response);
			}
		});
	}

	//////////////////////
	$(document).on("click","[id^='select_']",function(e){								//////////// para consulta con combo
		var combo=$(this).data('combo');
		var combo2;
		var id2;
		var lugar=$(this).data('lugar')+".php";
		var div;
		if ($(this).data('combo2')){
			combo2=$(this).data('combo2');
			id2=$("#"+combo2).val();
		}
		if ( $(this).data('div') ) {
			div = $(this).data('div');
		}
		else{
			div="trabajo";
		}
		var id=$("#"+combo).val();
		$.ajax({
			data:  {"id":id,"id2":id2},
			url:   lugar,
			type:  'post',
			success:  function (response) {
				$("#"+div).html(response);
			}
		});
	});
	$(document).on("click","[id^='imprimir_'], [id^='imprime_']",function(e){
		e.preventDefault();
		var id=$(this).attr('id');
		var padre=id.split("_")[0]
		var opcion=id.split("_")[1];
		var valor=0;
		var xyId;

		if ( $(this).data('valor') ) {
			var control=$(this).data('valor');
			valor = $("#"+control).val();
		}

		if(padre=="imprimir"){
			xyId = $(this).closest(".edit-t").attr("id");
		}
		if(padre=="imprime"){
			xyId= $("#id").val();
		}

		if( $("#"+id).data('select') ){
			var select=$("#"+id).data('select');
			xyId=$("#"+select).val();
		}

		var lugar = $("#"+id).data('lugar')+".php";
		var tipo = $("#"+id).data('tipo');
		VentanaCentrada(lugar+'?id='+xyId+'&tipo='+tipo+'&valor='+valor,'Impresion','','1024','768','true');
	});
	$(document).on('submit',"[id^='consulta_']",function(e){
		e.preventDefault();
		var dataString = $(this).serialize();
		var div = $(this).data('div');
		var funcion = $(this).data('funcion');

		var destino = $(this).data('destino')+".php?funcion="+funcion;
		$.ajax({
			data:  dataString,
			url: destino,
			type: "post",
			success:  function (response) {
				$("#"+div).html(response);
			}
		});
	});
	$(document).on("click","[id^='eliminar_']",function(e){
		e.preventDefault();
		var id = $(this).data('id');
		var id2 = $(this).data('id2');
		var id3 = $(this).data('id3');
		var lugar = $(this).data('lugar')+".php";
		var destino = $(this).data('destino')+".php";
		var iddest = $(this).data('iddest');
		var div;

		if ( $(this).data('funcion') ) {
			var funcion = $(this).data('funcion');
		}
		else{
			return;
		}

		if ( $(this).data('div') ) {
			div = $(this).data('div');
		}
		else{
			div="trabajo";
		}
		$.confirm({
			title: 'Eliminar',
			content: '¿Desea eliminar el registro seleccionado?',
			type: 'red',
			buttons: {
				Eliminar: function () {
					var parametros={
						"id":id,
						"id2":id2,
						"id3":id3,
						"iddest":iddest,
						"function":funcion
					};
					$.ajax({
						data:  parametros,
						url: lugar,
						type:  'post',
						timeout:10000,
						success:  function (response) {
							var datos = JSON.parse(response);
							if (datos.error==0){
								$.ajax({
									data:  {
										"id":iddest
									},
									url:   destino,
									type:  'post',
									success:  function (response) {
										$("#"+div).html(response);
									}
								});
								Swal.fire({
								  type: 'success',
								  title: "Se eliminó correctamente",
								  showConfirmButton: false,
								  timer: 700
								});
							}
							else{
								alert(response);
							}
						},
						error: function(jqXHR, textStatus, errorThrown) {
							if(textStatus==="timeout") {
								Swal.fire({
								  type: 'error',
								  title: textStatus,
								  showConfirmButton: false,
								  timer: 700
								});
							}
						}
					});
				},
				Cancelar: function () {

				}
			}
		});
	});
	$(document).on('submit','#recovery',function(e){
			e.preventDefault();
			var telefono=document.getElementById("userAcceso").value;
			telefono=telefono.trim();
			if(telefono.length>2){
				var btn=$(this).find(':submit')
				$(btn).attr('disabled', 'disabled');
				var tmp=$(btn).children("i").attr('class');
				$(btn).children("i").removeClass();
				$(btn).children("i").addClass("fas fa-spinner fa-pulse");

				var tipo=2;
				var parametros={
					"ctrl":"control",
					"function":"recuperar",
					"tipo":tipo,
					"telefono":telefono
				};
				$.ajax({
					url: "control_db.php",
					type: "post",
					data: parametros,
					beforeSend: function(objeto){
						$(btn).children("i").addClass(tmp);
					},
					success:function(response){
						if (response == "") {
							Swal.fire({
							  type: "error",
							  title: response,
							  showConfirmButton: false,
							  timer: 1000
							});

						} else {
							Swal.fire({
							  type: 'success',
							  title: response,
							  showConfirmButton: false,
							  timer: 3000
							});
						}
						$(btn).children("i").removeClass();
						$(btn).children("i").addClass(tmp);
						$(btn).prop('disabled', false);
					}
				});
			}
			else{
				$( "#telefono" ).focus();
				$( "#telefono" ).val("");
			}
		});

	/*!
	    * Start Bootstrap - SB Admin v6.0.1 (https://startbootstrap.com/templates/sb-admin)
	    * Copyright 2013-2020 Start Bootstrap
	    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
	    */
    (function($) {
	    "use strict";

	    // Add active state to sidbar nav links
	    var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
	        $("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function() {
	            if (this.href === path) {
	                $(this).addClass("active");
	            }
	        });

	    // Toggle the side navigation
	    $("#sidebarToggle").on("click", function(e) {
	        e.preventDefault();
	        $("body").toggleClass("sb-sidenav-toggled");
	    });
	})(jQuery);
