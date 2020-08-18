<?php
	require_once("../a_pacientes/db_.php");

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

	$sql="select * from modulo where id=:idmodulo";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":idmodulo",$actividad->idmodulo);
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

	$nombre_act=$actividad->nombre;
	$observaciones=$actividad->observaciones;
	$indicaciones=$actividad->indicaciones;
  $subactividad = $db->subactividad_ver($idactividad);


?>


<!-- actividad  -->
<div class="container">
<div id="accordion">
	<div class="card mb-3">
		<div class="card-header" id="headingOne">
			<div class='row'>
				<div class="col-2">

					<!---Editar actividad --->
				</div>
				<div class="col-9 text-left">
					<button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						Actividad: <?php echo $nombre_act; ?>
					</button>
				</div>
				<div class="col-1">

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


<!-- Nueva subactividad  -->

<?php
	foreach($subactividad as $key){
?>
	<!-- Subactividad  -->
	<div class="container-fluid mb-4" id="sub_<?php echo $key->idsubactividad; ?>">
		<div class="card" >
		<div class="card-header">
			<div class="row">
				<div class="col-2">

					<!-- Editar subactividad --->

				</div>
				<div class="col-10">
					<button class="btn btn-link" data-toggle="collapse" data-target="#collapsesub<?php echo $key->idsubactividad; ?>" aria-expanded="true" aria-controls="collapsesub<?php echo $key->idsubactividad; ?>">
						<?php echo $key->orden; ?>- Subactividad: <?php echo $key->nombre; ?>
					</button>
				</div>
			</div>
		</div>

	<!-- fin de Subactividad  -->

		<!-- Contexto  -->
		<div id="collapsesub<?php echo $key->idsubactividad; ?>" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
			<div class="card-body" id='bloque'>
      <!--- bloque-->

			<?php
				$bloq=$db->contexto_ver($key->idsubactividad);
				foreach($bloq as $row){
			?>
				<div class="card mb-4" draggable="true">
					<div class="card-header">
						<div class='row'>
							<div class="col-2">


								<!-- Editar Contexto --->

							</div>
							<div class="col-4 text-center">

								<button class="btn btn-link" data-toggle="collapse" data-target="#collapsecon<?php echo $row->id; ?>" aria-expanded="true" aria-controls="collapsecon<?php echo $row->id; ?>">
									Contexto (<?php echo $row->tipo; ?>)
								</button>
							</div>
							<div class="col-4">
								<!-- botones -->
							</div>
						</div>
					</div>

					<div id="collapsecon<?php echo $row->id; ?>" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
						<div class="card-body">
							<div>
								<?php	echo $row->observaciones; ?>
							</div>
							<hr>
							<div>
								<?php
									if($row->tipo=="imagen"){
										echo "<img src='".$db->doc.$row->texto."'/>";
									}
									if($row->tipo=="texto"){
										echo $row->texto;
									}
									if($row->tipo=="video"){
										echo $row->texto;
									}
									if($row->tipo=="archivo"){
										echo "<a href='".$db->doc.$row->texto."' download='$row->texto'>Descargar</a>";
									}
									if($row->tipo=="pregunta"){
										echo $row->texto;
									}
								?>
								<hr>

							</div>

							<!-- Fin de contexto  -->
							<!-- Preguntas  -->
							<div class="container-fluid">
								<form is="f-submit" id="form_editaract" db="a_actividades/db_" fun="guarda_respuesta" des="a_pacientes/actividad_ver" desid="idactividad" v_idactividad="<?php echo $idactividad; ?>" v_idpaciente="<?php echo $idpaciente; ?>">
								<?php
								$rx=$db->respuestas_ver($row->id);
								foreach ($rx as $respuesta) {

									?>
										<div class="row">
                      <!--Editar respuesta-->
											<div class="col-1">
												<?php
													if($row->incisos==1){
														echo "<input type='checkbox' name='' value=''>";
													}
													else{
														echo "<input type='radio' id='resp_".$respuesta->id."' name='resp_".$row->id."' value='1'>";
													}
												?>
											</div>
											<div class="col-1">
												<img src="<?php echo $db->doc.$respuesta->imagen; ?>" alt="" width="20px">
											</div>
											<div class="col-3">
												<?php echo $respuesta->nombre;  ?>
											</div>
											<div class="col-4">
												<?php
													if($row->usuario==1){
														echo "<input type='text' name='' value='' placeholder='Define..' class='form-control'>";
													}
												?>
											</div>
										</div>

									<?php
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
										echo "<div class='col-1'>";
										echo "</div>";

										echo "<div class='col-3'>";
											echo "<input type='text' name='' value='' class='form-control'>";
										echo "</div>";
									echo "</div>";
								}

								?>
								fin del form
							</div>
							<button class="btn btn-warning btn-sm" type="button" is="b-link" des='a_pacientes/paciente' v_idpaciente="<?php echo $idpaciente; ?>" dix='trabajo'>Responder</button>
							<!-- Fin Preguntas  -->
					</div>
				</div>
			</div>

			<?php
				}
			?>
		</div>
		</div>
	</div>
	</div>

<?php
	}
 ?>
</div>
