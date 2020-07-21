<?php
	require_once("db_.php");

	echo "<div id='trabajo'>";
		include 'lista.php';
	echo "</div>";
?>

<script>
	function actividad_editar(idactividad){
		$.ajax({
			data:{
				"idactividad":idactividad
			},
			url: "a_actividades/actividad_editar.php",
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
	function actividad_ver(idactividad){
		$.ajax({
			data:{
				"idactividad":idactividad
			},
			url: "a_actividades/actividad_ver.php",
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
						data:  parametros,
						url: "a_actividades/db_.php",
						type:  'post',
						timeout:10000,
						success:  function (response) {
							$('#trabajo').load("a_actividades/lista.php");
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

	function subactividad_editar(id,idactividad,tipo){
		$.ajax({
			data:{
				"id":id,
				"idactividad":idactividad,
				"tipo":tipo
			},
			url: "a_actividades/subactividad_editar.php",
			type: "POST",
			timeout:1000,
			beforeSend: function () {
				$("#cargando").addClass("is-active");
			},
			success:function(response){
				$('#subactividad').html(response);
			}
		});
		$("#cargando").removeClass("is-active");
	}
	function eliminar_subact(id){
		$.confirm({
			title: 'Eliminar',
			content: '¿Desea borrar la actividad seleccionada?',
			buttons: {
				Aceptar: function () {
					var parametros={
						"id":id,
						"function":"subactividad_del"
					};
					$.ajax({
						data:  parametros,
						url: "a_actividades/db_.php",
						type:  'post',
						timeout:10000,
						success:  function (response) {
							$('#trabajo').load("a_actividades/lista.php");
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


	</script>
