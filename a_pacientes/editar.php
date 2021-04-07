<?php
	require_once("db_.php");

	if($_SESSION['nivel']==666){
		$idpaciente=$_SESSION['idusuario'];
	}
	else{
		$idpaciente=clean_var($_REQUEST['idpaciente']);
	}

	$foto="";	
	$autoriza="1";
	$idsucursal="";
	$nombre="";
	$apellidop="";
	$apellidom="";
	$edad="";
	$correo="";
	$telefono="";
	$civil="";
	$hijos="";
	$direccion="";
	$ocupacion="";
	$escolaridad="";
	$religion="";
	$vive="";
	$nombre_vive="";
	$telefono_vive="";
	$parentesco_vive="";
		
	$enfermedad_cronica="";
	$enfermedad="";

	$enfermedad_mental="";
	$e_mental="";

	$consumo_medicamentos="";
	$c_medicamentos="";

	$alergias="";
	$c_alergias="";

	$lesiones="";
	$c_lesiones="";

	$per = $db->personal();
	$sucursal = $db->sucursal_lista();

	if($idpaciente>0){
		$pd = $db->cliente_editar($idpaciente);
		$idsucursal=$pd->idsucursal;
		$foto=$pd->foto;
		$autoriza=$pd->autoriza;
		$nombre=$pd->nombre;
		$apellidop=$pd->apellidop;
		$apellidom=$pd->apellidom;
		$edad=$pd->edad;
		$correo=$pd->correo;
		$telefono=$pd->telefono;
		$civil=$pd->civil;
		$hijos=$pd->hijos;
		$direccion=$pd->direccion;
		$ocupacion=$pd->ocupacion;
		$escolaridad=$pd->escolaridad;
		$religion=$pd->religion;
		$vive=$pd->vive;
		$nombre_vive=$pd->nombre_vive;
		$telefono_vive=$pd->telefono_vive;
		$parentesco_vive=$pd->parentesco_vive;
		
		$enfermedad_cronica=$pd->enfermedad_cronica;
		$enfermedad=$pd->enfermedad;

		$enfermedad_mental=$pd->enfermedad_mental;
		$e_mental=$pd->e_mental;

		$consumo_medicamentos=$pd->consumo_medicamentos;
		$c_medicamentos=$pd->c_medicamentos;
	
		$alergias=$pd->alergias;
		$c_alergias=$pd->c_alergias;

		$lesiones=$pd->lesiones;
		$c_lesiones=$pd->c_lesiones;
		
		
	}

	if($_SESSION['nivel']!=666){
		echo "<nav aria-label='breadcrumb'>";
			echo "<ol class='breadcrumb'>";
				echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_pacientes/index' dix='trabajo'>Pacientes</li>";
				echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_pacientes/paciente' v_idpaciente='$idpaciente' dix='trabajo'>$nombre $apellidop $apellidom</li>";

				echo "<li class='breadcrumb-item active' id='lista_track' is='li-link' des='a_pacientes/editar' v_idpaciente='$idpaciente' dix='trabajo'>Ficha de registro</li>";

				if($idpaciente>0){
					echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/paciente' v_idpaciente='$idpaciente' dix='trabajo'>Regresar</button>";
				}
				else{
					echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' is='li-link' des='a_pacientes/index' dix='trabajo'>Regresar</button>";
				}
			echo "</ol>";
		echo "</nav>";
	}

echo "<div class='container'>";
	if($_SESSION['nivel']!=666){
		echo "<form is='f-submit' id='form_cliente' db='a_pacientes/db_' fun='guardar_cliente' des='a_pacientes/editar' desid='idpaciente' >";
	}
	else{
		echo "<form is='f-submit' id='form_cliente' db='a_pacientes/db_' fun='guardar_cliente'>";
	}
?>
		<input type="hidden" name="idpaciente" id="idpaciente" value="<?php echo $idpaciente;?>">
		<div class='card'>
			<div class='card-header'>
				Editar cliente
			</div>
			<div class='card-body'>
				<?php
					echo "<div class='form-group' id='imagen_div'>";
						echo "<img src='".$db->pac.trim($foto)."' class='img-thumbnail' width='100px'>";
					echo "</div>";
				?>
				<div class="col-12">
					<h5><center><b>DATOS GENERALES</b></center></h5>
				</div>
				

				<div class='row'>
					<div class="col-3">
						<label>Nombre*:</label>
						<input type="text" class="form-control form-control-sm" name="nombre" id="nombre" value="<?php echo $nombre;?>" placeholder="Nombre" maxlength="100" required >
					</div>

					<div class="col-3">
						<label>Apellido Paterno*:</label>
						<input type="text" class="form-control form-control-sm" name="apellidop" id="apellidop" value="<?php echo $apellidop;?>" placeholder="Apellido Paterno" maxlength="50" required>
					</div>

					<div class="col-3">
						<label>Apellido materno*:</label>
						<input type="text" class="form-control form-control-sm" name="apellidom" id="apellidom" value="<?php echo $apellidom;?>" placeholder="Apellido materno" maxlength="50" required>
					</div>

					<div class="col-3">
						<label>Edad*:</label>
						<input type="text" class="form-control form-control-sm" name="edad" id="edad" value="<?php echo $edad;?>" placeholder="Edad"  maxlength="20" required>
					</div>

				</div>
				<div class='row'>

					<div class="col-3">
						<label>Correo*:</label>
						<input type="text" class="form-control form-control-sm" name="correo" id="correo" value="<?php echo $correo;?>" placeholder="Correo" maxlength="100" required>
					</div>

					<div class="col-3">
						<label>Teléfono*:</label>
						<input type="text" class="form-control form-control-sm" name="telefono" id="telefono" value="<?php echo $telefono;?>" maxlength="20" placeholder="Teléfono" required>
					</div>

					<div class="col-3">
						<label>Estado Civil*:</label>
						<select name="civil" id="civil" class="form-control form-control-sm" required>
							<option value="soltero" <?php if($civil=='soltero') echo "selected"; ?>>Soltero</option>
							<option value="casado" <?php if($civil=='casado') echo "selected"; ?>>Casado</option>
							<option value="divorciado" <?php if($civil=='divorciado') echo "selected"; ?>>Divorciado</option>
							<option value="unión libre" <?php if($civil=='unión libre') echo "selected"; ?>>Unión libre</option>
							<option value="viudo" <?php if($civil=='viudo') echo "selected"; ?>>Viudo</option>
						</select>
					</div>

					<div class="col-3">
						<label>Número de hijos:</label>
						<input type="text" class="form-control form-control-sm" name="hijos" id="hijos" value="<?php echo $hijos;?>" maxlength="100" placeholder="Número de hijos">
					</div>
				</div>


				<div class='row'>
					<div class="col-12">
						<label>Dirección en una linea*:</label>
						<input type="text" class="form-control form-control-sm" name="direccion" id="direccion" value="<?php echo $direccion;?>"  maxlength="200" required>
					</div>
				</div>

				<div class='row'>
					<div class="col-3">
						<label>Ocupación*:</label>
						<input type="text" class="form-control form-control-sm" name="ocupacion" id="ocupacion" value="<?php echo $ocupacion;?>" maxlength="100" placeholder="Ocupación" required>
					</div>

					<div class="col-3">
						<label>Escolaridad*:</label>
						<input type="text" class="form-control form-control-sm" name="escolaridad" id="escolaridad" value="<?php echo $escolaridad;?>" maxlength="100" placeholder="Escolaridad" required>
					</div>

					<div class="col-3">
						<label>Religión:</label>
						<input type="text" class="form-control form-control-sm" name="religion" id="religion" value="<?php echo $religion;?>" maxlength="100" placeholder="Religión" >
					</div>

					<div class="col-3">
						<label>¿Con quien vive actualmente?*:</label>
						<input type="text" class="form-control form-control-sm" name="vive" id="vive" value="<?php echo $vive;?>" maxlength="100" placeholder="¿Con quien vive actualmente?" required>
					</div>
				</div>
				<hr>
				<div class='row'>
					<div class="col-12">
						<h5><center><b>DATOS CONTACTO DE EMERGENCIA</b></center></h5>
					</div>
					<div class="col-6">
						<label>Nombre completo*:</label>
						<input type="text" class="form-control form-control-sm" name="nombre_vive" id="nombre_vive" value="<?php echo $nombre_vive;?>" maxlength="200" placeholder="Nombre completo" required>
					</div>

					<div class="col-3">
						<label>Teléfono*:</label>
						<input type="text" class="form-control form-control-sm" name="telefono_vive" id="telefono_vive" value="<?php echo $telefono_vive;?>" maxlength="100" placeholder="Teléfono o Medio de contacto" required>
					</div>

					<div class="col-3">
						<label>Relación / Parentesco*:</label>
						<select name="parentesco_vive" id="parentesco_vive" class="form-control form-control-sm" required>
							<option value="padre" <?php if($parentesco_vive=='padre') echo "selected"; ?>>Padre</option>
							<option value="madre" <?php if($parentesco_vive=='madre') echo "selected"; ?>>Madre</option>
							<option value="hijo" <?php if($parentesco_vive=='hijo') echo "selected"; ?>>Hijo</option>
							<option value="hermano" <?php if($parentesco_vive=='hermano') echo "selected"; ?>>Hermano</option>
							<option value="conyugue" <?php if($parentesco_vive=='conyugue') echo "selected"; ?>>Conyugue</option>
						</select>
					</div>
				</div>
				
				<hr>

				<div class='row'>
					<div class="col-12">
						<h5><center><b>HISTORIAL MÉDICO</b></center></h5>
					</div>
					<div class="col-3">
						<label>Enfermedad crónica o física*:</label>
						<select name="enfermedad_cronica" id="enfermedad_cronica" class="form-control form-control-sm">
							<option value="no" <?php if($enfermedad_cronica=='no') echo "selected"; ?>>No</option>
							<option value="si" <?php if($enfermedad_cronica=='si') echo "selected"; ?>>Si</option>
						</select>
					</div>

					<div class="col-9">
						<label>¿Cúal?:</label>
						<input type="text" class="form-control form-control-sm" name="enfermedad" id="enfermedad" value="<?php echo $enfermedad;?>" maxlength="200" placeholder="¿Cúal?">
					</div>


					<div class="col-3">
						<label>Enfermedad mental *:</label>
						<select name="enfermedad_mental" id="enfermedad_mental" class="form-control form-control-sm">
							<option value="no" <?php if($enfermedad_mental=='no') echo "selected"; ?>>No</option>
							<option value="si" <?php if($enfermedad_mental=='si') echo "selected"; ?>>Si</option>
						</select>
					</div>

					<div class="col-9">
						<label>¿Cúal?:</label>
						<input type="text" class="form-control form-control-sm" name="e_mental" id="e_mental" value="<?php echo $e_mental;?>" maxlength="200" placeholder="¿Cúal?">
					</div>

					<div class="col-3">
						<label>Consumo de medicamentos *:</label>
						<select name="consumo_medicamentos" id="consumo_medicamentos" class="form-control form-control-sm">
							<option value="no" <?php if($consumo_medicamentos=='no') echo "selected"; ?>>No</option>
							<option value="si" <?php if($consumo_medicamentos=='si') echo "selected"; ?>>Si</option>
						</select>
					</div>

					<div class="col-9">
						<label>¿Cúal?:</label>
						<input type="text" class="form-control form-control-sm" name="c_medicamentos" id="c_medicamentos" value="<?php echo $c_medicamentos;?>" maxlength="200" placeholder="¿Cúal?">
					</div>

					<div class="col-3">
						<label>Alergias*:</label>
						<select name="alergias" id="alergias" class="form-control form-control-sm">
							<option value="no" <?php if($alergias=='no') echo "selected"; ?>>No</option>
							<option value="si" <?php if($alergias=='si') echo "selected"; ?>>Si</option>
						</select>
					</div>

					<div class="col-9">
						<label>¿Cúal?:</label>
						<input type="text" class="form-control form-control-sm" name="c_alergias" id="c_alergias" value="<?php echo $c_alergias;?>" maxlength="200" placeholder="¿Cúal?">
					</div>

					<div class="col-3">
						<label>Lesiones*:</label>
						<select name="lesiones" id="lesiones" class="form-control form-control-sm">
							<option value="no" <?php if($lesiones=='no') echo "selected"; ?>>No</option>
							<option value="si" <?php if($lesiones=='si') echo "selected"; ?>>Si</option>
						</select>
					</div>

					<div class="col-9">
						<label>¿Cúal?:</label>
						<input type="text" class="form-control form-control-sm" name="c_lesiones" id="c_lesiones" value="<?php echo $c_lesiones;?>" maxlength="200" placeholder="¿Cúal?">
					</div>
				</div>

				<?php
					if($_SESSION['nivel']!=666){
						echo "<hr>";
						echo "<div class='row'>";
							echo "<div class='col-sm-4'>";
								echo "<label for='nombre'>Sucursal</label>";
								echo "<select name='idsucursal' id='idsucursal' class='form-control form-control-sm'>";
									foreach($sucursal as $key){
										echo  "<option value=".$key->idsucursal;
										if ($key->idsucursal==$idsucursal){
											echo  " selected ";
										}
										echo  ">".$key->nombre."</option>";
									}

								echo "</select>";
							echo "</div>";

							echo "<div class='col-4'>";
								echo "<label for=''>Activo:</label>";
								echo "<select class='form-control form-control-sm' name='autoriza' id='autoriza'>";
								echo "<option value='1'"; if($autoriza=="1") echo "selected"; echo ">Activo</option>";
								echo "<option value='0'"; if($autoriza=="0") echo "selected"; echo ">Inactivo</option>";
								echo "</select>";
							echo "</div>";
						echo "</div>";
					}
				?>
			</div>
			<div class='card-footer'>
				<div class="row">
					<div class="col-sm-12">
						<button class="btn btn-warning btn-sm" type="submit">Guardar</button>
						<?php
							if($idpaciente>0){
								echo "<button class='btn btn-warning btn-sm ml-1' type='button' is='b-link' des='a_pacientes/form_foto' dix='nueva_sub' tp='edit' v_idpaciente='$idpaciente' omodal='1'>Foto</button>";

								echo "<button class='btn btn-warning btn-sm ml-1' type='button' is='b-link' des='a_pacientes/form_pass' dix='nueva_sub' tp='edit' v_idpaciente='$idpaciente' omodal='1'>Contraseña</button>";

								if($_SESSION['nivel']!=666){
									echo "<button class='btn btn-warning btn-sm ml-1' type='button' is='b-link' des='a_pacientes/paciente' v_idpaciente='$idpaciente' dix='trabajo'>Regresar</button>";
								}

							}
							else{
								if($_SESSION['nivel']!=666){
									echo "<button class='btn btn-warning btn-sm ml-1' type='button' is='b-link' des='a_pacientes/paciente' dix='trabajo'>Regresar</button>";
								}
							}
						?>

					</div>
				</div>
			</div>
		</div>
	</form>
</div>
