<?php
	require_once("db_.php");
	$pd = $db->cuestionario_lista();
	echo "<div class='container' style='background-color:".$_SESSION['cfondo']."; '>";
	echo "<br>";

	echo "<nav aria-label='breadcrumb'>";
		echo "<ol class='breadcrumb'>";
			echo "<li class='breadcrumb-item active' aria-current='page'>Actividades</li>";
		echo "</ol>";
	echo "</nav>";

?>
	<h5>Lista de actividades</h5>


	<table id='x_cliente' class='table table-striped table-bordered' style='font-size:10pt;'>
	<thead>
	<th>#</th>
	<th>Numero</th>
	<th>Nombre</th>
	</thead>
	<tbody>
		<?php
			foreach($pd as $key){
				echo "<tr id='".$key->idcuestionario."'' class='edit-t'>";
					echo "<td>";
					echo "<div class='btn-group'>";
						echo "<button class='btn btn-outline-primary btn-sm' onclick='actividad($key->idcuestionario)'><i class='fas fa-pencil-alt'></i></button>";
						echo "</div>";
					echo "</td>";
					echo "<td>".$key->idcuestionario."</td>";
					echo "<td>".$key->nombre."</td>";
				echo "</tr>";
			}
		?>
	</tbody>
	</table>
</div>
