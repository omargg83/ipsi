<?php
	require_once("db_.php");
  $idtrack=$_REQUEST['idtrack'];


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
	?>

 <div class='container'>
  <div class='row'>
  <?php
  	foreach($modulos as $key){
  ?>
		<div class='col-4 p-2 w-50 actcard'>
			<div class='card' style='height:400px'>
					<img style="vertical-align: bottom;border-radius: 10px;max-width: 70px;margin: 0 auto;padding: 10px;" src="img/lapiz.png">
					<div class='card-header'>
					<?php
						echo "<div class='row'>";
							echo "<div class='col-12 text-center'>";
								echo $key->nombre;
							echo "</div>";
						echo "</div>";
						echo "<div class='row justify-content-end'>";
							echo "<div class='col-5'>";

								echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' des='a_actividades/modulos' dix='trabajo' db='a_actividades/db_' fun='borrar_modulo' v_idmodulo='$key->id' v_idtrack='$idtrack' tp='¿Desea eliminar el modulo selecionado?' title='Borrar'><i class='far fa-trash-alt'></i></button>";

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

		$actividad=$db->actividad_inicial($idtrack);
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
						echo "<div class='row justify-content-end'>";
							echo "<div class='col-5'>";

								echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/actividad_editar' dix='trabajo' v_idactividad='$key->idactividad' v_idtrack='$idtrack'><i class='fas fa-pencil-alt'></i></button>";

								echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' db='a_actividades/db_' fun='actividad_duplicar' v_idactividad='$key->idactividad' v_idtrack='$idtrack' des='a_actividades/modulos' tp='¿Desea duplicar la actividad seleccionada?' title='Duplicar' dix='trabajo'><i class='far fa-clone'></i></button>";

								echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades/modulos' dix='trabajo' db='a_actividades/db_' fun='borrar_actividad' v_idactividad='$key->idactividad' v_idtrack='$idtrack' tp='¿Desea eliminar la actividad inicial seleccionada?' title='Borrar'><i class='far fa-trash-alt'></i></button>";

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
