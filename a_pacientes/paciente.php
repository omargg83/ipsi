<?php
	require_once("db_.php");
	if (isset($_REQUEST['id1'])){$id1=$_REQUEST['id1'];} else{ $id1=0;}

	$pd = $db->cliente_editar($id1);
	$nombre=$pd->nombre;
	$apellidop=$pd->apellidop;
	$apellidom=$pd->apellidom;
	$telefono=$pd->telefono;
	$correo=$pd->correo;
	$foto=$pd->foto;
	$observaciones=$pd->observaciones;
?>

<nav aria-label='breadcrumb'>
	<ol class='breadcrumb'>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/lista" dix="trabajo">Pacientes</li>
		<li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_pacientes/paciente" id1="<?php echo $id1; ?>" dix="trabajo"><?php echo $nombre." ".$apellidop." ".$apellidom; ?></li>
	</ol>
</nav>

<div class="container">
	<div class='row'>
		<div class='col-5'>
			<div class='row p-3'>
				<div class='card col-12'>
					<div class='card-body'>
						<div class='col-12'>
							<?php
								echo "<div class='form-group text-center' id='imagen_div'>";
									echo "<img src='".$db->pac.trim($foto)."' class='img-thumbnail' width='200px'>";
									echo "<div class='text-center'>".$nombre." ".$apellidop." ".$apellidom."</div>";
									echo "<div class='text-center'>Paciente</div>";
								echo "</div>";
							?>
						</div>
					</div>
				</div>
			</div>
			<div class='row p-3'>
				<div class='card col-12'>
					<div class='card-body'>
						<h5>TERAPIAS</h5>
					</div>
					<div class='card-body'>
						<div class='row'>
							<div class='col-4'>
								<h5>Individual</h5>
							</div>
							<div class='col-4'>
								<h5>Pareja</h5>
							</div>
							<div class='col-4'>
								<h5>Infantil</h5>
							</div>
						</div>
						<div class='row'>
							<div class='col-12'>
							<?php
								echo "<button class='btn btn-warning' type='button' is='b-link' des='a_pacientes/terapias' dix='trabajo' id1='$id1'>Actividad</button>";

								$resp=$db->terapias_paciente($id1);
								foreach($resp as $key){
									//echo "<button class='btn btn-warning' type='button' is='b-link' des='a_pacientes/actividad' dix='trabajo' id1='$id1' id2='$key->idactividad'>Actividad</button>";
								}
							?>
							</div>
							<div class='col-4'>

							</div>
							<div class='col-4'>

							</div>
						</div>
					</div>
					<div class='card-body'>
						<div class='col-12'>
							<?php
								echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/form_terapia' dix='nueva_sub' tp='edit' id1='$id1' omodal='1'>Agregar terapia</button>";
								echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/form_terapia' dix='nueva_sub' tp='edit' id1='$id1' omodal='1'>Nueva terapia</button>";
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class='col-7'>
			<div class='row p-3'>
				<div class='card col-12'>
					<div class='card-body'>
						<div class='row'>
							<div class='col-12'>
								<h5>información personal (Escrita por el terapeuta)</h5>
								<p><?php echo $observaciones;?></p>
							</div>
						</div>
						<div class='row'>
							<div class='col-4'>
								<button class="btn btn-warning" type="button" is="b-link" des="a_pacientes/editar" dix="trabajo" id1="<?php echo $id1;?>">Ficha de registro</button>
							</div>
							<div class='col-4'>
								<button class='btn btn-warning btn-block btn-block' onclick='ficha(<?php echo $id;?>)'>Pruebas iniciales</button>
							</div>
							<div class='col-4'>
								<button class='btn btn-warning btn-block btn-block' onclick='ficha(<?php echo $id;?>)'>Agenda</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
