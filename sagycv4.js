	let intval="";

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
			this.addEventListener('click', (e) => {
				loadContent(e.target.hash.slice(1));
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

		 		let id=e.target.attributes.id.nodeValue;
		 		let elemento = document.getElementById(id);
		 		let db=elemento.attributes.db.nodeValue;
		 		let funcion=elemento.attributes.fun.nodeValue;
		 		let lug=elemento.attributes.lug.nodeValue;
				let div;

				if(elemento.attributes.dix !== undefined)
					div=elemento.attributes.dix.nodeValue;

		 		let cmodal=elemento.dataset.cmodal;
		 		let cerrar=0;
		 		let redirige=0;

		 		if(!div){
		 			div="trabajo";
		 		}
		 		if(db){
		 			db+=".php";
		 		}
		 		if(cmodal){
		 			cerrar=cmodal;
		 		}
		 		var formData = new FormData(elemento);
		 		formData.append("function", funcion);

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
		 				xhr.open('POST',db);
		 				xhr.addEventListener('load',(data)=>{
		 					var datos = JSON.parse(data.target.response);
		 					if (datos.error==0){
		 						document.getElementById("id1").value=datos.id;
								//////////////quitar esta linea al acompletar todo el cambio
								datos.id1=datos.id;
		 						if (lug !== undefined) {
		 							redirige_div(lug,div,datos);
		 						}
		 						if(cerrar==0){
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
		 							title: datos.terror,
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
		 })
		}
	}
	customElements.define("f-submit", Formsubmit, { extends: "form" });

	function flujo(object){
		let elemento=document.getElementById(object.id);
		console.log(elemento.dataset.lugar);
	}
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

	function proceso_db(e){
		let des;	/////////////el destino
		e.target.attributes.des!==undefined ? des=e.target.attributes.des.nodeValue : des="";

		let dix; 	/////////////	el div donde se pone el destino
		e.target.attributes.dix!==undefined ? dix=e.target.attributes.dix.nodeValue : dix="";

		let db;		/////////////en caso de base de datos
		e.target.attributes.db!==undefined ? db=e.target.attributes.db.nodeValue : db="";

		let fun;	///////////// la funcion a ejecutar
		e.target.attributes.fun!==undefined ? fun=e.target.attributes.fun.nodeValue : fun="";

		let tp;	///////////// el tipo de proceso del boton
		e.target.attributes.tp!==undefined ? tp=e.target.attributes.tp.nodeValue : tp="";

		let datos = new Object();
		e.target.attributes.id1!==undefined ? datos.id1=e.target.attributes.id1.nodeValue : datos.id1=0;
		e.target.attributes.id2!==undefined ? datos.id2=e.target.attributes.id2.nodeValue : datos.id2=0;
		e.target.attributes.id3!==undefined ? datos.id3=e.target.attributes.id3.nodeValue : datos.id3=0;

		//////////////poner aqui proceso en caso de existir funcion

		if(tp==="delete"){
			db += ".php";

			var formData = new FormData();
			formData.append("function", fun);
			formData.append("id1",datos.id1);
			formData.append("id2",datos.id2);
			formData.append("id3",datos.id3);

			let xhr = new XMLHttpRequest();
			xhr.open('POST',db);
			xhr.addEventListener('load',(data)=>{
				var datos = JSON.parse(data.target.response);
				if (datos.error==0){
					Swal.fire({
						type: 'success',
						title: "Se eliminó correctamente ",
						showConfirmButton: false,
						timer: 1000
					});
					redirige_div(des,dix,datos);
				}
				else{
					Swal.fire({
						type: 'info',
						title: datos.terror,
						showConfirmButton: false,
						timer: 1000
					});
				}
			});
			xhr.onerror = (e)=>{
			};
			xhr.send(formData);
		}
		if(tp==="edit"){
		
		}
		if(tp!=="delete"){
			redirige_div(des,dix,datos);
		}

		/////////////termina
		// console.log("db:"+db);
		// console.log("des:"+des);
		// console.log("dix:"+dix);
		// console.log("fun:"+fun);
		// console.log("tp:"+tp);
		// console.log("datos.id:"+datos.id);
		// console.log("datos.id2:"+datos.id2);
		// console.log("datos.id3:"+datos.id3);

	}
	function redirige_div(lugar,div,datos){
		lugar+=".php";
		var formData = new FormData();
		formData.append("id1", datos.id1);
		formData.append("id2", datos.id2);
		formData.append("id3", datos.id3);
		cargando(true);
		let xhr = new XMLHttpRequest();
		xhr.open('POST',lugar);
		xhr.addEventListener('load',(data)=>{
			document.getElementById(div).innerHTML =data.target.response;
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
				alert(e.target.attributes.lugar.nodeValue);
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
	$(document).on('click','#sidebarCollapse', function () {
		$('#sidebar').toggleClass('active');
  });
	$(document).on("click","[id^='edit_'], [id^='lista_'], [id^='new_']",function(e){	//////////// para ir a alguna opcion
			e.preventDefault();
			var param1=0;
			var id=$(this).attr('id');
			var funcion="";
			if ( $(this).data('funcion') ) {
				funcion = $(this).data('funcion');
			}

			var lugar="";
			var contenido="#trabajo";
			var xyId=0;
			var valor="";
			padre=id.split("_")[0]
			cargando(true);

			if ( $(this).data('valor')!=undefined ) {
				valor=$("#"+$(this).data('valor')).val();
			}

			if ( $(this).data('div')!=undefined ) {
				contenido="#"+$(this).data('div');
			}

			if ( $(this).data('param1') ) {
				param1 = $(this).data('param1');
			}

			if(padre=="edit" || padre=="new" || padre=="lista"){
				lugar = $("#"+id).data('lugar')+".php";
				if(padre=="edit"){
					lugar=$(this).attr("data-lugar")+".php";
					if ( $(this).closest(".edit-t").attr("id")){
						xyId = $(this).closest(".edit-t").attr("id");
					}
					else{
						xyId = $("#"+id).data('id');
					}
				}
			}
			$.ajax({
				data:  {"id":xyId,"param1":param1,"funcion":funcion,"valor":valor},
				url:   lugar,
				type:  'post',
				timeout:30000,
				beforeSend: function () {
					$(contenido).html("<div class='container' style='background-color:white; width:300px'><center><img src='img/carga.gif' width='100px'></center></div>");
				},
				success:  function (response) {
					$(contenido).html(response);
				},
				error: function(jqXHR, textStatus, errorThrown) {
					if(textStatus==="timeout") {
						$("#container").html("<div class='container' style='background-color:white; width:300px'><center><img src='img/giphy.gif' width='300px'></center></div><br><center><div class='alert alert-danger' role='alert'>Ocurrio un error intente de nuevo en unos minutos, vuelva a entrar o presione ctrl + F5, para reintentar</div></center> ");
					}
				}
			});
			cargando(false);
		});
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
	$(document).on("click","[id^='delfile_']",function(e){
		e.preventDefault();
		var ruta = $(this).data('ruta');
		var keyt = $(this).data('keyt');
		var key = $(this).data('key');
		var tabla = $(this).data('tabla');
		var campo = $(this).data('campo');
		var tipo = $(this).data('tipo');
		var iddest = $(this).data('iddest');
		var divdest = $(this).data('divdest');
		var dest = $(this).data('dest');
		var borrafile=0;
		if ( $(this).data('borrafile') ) {
			borrafile=$(this).data('borrafile');
		}

		var parametros={
			"ruta":ruta,
			"keyt":keyt,
			"key":key,
			"tabla":tabla,
			"campo":campo,
			"tipo":tipo,
			"borrafile":borrafile,
			"ctrl":"control",
			"function":"eliminar_file"
		};

		$.confirm({
			title: 'Eliminar',
			content: '¿Desea eliminar el archivo?',
			buttons: {
				Aceptar: function () {
					$.ajax({
						url: "control_db.php",
						type: "POST",
						data: parametros
					}).done(function(echo){

						if (!isNaN(echo)){
							$("#"+divdest).load(dest+iddest);
							Swal.fire({
							  type: 'success',
							  title: "Se eliminó correctamente",
							  showConfirmButton: false,
							  timer: 1000
							})
						}
						else{
							$.alert(echo);
						}
					});
				},
				Cancelar: function () {
					$.alert('Canceled!');
				}
			}
		});
	});
	$(document).on("click","[id^='winmodal_']",function(e){
		e.preventDefault();
		var id = "0";
		var id2 = "0";
		var id3 = "0";
		var lugar = $(this).data('lugar');

		if ( $(this).data('id') ) {
			id = $(this).data('id');
		}
		if ( $(this).data('id2') ) {
			id2 = $(this).data('id2');
		}
		if ( $(this).data('id3') ) {
			id3 = $(this).data('id3');
		}

		$("#modal_form").load(lugar+".php?id="+id+"&id2="+id2+"&id3="+id3);
		$('#myModal').modal({backdrop: 'static', keyboard: false})
		$('#myModal').modal('show');
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

	//////////////////////subir archivos
	$(document).on("click","[id^='fileup_']",function(e){
		e.preventDefault();
		var id = $(this).data('id');
		var ruta = $(this).data('ruta');
		var tipo = $(this).data('tipo');
		var ext = $(this).data('ext');
		var tabla = $(this).data('tabla');
		var campo = $(this).data('campo');
		var keyt = $(this).data('keyt');
		var destino = $(this).data('destino');
		var iddest = $(this).data('iddest');
		var proceso="";
		if ( $(this).data('proceso') ) {
			proceso=$(this).data('proceso');
		}
		$("#modal_form").load("archivo.php?id="+id+"&ruta="+ruta+"&ext="+ext+"&tipo="+tipo+"&tabla="+tabla+"&campo="+campo+"&keyt="+keyt+"&destino="+destino+"&iddest="+iddest+"&proceso="+proceso);
	});
	$(document).on('change',"#prefile",function(e){
		e.preventDefault();
		var control=$(this).attr('id');
		var accept=$(this).attr('accept');

		var fileSelect = document.getElementById(control);
		var files = fileSelect.files;
		var formData = new FormData();
		for (var i = 0; i < files.length; i++) {
		   var file = files[i];
		   formData.append('photos'+i, file, file.name);
		}
		var tam=(fileSelect.files[0].size/1024)/1024;
		if (tam<30){
			var xhr = new XMLHttpRequest();
			xhr.open('POST','control_db.php?function=subir_file&ctrl=control');
			xhr.onload = function() {
			};
			xhr.upload.onprogress = function (event) {
				var complete = Math.round(event.loaded / event.total * 100);
				if (event.lengthComputable) {
					btnfile.style.display="none";
					progress_file.style.display="block";
					progress_file.value = progress_file.innerHTML = complete;
					// conteo.innerHTML = "Cargando: "+ nombre +" ( "+complete+" %)";
				}
			};
			xhr.onreadystatechange = function(){
				if(xhr.readyState === 4 && xhr.status === 200){
					progress_file.style.display="none";
					btnfile.style.display="block";
					try {
						var data = JSON.parse(xhr.response);
						for (i = 0; i < data.length; i++) {
							$("#contenedor_file").html("<div style='border:0;float:left;margin:10px;'>"+
							"<input type='hidden' id='direccion' name='direccion' value='"+data[i].archivo+"'>"+
							"<img src='historial/"+data[i].archivo+"' width='300px'></div>");
						}
					}
					catch (err) {
					   alert(xhr.response);
					}
				}
			}
			xhr.send(formData);
		}
		else{
			alert("Archivo muy grande");
		}
	});
	$(document).on('submit','#upload_File',function(e){
		e.preventDefault();
		var funcion="guardar_file";
		var destino = $("#destino").val();
		var iddest = $("#iddest").val();
		var proceso="control_db.php";

		if ( $("#direccion").length ) {
			var dataString = $(this).serialize()+"&function="+funcion+"&ctrl=control";
			$.ajax({
				data:  dataString,
				url: proceso,
				type: "post",
				success:  function (response) {
					var datos = JSON.parse(response);
					if (datos.error==0){
						lugar=destino+".php?id="+iddest;
						$("#trabajo").load(lugar);
						$('#myModal').modal('hide');
						Swal.fire({
						  type: 'success',
						  title: "Se cargó correctamente",
						  showConfirmButton: false,
						  timer: 1000
						});
					}
					else{
						Swal.fire({
							type: 'info',
							title: datos.terror,
							showConfirmButton: false,
							timer: 1000
						});
					}
				}
			});
		}
		else{
			$.alert('Debe seleccionar un archivo');
		}
	});
