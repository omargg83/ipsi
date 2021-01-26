<?php
	require_once("db_.php");

	$idpaciente=$_REQUEST['idpaciente'];
	$pd = $db->cliente_editar($idpaciente);

	$nombre=$pd->nombre;
	$edad=$pd->edad;
	$apellidop=$pd->apellidop;
	$apellidom=$pd->apellidom;
	$telefono=$pd->telefono;
	$correo=$pd->correo;
	$foto=$pd->foto;
	$observaciones=$pd->observaciones;

	/////////////////////Relaciones
	$sql="select * from clientes_relacion
	left outer join clientes on clientes.id=clientes_relacion.idrel
	left outer join rol_familiar on rol_familiar.idrol=clientes_relacion.idrol
	where clientes_relacion.idcliente=:idcliente";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":idcliente",$idpaciente);
	$sth->execute();
	$relaciones=$sth->fetchAll(PDO::FETCH_OBJ);


	if($_SESSION['nivel']!=666){
		echo "<nav aria-label='breadcrumb'>";
			echo "<ol class='breadcrumb'>";
				echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_pacientes/index' dix='trabajo'>Pacientes</li>";
				echo "<li class='breadcrumb-item active' id='lista_track' is='li-link' des='a_pacientes/paciente' v_idpaciente='$idpaciente' dix='trabajo'><?php echo $nombre.' '.$apellidop.' '.$apellidom; ?></li>";
				echo "<li class='breadcrumb-item active' id='lista_track' is='li-link' des='a_pacientes/relaciones' v_idpaciente='$idpaciente' dix='trabajo'>Relaciones</li>";
				echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/paciente' v_idpaciente='$idpaciente' dix='trabajo'>Regresar</button>";
			echo "</ol>";
		echo "</nav>";
	}
?>


<div class="alert alert-warning text-center tituloventana" role="alert">
	Relaciones
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
							<?php
							if($_SESSION['nivel']!=666){
								echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' des='a_pacientes/relaciones_editar' dix='trabajo' v_idrelacion='$key->idrelacion' v_idpaciente='$idpaciente'><i class='fas fa-pencil-alt'></i></button>";

								echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' des='a_pacientes/relaciones' dix='trabajo' db='a_pacientes/db_' fun='rol_quitar' v_idrelacion='$key->idrelacion' v_idpaciente='$idpaciente'  tp='¿Desea eliminar la relacion seleccionada?' title='Borrar'><i class='far fa-trash-alt'></i></button>";
							}
							?>
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
									if($key->credencial==1){
										echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/form_accesos' dix='nueva_sub' tp='edit' v_idrel='$key->idrel' omodal='1'>Accesos</button>";
									}
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
		          echo "<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_pacientes/relaciones_agregar' dix='trabajo' v_idpaciente='$idpaciente'>Agregar</button>";
		        echo "</div>";
		      echo "</div>";
		    echo "</div>";
			}
		?>
  </div>
</div>
