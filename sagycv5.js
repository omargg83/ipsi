	let intval=""

	console.log("enta");
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
				let datos = new Object();

				e.target.attributes.id1!==undefined ? datos.id1=e.target.attributes.id1.nodeValue : datos.id1="";
				e.target.attributes.id2!==undefined ? datos.id1=e.target.attributes.id2.nodeValue : datos.id2="";
				e.target.attributes.id3!==undefined ? datos.id1=e.target.attributes.id3.nodeValue : datos.id3="";


				let lug=e.target.hash.slice(1);
				let dix="contenido";
				var formData = new FormData();
				formData.append("id1", datos.id1);
				formData.append("id2", datos.id2);
				formData.append("id3", datos.id3);
				redirige_div(lug,dix,datos,"");
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
		 		let id=e.target.attributes.id.nodeValue;
		 		let elemento = document.getElementById(id);

				/////////API que procesa el form
		 		let db;
				(elemento.attributes.db !== undefined) ? db=elemento.attributes.db.nodeValue+".php" : db="";

				/////////funcion del api que procesa el form
		 		let fun;
				(elemento.attributes.fun !== undefined) ? fun=elemento.attributes.fun.nodeValue : fun="";

				/////////Id del destino
				let iddest;
				if(elemento.attributes.iddest !== undefined) {
					alert("cambiar por ID1");
				}

				/////////Div de destino despues de guardar
				let id1;
				(elemento.attributes.id1 !== undefined) ? id1=elemento.attributes.id1.nodeValue : id1="";

				let id2;
				(elemento.attributes.id2 !== undefined) ? id2=elemento.attributes.id2.nodeValue : id2="";

				let id3;
				(elemento.attributes.id3 !== undefined) ? id3=elemento.attributes.id3.nodeValue : id3="";

				/////////Div de destino despues de guardar
				let dix;
				(elemento.attributes.dix !== undefined) ? dix=elemento.attributes.dix.nodeValue : dix="trabajo";

				/////////div destino despues de guardar
		 		let lug;
				(elemento.attributes.lug !== undefined) ? lug=elemento.attributes.lug.nodeValue : lug="";

				////////FORM pertenece a ventanamodal
		 		let cmodal;
				(elemento.attributes.cmodal !== undefined) ? cmodal=elemento.attributes.cmodal.nodeValue : cmodal="";

				////////FORM pertenece a ventanamodal
		 		let des;
				(elemento.attributes.des !== undefined) ? des=elemento.attributes.des.nodeValue : des="";

				var formData = new FormData(elemento);
				formData.append("function", fun);

				if(db.length>0){
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
								var datos = JSON.parse(data.target.response);
								if (datos.error==0){
									document.getElementById("id1").value=datos.id1;
									//////////////quitar esta linea al acompletar todo el cambio
									if(id1!==""){
										datos.id1=id1;
									}
									if(id2!==""){
										datos.id2=id2;
									}
									if(id3!==""){
										datos.id3=id3;
									}
									if (lug !== undefined && lug.length>0) {
										redirige_div(lug,dix,datos,"");
									}
									if(cmodal==1){
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
				}
				else{
					cargando(true);
					let xhr = new XMLHttpRequest();
					xhr.open('POST',des+".php");
					xhr.addEventListener('load',(data)=>{
						document.getElementById(dix).innerHTML = data.target.response;
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
		e.target.attributes.des!==undefined ? des=e.target.attributes.des.nodeValue : des="";

		let dix; 	/////////////	el div donde se pone el destino
		e.target.attributes.dix!==undefined ? dix=e.target.attributes.dix.nodeValue : dix="";

		let db;		/////////////en caso de base de datos
		e.target.attributes.db!==undefined ? db=e.target.attributes.db.nodeValue : db="";

		let fun;	///////////// la funcion a ejecutar
		e.target.attributes.fun!==undefined ? fun=e.target.attributes.fun.nodeValue : fun="";

		let tp;	///////////// el tipo de proceso del boton
		e.target.attributes.tp!==undefined ? tp=e.target.attributes.tp.nodeValue : tp="";

		let iddest;
		e.target.attributes.iddest!==undefined ? iddest=e.target.attributes.iddest.nodeValue : iddest="";

		let omodal;
		e.target.attributes.omodal!==undefined ? omodal=e.target.attributes.omodal.nodeValue : omodal="";

		let cmodal;
		(e.target.attributes.cmodal !== undefined) ? cmodal=e.target.attributes.cmodal.nodeValue : cmodal="";

		let params="";
		var formData = new FormData();
		let datos = new Object();


		if(e.target.attributes.params!==undefined){
			params=e.target.attributes.params.nodeValue;
		}
		e.target.attributes.id1!==undefined ? datos.id1=e.target.attributes.id1.nodeValue : datos.id1=0;
		e.target.attributes.id2!==undefined ? datos.id2=e.target.attributes.id2.nodeValue : datos.id2=0;
		e.target.attributes.id3!==undefined ? datos.id3=e.target.attributes.id3.nodeValue : datos.id3=0;

		datos.omodal=omodal;

		if(iddest!==""){
			datos.id1=iddest;
		}

		if(cmodal==1){
			$('#myModal').modal('hide');
			cargando(false);
			return;
		}
		if(cmodal==2){
			$('#myModal').modal('hide');
			cargando(false);
		}

		//////////////poner aqui proceso en caso de existir funcion
		if(tp==="proceso"){
			db += ".php";
			formData.append("function", fun);
			formData.append("id1",datos.id1);
			formData.append("id2",datos.id2);
			formData.append("id3",datos.id3);
			formData.append("params",params);

			let xhr = new XMLHttpRequest();
			xhr.open('POST',db);
			xhr.addEventListener('load',(data)=>{
				console.log(data.target.response);
				var datos = JSON.parse(data.target.response);
				if (datos.error==0){
					Swal.fire({
						type: 'success',
						title: "Listo",
						showConfirmButton: false,
						timer: 1000
					});
					redirige_div(des,dix,datos,params);
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

		if(tp!=="proceso"){
			redirige_div(des,dix,datos,params);
		}

		cargando(false);
	}

	//////////////////////////redirige si es necesario
	function redirige_div(lugar,div,datos,parametros){
		lugar+=".php";
		var formData = new FormData();
		formData.append("id1", datos.id1);
		formData.append("id2", datos.id2);
		formData.append("id3", datos.id3);

		let arrayDeCadenas = parametros.split(",");
		for (var i=0; i < arrayDeCadenas.length; i++) {
			let final=arrayDeCadenas[i].split("-");
			for (var j=0; j < final.length; j=j+2) {
				formData.append(final[0], final[1]);
			}
		}
		let xhr = new XMLHttpRequest();
		xhr.open('POST',lugar);
		xhr.addEventListener('load',(data)=>{
			if(datos.omodal==1){
				$('#myModal').modal('show');
				div="modal_form";
			}
			document.getElementById(div).innerHTML = data.target.response;
			var scripts = document.getElementById(div).getElementsByTagName("script");
			for (var i = 0; i < scripts.length; i++) {
		    eval(scripts[i].innerText);
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
