<?php
	require_once("db_.php");
  $idtrack=$_REQUEST['idtrack'];
	$visible="-1";
	if(isset($_REQUEST['visible'])){
		$visible=$_REQUEST['visible'];
	}

	if($visible=="-1"){
		/////////////////ordenar modulos
		$sql="SELECT * from modulo where idtrack=$idtrack order by modulo.orden asc";
		$sth = $db->dbh->query($sql);
		$respx=$sth->fetchAll(PDO::FETCH_OBJ);

		$orden=0;
		foreach($respx as $row){
			$arreglo =array();
			$arreglo+=array('orden'=>$orden);
			$x=$db->update('modulo',array('id'=>$row->id), $arreglo);
			$orden++;
		}
	}

  $modulos=$db->modulos($idtrack);

	$track=$db->track_editar($idtrack);
	$inicial=$track->inicial;
	$terapia=$db->terapia_editar($track->idterapia);

?>

 <nav aria-label='breadcrumb'>
   <ol class='breadcrumb'>
     <li class="breadcrumb-item" is="li-link" des="a_actividades/terapias" dix="trabajo" id1="" title="Inicio">Inicio</lis>
     <li class="breadcrumb-item" is="li-link" des="a_actividades/track" dix="trabajo" title="Terapias" v_idterapia="<?php echo $terapia->id; ?>"><?php echo $terapia->nombre; ?></li>
     <li class="breadcrumb-item active" is="li-link" des="a_actividades/modulos" dix="trabajo" title="Track" v_idtrack="<?php echo $track->id; ?>" ><?php echo $track->nombre; ?></li>
		 <button class="btn btn-warning btn-sm" is="b-link" des="a_actividades/track" dix="trabajo" v_idterapia="<?php echo $terapia->id; ?>">Regresar</button>
   </ol>
 </nav>

	<?php
		if($inicial==1){
			echo "<div class='alert alert-warning text-center tituloventana' role='alert'>";
		   echo "Actividad inicial";
		 	echo "</div>";
		}
		else{
			echo "<div class='alert alert-warning text-center tituloventana' role='alert'>";
		   echo "Modulos";
		 	echo "</div>";
		}

		/////////////////filtro
		if($inicial==1){
			echo "<div class='container' id='filtro'>";
				echo "<form id='filtro_form' des='a_actividades/modulos'>";
					echo "<input type='hidden' name='idtrack' id='idtrack' value='$idtrack'>";
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
  	foreach($modulos as $key){

		echo "<div class='col-4 p-2 w-50 actcard'>";
			echo "<div class='card' style='height:400px'>";
					echo "<img style='vertical-align: bottom;border-radius: 10px;max-width: 70px;margin: 0 auto;padding: 10px;' src='img/lapiz.png'>";
					echo "<div class='card-header'>";
						echo "<div class='row'>";
							echo "<div class='col-12 text-center'>";
								echo $key->nombre;
							echo "</div>";
						echo "</div>";
						echo "<div class='row justify-content-end'>";
							echo "<div class='col-5'>";

								echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' db='a_actividades/db_' fun='modulos_mover' des='a_actividades/modulos' v_idmodulo='$key->id' v_idtrack='$idtrack' v_dir='0' dix='trabajo' title='Arriba'><i class='fas fa-chevron-up'></i></button>";

								echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' db='a_actividades/db_' fun='modulos_mover' des='a_actividades/modulos' v_idmodulo='$key->id' v_idtrack='$idtrack' v_dir='1' dix='trabajo' title='Abajo'><i class='fas fa-chevron-down'></i></button>";

								echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' des='a_actividades/modulos' dix='trabajo' db='a_actividades/db_' fun='borrar_modulo' v_idmodulo='$key->id' v_idtrack='$idtrack' tp='¿Desea eliminar el modulo selecionado?' tt='Ya no podrá deshacer el cambio' title='Borrar'><i class='far fa-trash-alt'></i></button>";

								echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' des='a_actividades_e/modulos_editar' dix='trabajo' v_idmodulo='$key->id' v_idtrack='$idtrack'><i class='fas fa-pencil-alt'></i></button>";

							echo "</div>";
						echo "</div>";

						?>
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
  							<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_actividades/actividades" dix="trabajo" v_idmodulo="<?php echo $key->id; ?>"  v_idtrack="<?php echo $idtrack; ?>">Ver</button>
  						</div>
  					</div>
  				</div>
  			</div>
  		</div>
  	<?php
  	}
		if($inicial!=1){
			echo "<div id='' class='col-4 p-3 w-50'>";
	      echo "<div class='card' style='height:200px;'>";
	        echo "<div class='card-body text-center'>";
	          echo "<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_actividades_e/modulos_editar' dix='trabajo' v_idmodulo='0' v_idtrack='$idtrack' >Nuevo modulo</button>";
	        echo "</div>";
	      echo "</div>";
	    echo "</div>";
		}

		if($visible=="-1"){
			/////////////////ordenar modulos
			$sql="SELECT * from actividad where idtrack=$idtrack and idpaciente is null order by actividad.orden asc";
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


		$sql="select * from actividad where idtrack=$idtrack and idpaciente is null";
		if($visible>=0)
		$sql.=" and actividad.visible=$visible";

		$sql.=" order by actividad.orden asc";

		$sth = $db->dbh->query($sql);
		$actividad=$sth->fetchAll(PDO::FETCH_OBJ);

		foreach($actividad as $key){
		?>
		<div class='col-4 p-2 w-50 actcard'>
			<div class='card' style='height:400px'>
				<div class='card-header'>
					<?php
						echo "<div class='row'>";
							echo "<div class='col-12'>";
								echo $key->nombre;
							echo "</div>";
						echo "</div>";
						echo "<div class='row '>";
							echo "<div class='col-12'>";

								echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' db='a_actividades/db_' fun='actividad_mover' des='a_actividades/modulos' v_idactividad='$key->idactividad' v_idtrack='$idtrack' v_dir='0' dix='trabajo' title='Arriba'><i class='fas fa-chevron-up'></i></button>";

								echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' db='a_actividades/db_' fun='actividad_mover' des='a_actividades/modulos' v_idactividad='$key->idactividad' v_idtrack='$idtrack' v_dir='1' dix='trabajo' title='Abajo'><i class='fas fa-chevron-down'></i></button>";

								echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' des='a_actividades/modulos' dix='trabajo' db='a_actividades/db_' fun='borrar_actividad' v_idactividad='$key->idactividad' v_idtrack='$idtrack' tp='¿Desea eliminar la actividad inicial seleccionada?' tt='Ya no podrá deshacer el cambio' title='Borrar'><i class='far fa-trash-alt'></i></button>";

								echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' db='a_actividades/db_' fun='actividad_duplicar' v_idactividad='$key->idactividad' v_idtrack='$idtrack' des='a_actividades/modulos' tp='¿Desea duplicar la actividad seleccionada?' title='Duplicar' dix='trabajo'><i class='far fa-clone'></i></button>";

								echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' des='a_actividades_e/actividad_editar' dix='trabajo' v_idactividad='$key->idactividad' v_idtrack='$idtrack'><i class='fas fa-pencil-alt'></i></button>";

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
								<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_actividades/actividad_ver" dix="trabajo" v_idactividad="<?php echo $key->idactividad; ?>" v_idtrack="<?php echo $idtrack; ?>">Ver</button>
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
	          echo "<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_actividades_e/actividad_editar' dix='trabajo' v_idactividad='0' v_idtrack='$idtrack'>Nueva Actividad inicial</button>";
	        echo "</div>";
	      echo "</div>";
	    echo "</div>";
		}
		?>

	</div>
</div>
