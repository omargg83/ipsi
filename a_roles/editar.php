<?php
	require_once("db_.php");

	$idrol=$_REQUEST['idrol'];

	$rol="";

	if($idrol>0){
		$pd = $db->rol_editar($idrol);
		$rol=$pd->rol;
	}
?>

<div class="container">
	<form is="f-submit" id="form_roles" db="a_roles/db_" fun="guardar_rol" des="a_roles/lista" dix='lista'>
		<input type="hidden" class="form-control form-control-sm" name="idrol" id="idrol" value="<?php echo $idrol ;?>" readonly>
		<div class='card'>
		<div class='card-header'>
			Relaciones
		</div>
		<div class='card-body'>

			<div class='row'>
				<div class="col-12">
					<label for="">Relación:</label>
					<input type="text" class="form-control form-control-sm" name="rol" id="rol" value="<?php echo $rol ;?>" placeholder="Relación" maxlength="200" required>
				</div>

			</div>
		</div>

		<div class='card-footer'>
			<div class='row'>
				<div class="col-sm-12">

					<button class="btn btn-warning btn-sm" type="submit">Guardar</button>
					<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_roles/lista" dix="lista">Regresar</button>
				</div>
			</div>
		</div>
	</div>
	</form>
</div>
