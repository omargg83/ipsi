<?php
	require_once("db_.php");
	$idterapia="";
	$idtrack=$_REQUEST['idtrack'];
	$idpaciente=$_REQUEST['idpaciente'];
	$visible="-1";
	if(isset($_REQUEST['visible'])){
		$visible=$_REQUEST['visible'];
	}
	
	/////////////////////breadcrumb
	$paciente = $db->cliente_editar($idpaciente);
	$nombre=$paciente->nombre." ".$paciente->apellidop." ".$paciente->apellidom;

	$sql="select * from track where id=:idtrack";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":idtrack",$idtrack);
	$sth->execute();
	$track=$sth->fetch(PDO::FETCH_OBJ);
	$inicial=$track->inicial;

	$sql="select * from terapias where id=$track->idterapia";
	$sth = $db->dbh->query($sql);
	$terapia=$sth->fetch(PDO::FETCH_OBJ);


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
if($inicial==1){
	echo "<div class='alert alert-warning text-center tituloventana' role='alert'>";
		echo "Grupos ";
	echo "</div>";


	$sql="select * from grupo_actividad_pre left outer join grupo_actividad on grupo_actividad.idgrupo=grupo_actividad_pre.idgrupo where grupo_actividad.idtrack=$track->id and grupo_actividad_pre.idpaciente=$idpaciente order by grupo_actividad.orden asc";
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
							/*Pendiente*/

							echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' des='a_pacientes/modulos' dix='trabajo' db='a_pacientes/db_' fun='borrar_grupo' v_idtrack='$key->idtrack' v_idgrupo='$key->idgrupo' v_idpaciente='$idpaciente' v_idper='$key->idper' tp='¿Desea eliminar el grupo seleccionado?' tt='Ya no podrá deshacer el cambio' title='Borrar'><i class='far fa-trash-alt'></i></button>";
							

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
								echo "<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_pacientes/grupos' dix='trabajo' v_idgrupo='$key->idgrupo' v_idpaciente='$idpaciente'>Ver</button>";
							echo "</div>";
						echo "</div>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		}

			echo "<div id='' class='col-4 p-3 w-50'>";
				echo "<div class='card' style='height:200px;'>";
					echo "<div class='card-body text-center'>";
						echo "<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_pacientes_e/grupo_agregar' dix='trabajo' v_idgrupo='0' v_idtrack='$idtrack' v_idpaciente='$idpaciente'>Agregar grupo</button>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
	echo "</div>";
}
if($inicial!=1){
	echo "<div class='alert alert-warning text-center tituloventana' role='alert'>";
		echo "Mis Modulos";
	echo "</div>";

	echo "<div class='container'>";
	  echo "<div class='row'>";
		///////////////////////CODIGO
		$sql="SELECT * from modulo_per left outer join modulo on modulo.id=modulo_per.idmodulo where modulo_per.idpaciente=$idpaciente and modulo.idtrack=$idtrack order by modulo.orden asc";
		$sth = $db->dbh->query($sql);
		$modulos=$sth->fetchAll(PDO::FETCH_OBJ);

		foreach($modulos as $key){

			echo "<div class='col-4 p-2 w-50 actcard'>";
				echo "<div class='card' style='height:400px'>";
					echo "<img style='vertical-align: bottom;border-radius: 10px;max-width: 70px;margin: 0 auto;padding: 10px;' src='img/lapiz.png'>";
					echo "<div class='card-header'>";
						echo $key->nombre;

						echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' des='a_pacientes/modulos' dix='trabajo' db='a_pacientes/db_' fun='quitar_modulo' v_idmodulo='$key->id' v_idtrack='$idtrack'  v_idpaciente='$idpaciente'  tp='¿Desea quitar el modulo seleccionado?' title='Borrar'><i class='far fa-trash-alt'></i></button>";

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
								echo "<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_pacientes/actividades' dix='trabajo' v_idmodulo='$key->id' v_idpaciente='$idpaciente'>Ver</button>";
							echo "</div>";
						echo "</div>";
					echo "</div>";
				echo "</div>";
			echo "</div>";

  		}

			echo "<div id='' class='col-4 p-3 w-50'>";
				echo "<div class='card' style='height:200px;'>";
					echo "<div class='card-body text-center'>";
						echo "<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_pacientes_e/modulos_agregar' dix='trabajo' v_idmodulo='0' v_idtrack='$idtrack'  v_idpaciente='$idpaciente' >Agregar modulo</button>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		}

	echo "</div>";
echo "</div>";
?>
