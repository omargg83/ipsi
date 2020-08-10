<?php
	require_once("db_.php");
	$idmodulo=$_REQUEST['id1'];
	$idpaciente=$_REQUEST['id2'];

  /////////////////////breadcrumb
  $paciente = $db->cliente_editar($idpaciente);
  $nombre=$paciente->nombre." ".$paciente->apellidop." ".$paciente->apellidom;

  $sql="select * from modulo where id=:idmodulo";
  $sth = $db->dbh->prepare($sql);
  $sth->bindValue(":idmodulo",$idmodulo);
  $sth->execute();
  $modulo=$sth->fetch(PDO::FETCH_OBJ);

  $sql="select * from track where id=:idtrack";
  $sth = $db->dbh->prepare($sql);
  $sth->bindValue(":idtrack",$modulo->idtrack);
  $sth->execute();
  $track=$sth->fetch(PDO::FETCH_OBJ);

  $sql="select * from terapias where id=:idterapia";
  $sth = $db->dbh->prepare($sql);
  $sth->bindValue(":idterapia",$track->idterapia);
  $sth->execute();
  $terapia=$sth->fetch(PDO::FETCH_OBJ);


  ///////////////////////CODIGO
	$sql="select * from actividad
	where actividad.idpaciente=:id";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":id",$idpaciente);
	$sth->execute();
	$actividades=$sth->fetchAll(PDO::FETCH_OBJ);

?>

<nav aria-label='breadcrumb'>
 <ol class='breadcrumb'>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/lista" dix="trabajo">Pacientes</li>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/paciente" id1="<?php echo $idpaciente; ?>" dix="trabajo"><?php echo $nombre; ?></li>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/terapias" id1="<?php echo $idpaciente; ?>" dix="trabajo">Terapias</li>
	 <li class="breadcrumb-item" id='lista_track' is="li-link" des="a_pacientes/track" dix="trabajo" id1="<?php echo $terapia->id; ?>" id2="<?php echo $idpaciente; ?>"><?php echo $terapia->nombre; ?></li>
	 <li class="breadcrumb-item" id='lista_track' is="li-link" des="a_pacientes/modulos" dix="trabajo" id1="<?php echo $track->id; ?>" id2="<?php echo $idpaciente; ?>"><?php echo $track->nombre; ?></li>
	 <li class="breadcrumb-item active" id='lista_track' is="li-link" des="a_pacientes/actividades" dix="trabajo" id1="<?php echo $idmodulo; ?>" id2="<?php echo $idpaciente; ?>"><?php echo $modulo->nombre; ?></li>
 </ol>
</nav>



<div class="alert alert-warning text-center" role="alert">
	Actividades
	<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_pacientes/modulos" dix="trabajo" id1="<?php echo $track->id; ?>">Regresar</button>
</div>

<div class='container'>
	<div class='row'>


	<?php
		foreach($actividades as $key){
	?>
			<div id='<?php echo $key->idactividad; ?>' class='col-4 p-3 w-50'>
				<div class='card' style='height:200px;'>
					<div class='card-header'>
						<?php echo $key->nombre; ?>
						<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_pacientes_e/actividad_editar" dix="trabajo" id1="<?php echo $key->idactividad; ?>" id2="<?php echo $idmodulo; ?>">Editar</button>
					</div>
					<div class='card-body'>
						<div class='row'>
							<div class='col-12'>
								<?php echo $key->observaciones; ?>
							</div>
						</div>
					</div>
					<div class='card-footer'>
						<div class='row'>
							<div class='col-12'>
								<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_pacientes/actividad_ver" dix="trabajo" id1="<?php echo $key->idactividad; ?>">Ver</button>
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
					<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_pacientes_e/actividad_editar" dix="trabajo" id1="0" id2="<?php echo $idmodulo; ?>">Nueva actividad</button>
				</div>
			</div>
		</div>

	</div>
</div>
