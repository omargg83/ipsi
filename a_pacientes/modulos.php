<?php
	require_once("db_.php");
	$idterapia="";
	$idtrack=$_REQUEST['idtrack'];
	$idpaciente=$_REQUEST['idpaciente'];
	$visible="-1";
	if(isset($_REQUEST['visible'])){
		$visible=$_REQUEST['visible'];
	}
	$idpaciente=$_REQUEST['idpaciente'];

	/////////////////////breadcrumb
	$paciente = $db->cliente_editar($idpaciente);
	$nombre=$paciente->nombre." ".$paciente->apellidop." ".$paciente->apellidom;

	$sql="select * from track where id=:idtrack";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":idtrack",$idtrack);
	$sth->execute();
	$track=$sth->fetch(PDO::FETCH_OBJ);
	$inicial=$track->inicial;

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
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/lista" dix="trabajo">Pacientes</li>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/paciente" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo"><?php echo $nombre; ?></li>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/terapias" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Terapias</li>
	 <li class="breadcrumb-item" id='lista_track' is="li-link" des="a_pacientes/track" dix="trabajo" v_idterapia="<?php echo $terapia->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $terapia->nombre; ?></li>
	 <li class="breadcrumb-item active" id='lista_track' is="li-link" des="a_pacientes/modulos" dix="trabajo" v_idtrack="<?php echo $idtrack; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $track->nombre; ?></li>
	 <button class="btn btn-warning btn-sm " type="button" is="b-link" des="a_pacientes/track" dix="trabajo" v_idterapia="<?php echo $terapia->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>">Regresar</button>
 </ol>
</nav>

<?php
	if($inicial!=1){
		echo "<div class='alert alert-warning text-center tituloventana' role='alert'>";
			echo "Mis Modulos";
		echo "</div>";
	}
	else{
		echo "<div class='alert alert-warning text-center tituloventana' role='alert'>";
			echo "Actividad inicial";
		echo "</div>";
	}

	/////////////////filtro
	if($inicial==1){
		echo "<div class='container' id='filtro'>";
			echo "<form id='filtro_form' des='a_pacientes/modulos'>";
				echo "<input type='hidden' name='idtrack' id='idtrack' value='$idtrack'>";
				echo "<input type='hidden' name='idpaciente' id='idpaciente' value='$idpaciente'>";
					echo "<div class='row justify-content-end'>";
						echo "<div class='col-2'>";
							echo "<select name='visible' id='visible' class='form-control form-control-sm filter_x' >";
								echo "<option value='-1' "; if($visible=="-1"){ echo "selected"; } echo ">Todas</option>";
								echo "<option value='1' "; if($visible==1){ echo "selected"; } echo ">Visibles</option>";
								echo "<option value='0' "; if($visible==0){ echo "selected"; } echo ">Ocultas</option>";
							echo "</select>";
					echo "</div>";
			echo "</form>";
		echo "</div>";
	}
?>

<div class='container'>
  <div class='row'>
		<?php
		///////////////////////CODIGO
		$sql="SELECT * from actividad_per left outer join actividad on actividad.idactividad=actividad_per.idactividad where actividad_per.idpaciente=$idpaciente and actividad.idtrack=$idtrack order by actividad.orden asc ";
		$sth = $db->dbh->query($sql);
		$orden=0;
		foreach($sth->fetchAll(PDO::FETCH_OBJ) as $key){
			$arreglo =array();
			$arreglo+=array('orden'=>$orden);
			$x=$db->update('actividad',array('idactividad'=>$key->idactividad), $arreglo);
			$orden++;
		}

		$sql="SELECT * from actividad_per
		 left outer join actividad on actividad.idactividad=actividad_per.idactividad where actividad_per.idpaciente=$idpaciente and actividad.idtrack=$idtrack";
		 if($visible>=0)
		 $sql.=" and actividad.visible=$visible";
		 $sql.=" order by actividad.orden asc ";
		$sth = $db->dbh->query($sql);
		$acinicial=$sth->fetchAll(PDO::FETCH_OBJ);

		foreach($acinicial as $key){
		?>
			<div class='col-4 p-2 w-50 actcard'>
  			<div class='card' style='height:400px'>
					<img style="vertical-align: bottom;border-radius: 10px;max-width: 70px;margin: 0 auto;padding: 10px;" src="img/lapiz.png">
					<div class='card-header'>
						<?php
							echo "<div class='row'>";
								echo "<div class='col-12'>";
									echo $key->nombre;
								echo "</div>";
							echo "</div>";
							echo "<div class='row justify-content-end'>";
								echo "<div class='col-6'>";

									echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' db='a_actividades/db_' fun='actividad_duplicar' v_idactividad='$key->idactividad' v_idpaciente='$idpaciente' v_idtrack='$idtrack' des='a_pacientes/modulos' tp='¿Desea duplicar la actividad seleccionada?' title='Duplicar' dix='trabajo'><i class='far fa-clone'></i></button>";

									echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/modulos' dix='trabajo' db='a_pacientes/db_' fun='quitar_actividad' v_idactividad='$key->idactividad' v_idpaciente='$idpaciente' v_idtrack='$idtrack' tp='¿Desea quitar la actividad inicial seleccionada?' title='Borrar'><i class='far fa-trash-alt'></i></button>";


									echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' db='a_pacientes/db_' fun='actividad_mover' des='a_pacientes/modulos' v_idactividad='$key->idactividad' v_idpaciente='$idpaciente' v_idtrack='$idtrack' v_dir='0' dix='trabajo' title='Mover arriba'><i class='fas fa-chevron-up'></i></button>";

									echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' db='a_pacientes/db_' fun='actividad_mover' des='a_pacientes/modulos' v_idactividad='$key->idactividad' v_idpaciente='$idpaciente' v_idtrack='$idtrack' v_dir='1' dix='trabajo' title='Mover abajo'><i class='fas fa-chevron-down'></i></button>";

								echo "</div>";
							echo "</div>";
						?>
					</div>
					<div class='card-body' style='overflow:auto; height:220px'>
						<div class='row'>
							<div class='col-12'>
								<?php echo $key->observaciones; ?>
							</div>
						</div>
					</div>
					<div class='card-body'>
						<div class='row'>
							<div class='col-12'>
								<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_pacientes/actividad_ver" dix="trabajo" v_idactividad="<?php echo $key->idactividad; ?>" v_idterapia="<?php echo $idterapia; ?>" v_idpaciente='<?php echo $idpaciente; ?>'>Ver inicial</button>
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
			<div class='col-4 p-2 w-50 actcard'>
				<div class='card' style='height:400px'>
					<img style="vertical-align: bottom;border-radius: 10px;max-width: 70px;margin: 0 auto;padding: 10px;" src="img/lapiz.png">
					<div class="card-header">
						<?php echo $key->nombre; ?>

						<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_pacientes/modulos" dix="trabajo" db="a_pacientes/db_" fun="quitar_modulo" v_idmodulo="<?php echo $key->id; ?>" v_idtrack="<?php echo $idtrack; ?>"  v_idpaciente="<?php echo $idpaciente; ?>"  tp="¿Desea quitar el modulo seleccionado?" title="Borrar"><i class="far fa-trash-alt"></i></button>
					</div>
  				<div class='card-body' style='overflow:auto; height:220px'>
  					<div class='row'>
  						<div class='col-12'>
  							<?php echo $key->descripcion; ?>
  						</div>
  					</div>
  				</div>
  				<div class='card-body'>
  					<div class='row'>
  						<div class='col-12'>
  							<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_pacientes/actividades" dix="trabajo" v_idmodulo="<?php echo $key->id; ?>"  v_idpaciente="<?php echo $idpaciente; ?>">Ver</button>
  						</div>
  					</div>
  				</div>
  			</div>
  		</div>
  	<?php
  	}
		if($inicial==1){
			echo "<div id='' class='col-4 p-3 w-50'>";
				echo "<div class='card' style='height:200px;'>";
					echo "<div class='card-body text-center'>";
						echo "<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_pacientes_e/inicial_agregar' dix='trabajo' v_idtrack='$idtrack' v_idpaciente='$idpaciente'>Agregar Actividad inicial</button>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		}
		else{
			echo "<div id='' class='col-4 p-3 w-50'>";
				echo "<div class='card' style='height:200px;'>";
					echo "<div class='card-body text-center'>";
						echo "<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_pacientes_e/modulos_agregar' dix='trabajo' v_idmodulo='0' v_idtrack='$idtrack'  v_idpaciente='$idpaciente' >Nuevo modulo</button>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		}
		?>
	</div>
</div>
