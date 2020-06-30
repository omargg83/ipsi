<?php
	require_once("db_.php");
	$pd = $db->clientes_lista();
	echo "<nav aria-label='breadcrumb'>";
		echo "<ol class='breadcrumb'>";
			echo "<li class='breadcrumb-item' id='lista_pacientes' data-lugar='a_clientes/lista'>Mis pacientes</li>";
		echo "</ol>";
	echo "</nav>";

	
	echo "<div class='container' style='background-color:".$_SESSION['cfondo']."; '>";

?>
	<div class='row'>
		<?php
			foreach($pd as $key){
				echo "<div id='".$key->id."'' class='col-4 edit-t p-3'>";
					echo "<div class='card '>";
					echo "<div class='card-body'>";
							echo "<div class='text-center'><img src='".$db->doc.$key->foto."' class='img-fluid img-thumbnail' alt='foto' width='100px'></div>";
							echo "<div class='text-center'>".$key->nombre." ".$key->apellidop." ".$key->apellidom."</div>";
							echo "<div class='text-center'>Paciente</div>";

							echo "<div class='row'>";
								echo "<div class='col-12  text-center'>";
									echo "<div class='btn-group'>";
										echo "<button class='btn btn-sm' id='edit_persona' title='Editar' data-lugar='a_clientes/paciente'><i class='fas fa-pencil-alt'></i>Ver perfil</button>";
									echo "</div>";
								echo "</div>";
							echo "</div>";
						echo "</div>";
					echo "</div>";
				echo "</div>";
			}
		?>
	</div>

</div>
<script>
	$(document).ready( function () {
		lista("x_cliente");
	});
</script>
