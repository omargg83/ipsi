<?php
	require_once("db_.php");

	$idactividad=$_REQUEST['idactividad'];
	$idpaciente=$_SESSION['idusuario'];

	/////////////////////breadcrumb
	$paciente = $db->cliente_editar($idpaciente);
	$nombre=$paciente->nombre." ".$paciente->apellidop." ".$paciente->apellidom;

	$sql="select * from actividad where idactividad=:idactividad";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":idactividad",$idactividad);
	$sth->execute();
	$actividad=$sth->fetch(PDO::FETCH_OBJ);

	$inicial=0;
	if($actividad->idtrack){
		$inicial=1;
		$idtrack=$actividad->idtrack;
	}
	else{
		$sql="select * from modulo where id=:idmodulo";
		$sth = $db->dbh->prepare($sql);
		$sth->bindValue(":idmodulo",$actividad->idmodulo);
		$sth->execute();
		$modulo=$sth->fetch(PDO::FETCH_OBJ);
		$idtrack=$modulo->idtrack;

	}
	$sql="select * from track where id=:idtrack";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":idtrack",$idtrack);
	$sth->execute();
	$track=$sth->fetch(PDO::FETCH_OBJ);
	$idterapia=$track->idterapia;

	$sql="select * from terapias where id=:idterapia";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":idterapia",$idterapia);
	$sth->execute();
	$terapia=$sth->fetch(PDO::FETCH_OBJ);

	$nombre_act=$actividad->nombre;
	$observaciones=$actividad->observaciones;
	$indicaciones=$actividad->indicaciones;
	$anotaciones=$actividad->anotaciones;
	$subactividad = $db->subactividad_ver($idactividad);
?>
<nav aria-label='breadcrumb'>
 <ol class='breadcrumb'>

	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_respuesta/terapias"  dix="contenido">Terapias</li>
	 <li class="breadcrumb-item" id='lista_track' is="li-link" des="a_respuesta/track" dix="contenido" v_idterapia="<?php echo $terapia->id; ?>" ><?php echo $terapia->nombre; ?></li>
	 <?php
	 if($inicial==0){
	?>
		 <li class="breadcrumb-item" id='lista_track' is="li-link" des="a_respuesta/modulos" dix="contenido" v_idtrack="<?php echo $track->id; ?>" ><?php echo $track->nombre; ?></li>
		 <li class="breadcrumb-item" id='lista_track' is="li-link" des="a_respuesta/actividades" dix="contenido" v_idmodulo="<?php echo $modulo->id; ?>" ><?php echo $modulo->nombre; ?></li>
		<?php
	 }
	 ?>
	 <li class="breadcrumb-item active" id='lista_track' is="li-link" des="a_respuesta/actividad_ver" dix="contenido" v_idactividad="<?php echo $idactividad; ?>" ><?php echo $nombre_act; ?></li>

		 <?php
		 if($inicial==0){
		 ?>
		 <button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_respuesta/actividades" dix="contenido" v_idmodulo="<?php echo $modulo->id; ?>" >Regresar</button>
		 <?php
		 }
		 else{
		 ?>
		 	<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_respuesta/track" dix="contenido" v_idterapia="<?php echo $idterapia; ?>" >Regresar</button>
		 <?php
		 }
		 ?>
 </ol>
</nav>

<!-- actividad  -->
<div class="container">
<div id="accordion">
	<div class="card mt-3">
		<div class="card-header" id="headingOne">
			<div class='row'>
				<div class="col-12 text-center">
					<button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						Actividad: <?php echo $nombre_act; ?>
						<?php
							$sql="SELECT count(contexto.id) as total from contexto
							left outer join subactividad on subactividad.idsubactividad=contexto.idsubactividad
							where subactividad.idactividad=:id and (contexto.tipo='pregunta' or contexto.tipo='textores'  or contexto.tipo='textocorto' or contexto.tipo='fecha'  or contexto.tipo='archivores')";
							$contx = $db->dbh->prepare($sql);
							$contx->bindValue(":id",$idactividad);
							$contx->execute();
							$bloques=$contx->fetch(PDO::FETCH_OBJ);

							$sql="SELECT count(contexto_resp.id) as total FROM	contexto
							right OUTER JOIN contexto_resp ON contexto_resp.idcontexto=contexto.id
							left outer join subactividad on subactividad.idsubactividad=contexto.idsubactividad
							where subactividad.idactividad=:id
							group by contexto.id";
							$contx = $db->dbh->prepare($sql);
							$contx->bindValue(":id",$idactividad);
							$contx->execute();
							$total=0;
							if($contx->rowCount()){
								$total=(100*$contx->rowCount())/$bloques->total;
							}
							echo "<div id='prog_$idactividad'>";
								echo "(".$contx->rowCount()."/".$bloques->total.")<br>";
								echo "<progress id='file' value='$total' max='100'> $total %</progress>";
							echo "</div>";
						?>

					</button>
				</div>
			</div>
		</div>

		<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
			<div class='card-body'>
				<p>Indicaciones</p>
				<?php echo $indicaciones; ?>
			</div>
		</div>
	</div>
</div>
<!-- Fin de actividad  -->


<?php
	foreach($subactividad as $key){

	//////////<!-- Subactividad  -->
	echo "<div class='container-fluid mt-4' id='sub_$key->idsubactividad'>";
		echo "<div class='card' >";
		echo "<div class='card-header'>";
			echo "<div class='row'>";
				echo "<div class='col-12 text-center'>";
						echo "<button class='btn btn-link' data-toggle='collapse' data-target='#collapsesub_$key->idsubactividad' aria-expanded='true' aria-controls='collapsesub_$key->idsubactividad'>";
							echo $key->orden." Subactividad: $key->nombre";
								$sql="SELECT count(contexto.id) as total from contexto where idsubactividad = $key->idsubactividad and (contexto.tipo='pregunta' or contexto.tipo='textores' or contexto.tipo='textocorto' or contexto.tipo='fecha'  or contexto.tipo='archivores')";
								$contx = $db->dbh->prepare($sql);
								$contx->execute();
								$bloques=$contx->fetch(PDO::FETCH_OBJ);

								$sql="SELECT count(contexto_resp.id) as total FROM	contexto right OUTER JOIN contexto_resp ON contexto_resp.idcontexto=contexto.id WHERE	idsubactividad = :id	group by contexto.id";
								$contx = $db->dbh->prepare($sql);
								$contx->bindValue(":id",$key->idsubactividad);
								$contx->execute();
								$total=0;
								if($contx->rowCount()){
									$total=(100*$contx->rowCount())/$bloques->total;
								}
								echo "<div id='progreso_$key->idsubactividad'>";
								echo "(".$contx->rowCount()."/".$bloques->total.")<br>";
								echo "<progress id='file' value='$total' max='100'> $total %</progress>";
								echo "</div>";
						echo "</button>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
		/////////////////<!-- fin de Subactividad  -->

		/////////////<!-- Contexto  -->
		echo "<div id='collapsesub_$key->idsubactividad' class='collapse show' aria-labelledby='headingOne' data-parent='#accordion'>";
			echo "<div class='card-body' id='bloque'>";
				$bloq=$db->contexto_ver($key->idsubactividad);
				foreach($bloq as $row){
					echo "<div id='con_$row->id'>";
						$db->contexto_respuesta($row->id, $idactividad, $idpaciente);
					echo "</div>";
				}
				echo "</div>";
			echo "</div>";
		echo "</div>";
		echo "</div>";
	}
echo "</div>";
?>

<script type="text/javascript">
	$(function() {
		setTimeout(function(){ carga_editor(); }, 1000);
		function carga_editor(){
			$('.texto').summernote({
				lang: 'es-ES',
				placeholder: 'Texto',
				tabsize: 5,
				height: 250,
				toolbar: [
			    // [groupName, [list of button]]
			    ['style', ['bold', 'italic', 'underline', 'clear']],
			    ['font', ['strikethrough', 'superscript', 'subscript']],
			    ['fontsize', ['fontsize']],
			    ['color', ['color']],
			    ['para', ['ul', 'ol', 'paragraph']],
			    ['height', ['height']]
			  ]
			});
		}
	});
</script>
