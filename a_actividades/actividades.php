<?php
	require_once("db_.php");
	$idmodulo=$_REQUEST['idmodulo'];

	$modulo=$db->modulo_editar($idmodulo);
	$track=$db->track_editar($modulo->idtrack);
	$terapia=$db->terapia_editar($track->idterapia);

	$sql="SELECT * from grupo_actividad where grupo_actividad.idmodulo=$idmodulo order by grupo_actividad.orden asc";
	$sth = $db->dbh->query($sql);
	$respx=$sth->fetchAll(PDO::FETCH_OBJ);
	$orden=0;
	foreach($respx as $row){
		$arreglo =array();
		$arreglo+=array('orden'=>$orden);
		$x=$db->update('grupo_actividad',array('idgrupo'=>$row->idgrupo), $arreglo);
		$orden++;
	}

?>

<nav aria-label='breadcrumb'>
	<ol class='breadcrumb'>
		<li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/terapias" dix="trabajo" id1="">Inicio</lis>
		<li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/track" dix="trabajo" title="Track" v_idterapia="<?php echo $terapia->id; ?>"><?php echo $terapia->nombre; ?></li>
		<li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/modulos" dix="trabajo" v_idtrack="<?php echo $track->id; ?>" ><?php echo $track->nombre; ?></li>
		<li class="breadcrumb-item active" type="button" is="li-link" des="a_actividades/actividades" dix="trabajo" v_idmodulo="<?php echo $modulo->id; ?>" ><?php echo $modulo->nombre; ?></li>
		<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_actividades/modulos" dix="trabajo" v_idtrack="<?php echo $track->id; ?>">Regresar</button>
	</ol>
</nav>

<?php

	echo "<div class='alert alert-warning text-center tituloventana' role='alert'>";
		echo "Grupos ";
	echo "</div>";


	$sql="select * from grupo_actividad where idmodulo=$modulo->id order by orden asc";
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

								echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' db='a_actividades/db_' fun='grupo_mover' des='a_actividades/actividades' v_idmodulo='$key->idmodulo' v_idgrupo='$key->idgrupo' v_dir='0' dix='trabajo' title='Arriba'><i class='fas fa-chevron-up'></i></button>";

								echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' db='a_actividades/db_' fun='grupo_mover' des='a_actividades/actividades' v_idmodulo='$key->idmodulo' v_idgrupo='$key->idgrupo' v_dir='1' dix='trabajo' title='Abajo'><i class='fas fa-chevron-down'></i></button>";

								echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' des='a_actividades/actividades' dix='trabajo' db='a_actividades/db_' fun='borrar_grupo' v_idmodulo='$key->idmodulo' v_idgrupo='$key->idgrupo' tp='¿Desea eliminar el grupo seleccionado?' tt='Ya no podrá deshacer el cambio' title='Borrar'><i class='far fa-trash-alt'></i></button>";

								echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' des='a_actividades_e/grupo_editar' dix='trabajo' v_idmodulo='$key->idmodulo' v_idgrupo='$key->idgrupo'><i class='fas fa-pencil-alt'></i></button>";
								
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
						echo "<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_actividades_e/grupo_editar' dix='trabajo' v_idgrupo='0' v_idmodulo='$idmodulo'>Nuevo grupo</button>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
	echo "</div>";
?>
