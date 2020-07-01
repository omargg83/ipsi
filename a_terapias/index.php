<?php
	session_start();
	
	echo "<div id='trabajo'>";
		include 'lista.php';
	echo "</div>";

?>

<script>
	function actividad_pr(idactividad){
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

</script>
