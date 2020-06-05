<?php
	require_once("db_.php");
	$pd = $db->cuestionario_lista();
	echo "<div class='container' style='background-color:".$_SESSION['cfondo']."; '>";
	echo "<br>";
?>

	<table id='x_cliente' class='table table-striped table-bordered' style='font-size:10pt;'>
	<thead>
	<th>#</th>
	<th>Nombre</th>
	<th>Correo</th>
	</thead>
	<tbody>
		<?php
			foreach($pd as $key){
				echo "<tr id='".$key->idcuestionario."'' class='edit-t'>";
					echo "<td>";
					echo "<div class='btn-group'>";
						echo "<button class='btn btn-outline-primary btn-sm' id='edit_persona' title='Editar' data-lugar='a_preguntas/cuestionario'><i class='fas fa-pencil-alt'></i></button>";
						echo "</div>";
					echo "</td>";
					echo "<td>".$key->idcuestionario."</td>";
					echo "<td>".$key->nombre."</td>";
				echo "</tr>";
			}
		?>



	</div>
	</tbody>
	</table>
</div>
<script>
	$(document).ready( function () {
		lista("x_cliente");
	});
</script>
