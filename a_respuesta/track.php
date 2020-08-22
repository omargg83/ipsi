<?php
	require_once("db_.php");
	$idterapia=$_REQUEST['idterapia'];
	$idpaciente=$_SESSION['idusuario'];

	/////////////////////breadcrumb
	$paciente = $db->cliente_editar($idpaciente);
	$nombre=$paciente->nombre." ".$paciente->apellidop." ".$paciente->apellidom;

	$sql="select * from terapias where id=:idterapia";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":idterapia",$idterapia);
	$sth->execute();
	$terapia=$sth->fetch(PDO::FETCH_OBJ);


	///////////////////////CODIGO
	 $sql="SELECT * from track_per
	 left outer join track on track.id=track_per.idtrack where track_per.idpaciente=:id and track.idterapia=:idterapia";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":id",$idpaciente);
	$sth->bindValue(":idterapia",$idterapia);
	$sth->execute();
	$track=$sth->fetchAll(PDO::FETCH_OBJ);

?>

<nav aria-label='breadcrumb'>
	<ol class='breadcrumb'>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_respuesta/terapias" v_idpaciente="<?php echo $idpaciente; ?>" dix="contenido">Terapias</li>
		<li class="breadcrumb-item active" type="button" is="li-link" des="a_respuesta/track" dix="contenido" title="Terapias" v_idterapia="<?php echo $idterapia; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $terapia->nombre; ?></li>
	</ol>
</nav>


<div class="alert alert-warning text-center" role="alert">
	Track
</div>

<div class='container'>
	<div class='row'>
		<?php
		///////////////////////CODIGO
		 $sql="SELECT * from actividad_per
		 left outer join actividad on actividad.idactividad=actividad_per.idactividad where actividad_per.idpaciente=:id and actividad.idterapia=:idterapia";
		$sth = $db->dbh->prepare($sql);
		$sth->bindValue(":id",$idpaciente);
		$sth->bindValue(":idterapia",$idterapia);
		$sth->execute();
		$inicial=$sth->fetchAll(PDO::FETCH_OBJ);


		foreach($inicial as $key){
		?>
			<div class='col-4 p-3 w-50'>
				<div class='card' style='height:200px;'>
					<div class='card-header'>
						<img style="vertical-align: bottom;border-radius: 10px; max-width: 50px;" src="img/perfil.jpg">
					</div>
					<div class='card-header'>
						<?php echo $key->nombre; ?> (Actividad inicial)
					</div>
					<div class='card-body'>
						<div class='row'>
							<div class='col-12'>
								<?php echo $key->observaciones; ?>
							</div>
						</div>
					</div>
					<div class='card-body'>
						<div class='row'>
							<div class='col-12'>
								<button class="btn btn-danger btn-block" type="button" is="b-link" des="a_respuesta/actividad_ver" dix="contenido" v_idactividad="<?php echo $key->idactividad; ?>" v_idterapia="<?php echo $idterapia; ?>" v_idpaciente='<?php echo $idpaciente; ?>'>Ver</button>

							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
		}
		?>

  	<?php
  	foreach($track as $key){
  	?>
  		<div class='col-4 p-3 w-50 actcard'>
  			<div class='card'>
					<img style="vertical-align: bottom;border-radius: 10px;max-width: 70px;margin: 0 auto;padding: 10px;" src="img/lapiz.png">
  				<div class='card-header'>
						<?php echo $key->nombre; ?>
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
  							<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_respuesta/modulos" dix="contenido" v_idtrack="<?php echo $key->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>">Ver</button>
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
