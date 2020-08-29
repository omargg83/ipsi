<?php
	require_once("db_.php");
	$idtrack=$_REQUEST['idtrack'];
	$idpaciente=$_SESSION['idusuario'];

	/////////////////////breadcrumb
	$paciente = $db->cliente_editar($idpaciente);
	$nombre=$paciente->nombre." ".$paciente->apellidop." ".$paciente->apellidom;

	$sql="select * from track where id=:idtrack";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":idtrack",$idtrack);
	$sth->execute();
	$track=$sth->fetch(PDO::FETCH_OBJ);

	$sql="select * from terapias where id=:idterapia";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":idterapia",$track->idterapia);
	$sth->execute();
	$terapia=$sth->fetch(PDO::FETCH_OBJ);

	///////////////////////CODIGO
	$sql="SELECT * from modulo_per left outer join modulo on modulo.id=modulo_per.idmodulo where modulo_per.idpaciente=:id and modulo.idtrack=:idtrack";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":id",$idpaciente);
	$sth->bindValue(":idtrack",$idtrack);
	$sth->execute();
	$modulos=$sth->fetchAll(PDO::FETCH_OBJ);
?>

<nav aria-label='breadcrumb'>
 <ol class='breadcrumb'>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_respuesta/terapias"  dix="contenido">Terapias</li>
	 <li class="breadcrumb-item" id='lista_track' is="li-link" des="a_respuesta/track" dix="contenido" v_idterapia="<?php echo $terapia->id; ?>" ><?php echo $terapia->nombre; ?></li>
	 <li class="breadcrumb-item active" id='lista_track' is="li-link" des="a_respuesta/modulos" dix="contenido" v_idtrack="<?php echo $idtrack; ?>" ><?php echo $track->nombre; ?></li>

	  <button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_respuesta/track" dix="contenido" v_idterapia="<?php echo $terapia->id; ?>">Regresar</button>
 </ol>
</nav>

 <div class="alert alert-warning text-center tituloventana" role="alert">
   Mis Modulos

 </div>

<div class='container'>
  <div class='row'>
		<?php
		///////////////////////CODIGO
		$sql="SELECT * from actividad_per left outer join actividad on actividad.idactividad=actividad_per.idactividad where actividad_per.idpaciente=:id and actividad.idtrack=:idtrack";
		$sth = $db->dbh->prepare($sql);
		$sth->bindValue(":id",$idpaciente);
		$sth->bindValue(":idtrack",$idtrack);
		$sth->execute();
		$inicial=$sth->fetchAll(PDO::FETCH_OBJ);

		$continuar=1;
		foreach($inicial as $key){
			$total=0;
			$sql="SELECT count(contexto.id) as total from contexto
			left outer join subactividad on subactividad.idsubactividad=contexto.idsubactividad
			where subactividad.idactividad=:id";
			$contx = $db->dbh->prepare($sql);
			$contx->bindValue(":id",$key->idactividad);
			$contx->execute();
			$bloques=$contx->fetch(PDO::FETCH_OBJ);

			$sql="SELECT count(contexto_resp.id) as total FROM	contexto
			right OUTER JOIN contexto_resp ON contexto_resp.idcontexto=contexto.id
			left outer join subactividad on subactividad.idsubactividad=contexto.idsubactividad
			where subactividad.idactividad=:id
			group by contexto.id";
			$contx = $db->dbh->prepare($sql);
			$contx->bindValue(":id",$key->idactividad);
			$contx->execute();
			if($contx->rowCount()){
				$total=(100*$contx->rowCount())/$bloques->total;
			}

			if($total!=100){
				$continuar=0;
			}
		?>
			<div class='col-4 p-3 w-50 actcard'>
				<div class='card'>
					<img style="vertical-align: bottom;border-radius: 10px;max-width: 70px;margin: 0 auto;padding: 10px;" src="img/lapiz.png">

					<div class='card-header'>
						<?php echo $key->nombre; ?> (Actividad inicial)
						<?php
							echo "<progress id='file' value='$total' max='100'> $total %</progress>";
						?>
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
  	foreach($modulos as $key){
  ?>
  		<div class='col-4 p-3 w-50 actcard'>
  			<div class='card'>
					<img style="vertical-align: bottom;border-radius: 10px;max-width: 70px;margin: 0 auto;padding: 10px;" src="img/lapiz.png">
					<div class="card-header">
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
  							<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_respuesta/actividades" dix="contenido" v_idmodulo="<?php echo $key->id; ?>"  >Ver</button>
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
