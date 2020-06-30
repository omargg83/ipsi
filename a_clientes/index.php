<?php
	require_once("db_.php");

	echo "<nav class='navbar navbar-expand-lg navbar-light bg-light '>
	<a class='navbar-brand' ><i class='fas fa-user-check'></i> Clientes</a>
	  <button class='navbar-toggler navbar-toggler-right' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='principal' aria-expanded='false' aria-label='Toggle navigation'>
		<span class='navbar-toggler-icon'></span>
	  </button>
		  <div class='collapse navbar-collapse' id='navbarSupportedContent'>
			<ul class='navbar-nav mr-auto'>";

			echo"<li class='nav-item active'><a class='nav-link barranav' title='Mostrar todo' id='lista_comision' data-lugar='a_clientes/lista'><i class='fas fa-list-ul'></i><span>Lista</span></a></li>";

			echo"<li class='nav-item active'><a class='nav-link barranav izq' title='Nuevo' id='new_personal' data-lugar='a_clientes/editar'><i class='fas fa-plus'></i><span>Nuevo</span></a></li>";

			echo "</ul>";
		echo "
	  </div>
	</nav>";

?>
<div id='trabajo'>
	<?php
		include 'lista.php';
	?>
</div>

<script>
	function ficha(id){
		$.ajax({
			data:{
				"id":id
			},
			url: "a_clientes/editar.php",
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
	function buscar_actividad(id){
		var b_actividad=$("#b_actividad").val();
		if(b_actividad.length>=-1){
			$.ajax({
				data:  {
					"b_actividad":b_actividad,
					"id":id,
					"function":"buscar_actividad"
				},
				url:   "a_clientes/db_.php",
				type:  'post',
				beforeSend: function () {
					$("#resultadosx").html("buscando...");
				},
				success:  function (response) {
					$("#resultadosx").html(response);
					$("#prod_venta").val();
				}
			});
		}

	}
	function actividad_addv(actividad,id){
		console.log(actividad);
	}
</script>
