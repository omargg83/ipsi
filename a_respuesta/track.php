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
	$sql="SELECT * from track_per left outer join track on track.id=track_per.idtrack where track_per.idpaciente=:id and track.idterapia=:idterapia order by track.inicial desc, track.orden asc";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":id",$idpaciente);
	$sth->bindValue(":idterapia",$idterapia);
	$sth->execute();
	$track=$sth->fetchAll(PDO::FETCH_OBJ);

?>

<nav aria-label='breadcrumb'>
	<ol class='breadcrumb'>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_respuesta/terapias" dix="contenido">Terapias</li>
		<li class="breadcrumb-item active" is="li-link" des="a_respuesta/track" dix="contenido" title="Terapias" v_idterapia="<?php echo $idterapia; ?>"><?php echo $terapia->nombre; ?></li>

		<button class="btn btn-warning btn-sm" is="b-link" des="a_respuesta/terapias" dix="contenido" v_idterapia="<?php echo $terapia->id; ?>">Regresar</button>
	</ol>
</nav>


<div class="alert alert-warning text-center tituloventana" role="alert">
	Track
</div>

<div class='container'>
	<div class='row'>
  	<?php
		$continuar=1;
  	foreach($track as $key){
			if($key->inicial){
				$sql="SELECT count(contexto.id) as total from contexto
				left outer join subactividad on subactividad.idsubactividad=contexto.idsubactividad
				left outer join actividad on actividad.idactividad=subactividad.idactividad
				where  actividad.idtrack=".$key->idtrack." and actividad.idpaciente=".$_SESSION['idusuario']." and (contexto.tipo='pregunta' or contexto.tipo='textores' or contexto.tipo='fecha'  or contexto.tipo='archivores')";
				$contx = $db->dbh->prepare($sql);
				$contx->execute();
				$bloques=$contx->fetch(PDO::FETCH_OBJ);

				/////////////////
				$sql="SELECT count(contexto_resp.id) as total FROM	contexto
				right OUTER JOIN contexto_resp ON contexto_resp.idcontexto=contexto.id
				left outer join subactividad on subactividad.idsubactividad=contexto.idsubactividad
				left outer join actividad on actividad.idactividad=subactividad.idactividad
				where actividad.idtrack=".$key->idtrack."	and actividad.idpaciente=".$_SESSION['idusuario']." group by contexto.id";
				$respx = $db->dbh->prepare($sql);
				$respx->execute();
				$respx->fetch(PDO::FETCH_OBJ);
				$total=0;
				if($bloques->total>0){
					$total=(100*$respx->rowCount())/$bloques->total;
				}

				if($total!=100){
					$continuar=0;
				}
			}
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
									<?php
										//if($continuar==1 or $key->inicial){
											echo "<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_respuesta/modulos' dix='contenido' v_idtrack='$key->id' >Ver</button>";
									/*	}
										else{
											echo "<button class='btn btn-warning btn-block' type='button' disabled>Ver</button>";
										}*/
									?>
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
