<?php
	require_once("db_.php");

	$idticket=$_REQUEST['idticket'];
	$estado="Abierto";
	$numero="";
	$asunto="";
	$mensaje="";
	$idpara_cliente="";
	$idpara_usuario="";
	$idde_cliente="";
	$idde_usuario="";
	$idpara="";
	if($idticket>0){
		$pd = $db->ticket_editar($idticket);
		$numero=$pd->numero;
		$asunto=$pd->asunto;
		$estado=$pd->estado;
		$mensaje=$pd->mensaje;
		$imagen1=$pd->imagen1;
		$imagen2=$pd->imagen2;
		$imagen3=$pd->imagen3;
		$imagen4=$pd->imagen4;
		$imagen5=$pd->imagen5;
		$idpara_cliente=$pd->idpara_cliente;
		$idpara_usuario=$pd->idpara_usuario;

		$idde_cliente=$pd->idde_cliente;
		$idde_usuario=$pd->idde_usuario;
	}


?>

<div class="container">
	<form is="f-submit" id="form_personal" db="a_ticket/db_" fun="guardar_ticket" des="a_ticket/editar" desid="idticket">
		<input type="hidden" class="form-control form-control-sm" name="idticket" id="idticket" value="<?php echo $idticket ;?>" readonly>
		<div class='card mb-3'>
			<div class='card-header'>
				Ticket <?php echo "#".$numero; ?>
				<?php echo $estado; ?>
			</div>
			<div class='card-body'>
				<div class='row'>
					<div class="col-6">
						<label for="">Asunto:</label>
						<input type="text" class="form-control form-control-sm" name="asunto" id="asunto" value="<?php echo $asunto;?>" placeholder="Asunto" required
						<?php
							if($idticket!=0){
								echo "readonly";
							}
						?>
						>
					</div>
					<div class="col-6">
						<?php
							if($idticket==0){
								echo "<label>Enviar a:</label>";
								echo $_SESSION['nivel'];
								echo "<select name='idpara' id='idpara' class='form-control form-control-sm' >";
									if($_SESSION['nivel']==666){
										echo  "<optgroup label='Terapeutas'>";
										$sth = $db->dbh->query("select * from cliente_terapeuta left outer join usuarios on usuarios.idusuario=cliente_terapeuta.idusuario where idcliente='".$_SESSION['idusuario']."'");
										foreach($sth->fetchAll(PDO::FETCH_OBJ) as $key){
											echo  "<option value='us_$key->idusuario'";
											if ($key->idusuario==$idpara)	echo  " selected ";
											echo  ">".$key->nombre." ".$key->apellidop." ".$key->apellidom;
											echo "</option>";
										}
										echo  "<optgroup label='Administrador de sucursal'>";
										$sql="select * from sucursal_administracion left outer join usuarios on usuarios.idusuario=sucursal_administracion.idusuario where sucursal_administracion.idsucursal='".$_SESSION['idsucursal']."'";
										$sth = $db->dbh->query($sql);
										foreach($sth->fetchAll(PDO::FETCH_OBJ) as $key){
											echo  "<option value='us_$key->idusuario'";
											if ($key->idusuario==$idpara)	echo  " selected ";
											echo  ">".$key->nombre." ".$key->apellidop." ".$key->apellidom;
											echo "</option>";
										}
									}
									if($_SESSION['nivel']==2){
										echo  "<optgroup label='Pacientes'>";
										$sql="select * from cliente_terapeuta left outer join clientes on clientes.id=cliente_terapeuta.idcliente where cliente_terapeuta.idusuario='".$_SESSION['idusuario']."'";
										$sth = $db->dbh->query($sql);
										foreach($sth->fetchAll(PDO::FETCH_OBJ) as $key){
											echo  "<option value='cl_$key->id'>".$key->nombre." ".$key->apellidop." ".$key->apellidom;
											echo "</option>";
										}
										echo  "<optgroup label='Administrador'>";
										$sql="select * from usuarios where idsucursal='".$_SESSION['idsucursal']."' and nivel=3 and idusuario!='".$_SESSION['idusuario']."'";
										$sth = $db->dbh->query($sql);
										foreach($sth->fetchAll(PDO::FETCH_OBJ) as $key){
											echo  "<option value='us_$key->idusuario'>".$key->nombre." ".$key->apellidop." ".$key->apellidom;
											echo "</option>";
										}

										echo  "<optgroup label='Terapeutas'>";
										$sql="select * from usuarios where idsucursal='".$_SESSION['idsucursal']."' and nivel=2 and idusuario!='".$_SESSION['idusuario']."'";
										$sth = $db->dbh->query($sql);
										foreach($sth->fetchAll(PDO::FETCH_OBJ) as $key){
											echo  "<option value='us_$key->idusuario'>".$key->nombre." ".$key->apellidop." ".$key->apellidom;
											echo "</option>";
										}

										echo  "<optgroup label='Secretaria'>";
										$sql="select * from usuarios where nivel=4 and idusuario!='".$_SESSION['idusuario']."'";
										$sth = $db->dbh->query($sql);
										foreach($sth->fetchAll(PDO::FETCH_OBJ) as $key){
											echo  "<option value='us_$key->idusuario'>".$key->nombre." ".$key->apellidop." ".$key->apellidom;
											echo "</option>";
										}
									}
									if($_SESSION['nivel']==3){
										echo  "<optgroup label='Pacientes'>";
										$sql="select * from clientes where idsucursal='".$_SESSION['idsucursal']."'";
										$sth = $db->dbh->query($sql);
										foreach($sth->fetchAll(PDO::FETCH_OBJ) as $key){
											echo  "<option value='cl_$key->id'>".$key->nombre." ".$key->apellidop." ".$key->apellidom;
											echo "</option>";
										}

										echo  "<optgroup label='Terapeutas'>";
										$sql="select * from usuarios where idsucursal='".$_SESSION['idsucursal']."' and nivel=2 and idusuario!='".$_SESSION['idusuario']."'";
										$sth = $db->dbh->query($sql);
										foreach($sth->fetchAll(PDO::FETCH_OBJ) as $key){
											echo  "<option value='us_$key->idusuario'>".$key->nombre." ".$key->apellidop." ".$key->apellidom;
											echo "</option>";
										}

										echo  "<optgroup label='Directores'>";
										$sql="select * from usuarios where nivel=3 and idusuario!='".$_SESSION['idusuario']."'";
										$sth = $db->dbh->query($sql);
										foreach($sth->fetchAll(PDO::FETCH_OBJ) as $key){
											echo  "<option value='us_$key->idusuario'>".$key->nombre." ".$key->apellidop." ".$key->apellidom;
											echo "</option>";
										}

										echo  "<optgroup label='Director general'>";
										$sql="select * from usuarios where nivel=1 and idusuario!='".$_SESSION['idusuario']."'";
										$sth = $db->dbh->query($sql);
										foreach($sth->fetchAll(PDO::FETCH_OBJ) as $key){
											echo  "<option value='us_$key->idusuario'>".$key->nombre." ".$key->apellidop." ".$key->apellidom;
											echo "</option>";
										}

										echo  "<optgroup label='Secretaria'>";
										$sql="select * from usuarios where nivel=4 and idusuario!='".$_SESSION['idusuario']."'";
										$sth = $db->dbh->query($sql);
										foreach($sth->fetchAll(PDO::FETCH_OBJ) as $key){
											echo  "<option value='us_$key->idusuario'>".$key->nombre." ".$key->apellidop." ".$key->apellidom;
											echo "</option>";
										}
									}
									if($_SESSION['nivel']==1 or $_SESSION['nivel']==4){
										echo  "<optgroup label='Pacientes'>";
										$sql="select * from clientes order by nombre";
										$sth = $db->dbh->query($sql);
										foreach($sth->fetchAll(PDO::FETCH_OBJ) as $key){
											echo  "<option value='cl_$key->id'>".$key->nombre." ".$key->apellidop." ".$key->apellidom;
											echo "</option>";
										}

										echo  "<optgroup label='Terapeutas'>";
										$sql="select * from usuarios where nivel=2 order by nombre";
										$sth = $db->dbh->query($sql);
										foreach($sth->fetchAll(PDO::FETCH_OBJ) as $key){
											echo  "<option value='us_$key->idusuario'>".$key->nombre." ".$key->apellidop." ".$key->apellidom;
											echo "</option>";
										}

										echo  "<optgroup label='Directores'>";
										$sql="select * from usuarios where nivel=3 order by nombre";
										$sth = $db->dbh->query($sql);
										foreach($sth->fetchAll(PDO::FETCH_OBJ) as $key){
											echo  "<option value='us_$key->idusuario'>".$key->nombre." ".$key->apellidop." ".$key->apellidom;
											echo "</option>";
										}

										echo  "<optgroup label='Secretaria'>";
										$sql="select * from usuarios where nivel=4";
										$sth = $db->dbh->query($sql);
										foreach($sth->fetchAll(PDO::FETCH_OBJ) as $key){
											echo  "<option value='us_$key->idusuario'>".$key->nombre." ".$key->apellidop." ".$key->apellidom;
											echo "</option>";
										}

										echo  "<optgroup label='Admin General'>";
										$sql="select * from usuarios where nivel=1 and idusuario!='".$_SESSION['idusuario']."'";
										$sth = $db->dbh->query($sql);
										foreach($sth->fetchAll(PDO::FETCH_OBJ) as $key){
											echo  "<option value='us_$key->idusuario'>".$key->nombre." ".$key->apellidop." ".$key->apellidom;
											echo "</option>";
										}
									}

								echo "</select>";
							}
							else{
								echo "<label>Enviar a:</label>";
								if(strlen($idpara_usuario)>0){
									$para=$db->usuarios_editar($idpara_usuario);
								}
								else{
									$para=$db->cliente_editar($idpara_cliente);
								}
								echo "<input value='$para->nombre $para->apellidop $para->apellidom' class='form-control form-control-sm' readonly>";
							}
						?>
					</div>
				</div>
				<div class='row'>
					<div class="col-12">
						<label for="">Mensaje:</label>
						<?php
							if($idticket==0){
								echo "<div id='mensaje_ticket' name='mensaje_ticket' onclick='editable(this)' style='width:100%; height: 200px; border:1px solid silver'>$mensaje</div>";
							}
							else{
								echo "<br>";
								echo "<textarea row='5' class='form-control' readonly>";
								echo strip_tags ($mensaje);
								echo "</textarea>";
							}
						?>
					</div>
				</div>
				<br>

				<?php
					if($idticket==0){
						echo "<div class='row' id='img_1'>";
							echo "<div class='col-10'>";
							echo "<input type='file' name='foto1' id='foto1' value=''>";
							echo "</div>";
							echo "<div class='col-2'>";
								echo "<button class='btn btn-warning btn-sm' type='button' onclick='ver_img(\"img_2\")'>+ Agregar</button>";
							echo "</div>";
						echo "</div>";

						echo "<div class='row' id='img_2' style='display:none'>";
							echo "<div class='col-10'>";
							echo "<input type='file' name='foto2' id='foto2' value=''>";
							echo "</div>";
							echo "<div class='col-2'>";
								echo "<button class='btn btn-warning btn-sm' type='button' onclick='ver_img(\"img_3\")'>+ Agregar</button>";
							echo "</div>";
						echo "</div>";

						echo "<div class='row' id='img_3' style='display:none'>";
							echo "<div class='col-10'>";
							echo "<input type='file' name='foto3' id='foto3' value=''>";
							echo "</div>";
							echo "<div class='col-2'>";
								echo "<button class='btn btn-warning btn-sm' type='button' onclick='ver_img(\"img_4\")'>+ Agregar</button>";
							echo "</div>";
						echo "</div>";

						echo "<div class='row' id='img_4' style='display:none'>";
							echo "<div class='col-10'>";
							echo "<input type='file' name='foto4' id='foto4' value=''>";
							echo "</div>";
							echo "<div class='col-2'>";
								echo "<button class='btn btn-warning btn-sm' type='button' onclick='ver_img(\"img_5\")'>+ Agregar</button>";
							echo "</div>";
						echo "</div>";

						echo "<div class='row' id='img_5' style='display:none'>";
							echo "<div class='col-10'>";
							echo "<input type='file' name='foto5' id='foto5' value=''>";
							echo "</div>";
							echo "<div class='col-2'>";
								echo "<button class='btn btn-warning btn-sm' type='button'>+ Agregar</button>";
							echo "</div>";
						echo "</div>";
					}
					else{
						echo "<div class='col-12'>";
							if(strlen($imagen1)>0 and file_exists("../a_archivos/ticket/$imagen1"))
							echo "<a href='a_archivos/ticket/$imagen1' download><img src='a_archivos/ticket/$imagen1' width='100px' height='100px' class='rounded-sm'></a>";

							if(strlen($imagen2)>0 and file_exists("../a_archivos/ticket/$imagen2"))
							echo "<a href='a_archivos/ticket/$imagen2' download><img src='a_archivos/ticket/$imagen2' width='100px' height='100px' class='rounded-sm'></a>";

							if(strlen($imagen3)>0 and file_exists("../a_archivos/ticket/$imagen3"))
							echo "<a href='a_archivos/ticket/$imagen3' download><img src='a_archivos/ticket/$imagen3' width='100px' height='100px' class='rounded-sm'></a>";

							if(strlen($imagen4)>0 and file_exists("../a_archivos/ticket/$imagen4"))
							echo "<a href='a_archivos/ticket/$imagen4' download><img src='a_archivos/ticket/$imagen4' width='100px' height='100px' class='rounded-sm'></a>";

							if(strlen($imagen5)>0 and file_exists("../a_archivos/ticket/$imagen5"))
							echo "<a href='a_archivos/ticket/$imagen5' download><img src='a_archivos/ticket/$imagen5' width='100px' height='100px' class='rounded-sm'></a>";
						echo "</div>";
					}
				?>
			</div>

			<div class='card-footer'>
				<div class='row'>
					<div class="col-sm-12">
					<?php
						if($idticket==0){
							echo "<button class='btn btn-warning btn-sm' type='submit'>Guardar</button>";
						}
						else{
							echo "<button class='btn btn-warning btn-sm' id='cerrar' type='button' is='b-link' v_idticket='$idticket' db='a_ticket/db_' des='a_ticket/lista' dix='trabajo' fun='cerrar_ticket' tp='¿Desea marcar como ticket finalizado?' title='Borrar'>Cerrar ticket</button>";
						}
					?>
						<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_ticket/lista" dix="trabajo">Regresar</button>
					</div>
				</div>
			</div>
		</div>
	</form>
<?php

	$reg=$db->ticket_registro($idticket);
	foreach($reg as $v2){
		echo "<div class='card mb-3'>";
			echo "<div class='card-header'>";
				if($v2->idde_usuario>0){
					$de=$db->usuarios_editar($v2->idde_usuario);
				}
				else{
					$de=$db->cliente_editar($v2->idde_cliente);
				}
				echo $de->nombre." ".$de->apellidop." ".$de->apellidop;

				echo "<br><small><span class='text-right'>".fecha($v2->fecha,2)."</span></small>";
			echo "</div>";
			echo "<div class='card-body'>";
			echo strip_tags ($v2->mensaje);
			echo "</div>";

			echo "<div class='card-body'>";
			echo "<div class='col-12'>";
				if(strlen($v2->imagen1)>0 and file_exists("../a_archivos/ticket/$v2->imagen1"))
				echo "<a href='a_archivos/ticket/$v2->imagen1' download><img src='a_archivos/ticket/$v2->imagen1' width='100px' height='100px' class='rounded-sm'></a>";
				if(strlen($v2->imagen2)>0 and file_exists("../a_archivos/ticket/$v2->imagen2"))
				echo "<a href='a_archivos/ticket/$v2->imagen2' download><img src='a_archivos/ticket/$v2->imagen2' width='100px' height='100px' class='rounded-sm'></a>";
				if(strlen($v2->imagen3)>0 and file_exists("../a_archivos/ticket/$v2->imagen3"))
				echo "<a href='a_archivos/ticket/$v2->imagen3' download><img src='a_archivos/ticket/$v2->imagen3' width='100px' height='100px' class='rounded-sm'></a>";
				if(strlen($v2->imagen4)>0 and file_exists("../a_archivos/ticket/$v2->imagen4"))
				echo "<a href='a_archivos/ticket/$v2->imagen4' download><img src='a_archivos/ticket/$v2->imagen4' width='100px' height='100px' class='rounded-sm'></a>";
				if(strlen($v2->imagen5)>0 and file_exists("../a_archivos/ticket/$v2->imagen5"))
				echo "<a href='a_archivos/ticket/$v2->imagen5' download><img src='a_archivos/ticket/$v2->imagen5' width='100px' height='100px' class='rounded-sm'></a>";
			echo "</div>";
			echo "</div>";
		echo "</div>";
	}

	if($idticket!=0 and $estado=="Abierto"){
		echo "<form is='f-submit' id='form_hijo' db='a_ticket/db_' fun='guardar_hijo' des='a_ticket/editar' desid='idticket'>";
		echo "<div class='card mb-3'>";
			echo "<input type='hidden' class='form-control form-control-sm' name='idticket' id='idticket' value='$idticket' readonly>";
			echo "<div class='card-body'>";

				echo "<div class='row'>";
					echo "<div class='col-12'>";
						echo "<label>Mensaje:</label>";
						echo "<div id='mensaje_hijo' name='mensaje_hijo' onclick='editable(this)' style='width:100%; height: 200px; border:1px solid silver'></div>";
					echo "</div>";
				echo "</div>";

				echo "<div class='row' id='img_1'>";
					echo "<div class='col-10'>";
					echo "<input type='file' name='foto1' id='foto1' value=''>";
					echo "</div>";
					echo "<div class='col-2'>";
						echo "<button class='btn btn-warning btn-sm' type='button' onclick='ver_img(\"img_2\")'>+ Agregar</button>";
					echo "</div>";
				echo "</div>";

				echo "<div class='row' id='img_2' style='display:none'>";
					echo "<div class='col-10'>";
					echo "<input type='file' name='foto2' id='foto2' value=''>";
					echo "</div>";
					echo "<div class='col-2'>";
						echo "<button class='btn btn-warning btn-sm' type='button' onclick='ver_img(\"img_3\")'>+ Agregar</button>";
					echo "</div>";
				echo "</div>";

				echo "<div class='row' id='img_3' style='display:none'>";
					echo "<div class='col-10'>";
					echo "<input type='file' name='foto3' id='foto3' value=''>";
					echo "</div>";
					echo "<div class='col-2'>";
						echo "<button class='btn btn-warning btn-sm' type='button' onclick='ver_img(\"img_4\")'>+ Agregar</button>";
					echo "</div>";
				echo "</div>";

				echo "<div class='row' id='img_4' style='display:none'>";
					echo "<div class='col-10'>";
					echo "<input type='file' name='foto4' id='foto4' value=''>";
					echo "</div>";
					echo "<div class='col-2'>";
						echo "<button class='btn btn-warning btn-sm' type='button' onclick='ver_img(\"img_5\")'>+ Agregar</button>";
					echo "</div>";
				echo "</div>";

				echo "<div class='row' id='img_5' style='display:none'>";
					echo "<div class='col-10'>";
					echo "<input type='file' name='foto5' id='foto5' value=''>";
					echo "</div>";
					echo "<div class='col-2'>";
						echo "<button class='btn btn-warning btn-sm' type='button' >+ Agregar</button>";
					echo "</div>";
				echo "</div>";

			echo "</div>";
			echo "<div class='card-footer'>";
				echo "<div class='row'>";
					echo "<div class='col-sm-12'>";
						echo "<button class='btn btn-warning btn-sm' type='submit'>Enviar</button>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
		echo "</form>";
	}
?>

</div>
