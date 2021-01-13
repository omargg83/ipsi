<?php
	require_once("db_.php");
	$pd = $db->usuario_lista();
?>
<div class='container'>
	<div class='tabla_v' id='tabla_css'>

	<div class='header-row'>
		<div class='cell'>#</div>
		<div class='cell'>Nombre</div>
		<div class='cell'>Nivel</div>
		<div class='cell'>Correo</div>
		<div class='cell'>Activo</div>
	</div>

			<?php
				foreach($pd as $key){

					echo "<div class='body-row' draggable='true'>";
						echo "<div class='cell'>";
							echo "<div class='btn-group'>";
					?>
								<button class='btn btn-warning btn-sm' type="button" is="b-link" des='a_usuarios/editar' dix='trabajo' tp="edit" v_idusuario='<?php echo $key->idusuario; ?>' title='editar'>Editar</button>
								</div>
							</div>
						<div class='cell' data-titulo='Nombre'><?php echo $key->nombre; ?></div>
						<div class='cell' data-titulo='Nivel'><?php echo $key->nivel; ?></div>
						<div class='cell' data-titulo='Correo'><?php echo $key->correo; ?></div>
						<div class='cell' data-titulo='Activo'>
						<?php
							if ($key->autoriza==0) { echo "Inactivo"; }
							if ($key->autoriza==1) { echo "Activo"; }
						?>
						</div>
					</div>
			<?php
				}
			?>
	</div>
</div>
