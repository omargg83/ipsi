<?php
	require_once("db_.php");

	$idpaciente=$_REQUEST['idpaciente'];
	$pd = $db->cliente_editar($idpaciente);
	$nombre=$pd->nombre;
	$edad=$pd->edad;
	$apellidop=$pd->apellidop;
	$apellidom=$pd->apellidom;
	$telefono=$pd->telefono;
	$correo=$pd->correo;
	$foto=$pd->foto;
	$observaciones=$pd->observaciones;

	/////////////////////Relaciones
	$sql="select * from clientes_relacion
	left outer join clientes on clientes.id=clientes_relacion.idrel
	left outer join rol_familiar on rol_familiar.idrol=clientes_relacion.idrol
	where clientes_relacion.idcliente=:idcliente";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":idcliente",$idpaciente);
	$sth->execute();
	$relaciones=$sth->fetchAll(PDO::FETCH_OBJ);
?>

<nav aria-label='breadcrumb'>
	<ol class='breadcrumb'>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/index" dix="trabajo">Pacientes</li>
		<li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_pacientes/paciente" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo"><?php echo $nombre." ".$apellidop." ".$apellidom; ?></li>
		<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_pacientes/index" dix="trabajo">Regresar</button>
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
						<div class='row'>
							<div class='col-12 text-center'>
								<h5>Terapias</h5>
							</div>
						</div>
						<div class='row'>
							<div class='col-12'>
							<?php
								$resp=$db->terapias_paciente($idpaciente);
								foreach($resp as $key){
									echo "<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_pacientes/track' dix='trabajo' v_idpaciente='$idpaciente' v_idterapia='$key->id'>$key->nombre</button>";
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
						<div class='col-12 text-center'>
							<?php
								echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes_e/terapias_agregar' dix='trabajo' v_idpaciente='$idpaciente' >Nueva terapia</button>";
							?>
						</div>
					</div>
				</div>
			</div>
			<div class='row p-3'>
				<div class='card col-12'>
					<div class='card-body'>
						<div class='row'>
							<div class='col-12 text-center'>
								<h5>Terapeutas</h5>
							</div>
						</div>
					</div>


					<?php
						$sql="SELECT * FROM cliente_terapeuta LEFT OUTER JOIN usuarios ON cliente_terapeuta.idusuario = usuarios.idusuario WHERE cliente_terapeuta.idcliente =$idpaciente";
						$sth = $db->dbh->prepare($sql);
						$sth->execute();
						$terap=$sth->fetchAll(PDO::FETCH_OBJ);
						foreach($terap as $key){
							echo "<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_pacientes/track' dix='trabajo' v_idpaciente='$idpaciente' v_idterapeuta='$key->idterapeuta'>$key->nombre</button>";
						}
					?>


					<div class='card-body'>
						<div class='col-12 text-center'>
							<?php
								echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/terapeutas_agregar' dix='trabajo' v_idpaciente='$idpaciente' >Agregar</button>";
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
								<h5>Información básica</h5>
							</div>
							<div class='col-4'>
								<?php
									echo "<label>Edad</label>";
									echo "<input class='form-control form-control-sm' value='$edad' readonly/>";
								?>
							</div>
							<div class='col-4'>
								<?php
									echo "<label>Correo</label>";
									echo "<input class='form-control form-control-sm' value='$correo' readonly/>";
								?>
							</div>
							<div class='col-4'>
								<?php
									echo "<label>Teléfono</label>";
									echo "<input class='form-control form-control-sm' value='$telefono' readonly/>";
								?>
							</div>
						</div>
						<hr>
						<div class='row'>
							<div class='col-12'>
								<button class="btn btn-warning" type="button" is="b-link" des="a_pacientes/editar" dix="trabajo" v_idpaciente="<?php echo $idpaciente;?>">Ver más</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class='row p-3'>
				<div class='card col-12'>
					<div class='card-body'>
						<div class='row'>
							<div class='col-12'>
								<h5>Relaciones</h5>
							</div>
						</div>
						<div class='row'>
							<div class='col-6'>
								Nombre
							</div>
							<div class='col-6'>
								Tipo
							</div>
						</div>
						<?php
							foreach($relaciones as $key){
								echo "<div class='row'>";
									echo "<div class='col-6'>";
										echo "<input class='form-control form-control-sm' value='$key->nombre' readonly/>";
									echo "</div>";
									echo "<div class='col-6'>";
										echo "<input class='form-control form-control-sm' value='$key->rol' readonly/>";
									echo "</div>";
								echo "</div>";
							}
						?>

						<hr>
						<div class='row'>
							<div class='col-12'>
								<button class="btn btn-warning" type="button" is="b-link" des="a_pacientes/relaciones" dix="trabajo" v_idpaciente="<?php echo $idpaciente;?>">Ver más</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
