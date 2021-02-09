<?php
	require_once("db_.php");

	$idactividad=$_REQUEST['idactividad'];
	$idpaciente=$_SESSION['idusuario'];

	if(isset($_REQUEST['pagina'])){
		$pagina=$_REQUEST['pagina'];
	}
	else{
		$pagina=0;
	}
	/////////////////paginas
	$sql="SELECT contexto.pagina FROM contexto
	left outer join subactividad on subactividad.idsubactividad=contexto.idsubactividad
	left outer join actividad on actividad.idactividad=subactividad.idactividad
	where actividad.idactividad=$idactividad group by pagina";
	$sth = $db->dbh->query($sql);
	$no_paginas=$sth->rowCount();

	/////////////////////breadcrumb
	$paciente = $db->cliente_editar($idpaciente);
	$nombre=$paciente->nombre." ".$paciente->apellidop." ".$paciente->apellidom;

	$sql="select * from actividad where idactividad=$idactividad";
	$sth = $db->dbh->query($sql);
	$actividad=$sth->fetch(PDO::FETCH_OBJ);

	$inicial=0;
	if($actividad->idtrack){
		$inicial=1;
		$idtrack=$actividad->idtrack;
	}
	else{
		$sql="select * from modulo where id=$actividad->idmodulo";
		$sth = $db->dbh->query($sql);
		$modulo=$sth->fetch(PDO::FETCH_OBJ);
		$idtrack=$modulo->idtrack;

	}
	$sql="select * from track where id=$idtrack";
	$sth = $db->dbh->query($sql);
	$track=$sth->fetch(PDO::FETCH_OBJ);
	$idterapia=$track->idterapia;

	$sql="select * from terapias where id=$idterapia";
	$sth = $db->dbh->query($sql);
	$terapia=$sth->fetch(PDO::FETCH_OBJ);

	$nombre_act=$actividad->nombre;
	$observaciones=$actividad->observaciones;
	$indicaciones=$actividad->indicaciones;
	$anotaciones=$actividad->anotaciones;


	/////////////////subactividades
	$sql="(SELECT subactividad.* FROM contexto
	left outer join subactividad on subactividad.idsubactividad=contexto.idsubactividad
	where subactividad.idactividad=$idactividad and contexto.pagina=$pagina group by idsubactividad order by subactividad.orden asc)";
	if($pagina==($no_paginas-1)){
		$sql.="UNION (
		SELECT subactividad.* FROM subactividad
		left outer join contexto on subactividad.idsubactividad=contexto.idsubactividad
		where subactividad.idactividad=$idactividad and contexto.id is null order by subactividad.orden asc
		)";
	}
	$sth = $db->dbh->query($sql);
	$subactividad=$sth->fetchAll(PDO::FETCH_OBJ);


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
	<div class="card mb-3">
		<div class="card-header" id="headingOne">
			<div class='row'>
				<div class="col-12 text-center">
					Actividad: <?php echo $nombre_act; ?>
					<?php
						$sql="SELECT count(contexto.id) as total from contexto
						left outer join subactividad on subactividad.idsubactividad=contexto.idsubactividad
						where subactividad.idactividad=$idactividad and (contexto.tipo='pregunta' or contexto.tipo='textores'  or contexto.tipo='textocorto' or contexto.tipo='fecha'  or contexto.tipo='archivores')";
						$contx = $db->dbh->query($sql);
						$bloques=$contx->fetch(PDO::FETCH_OBJ);

						$sql="SELECT count(contexto_resp.id) as total FROM	contexto
						right OUTER JOIN contexto_resp ON contexto_resp.idcontexto=contexto.id
						left outer join subactividad on subactividad.idsubactividad=contexto.idsubactividad
						where subactividad.idactividad=$idactividad
						group by contexto.id";
						$contx = $db->dbh->query($sql);
						$total=0;
						if($contx->rowCount()){
							$total=(100*$contx->rowCount())/$bloques->total;
						}
						echo "<div id='prog_$idactividad'>";
							echo "(".$contx->rowCount()."/".$bloques->total.")<br>";
							echo "<progress id='file' value='$total' max='100'> $total %</progress>";
						echo "</div>";
					?>
				</div>
			</div>
		</div>
			<div class='card-body'>
				<p>Indicaciones</p>
				<?php echo $indicaciones; ?>
			</div>
	</div>
<!-- Fin de actividad  -->

<?php
	foreach($subactividad as $key){
		//////////<!-- Subactividad  -->
		echo "<div class='card mt-3 ml-3'>";
			echo "<div class='card-header' style='background-color:#f9eec1;'>";
				echo "<div class='row'>";
					echo "<div class='col-12 text-center'>";
						echo $key->orden." Subactividad: $key->nombre";
						$sql="SELECT count(contexto.id) as total from contexto where idsubactividad = $key->idsubactividad and (contexto.tipo='pregunta' or contexto.tipo='textores' or contexto.tipo='textocorto' or contexto.tipo='fecha'  or contexto.tipo='archivores')";
						$contx = $db->dbh->query($sql);
						$bloques=$contx->fetch(PDO::FETCH_OBJ);

						$sql="SELECT count(contexto_resp.id) as total FROM	contexto right OUTER JOIN contexto_resp ON contexto_resp.idcontexto=contexto.id WHERE	idsubactividad = $key->idsubactividad	group by contexto.id";
						$contx = $db->dbh->query($sql);
						$total=0;
						if($contx->rowCount()){
							$total=(100*$contx->rowCount())/$bloques->total;
						}
						echo "<div id='progreso_$key->idsubactividad'>";
							echo "(".$contx->rowCount()."/".$bloques->total.")<br>";
							echo "<progress id='file' value='$total' max='100'> $total %</progress>";
						echo "</div>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
		/////////////////<!-- fin de Subactividad  -->

		/////////////<!-- Contexto  -->
		//$bloq=$db->contexto_ver($key->idsubactividad);

		$sql="select * from contexto where idsubactividad=$key->idsubactividad and pagina=$pagina order by orden asc";
		$sth = $db->dbh->query($sql);
		$bloq=$sth->fetchAll(PDO::FETCH_OBJ);
		foreach($bloq as $row){
			echo "<div id='con_$row->id'>";
				$db->contexto_respuesta($row->id, $idactividad, $idpaciente);
			echo "</div>";
		}
	}

	$variables['idactividad']=$idactividad;
	echo $db->paginar_x($no_paginas,$pagina,"a_respuesta/actividad_ver","contenido",$variables);

echo "</div>";
?>
