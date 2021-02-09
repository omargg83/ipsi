<?php
	require_once("db_.php");

	$idactividad=clean_var($_REQUEST['idactividad']);
  $actividad = $db->actividad_editar($idactividad);

	if(isset($_REQUEST['pagina'])){
		$pagina=$_REQUEST['pagina'];
	}
	else{
		$pagina=0;
	}

	///////paginas
	$sql="SELECT contexto.pagina FROM contexto
	left outer join subactividad on subactividad.idsubactividad=contexto.idsubactividad
	left outer join actividad on actividad.idactividad=subactividad.idactividad
	where actividad.idactividad=$idactividad group by pagina";
	$sth = $db->dbh->query($sql);
	$no_paginas=$sth->rowCount();
	$paginas=$sth->fetch(PDO::FETCH_OBJ);

	$nombre=$actividad->nombre;
	$observaciones=$actividad->observaciones;
	$indicaciones=$actividad->indicaciones;
	$inicial=0;

	if($actividad->idtrack){
		$inicial=1;
		$idtrack=$actividad->idtrack;
	}
	else{
		$modulo = $db->modulo_editar($actividad->idmodulo);
		$idtrack=$modulo->idtrack;
	}
	$track=$db->track_editar($idtrack);
	$idterapia=$track->idterapia;
	$terapia=$db->terapia_editar($idterapia);

	/////////////////ordenar subactividad
	$sql="SELECT * from subactividad where subactividad.idactividad=$idactividad order by subactividad.orden asc, subactividad.nombre asc";
	$sth = $db->dbh->query($sql);
	$respx=$sth->fetchAll(PDO::FETCH_OBJ);

	$orden=0;
	foreach($respx as $row){
		$arreglo =array();
		$arreglo+=array('orden'=>$orden);
		$x=$db->update('subactividad',array('idsubactividad'=>$row->idsubactividad), $arreglo);
		$orden++;
	}

	///////////para ordenar contextos
	$sql="SELECT contexto.* FROM contexto
	left outer join subactividad on subactividad.idsubactividad=contexto.idsubactividad
	left outer join actividad on actividad.idactividad=subactividad.idactividad
	where actividad.idactividad=$idactividad order by subactividad.orden asc, contexto.orden asc";
	$sth = $db->dbh->query($sql);
	$respx=$sth->fetchAll(PDO::FETCH_OBJ);

	$orden=0;
	$idsubx=0;
	foreach($respx as $row){
		if($idsubx!=$row->idsubactividad){
			$orden=0;
			$idsubx=$row->idsubactividad;
		}
		$arreglo =array();
		$arreglo+=array('orden'=>$orden);
		$x=$db->update('contexto',array('id'=>$row->id), $arreglo);
		$orden++;
	}


	/////////////////subactividades
	$sql="SELECT subactividad.* FROM contexto
	left outer join subactividad on subactividad.idsubactividad=contexto.idsubactividad
	where subactividad.idactividad=$idactividad and contexto.pagina=$pagina group by idsubactividad order by subactividad.orden asc";
	$sth = $db->dbh->query($sql);
	$subactividad=$sth->fetchAll(PDO::FETCH_OBJ);
?>

<nav aria-label='breadcrumb'>
	<ol class='breadcrumb'>
		<li class="breadcrumb-item" is="li-link" des="a_actividades/terapias" dix="trabajo" id1="">Inicio</li>
		<li class="breadcrumb-item" is="li-link" des="a_actividades/track" dix="trabajo" title="Track" v_idterapia="<?php echo $terapia->id; ?>"><?php echo $terapia->nombre; ?></li>
		<li class="breadcrumb-item" is="li-link" des="a_actividades/modulos" dix="trabajo" v_idtrack="<?php echo $track->id; ?>" ><?php echo $track->nombre; ?></li>
		<?php
			if($inicial==0){
		?>
			<li class="breadcrumb-item" is="li-link" des="a_actividades/actividades" dix="trabajo" v_idmodulo="<?php echo $modulo->id; ?>" ><?php echo $modulo->nombre; ?></li>
		<?php
			}
		 ?>
		<li class="breadcrumb-item active" is="li-link" des="a_actividades/actividad_ver" dix="trabajo" v_idactividad="<?php echo $actividad->idactividad; ?>" ><?php echo $actividad->nombre; ?></li>
		<?php
			if($inicial==0){
				echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades/actividades' dix='trabajo' v_idmodulo='$modulo->id'>Regresar</button>";
			}
			else{
				echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades/modulos' dix='trabajo' v_idtrack='$idtrack' >Regresar</button>";
			}
		?>
	</ol>
</nav>

<div class='container'>
<!-- actividad  -->
	<div class="card mb-3">
			<div class="card-header" id="headingOne">
				<div class='row'>
					<div class="col-2">
						<!---Editar actividad -->
						<?php

						if($inicial==0){
							echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/actividad_editar' dix='trabajo' v_idactividad='$idactividad' v_idmodulo='$actividad->idmodulo' ><i class='fas fa-pencil-alt'></i></button>";
						}
						else{
							echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/actividad_editar' dix='trabajo' v_idactividad='$idactividad' v_idterapia='$idterapia' ><i class='fas fa-pencil-alt'></i></button>";
						}
						if($actividad->tipo=="evaluacion"){
							echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/escala2' v_idactividad='$idactividad' omodal='1' v_idescala='0'><i class='fas fa-file-medical-alt'></i></button>";
						}
					?>

					</div>
					<div class="col-9 text-left">
						Actividad: <?php echo $nombre; ?> 	(<?php echo $actividad->tipo; ?>)
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
	$orden=0;
	foreach($subactividad as $key){
		//<!-- Subactividad  -->
		echo "<div class='card mb-1 ml-3'>";
			echo "<div class='card-header' style='background-color:#f9eec1;'>";
				echo "<div class='row'>";
					echo "<div class='col-2'>";
						//<!-- Editar subactividad --->
						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/subactividad_editar' v_idsubactividad='$key->idsubactividad' v_idactividad='$idactividad' omodal='1'><i class='fas fa-pencil-alt'></i></button>";

						//////////////////clonar
						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='subactividad_duplicar' v_idactividad='$idactividad' v_idsubactividad='$key->idsubactividad' tp='¿Desea duplicar la subactividad?' title='Duplicar'><i class='far fa-clone'></i></button>";

						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='subactividad_borrar' v_idactividad='$idactividad' v_idsubactividad='$key->idsubactividad' tp='¿Desea eliminar la subactividad: \"$key->nombre\"?' tt='Ya no podrá deshacer el cambio' title='Borrar'><i class='far fa-trash-alt'></i></button>";

						if($actividad->tipo=='evaluacion'){
							echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/escala' v_idactividad='$idactividad' omodal='1' v_idescala='0' v_idsubactividad='$key->idsubactividad'><i class='fas fa-chart-line'></i></button>";
						}

					echo "</div>";
					echo "<div class='col-9' >";
						echo 'Subactividad: '; echo $key->nombre;
					echo "</div>";

					echo "<div class='col-1'>";
						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' db='a_actividades/db_' fun='arriba' des='a_actividades/actividad_ver' v_idactividad='$idactividad'><i class='fas fa-sort-up'></i></button>";
						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' db='a_actividades/db_' fun='arriba' des='a_actividades/actividad_ver' v_idactividad='$idactividad'><i class='fas fa-sort-down'></i></button>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
		//<!-- fin de Subactividad  -->
		//<!-- Contexto  -->
		$sql="select * from contexto where idsubactividad=$key->idsubactividad and pagina=$pagina order by orden asc";
		$sth = $db->dbh->query($sql);
		$bloq=$sth->fetchAll(PDO::FETCH_OBJ);
		foreach($bloq as $row){
			echo "<div id='con_$row->id'>";
				echo "<div class='card mt-2 ml-5'>";
				echo "<div class='card-header'>";
					echo "<div class='row'>";
						echo "<div class='col-3'>";
							//////////////////<!-- Editar Contexto --->
							echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/contexto_editar' v_idcontexto='$row->id' omodal='1'><i class='fas fa-pencil-alt'></i></button>";

							///////////////editar incisos
							if($row->tipo=="pregunta"){
								echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/incisos_lista' v_idcontexto='$row->id' v_idactividad='$idactividad' omodal='1'><i class='fas fa-tasks'></i></button>";
							}

							echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='contexto_duplicar' v_idactividad='$idactividad' v_idcontexto='$row->id' tp='¿Desea duplicar el bloque?' title='Borrar'><i class='far fa-copy'></i></button>";

							echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='contexto_borrar' v_idactividad='$idactividad' v_idcontexto='$row->id' tp='¿Desea eliminar el bloque seleccionado?' tt='Ya no podrá deshacer el cambio' title='Borrar'><i class='far fa-trash-alt'></i></button>";

							echo "<button "; if($row->idcond){ echo "class='btn btn-danger btn-sm'"; } else { echo "class='btn btn-warning btn-sm'"; } echo "type='button' is='b-link' des='a_actividades_e/condicional_editar' v_idactividad='$idactividad' omodal='1' v_idcontexto='$row->id'><i class='fas fa-project-diagram'></i></button>";

							echo "<button "; if($row->salto){ echo "class='btn btn-danger btn-sm' "; } else { echo "class='btn btn-warning btn-sm'"; } echo " type='button' is='b-link' des='a_actividades/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='salto_pagina' tp='¿Desea";
							if(!$row->salto){ echo " insertar ";} else{ echo " quitar el ";}
							echo "salto de pagina?' v_idactividad='$idactividad' v_idcontexto='$row->id' v_salto='$row->salto' title='Borrar'><i class='far fa-sticky-note'></i></button>";

						echo "</div>";
						echo "<div class='col-9 text-center'>";
								echo "Contexto ($row->tipo)";
						echo "</div>";
					echo "</div>";
				echo "</div>";

						echo "<div class='card-body'>";

							if(strlen($row->observaciones)>0){
								echo "<div>";
									echo "<p>".$row->observaciones."</p>";
								echo "</div>";
								echo "<hr>";
							}

							if($row->tipo=="imagen"){
								echo "<div>";
									echo "<img src='".$db->doc.$row->texto."'/>";
									echo "<hr>";
								echo "</div>";
							}
							else if($row->tipo=="texto"){
								echo "<div>";
									echo $row->texto;
									echo "<hr>";
								echo "</div>";
							}
							else if($row->tipo=="video"){
								echo "<div>";
									echo $row->texto;
									echo "<hr>";
								echo "</div>";
							}
							else if($row->tipo=="archivo"){
								echo "<div>";
									echo "<a href='".$db->doc.$row->texto."' download='$row->texto'>Descargar</a>";
									echo "<hr>";
								echo "</div>";
							}
							else if($row->tipo=="pregunta"){
								echo "<div>";
									echo $row->texto;
									echo "<hr>";
								echo "</div>";
							}
							else if($row->tipo=="textores"){
								echo "<div>";
									echo "<textarea class='texto' id='texto' name='texto' rows=5 placeholder=''>$row->texto</textarea>";
									echo "<hr>";
								echo "</div>";
							}
							else if($row->tipo=="textocorto"){
								echo "<div>";
									echo "<input type='text' class='form-control' id='texto' name='texto' rows=5 placeholder=''>$row->texto</input>";
									echo "<hr>";
								echo "</div>";
							}
							else if($row->tipo=="fecha"){
								echo "<div>";
									echo "<input type='date' name='texto' id='texto' value='$row->texto' class='form-control'>";
									echo "<hr>";
								echo "</div>";
							}
							else if($row->tipo=="archivores"){
								echo "<div>";
									echo "<input type='file' name='texto' id='texto' class='form-control'>";
									echo "<hr>";
								echo "</div>";
							}

						//////<!-- Fin de contexto  -->
						//////<!-- Preguntas  -->
						echo "<div class='container-fluid'>";
								$rx=$db->respuestas_ver($row->id);
								if(strlen($row->incisos)==0 and $row->tipo=="pregunta" and strlen($row->personalizado)==0 ){
									echo "<div class='row'>";
										echo "<div class='col-8'>";
										echo "<select class='form-control'>";
										foreach ($rx as $respuesta) {
											echo "<option>$respuesta->nombre (".$respuesta->valor.")</option>";
										}
										echo "</select>";
										echo "</div>";
										echo "<div class='col-4'>";
											if($row->usuario==1){
												echo "<input type='text' name='' value='' placeholder='Define..' class='form-control'>";
											}
										echo "</div>";
									echo "</div>";
								}
								else{
									foreach ($rx as $respuesta) {
										echo "<div class='row'>";
												echo "<div class='col-1'>";
												if($row->incisos==1){
													echo "<input type='checkbox' name='' value=''>";
												}
												else{
													echo "<input type='radio' id='resp_".$row->id."' name='resp_".$row->id."' value='1'>";
												}
											echo "</div>";
											if (strlen($respuesta->imagen)>0){
												echo "<div class='col-1'>";
													echo "<img src='".$db->doc.$respuesta->imagen."' width='20px'>";
												echo "</div>";
											}
											echo "<div class='col-5'>";
												echo $respuesta->nombre;
												echo "(".$respuesta->valor.")";
											echo "</div>";
											echo "<div class='col-4'>";
												if($row->usuario==1){
													echo "<input type='text' name='' value='' placeholder='Define..' class='form-control'>";
												}
											echo "</div>";
										echo "</div>";
									}
									if($row->personalizado==1){
										echo "<div class='row'>";
											echo "<div class='col-1'>";
												if($row->incisos==1){
													echo "<input type='checkbox' name='' value=''>";
												}
												else{
													echo "<input type='radio' id='resp_".$row->id."' name='resp_".$row->id."' value='1'>";
												}
											echo "</div>";
											echo "<div class='col-3'>";
												echo "<input type='text' class='form-control' name='' value=''>";
											echo "</div>";
										echo "</div>";
									}
								}

							echo "</div>";
							if($row->tipo=="pregunta"){
								echo "<br>";
								echo "<div class='row'>";
									echo "<div class='col-12'>";
										echo "<button class='btn btn-warning' type='button' is='b-link' des='a_actividades_e/inciso_editar' v_idrespuesta='0' v_idcontexto='$row->id' v_idactividad='$idactividad' omodal='1' >Agregar inciso</button>";
									echo "</div>";
								echo "</div>";
							}
						//////////////////<!-- Fin Preguntas  -->
						echo "</div>";

				echo "</div>";
			echo "</div>";
		}

		echo "<div class='container-fluid mb-5 mt-5 text-center'>";
				echo "<button class='btn btn-warning' type='button' is='b-link' des='a_actividades_e/bloque' dix='sub_".$key->idsubactividad."' v_idactividad='".$idactividad."' v_idsubactividad='".$key->idsubactividad."' v_tipo='".$actividad->tipo."' omodal='1' >Nuevo Bloque</button>";
		echo "</div>";

		if($actividad->tipo=="evaluacion"){
			$sql="select * from escala_sub where idsubactividad='$key->idsubactividad'";
			$escala = $db->dbh->prepare($sql);
			$escala->execute();
			$texto_resp="";
			if($escala->rowCount()>0){
				echo "<div class='container-fluid mb-5'>";
					echo "<div class='card mb-1 ml-3'>";
						echo "<div class='card-body'>";
							echo "Escala";
							echo "<table class='table table-sm'>";
							echo "<tr><td>-</td><td>Descripcion</td><td>Minimo</td><td>Maximo</td></tr>";
							foreach($escala->fetchAll(PDO::FETCH_OBJ) as $exca){
								echo "<tr>";
									echo "<td>";

										echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/escala' v_idactividad='$idactividad' omodal='1' v_idescala='$exca->id' v_idsubactividad='$key->idsubactividad' >
										Editar</button>";

										echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='borrar_escala' v_idescala='$exca->id' v_idactividad='$idactividad' v_idsubactividad='$key->idsubactividad'  tp='¿Desea eliminar la escala seleccionada?' tt='Ya no podrá deshacer el cambio' title='Borrar'>Borrar</button>";

									echo "</td>";
									echo "<td>";
										echo $exca->descripcion;
									echo "</td>";
									echo "<td>";
										echo $exca->minimo;
									echo "</td>";
									echo "<td>";
										echo $exca->maximo;
									echo "</td>";
								echo "</tr>";
							}
							echo "</table>";
						echo "</div>";
					echo "</div>";
				echo "</div>";
			}
		}
	}
	 echo "<hr>";

 $sql="select * from escala_actividad where idactividad=$idactividad";
 $sth = $db->dbh->prepare($sql);
 $sth->execute();
 if($sth->rowCount()){
	 $v1=$sth->fetchAll(PDO::FETCH_OBJ);
	 foreach($v1 as $escala){
		 $gparcial=0;
		 $reexp="";
		 echo "<div class='card'>";
			 echo "<div class='card-header'>";

			 echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/escala2' v_idactividad='$idactividad'  omodal='1' v_idescala='$escala->id'><i class='fas fa-file-medical-alt'></i></button>";

			 echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='borrar_escalaactitivdad' v_idactividad='$idactividad' v_idsubactividad='$key->idsubactividad'  tp='¿Desea eliminar la variable: \"$escala->nombre\"?' tt='Ya no podrá deshacer el cambio' v_id='$escala->id' title='Borrar'><i class='far fa-trash-alt'></i></button>";
				 echo "Escala:".$escala->nombre;
		 	echo "</div>";
		 	echo "<div class='card-body'>";
				$sql="SELECT escala_contexto.*, contexto.id AS idcontex, contexto.texto FROM escala_contexto LEFT OUTER JOIN contexto ON contexto.id = escala_contexto.idcontexto WHERE escala_contexto.idescala='$escala->id'";

				$sth = $db->dbh->prepare($sql);
				$sth->execute();
				$es=$sth->fetchAll(PDO::FETCH_OBJ);
				echo "<table class='table tabe-sm'>";
				echo "<tr><th>-</th><th>Descripcion</th></tr>";
				foreach($es as $v2){
				 echo "<tr>";

				 echo "<td>";
				 echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/contexto_escala' v_id='$v2->id' v_idescala='$escala->id' v_idactividad='$idactividad'  omodal='1' ><i class='fas fa-list-ul'></i></button>";

				 echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='borrar_escalacont' v_idactividad='$idactividad' v_idsubactividad='$key->idsubactividad'  tp='¿Desea eliminar la variable?' tt='Ya no podrá deshacer el cambio' v_id='$v2->id' title='Borrar'><i class='far fa-trash-alt'></i></button>";
				 echo "</td>";

				 echo "<td>";
				 echo $v2->texto;

				 $sql="select sum(valor) as total from contexto_resp where idcontexto='$v2->idcontex'";
				 $xsth = $db->dbh->prepare($sql);
				 $xsth->execute();
				 if($xsth->rowCount()){
					 $tabparc=$xsth->fetch(PDO::FETCH_OBJ);
					 if(is_numeric($tabparc->total)){
						 $gparcial+=$tabparc->total;
					 }
				 }
				 echo "</td>";
				 echo "</tr>";
				}
				echo "</table>";
	 		echo "</div>";


			 echo "<div class='card-body'>";
				 $sql="select * from escala_act where idescala=$escala->id";
				 $sth = $db->dbh->prepare($sql);
				 $sth->execute();
				 $es=$sth->fetchAll(PDO::FETCH_OBJ);
				 echo "<table class='table tabe-sm'>";
				 echo "<tr><th>Descripcion</th><th>Minimo</th><th>Maximo</th></tr>";
				 foreach($es as $v2){
					 echo "<tr>";

					 echo "<td>";
					 echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/escala3' v_id='$v2->id' v_idescala='$escala->id' v_idactividad='$idactividad'  omodal='1' v_idescala='0'><i class='fas fa-file-medical-alt'></i></button>";

					 echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='borrar_escalaact' v_idactividad='$idactividad' v_idsubactividad='$key->idsubactividad'  tp='¿Desea eliminar la escala seleccionada?' tt='Ya no podrá deshacer el cambio' v_id='$v2->id' title='Borrar'><i class='far fa-trash-alt'></i></button>";

					 echo "</td>";
					 echo "<td>";

					 echo $v2->descripcion;
					 echo "</td>";
					 echo "<td>";
					 echo $v2->minimo;
					 echo "</td>";
					 echo "<td>";
					 echo $v2->maximo;
					 echo "</td>";
					 echo "</tr>";
					 if($v2->minimo<=$gparcial and $gparcial<=$v2->maximo){
						 $reexp=$v2->descripcion;
					 }
				 }
				 echo "</table>";

			 echo "</div>";

			 echo "<div class='card-body'>";
				 echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/escala3' v_id='0' v_idescala='$escala->id' v_idactividad='$idactividad'  omodal='1' ><i class='fas fa-file-medical-alt'></i></button>";

				 echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/contexto_escala' v_id='0' v_idescala='$escala->id' v_idactividad='$idactividad'  omodal='1' ><i class='fas fa-list-ul'></i></button>";
			 echo "</div>";

			 echo "<div class='card-body'>";
				 echo "Suma:$gparcial";
				 echo "<br>Resultado:$reexp";
			 echo "</div>";
		 echo "</div>";
	 }

 }

 ?>


 <div class="container-fluid mb-3 text-center">
 	<button class='btn btn-warning' type="button" is="b-link" des='a_actividades_e/subactividad_editar' dix='nueva_sub' v_idsubactividad="0" v_idactividad='<?php echo $idactividad; ?>' title='editar' omodal="1">Nueva Subactividad</button>
 </div>
<?php
	//////////////////////////////paginacion
	$variables['idactividad']=$idactividad;
	echo $db->paginar_x($no_paginas,$pagina,"a_actividades/actividad_ver","trabajo",$variables);

 ?>
</div>
