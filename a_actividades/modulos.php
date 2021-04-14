<?php
	require_once("db_.php");
  	$idtrack=$_REQUEST['idtrack'];

	$visible="-1";
	if(isset($_REQUEST['visible'])){
		$visible=$_REQUEST['visible'];
	}

	
	/////////////////ordenar modulos
	$sql="SELECT * from grupo_actividad where grupo_actividad.idtrack=$idtrack order by grupo_actividad.orden asc";
	$sth = $db->dbh->query($sql);
	$respx=$sth->fetchAll(PDO::FETCH_OBJ);

	$orden=0;
	foreach($respx as $row){
		$arreglo =array();
		$arreglo+=array('orden'=>$orden);
		$x=$db->update('grupo_actividad',array('idgrupo'=>$row->idgrupo), $arreglo);
		$orden++;
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
			echo "Grupos ";
		echo "</div>";


		$sql="select * from grupo_actividad where idtrack=$track->id order by grupo_actividad.orden asc";
		$sth = $db->dbh->query($sql);
		$grupos=$sth->fetchAll(PDO::FETCH_OBJ);
		echo "<div class='container'>";
			echo "<div class='row'>";
			foreach($grupos as $key){
				echo "<div class='col-4 p-2 w-50 actcard'>";
					echo "<div class='card' style='height:400px'>";
						echo "<div class='card-header'>";
							echo "<div class='row'>";
								echo "<div class='col-12'>";
									echo $key->grupo;
								echo "</div>";
							echo "</div>";
							echo "<div class='row'>";
								echo "<div class='col-12'>";

									echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' db='a_actividades/db_' fun='grupo_mover' des='a_actividades/modulos' v_idtrack='$key->idtrack' v_idgrupo='$key->idgrupo' v_dir='0' dix='trabajo' title='Arriba'><i class='fas fa-chevron-up'></i></button>";

									echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' db='a_actividades/db_' fun='grupo_mover' des='a_actividades/modulos' v_idtrack='$key->idtrack' v_idgrupo='$key->idgrupo' v_dir='1' dix='trabajo' title='Abajo'><i class='fas fa-chevron-down'></i></button>";

									echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' des='a_actividades/modulos' dix='trabajo' db='a_actividades/db_' fun='borrar_grupo' v_idtrack='$key->idtrack' v_idgrupo='$key->idgrupo' tp='¿Desea eliminar el grupo seleccionado?' tt='Ya no podrá deshacer el cambio' title='Borrar'><i class='far fa-trash-alt'></i></button>";

									echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' des='a_actividades_e/grupo_editar' dix='trabajo' v_idtrack='$key->idtrack' v_idgrupo='$key->idgrupo'><i class='fas fa-pencil-alt'></i></button>";

								echo "</div>";
							echo "</div>";
						echo "</div>";
						echo "<div class='card-body' style='overflow:auto; height:220px'>";
							echo "<div class='row'>";
								echo "<div class='col-12'>";
									echo $key->observaciones;
								echo "</div>";
							echo "</div>";
						echo "</div>";
						echo "<div class='card-body'>";
							echo "<div class='row'>";
								echo "<div class='col-12'>";
									echo "<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_actividades/grupos' dix='trabajo' v_idgrupo='$key->idgrupo'>Ver</button>";
								echo "</div>";
							echo "</div>";
						echo "</div>";
					echo "</div>";
				echo "</div>";
			}
		
				echo "<div id='' class='col-4 p-3 w-50'>";
					echo "<div class='card' style='height:200px;'>";
						echo "<div class='card-body text-center'>";
							echo "<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_actividades_e/grupo_editar' dix='trabajo' v_idgrupo='0' v_idtrack='$idtrack'>Nuevo grupo</button>";
						echo "</div>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
	}


	if($inicial!=1){
		echo "<div class='alert alert-warning text-center tituloventana' role='alert'>";
			echo "Modulos";
		echo "</div>";

		echo "<div class='container'>";
			echo "<div class='row'>";
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
									echo "<div class='col-12'>";

										echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' db='a_actividades/db_' fun='modulos_mover' des='a_actividades/modulos' v_idmodulo='$key->id' v_idtrack='$idtrack' v_dir='0' dix='trabajo' title='Arriba'><i class='fas fa-chevron-up'></i></button>";

										echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' db='a_actividades/db_' fun='modulos_mover' des='a_actividades/modulos' v_idmodulo='$key->id' v_idtrack='$idtrack' v_dir='1' dix='trabajo' title='Abajo'><i class='fas fa-chevron-down'></i></button>";

										echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' des='a_actividades/modulos' dix='trabajo' db='a_actividades/db_' fun='borrar_modulo' v_idmodulo='$key->id' v_idtrack='$idtrack' tp='¿Desea eliminar el modulo selecionado?' tt='Ya no podrá deshacer el cambio' title='Borrar'><i class='far fa-trash-alt'></i></button>";

										echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' des='a_actividades_e/modulos_editar' dix='trabajo' v_idmodulo='$key->id' v_idtrack='$idtrack'><i class='fas fa-pencil-alt'></i></button>";

									echo "</div>";
								echo "</div>";
							echo "</div>";
						
							echo "<div class='card-body' style='overflow:auto; height:220px'>";
								echo "<div class='row'>";
									echo "<div class='col-12'>";
										echo $key->descripcion;
									echo "</div>";
								echo "</div>";
							echo "</div>";
							
							echo "<div class='card-body'>";
								echo "<div class='row'>";
									echo "<div class='col-12'>";
										echo "<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_actividades/actividades' dix='trabajo' v_idmodulo='$key->id'  v_idtrack='$idtrack'>Ver</button>";
									echo "</div>";
								echo "</div>";
							echo "</div>";
							
						echo "</div>";
					echo "</div>";
				}
				echo "<div id='' class='col-4 p-3 w-50'>";
					echo "<div class='card' style='height:200px;'>";
						echo "<div class='card-body text-center'>";
							echo "<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_actividades_e/modulos_editar' dix='trabajo' v_idmodulo='0' v_idtrack='$idtrack' >Nuevo modulo</button>";
						echo "</div>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
	}
	
?>	