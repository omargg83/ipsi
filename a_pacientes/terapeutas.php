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
	$sql="SELECT * FROM cliente_terapeuta LEFT OUTER JOIN usuarios ON cliente_terapeuta.idusuario = usuarios.idusuario WHERE cliente_terapeuta.idcliente =$idpaciente";
	$sth = $db->dbh->prepare($sql);
	$sth->execute();
	$terap=$sth->fetchAll(PDO::FETCH_OBJ);
?>

<nav aria-label='breadcrumb'>
	<ol class='breadcrumb'>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/index" dix="trabajo">Pacientes</li>
		<li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_pacientes/paciente" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo"><?php echo $nombre." ".$apellidop." ".$apellidom; ?></li>
		<li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_pacientes/terapeutas" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Terapeutas</li>
		<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_pacientes/paciente" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Regresar</button>
	</ol>
</nav>

<div class="alert alert-warning text-center tituloventana" role="alert">
	Terapeutas
</div>

<div class='container'>
	<div class='row'>

  	<?php
  	foreach($terap as $key){
  	?>
  		<div class='col-4 p-3 w-50 actcard'>
  			<div class='card'>
					<img style="vertical-align: bottom;border-radius: 10px;max-width: 70px;margin: 0 auto;padding: 10px;" src="<?php echo $db->pac.trim($key->foto); ?>">
					<div class='row'>
						<div class='col-12'>

							<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_pacientes/terapeutas" dix="trabajo" db="a_pacientes/db_" fun="terapeuta_quitar" v_idterapeuta="<?php echo $key->idterapeuta; ?>" v_idpaciente="<?php echo $idpaciente; ?>"  tp="¿Desea eliminar la relacion seleccionada?" title="Borrar"><i class="far fa-trash-alt"></i></button>

						</div>
					</div>

					<div class='card-body'>
						<div class='row'>
							<div class='col-12 text-center'>
								<?php echo $key->nombre." ".$key->apellidop." ".$key->apellidom; ?>
							</div>
						</div>
					</div>

  			</div>
  		</div>
  	<?php
  	}
  	?>

		<div id='' class='col-4 p-3 w-50'>
      <div class="card" style='height:200px;'>
        <div class='card-body text-center'>
          <button class="btn btn-warning btn-block" type="button" is="b-link" des="a_pacientes\terapeutas_agregar" dix="trabajo" v_idpaciente='<?php echo $idpaciente; ?>'>Agregar</button>
        </div>
      </div>
    </div>
  </div>
</div>
