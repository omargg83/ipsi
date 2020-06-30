<?php
	require_once("db_.php");

	echo "<nav class='navbar navbar-expand-lg navbar-light bg-light '>
	<a class='navbar-brand' ><i class='fas fa-user-check'></i> Actividades</a>
	  <button class='navbar-toggler navbar-toggler-right' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='principal' aria-expanded='false' aria-label='Toggle navigation'>
		<span class='navbar-toggler-icon'></span>
	  </button>
		  <div class='collapse navbar-collapse' id='navbarSupportedContent'>
			<ul class='navbar-nav mr-auto'>";

			echo"<li class='nav-item active'><a class='nav-link barranav' title='Mostrar todo' id='lista_comision' data-lugar='a_actividades/lista'><i class='fas fa-list-ul'></i><span>Actividades</span></a></li>";

			echo"<li class='nav-item active'><a class='nav-link barranav izq' title='Nuevo' id='new_personal' data-lugar='a_actividades/actividad'><i class='fas fa-plus'></i><span>Nuevo</span></a></li>";

			echo "</ul>";
		echo "
	  </div>
	</nav>";
	echo "<div id='trabajo'>";
		include 'lista.php';
	echo "</div>";
?>

<script>
	function actividad(idactividad){
		$.ajax({
			data:{
				"idactividad":idactividad
			},
			url: "a_actividades/actividad.php",
			type: "POST",
			timeout:1000,
			beforeSend: function () {
				$("#cargando").addClass("is-active");
			},
			success:function(response){
				$('#trabajo').html(response);
			}
		});
		$("#cargando").removeClass("is-active");
	}
	function preguntas(idactividad,idpregunta){
		$.ajax({
			data:{
				"idactividad":idactividad,
				"idpregunta":idpregunta,
			},
			url: "a_actividades/preguntas.php",
			type: "POST",
			timeout:1000,
			beforeSend: function () {
				$("#cargando").addClass("is-active");
			},
			success:function(response){
				$('#trabajo').html(response);
			}
		});
		$("#cargando").removeClass("is-active");
	}
	function respuestas(idactividad,idpregunta,idrespuesta){
		$.ajax({
			data:{
				"idactividad":idactividad,
				"idpregunta":idpregunta,
				"idrespuesta":idrespuesta
			},
			url: "a_actividades/respuestas.php",
			type: "POST",
			timeout:1000,
			beforeSend: function () {
				$("#cargando").addClass("is-active");
			},
			success:function(response){
				$('#trabajo').html(response);
			}
		});
		$("#cargando").removeClass("is-active");
	}
	function pregunta_tipo(){
	 var tipo=$('#tipo').val();
		$.ajax({
			data:{
				"function":"pregunta_tipo",
				"tipo":tipo
			},
			url: "db_.php",
			type: "POST",
			timeout:1000,
			beforeSend: function () {

			},
			success:function(response){
				$('#pregunta').html(response);
			}
		});

	}

	function pacientes(idactividad){
		$.ajax({
			data:{
				"idactividad":idactividad
			},
			url: "a_actividades/pacientes.php",
			type: "POST",
			timeout:1000,
			beforeSend: function () {
				$("#cargando").addClass("is-active");
			},
			success:function(response){
				$('#trabajo').html(response);
			}
		});
		$("#cargando").removeClass("is-active");
	}

	function eliminar_act(idactividad){
		$.confirm({
			title: 'Eliminar',
			content: '¿Desea borrar la actividad seleccionada?',
			buttons: {
				Aceptar: function () {
					var parametros={
						"idactividad":idactividad,
						"function":"actividad_del"
					};
					$.ajax({
						data:  "a_actividades/db_.php",
						url: lugar,
						type:  'post',
						timeout:10000,
						success:  function (response) {
							console.log(response);
						},
						error: function(jqXHR, textStatus, errorThrown) {

						}
					});
				},
				Cancelar: function () {

				}
			}
		});
	}

	</script>
