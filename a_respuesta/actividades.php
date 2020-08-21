<?php
	require_once("db_.php");
	$idmodulo=$_REQUEST['idmodulo'];
	$idpaciente=$_SESSION['idusuario'];

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
	where actividad.idpaciente=:id and actividad.idmodulo=:idmodulo";

	$sql="SELECT * from actividad_per left outer join actividad on actividad.idactividad=actividad_per.idactividad where actividad_per.idpaciente=:id and actividad.idmodulo=:idmodulo";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":id",$idpaciente);
	$sth->bindValue(":idmodulo",$idmodulo);
	$sth->execute();
	$actividades=$sth->fetchAll(PDO::FETCH_OBJ);

?>

<nav aria-label='breadcrumb'>
 <ol class='breadcrumb'>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_respuesta/terapias"  dix="contenido">Terapias</li>
	 <li class="breadcrumb-item" id='lista_track' is="li-link" des="a_respuesta/track" dix="contenido" v_idterapia="<?php echo $terapia->id; ?>" ><?php echo $terapia->nombre; ?></li>
	 <li class="breadcrumb-item" id='lista_track' is="li-link" des="a_respuesta/modulos" dix="contenido" v_idtrack="<?php echo $track->id; ?>" ><?php echo $track->nombre; ?></li>
	 <li class="breadcrumb-item active" id='lista_track' is="li-link" des="a_respuesta/actividades" dix="contenido" v_idmodulo="<?php echo $idmodulo; ?>" ><?php echo $modulo->nombre; ?></li>
 </ol>
</nav>



<div class="alert alert-warning text-center" role="alert">
	Actividades
	<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_respuesta/modulos" dix="contenido" id1="<?php echo $track->id; ?>">Regresar</button>
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
								<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_respuesta/actividad_ver" dix="contenido" v_idactividad="<?php echo $key->idactividad; ?>" >Ver</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
		}
		?>
	</div>
</div>
