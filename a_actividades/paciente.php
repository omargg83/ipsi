<?php
	require_once("db_.php");
	if (isset($_POST['id'])){$id=$_REQUEST['id'];} else{ $id=0;}

	$pd = $db->cliente_editar($id);
	$nombre=$pd->nombre;
	$apellidop=$pd->apellidop;
	$apellidom=$pd->apellidom;
	$telefono=$pd->telefono;
	$correo=$pd->correo;
	$foto=$pd->foto;
	$observaciones=$pd->observaciones;

	echo "<nav aria-label='breadcrumb'>";
		echo "<ol class='breadcrumb'>";
			echo "<li class='breadcrumb-item' id='lista_pacientes' data-lugar='a_clientes/lista'>Mis pacientes</li>";
			echo "<li class='breadcrumb-item active' aria-current='page'>".$nombre." ".$apellidop." ".$apellidom."</li>";
		echo "</ol>";
	echo "</nav>";
?>

<div class="container">
	<div class='row'>
		<div class='col-4'>
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
						<div class='col-12'>
							<?php
								echo "<button type='button' class='btn btn-sm' id='winmodal_pass' data-id='$id' data-lugar='a_clientes/form_terapia' title='Agregar actividad' >Agregar terapia</button>";
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class='col-8'>
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
								<button class='btn btn-sm btn-block' onclick='ficha(<?php echo $id;?>)'>Ficha de registro</button>
							</div>
							<div class='col-4'>
								<button class='btn btn-sm btn-block' onclick='ficha(<?php echo $id;?>)'>Pruebas iniciales</button>
							</div>
							<div class='col-4'>
								<button class='btn btn-sm btn-block' onclick='ficha(<?php echo $id;?>)'>Agenda</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
