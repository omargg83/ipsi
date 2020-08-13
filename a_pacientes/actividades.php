<?php
	require_once("db_.php");
	$idmodulo=$_REQUEST['idmodulo'];
	$idpaciente=$_REQUEST['idpaciente'];

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
	echo "idpaciente:".$idpaciente;
	$actividades=$sth->fetchAll(PDO::FETCH_OBJ);

?>

<nav aria-label='breadcrumb'>
 <ol class='breadcrumb'>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/lista" dix=""contenido"">Pacientes</li>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/paciente" v_idpaciente="<?php echo $idpaciente; ?>" dix=""contenido""><?php echo $nombre; ?></li>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/terapias" v_idpaciente="<?php echo $idpaciente; ?>" dix=""contenido"">Terapias</li>
	 <li class="breadcrumb-item" id='lista_track' is="li-link" des="a_pacientes/track" dix=""contenido"" v_idterapia="<?php echo $terapia->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $terapia->nombre; ?></li>
	 <li class="breadcrumb-item" id='lista_track' is="li-link" des="a_pacientes/modulos" dix=""contenido"" v_idtrack="<?php echo $track->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $track->nombre; ?></li>
	 <li class="breadcrumb-item active" id='lista_track' is="li-link" des="a_pacientes/actividades" dix=""contenido"" v_idmodulo="<?php echo $idmodulo; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $modulo->nombre; ?></li>
 </ol>
</nav>



<div class="alert alert-warning text-center" role="alert">
	Actividades
	<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_pacientes/modulos" dix=""contenido"" id1="<?php echo $track->id; ?>">Regresar</button>
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
						<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_pacientes_e/actividad_editar" dix=""contenido"" id1="<?php echo $key->idactividad; ?>" id2="<?php echo $idmodulo; ?>">Editar</button>
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
								<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_pacientes/actividad_ver" dix=""contenido"" v_idactividad="<?php echo $key->idactividad; ?>" v_idpaciente="<?php echo $idpaciente; ?>">Ver</button>
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
					<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_pacientes_e/actividad_editar" dix=""contenido"" id1="0" id2="<?php echo $idmodulo; ?>">Nueva actividad</button>
				</div>
			</div>
		</div>

	</div>
</div>
