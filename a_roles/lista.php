<?php
	require_once("db_.php");
	$pd = $db->roles_lista();
?>

	<nav aria-label='breadcrumb'>
		<ol class='breadcrumb'>
			<li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_pacientes/index" dix="trabajo">Relaciones</li>
		</ol>
	</nav>


	<div class='container'>
		<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_roles/editar' dix='lista' v_idrol='0'>Nuevo</button>
		<div class='tabla_v' id='tabla_css'>

		<div class='header-row'>
			<div class='cell'>#</div>
			<div class='cell'>Relación</div>
		</div>

		<?php
			foreach($pd as $key){
				echo "<div class='body-row' >";
					echo "<div class='cell'>";
						echo "<div class='btn-group'>";

						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_roles/editar' dix='lista' v_idrol='$key->idrol'>Editar</button>";

						echo "</div>";
					echo "</div>";
					echo "<div class='cell' data-titulo='Relación'>".$key->rol."</div>";

				echo "</div>";
			}
		?>
	</div>


</div>
