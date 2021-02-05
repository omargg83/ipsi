<?php
	require_once("db_.php");
	$idmodulo=$_REQUEST['idmodulo'];

	$visible="-1";
	if(isset($_REQUEST['visible'])){
		$visible=$_REQUEST['visible'];
	}

	$modulo=$db->modulo_editar($idmodulo);
	$track=$db->track_editar($modulo->idtrack);
	$terapia=$db->terapia_editar($track->idterapia);

	$sql="select * from actividad where idmodulo=:id and idpaciente is null";
	if($visible>=0)
	$sql.=" and actividad.visible=:visible";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":id",$idmodulo);
	if($visible>=0)
	$sth->bindValue(":visible",$visible);
	$sth->execute();
	$actividad = $sth->fetchAll(PDO::FETCH_OBJ);

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

<div class="alert alert-warning text-center tituloventana" role="alert">
	Actividades
</div>

<?php
	/////////////////filtro

	echo "<div class='container' id='filtro'>";
		echo "<form id='filtro_form' des='a_actividades/actividades'>";
			echo "<input type='hidden' name='idmodulo' id='idmodulo' value='$idmodulo'>";
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
		foreach($actividad as $key){
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
								echo "<div class='col-5'>";

									echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/actividad_editar' dix='trabajo' v_idactividad='$key->idactividad' v_idmodulo='$idmodulo' v_origen='actividades'><i class='fas fa-pencil-alt'></i></button>";

									echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' db='a_actividades/db_' fun='actividad_duplicar' v_idactividad='$key->idactividad' v_idmodulo='$idmodulo' des='a_actividades/actividades' tp='¿Desea duplicar la actividad seleccionada?' title='Duplicar' dix='trabajo'><i class='far fa-clone'></i></button>";

									echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades/actividades' dix='trabajo' db='a_actividades/db_' fun='borrar_actividad' v_idactividad='$key->idactividad' v_idmodulo='$idmodulo' tp='¿Desea eliminar la actividad seleccionada?' title='Borrar'><i class='far fa-trash-alt'></i></button>";

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
					<div class='card-footer'>
						<div class='row'>
							<div class='col-12'>
								<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_actividades/actividad_ver" dix="trabajo" v_idactividad="<?php echo $key->idactividad; ?>" >Ver</button>
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
					<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_actividades_e/actividad_editar" dix="trabajo" v_idactividad="0" v_idmodulo="<?php echo $idmodulo; ?>" >Nueva actividad</button>
				</div>
			</div>
		</div>
	</div>
</div>
