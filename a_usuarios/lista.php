<?php
	require_once("db_.php");
	$pd = $db->usuario_lista();
?>

<div class="container-fluid">

	<div class="row">
		<div class="col-2">Numero</div>
		<div class="col-3">Nombre</div>
		<div class="col-2">Nivel</div>
		<div class="col-3">Correo</div>
		<div class="col-2">Activo</div>
	</div>
			<?php
				foreach($pd as $key){
			?>
					<div class='row'>
						<div class="col-2">
							<button class='btn btn-warning' type="button" is="b-link" des='a_usuarios/editar' dix='trabajo' tp="edit" id1='<?php echo $key->id; ?>' title='editar'>Editar</button>
						</div>
						<div class="col-3"><?php echo $key->nombre; ?></div>
						<div class="col-2"><?php echo $key->nivel; ?></div>
						<div class="col-3"><?php echo $key->correo; ?></div>
						<div class="col-2">
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
