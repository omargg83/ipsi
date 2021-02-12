<?php
	require_once("db_.php");
	$idmodulo=$_REQUEST['idmodulo'];
	$idpaciente=$_REQUEST['idpaciente'];

	$visible="-1";
	if(isset($_REQUEST['visible'])){
		$visible=$_REQUEST['visible'];
	}


	if($visible=="-1"){
		/////////////////ordenar modulos
		$sql="SELECT * from actividad_per left outer join actividad on actividad.idactividad=actividad_per.idactividad where actividad_per.idpaciente=$idpaciente and actividad.idmodulo=$idmodulo order by actividad.orden asc";
		$sth = $db->dbh->query($sql);
		$respx=$sth->fetchAll(PDO::FETCH_OBJ);
		$orden=0;
		foreach($respx as $row){
			$arreglo =array();
			$arreglo+=array('orden'=>$orden);
			$x=$db->update('actividad',array('idactividad'=>$row->idactividad), $arreglo);
			$orden++;
		}
	}


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
	$sql="SELECT * from actividad_per left outer join actividad on actividad.idactividad=actividad_per.idactividad where actividad_per.idpaciente=$idpaciente and actividad.idmodulo=$idmodulo";

	if($visible>=0)
	$sql.=" and actividad.visible=$visible";
	$sql.=" order by actividad.orden asc";
	$sth = $db->dbh->query($sql);


	$actividades=$sth->fetchAll(PDO::FETCH_OBJ);

?>

<nav aria-label='breadcrumb'>
 <ol class='breadcrumb'>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/lista" dix="trabajo">Pacientes</li>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/paciente" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo"><?php echo $nombre; ?></li>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/terapias" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Terapias</li>
	 <li class="breadcrumb-item" id='lista_track' is="li-link" des="a_pacientes/track" dix="trabajo" v_idterapia="<?php echo $terapia->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $terapia->nombre; ?></li>
	 <li class="breadcrumb-item" id='lista_track' is="li-link" des="a_pacientes/modulos" dix="trabajo" v_idtrack="<?php echo $track->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $track->nombre; ?></li>
	 <li class="breadcrumb-item active" id='lista_track' is="li-link" des="a_pacientes/actividades" dix="trabajo" v_idmodulo="<?php echo $idmodulo; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $modulo->nombre; ?></li>
	 <button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_pacientes/modulos" dix="trabajo" v_idtrack="<?php echo $track->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>">Regresar</button>
 </ol>
</nav>



<div class="alert alert-warning text-center tituloventana" role="alert">
	Actividades
</div>
<?php

	echo "<div class='container' id='filtro'>";
		echo "<form id='filtro_form' des='a_pacientes/actividades'>";
			echo "<input type='hidden' name='idmodulo' id='idmodulo' value='$idmodulo'>";
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

?>

<div class='container'>
	<div class='row'>
	<?php
		foreach($actividades as $key){
	?>
			<div id='<?php echo $key->idactividad; ?>' class='col-4 p-3 w-50 actcard'>
				<div class='card'>
				<img style="vertical-align: bottom;border-radius: 10px;max-width: 70px;margin: 0 auto;padding: 10px;" src="img/lapiz.png">

					<div class='card-header'>
						<?php
							echo "<div class='row'>";
								echo "<div class='col-12'>";
									echo $key->nombre;
								echo "</div>";
							echo "</div>";
							echo "<div class='row justify-content-end'>";
								echo "<div class='col-12'>";

									echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' db='a_pacientes/db_' fun='actividad_mover' des='a_pacientes/actividades' v_idactividad='$key->idactividad' v_idpaciente='$idpaciente' v_idmodulo='$idmodulo' v_dir='1' dix='trabajo' title='Abajo'><i class='fas fa-chevron-down'></i></button>";

									echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' db='a_pacientes/db_' fun='actividad_mover' des='a_pacientes/actividades' v_idactividad='$key->idactividad' v_idpaciente='$idpaciente' v_idmodulo='$idmodulo' v_dir='0' dix='trabajo' title='Arriba'><i class='fas fa-chevron-up'></i></button>";

									echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' des='a_pacientes/actividades' dix='trabajo' db='a_pacientes/db_' fun='quitar_actividad' v_idactividad='$key->idactividad' v_idpaciente='$idpaciente' v_idtrack='$track->id' v_idmodulo='$idmodulo' tp='¿Desea quitar la actividad inicial seleccionada?' title='Borrar'><i class='far fa-trash-alt'></i></button>";

									echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' db='a_actividades/db_' fun='actividad_duplicar' v_idactividad='$key->idactividad' v_idpaciente='$idpaciente' v_idtrack='$track->id' v_idmodulo='$idmodulo' des='a_pacientes/actividades' tp='¿Desea duplicar la actividad seleccionada?' title='Duplicar' dix='trabajo'><i class='far fa-clone'></i></button>";

									echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' des='a_pacientes_e/actividad_editar' dix='trabajo' v_idactividad='$key->idactividad' v_idpaciente='$idpaciente' v_idmodulo='$idmodulo' v_proviene='actividades'><i class='fas fa-pencil-alt'></i></button>";


								echo "</div>";
							echo "</div>";
						?>
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
								<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_pacientes/actividad_ver" dix="trabajo" v_idactividad="<?php echo $key->idactividad; ?>" v_idpaciente="<?php echo $idpaciente; ?>">Ver</button>
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
					<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_pacientes_e/actividad_agregar" dix="trabajo" v_idmodulo="<?php echo $idmodulo; ?>" v_idpaciente="<?php echo $idpaciente; ?>">Nueva actividad</button>
				</div>
			</div>
		</div>

	</div>
</div>
