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
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_clientes/lista" dix="trabajo">Pacientes</li>
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
									echo "<img src='".$db->doc.trim($foto)."' class='img-thumbnail' width='200px'>";
									echo "<div class='text-center'>".$nombre." ".$apellidop." ".$apellidom."</div>";
									echo "<div class='text-center'>Paciente</div>";
								echo "</div>";
							?>
						</div>
					</div>
				</div>
			</div>
			<div class='row text-center p-3'>
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
							<div class='col-4'>
							<?php
								$resp=$db->individual($id,'individual','enojo');
								$num=count($resp);
								if($num>0){
										echo "<button type='button' class='btn btn-warning btn-block' id='winmodal_pass' data-id='$id' data-lugar='a_clientes/form_terapia' >Enojo</button>";
								}

								$resp=$db->individual($id,'individual','ansiedad');
								$num=count($resp);
								if($num>0){
										echo "<button type='button' class='btn btn-warning btn-block' id='winmodal_pass' data-id='$id' data-lugar='a_clientes/form_terapia' >Ansiedad</button>";
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
								echo "<button type='button' class='btn btn-warning btn-block' id='winmodal_pass' data-id='$id' data-lugar='a_clientes/form_terapia' title='Agregar actividad' >Agregar terapia</button>";
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
								<button class='btn btn-warning btn-block btn-block' onclick='ficha(<?php echo $id;?>)'>Ficha de registro</button>
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
