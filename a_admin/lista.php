<?php
	require_once("db_.php");

	$pd = $db->config_lista();	
?>
<div class='container'>
	<div class='tabla_v' id='tabla_css'>

	<div class='header-row'>
		<div class='cell'>#</div>
		<div class='cell'>Correo</div>
		<div class='cell'>Mail</div>
	</div>

		<?php
			foreach($pd as $key){
				echo "<div class='body-row' >";
					echo "<div class='cell'>";

					    echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_admin/editar' dix='trabajo' v_idmail='$key->idmail'>Editar</button>";
						

					echo "</div>";
					echo "<div class='cell' data-titulo='Correo'>".$key->correo."</div>";
					echo "<div class='cell' data-titulo='Mail'>".$key->user."</div>";
					
				echo "</div>";
			}
		?>
	</div>

</div>
