<?php
	require_once("db_.php");
	$pd = $db->cuestionario_lista();

	echo "<nav aria-label='breadcrumb'>";
		echo "<ol class='breadcrumb'>";
			echo "<li class='breadcrumb-item active' aria-current='page'>Actividades</li>";
		echo "</ol>";
	echo "</nav>";

	echo "<div class='container' style='background-color:".$_SESSION['cfondo']."; '>";
?>

	<div class='row'>
	<?php
		foreach($pd as $key){
			echo "<div id='".$key->idcuestionario."'' class='col-4 p-3'>";
				echo "<div class='card'>";
					echo "<div class='card-body'>";
						echo "<div class='row'>";
							echo "<div class='col-12'>";
								echo "<div>".$key->nombre."</div>";
								echo "<div>".$key->observaciones."</div>";
							echo "</div>";
						echo "</div>";
					echo "</div>";
					echo "<div class='card-body'>";
						echo "<div class='row'>";
							echo "<div class='col-12'>";
								echo "<div class='btn-group'>";
									echo "<button class='btn btn-outline-primary btn-sm ' onclick='actividad($key->idcuestionario)'><i class='fas fa-pencil-alt'></i>Editar</button>";
									echo "<button class='btn btn-outline-primary btn-sm ' onclick='eliminar_act($key->idcuestionario)'><i class='far fa-trash-alt'></i>Eliminar</button>";
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
