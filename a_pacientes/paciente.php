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
	$numero=$pd->numero;
	$estatus=$pd->estatus;
	$tipo_paciente=$pd->tipo_paciente;

	$suc=$db->sucursal($pd->idsucursal);

	/////////////////////Relaciones
	$sql="select * from clientes_relacion
	left outer join rol_familiar on rol_familiar.idrol=clientes_relacion.idrol
	where clientes_relacion.idcliente=:idcliente or clientes_relacion.idrel=:idcliente";
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
									echo "<div class='text-center'>ID: $numero</div>";
									echo "<div class='text-center'>Sucursal: $suc->nombre</div>";
								echo "</div>";
							?>
						</div>
					</div>
				</div>
			</div>
			<?php
				if($_SESSION['nivel']==1 or $_SESSION['nivel']==2 or $_SESSION['nivel']==3){
					echo "<div class='row p-3'>";
						echo "<div class='card col-12'>";
							echo "<div class='card-body'>";
								echo "<div class='row'>";
									echo "<div class='col-12 text-center'>";
										echo "<h5>Terapias</h5>";
									echo "</div>";
								echo "</div>";
								echo "<div class='row'>";
									echo "<div class='col-12'>";
										$resp=$db->terapias_paciente($idpaciente);

										foreach($resp as $key){
											$terapeuta=array();
											echo "<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_pacientes/track' dix='trabajo' v_idpaciente='$idpaciente' v_idterapia='$key->id'>";
											echo $key->nombre;

											$sql="select * from track where idterapia=$key->id";
											$sth1 = $db->dbh->query($sql);
											$tracksdb=$sth1->fetchAll(PDO::FETCH_OBJ);
											foreach($tracksdb as $track){
												//echo "<br>track:".$track->nombre;

												/////////////modulo
												$sql="select * from modulo where idtrack=$track->id";
												$sth2 = $db->dbh->query($sql);
												$modulossdb=$sth2->fetchAll(PDO::FETCH_OBJ);
												foreach($modulossdb as $modulo){
													//echo "<br>Modulo:".$modulo->nombre;

													$sql="select * from grupo_actividad where idmodulo=$modulo->id";

													$sth3 = $db->dbh->query($sql);
													$grupossdb=$sth3->fetchAll(PDO::FETCH_OBJ);
													foreach($grupossdb as $grupo){
														//echo "<br>Grupo:".$grupo->grupo;

														$sql="select usuarios.idusuario, usuarios.nombre,usuarios.apellidop, usuarios.apellidom from actividad
														left outer join actividad_per on actividad_per.idactividad=actividad.idactividad
														left outer join usuarios on usuarios.idusuario=actividad.idcreado
														where idgrupo=$grupo->idgrupo and actividad_per.idpaciente=$idpaciente";
														$sth4 = $db->dbh->query($sql);
														$actividaddb=$sth4->fetchAll(PDO::FETCH_OBJ);
														foreach($actividaddb as $actividad){
																$terapeuta[$actividad->idusuario]="$actividad->nombre $actividad->apellidop $actividad->apellidom";
																//echo "<br>$actividad->nombre $actividad->apellidop $actividad->apellidom";
														}

													}

												}


												/////////////////ACTIVIDADES INICIALES
												/////////////grupo
												$sql="select * from grupo_actividad where idtrack=$track->id";
												$sth3 = $db->dbh->query($sql);
												$grupossdb=$sth3->fetchAll(PDO::FETCH_OBJ);
												foreach($grupossdb as $grupo){
													//echo "<br>Grupo:".$grupo->grupo;
													$sql="select usuarios.idusuario, usuarios.nombre,usuarios.apellidop, usuarios.apellidom from actividad
													left outer join actividad_per on actividad_per.idactividad=actividad.idactividad
													left outer join usuarios on usuarios.idusuario=actividad.idcreado
													where idgrupo=$grupo->idgrupo and actividad_per.idpaciente=$idpaciente";
													$sth4 = $db->dbh->query($sql);
													$actividaddb=$sth4->fetchAll(PDO::FETCH_OBJ);
													foreach($actividaddb as $actividad){
															$terapeuta[$actividad->idusuario]="$actividad->nombre $actividad->apellidop $actividad->apellidom";
															//echo "<br>$actividad->nombre $actividad->apellidop $actividad->apellidom";
													}
												}

											}
											foreach($terapeuta as $terx){
												echo "<br>$terx";
											}
											//echo "<hr>";
											echo "</button>";
										}
									echo "</div>";
									echo "<div class='col-4'>";
									echo "</div>";
									echo "<div class='col-4'>";
									echo "</div>";
								echo "</div>";
							echo "</div>";
							if($tipo_paciente=='Paciente'){
								echo "<div class='card-body'>";
									echo "<div class='col-12 text-center'>";
											echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes_e/terapias_agregar' dix='trabajo' v_idpaciente='$idpaciente' >Nueva terapia</button>";
									echo "</div>";
								echo "</div>";
							}
						echo "</div>";
					echo "</div>";
				}
			?>
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
							echo "<button class='btn btn-warning btn-block' type='button' >$key->nombre $key->apellidop $key->apellidom</button>";
						}
					?>
					<div class='card-body'>
						<div class='col-12 text-center'>
							<?php
								echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/terapeutas' dix='trabajo' v_idpaciente='$idpaciente' >Ver mas</button>";
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
								<h5>Estatus</h5>
							</div>
							<div class='col-12'>
								<?php
									echo "<label>Estatus</label>";
									echo "<input class='form-control form-control-sm' value='$estatus' readonly/>";
								?>
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
								<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_pacientes/editar_trabajo" dix="trabajo" v_idpaciente="<?php echo $idpaciente;?>">Ver más</button>
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
								if($key->idcliente==$idpaciente){
									$cli=$db->cliente_editar($key->idrel);
								}
								else{
									$cli=$db->cliente_editar($key->idcliente);
								}
								echo "<div class='row'>";
									echo "<div class='col-6'>";
										echo "<input class='form-control form-control-sm' value='$cli->nombre $cli->apellidop $cli->apellidom' readonly/>";
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
								<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_pacientes/relaciones" dix="trabajo" v_idpaciente="<?php echo $idpaciente;?>">Ver más</button>
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
								<h5>Últimas citas</h5>
							</div>
						</div>
						<div class='row'>
							<div class='col-4'>
								Fecha
							</div>
							<div class='col-4'>
								Hora
							</div>
							<div class='col-4'>
								Terapeuta
							</div>
						</div>
						<?php
							$sql="SELECT * FROM citas where idpaciente=$idpaciente order by estatus asc, desde asc limit 3 ";
							$sth = $db->dbh->query($sql);

							$citas=$sth->fetchAll(PDO::FETCH_OBJ);
							foreach($citas as $key){
								$fecha = new DateTime($key->desde);
								echo "<div class='row'>";
									echo "<div class='col-4'>";
										echo "<input class='form-control form-control-sm' value='".$fecha->format("d-m-Y")."' readonly/>";
									echo "</div>";
									echo "<div class='col-4'>";
										echo "<input class='form-control form-control-sm' value='".$fecha->format("h:i A")."' readonly/>";
									echo "</div>";
									echo "<div class='col-4'>";
										$terapeuta=$db->terapeuta($key->idusuario);
										echo "<input class='form-control form-control-sm' value='$terapeuta->nombre $terapeuta->apellidop $terapeuta->apellidom' readonly/>";
									echo "</div>";
								echo "</div>";
							}
						?>
						<hr>
						<div class='row'>
							<div class='col-12'>
								<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_agenda/index" dix="contenido">Ver más</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
				if($_SESSION['nivel']==2){
			 ?>
			<div class='row p-3'>
				<div class='card col-12'>
					<div class='card-body'>
						<div class='row'>
							<div class='col-12'>
								<h5>Mis Citas con el paciente</h5>
							</div>
						</div>
						<?php
							$sql="SELECT * FROM citas where idpaciente=$idpaciente and idusuario=".$_SESSION['idusuario']." and estatus_paciente='confirmar'";
							$sth = $db->dbh->query($sql);
							echo "Citas confirmadas: ".$sth->rowCount();

							$sql="select * from citas where idpaciente='$idpaciente' and citas.idusuario=".$_SESSION['idusuario']."";
							$sth = $db->dbh->query($sql);
							echo "<br>Citas Totales: ".$sth->rowCount();
						?>

					</div>
				</div>
			</div>
			<?php
				}
			 ?>
		</div>
	</div>
</div>
