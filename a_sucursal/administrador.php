<?php
	require_once("db_.php");

	$idsucursal=$_REQUEST['idsucursal'];
	$pd = $db->sucursal($idsucursal);

	$nombre=$pd->nombre;
	$ubicacion=$pd->ubicacion;
	$ciudad=$pd->ciudad;

	/////////////////////Relaciones
	$sql="select * from sucursal_administracion
	left outer join usuarios on usuarios.idusuario=sucursal_administracion.idusuario
	where sucursal_administracion.idsucursal=:idsucursal";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":idsucursal",$idsucursal);
	$sth->execute();
	$relaciones=$sth->fetchAll(PDO::FETCH_OBJ);

		echo "<nav aria-label='breadcrumb'>";
			echo "<ol class='breadcrumb'>";
				echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_sucursal/index' dix='trabajo'>Sucursales</li>";
				echo "<li class='breadcrumb-item active' id='lista_track' is='li-link' des='a_sucursal/administrador' v_idsucursal='$idsucursal' dix='trabajo'>$nombre</li>";
				echo "<button class='btn btn-warning btn-sm' is='b-link' des='a_sucursal/lista' dix='trabajo'>Regresar</button>";
			echo "</ol>";
		echo "</nav>";

?>

<div class="alert alert-warning text-center tituloventana" role="alert">
	Administradores
</div>

<div class='container'>
	<div class='row'>

  	<?php
  	foreach($relaciones as $key){
  	?>
  		<div class='col-4 p-3 w-50 actcard'>
  			<div class='card'>
					<img style="vertical-align: bottom;border-radius: 10px;max-width: 70px;margin: 0 auto;padding: 10px;" src="<?php echo $db->pac.trim($key->foto); ?>">
					<div class='row'>
						<div class='col-12'>

							<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_pacientes/relaciones_editar" dix="trabajo" v_idrelacion="<?php echo $key->idrelacion; ?>"
								v_idpaciente="<?php echo $idpaciente; ?>"><i class="fas fa-pencil-alt"></i></button>

								<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_pacientes/relaciones" dix="trabajo" db="a_pacientes/db_" fun="rol_quitar" v_idrelacion="<?php echo $key->idrelacion; ?>" v_idpaciente="<?php echo $idpaciente; ?>"  tp="¿Desea eliminar la relacion seleccionada?" title="Borrar"><i class="far fa-trash-alt"></i></button>

						</div>
					</div>

					<div class='card-body'>
						<div class='row'>
							<div class='col-12 text-center'>
								<?php echo $key->nombre." ".$key->apellidop." ".$key->apellidom; ?>
							</div>
						</div>
						<div class='row'>
							<div class='col-12 text-center'>
								<?php echo $key->rol; ?>
							</div>
						</div>
						<div class='row'>
							<div class='col-12 text-center'>
								<?php
									echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/form_accesos' dix='nueva_sub' tp='edit' v_idrel='$key->idrel' omodal='1'>Accesos</button>";
								?>
							</div>
						</div>
					</div>

  			</div>
  		</div>
  	<?php
  	}

			if($_SESSION['nivel']!=666){
				echo "<div id='' class='col-4 p-3 w-50'>";
		      echo "<div class='card' style='height:200px;'>";
		        echo "<div class='card-body text-center'>";
		          echo "<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_sucursales\admin_agregar' dix='trabajo' v_idsucursal='$idsucursal'>Agregar</button>";
		        echo "</div>";
		      echo "</div>";
		    echo "</div>";
			}
		?>
  </div>
</div>
