<?php
	require_once("db_.php");
	$idterapia=$_REQUEST['id1'];
	$idpaciente=$_REQUEST['id2'];

	/////////////////////breadcrumb
	$paciente = $db->cliente_editar($idpaciente);
	$nombre=$paciente->nombre." ".$paciente->apellidop." ".$paciente->apellidom;

	$sql="select * from terapias where id=:idterapia";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":idterapia",$idterapia);
	$sth->execute();
	$terapia=$sth->fetch(PDO::FETCH_OBJ);


	///////////////////////CODIGO
	$sql="select track.* from actividad
	left outer join modulo on modulo.id=actividad.idmodulo
	left outer join track on track.id=modulo.idtrack
	where actividad.idpaciente=:id";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":id",$idpaciente);
	$sth->execute();
	$track=$sth->fetchAll(PDO::FETCH_OBJ);

?>

<nav aria-label='breadcrumb'>
	<ol class='breadcrumb'>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/lista" dix="trabajo">Pacientes</li>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/paciente" id1="<?php echo $idpaciente; ?>" dix="trabajo"><?php echo $nombre; ?></li>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/terapias" id1="<?php echo $idpaciente; ?>" dix="trabajo">Terapias</li>
		<li class="breadcrumb-item active" type="button" is="li-link" des="a_pacientes/track" dix="trabajo" title="Terapias" id1="<?php echo $idterapia; ?>" id2="<?php echo $idpaciente; ?>"><?php echo $terapia->nombre; ?></li>
	</ol>
</nav>

<div class="alert alert-warning text-center" role="alert">
  Track
	<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_pacientes/terapias" dix="trabajo" id1="">Regresar</button>
</div>

<div class='container'>
  <div class='row'>
  	<?php
  	foreach($track as $key){
  	?>
  		<div class='col-4 p-3 w-50'>
  			<div class='card' style='height:200px;'>
  				<div class='card-header'>
						<?php echo $key->nombre; ?>
						<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_pacientes_e/track_editar" dix="trabajo" id1="<?php echo $key->id; ?>" id2="<?php echo $idterapia; ?>">Editar</button>
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
  							<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_pacientes/modulos" dix="trabajo" id1="<?php echo $key->id; ?>" id2="<?php echo $idpaciente; ?>">Ver</button>
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
          <button class="btn btn-warning btn-block" type="button" is="b-link" des="a_pacientes_e/track_editar" dix="trabajo" id1="0" id2="<?php echo $idterapia; ?>">Nuevo track</button>
        </div>
      </div>
    </div>
  </div>
</div>
