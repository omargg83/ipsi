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
	where clientes_relacion.idcliente=:idcliente";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":idcliente",$idpaciente);
	$sth->execute();
	$relaciones=$sth->fetchAll(PDO::FETCH_OBJ);

?>

<nav aria-label='breadcrumb'>
	<ol class='breadcrumb'>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/index" dix="trabajo">Pacientes</li>
		<li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_pacientes/paciente" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo"><?php echo $nombre." ".$apellidop." ".$apellidom; ?></li>
		<li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_pacientes/relaciones" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Relaciones</li>
		<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_pacientes/index" dix="trabajo">Regresar</button>
	</ol>
</nav>



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
					<img style="vertical-align: bottom;border-radius: 10px;max-width: 70px;margin: 0 auto;padding: 10px;" src="<?php echo $key->foto; ?>">
  				<div class='card-header'>
						<?php echo $key->nombre; ?>

						<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_pacientes/track" dix="trabajo" db="a_pacientes/db_" fun="quitar_track" v_idtrack="<?php echo $key->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>" v_idterapia="<?php echo $idterapia; ?>" tp="¿Desea quitar el track seleccionado?" title="Borrar"><i class="far fa-trash-alt"></i></button>
					</div>

  				<div class='card-body'>
  					<div class='row'>
  						<div class='col-12'>
  							<?php echo $key->descripcion; ?>
  						</div>
  					</div>
  				</div>
  				<div class='card-body'>
  					<div class='row'>
  						<div class='col-12'>
  							<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_pacientes/modulos" dix="trabajo" v_idtrack="<?php echo $key->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>">Ver</button>
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
          <button class="btn btn-warning btn-block" type="button" is="b-link" des="a_pacientes\relaciones_agregar" dix="trabajo" v_idpaciente='<?php echo $idpaciente; ?>'>Agregar</button>
        </div>
      </div>
    </div>
  </div>
</div>
