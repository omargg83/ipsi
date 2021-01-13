<?php
	require_once("db_.php");
	$idpaciente=clean_var($_REQUEST['idpaciente']);

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

	$foto="";
	$observaciones="";
	$idusuario="";
	$sexo="";
	$peso="";
	$altura="";
	$enfermedades="";
	$medicamentos="";
	$fnacimiento="";
	$hermanos="";
	$facebook="";
	$estudios="";
	$trabajo="";
	$puesto="";
	$ipsi="";
	$contacto="";
	$parentesco="";
	$telparentesco="";
	$idsucursal="";
	$per = $db->personal();
	$sucursal = $db->sucursal_lista();

	if($idpaciente>0){
		$pd = $db->cliente_editar($idpaciente);
		$nombre=$pd->nombre;
		$apellidop=$pd->apellidop;
		$apellidom=$pd->apellidom;
		$edad=$pd->edad;
		$correo=$pd->correo;
		$civil=$pd->civil;
		$hijos=$pd->hijos;
		$direccion=$pd->direccion;
		$ocupacion=$pd->ocupacion;
		$escolaridad=$pd->escolaridad;
		$religion=$pd->religion;
		$vive=$pd->vive;
		$nombre_vive=$pd->nombre_vive;
		$telefono_vive=$pd->telefono_vive;
		$idsucursal=$pd->idsucursal;


		$telefono=$pd->telefono;
		$foto=$pd->foto;
		$observaciones=$pd->observaciones;
		$idusuario=$pd->idusuario;
		$sexo=$pd->sexo;
		$peso=$pd->peso;
		$altura=$pd->altura;
		$enfermedades=$pd->enfermedades;
		$medicamentos=$pd->medicamentos;
		$fnacimiento=$pd->fnacimiento;
		$hermanos=$pd->hermanos;
		$facebook=$pd->facebook;
		$estudios=$pd->estudios;
		$trabajo=$pd->trabajo;
		$puesto=$pd->puesto;
		$ipsi=$pd->ipsi;
		$contacto=$pd->contacto;
		$parentesco=$pd->parentesco;
		$telparentesco=$pd->telparentesco;
	}
	?>
	<nav aria-label='breadcrumb'>
		<ol class='breadcrumb'>
			<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/index" dix="trabajo">Pacientes</li>
			<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/paciente" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo"><?php echo $nombre." ".$apellidop." ".$apellidom; ?></li>
			<li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_pacientes/editar" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Ficha de registro</li>
			<?php
			if($idpaciente>0){
				echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/paciente' v_idpaciente='$idpaciente' dix='trabajo'>Regresar</button>";
			}
			else{
				echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' is='li-link' des='a_pacientes/index' dix='trabajo'>Regresar</button>";
			}

			?>
		</ol>
	</nav>

<div class="container">
	<form is="f-submit" id="form_cliente" db="a_pacientes/db_" fun="guardar_cliente" des="a_pacientes/editar" desid="idpaciente" >
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
							<input type="text" class="form-control form-control-sm" name="apellidom" id="apellidom" value="<?php echo $apellidom;?>" placeholder="Apellido materno" maxlength="50">
					</div>

					<div class="col-3">
						<label>Edad:</label>
							<input type="text" class="form-control form-control-sm" name="edad" id="edad" value="<?php echo $edad;?>" placeholder="Edad"  maxlength="20">
					</div>

				</div>
				<div class='row'>

					<div class="col-3">
						<label>Correo:</label>
							<input type="text" class="form-control form-control-sm" name="correo" id="correo" value="<?php echo $correo;?>" placeholder="Correo" maxlength="100" required>
					</div>

					<div class="col-3">
						<label>Teléfono:</label>
							<input type="text" class="form-control form-control-sm" name="telefono" id="telefono" value="<?php echo $telefono;?>" maxlength="20" placeholder="Teléfono">
					</div>

					<div class="col-3">
						<label>Estado Civil:</label>
						<input type="text" class="form-control form-control-sm" name="civil" id="civil" value="<?php echo $civil;?>" maxlength="100" placeholder="Estado civil">
					</div>

					<div class="col-3">
						<label>Número de hijos*:</label>
						<input type="text" class="form-control form-control-sm" name="hijos" id="hijos" value="<?php echo $hijos;?>" maxlength="100" placeholder="Número de hijos">
					</div>
				</div>


				<div class='row'>
					<div class="col-12">
						<label>Dirección en una linea:</label>
						<input type="text" class="form-control form-control-sm" name="direccion" id="direccion" value="<?php echo $direccion;?>"  maxlength="200">
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
						<label>Religión*:</label>
						<input type="text" class="form-control form-control-sm" name="religion" id="religion" value="<?php echo $religion;?>" maxlength="100" placeholder="Religión" required>
					</div>

					<div class="col-3">
						<label>¿Con quien vive actualmente?*:</label>
						<input type="text" class="form-control form-control-sm" name="vive" id="vive" value="<?php echo $vive;?>" maxlength="100" placeholder="¿Con quien vive actualmente?" required>
					</div>
				</div>

				<div class='row'>
					<div class="col-12">
						<h5><center><b>Contacto de emergencia</b></center></h5>
					</div>
					<div class="col-6">
						<label>Nombre completo*:</label>
						<input type="text" class="form-control form-control-sm" name="nombre_vive" id="nombre_vive" value="<?php echo $nombre_vive;?>" maxlength="200" placeholder="Nombre completo" required>
					</div>

					<div class="col-6">
						<label>Teléfono o Medio de contacto*:</label>
						<input type="text" class="form-control form-control-sm" name="telefono_vive" id="telefono_vive" value="<?php echo $telefono_vive;?>" maxlength="100" placeholder="Teléfono o Medio de contacto" required>
					</div>
				</div>

				<div class='row'>
					<div class='col-sm-4'>
						<label for='nombre'>Sucursal</label>
						<select name='idsucursal' id='idsucursal' class='form-control form-control-sm'>
						<?php
							foreach($sucursal as $key){
								echo  "<option value=".$key->idsucursal;
								if ($key->idsucursal==$idsucursal){
									echo  " selected ";
								}
								echo  ">".$key->nombre."</option>";
							}
						?>
						</select>
					</div>
				</div>
				<hr>




				<div class='row'>
					<div class="col-3">
						<label>Fecha nacimiento:</label>
							<input type="date" class="form-control form-control-sm" name="fnacimiento" id="fnacimiento" value="<?php echo $fnacimiento;?>"  maxlength="20">
					</div>


					<div class='col-sm-3'>
						<label for='nombre'>Sexo</label>
						<select name='sexo' id='sexo' class='form-control form-control-sm'>
						<?php
							echo  "<option value='masculino'"; if ($sexo=="masculino"){	echo  " selected ";	}	echo  ">Masculino</option>";
							echo  "<option value='femenino'"; if ($sexo=="femenino"){	echo  " selected ";	}	echo  ">Femenino</option>";
						?>
						</select>
					</div>

					<div class="col-3">
						<label>Peso:</label>
							<input type="text" class="form-control form-control-sm" name="peso" id="peso" value="<?php echo $peso;?>" placeholder="Peso" maxlength="20">
					</div>

					<div class="col-3">
						<label>Altura:</label>
							<input type="text" class="form-control form-control-sm" name="altura" id="altura" value="<?php echo $altura;?>" placeholder="Altura" maxlength="20">
					</div>

					<div class="col-3">
						<label>Hermanos:</label>
						<input type="text" class="form-control form-control-sm" name="hermanos" id="hermanos" value="<?php echo $hermanos;?>" placeholder="Numero de hermanos"  maxlength="20">
					</div>

					<div class="col-3">
						<label>Facebook:</label>
						<input type="text" class="form-control form-control-sm" name="facebook" id="facebook" value="<?php echo $facebook;?>" placeholder="Facebook"  maxlength="200">
					</div>
					<div class="col-3">
						<label>Nivel máximo de estudios:</label>
						<input type="text" class="form-control form-control-sm" name="estudios" id="estudios" value="<?php echo $estudios;?>" placeholder="Nivel máximo de estudios"  maxlength="100">
					</div>
					<div class="col-3">
						<label>Nombre del lugar de trabajo o escuela:</label>
						<input type="text" class="form-control form-control-sm" name="trabajo" id="trabajo" value="<?php echo $trabajo;?>" placeholder="Nombre del lugar de trabajo o escuela"  maxlength="100">
					</div>
					<div class="col-3">
						<label>Nombre del puesto o Número de grado actual:</label>
						<input type="text" class="form-control form-control-sm" name="puesto" id="puesto" value="<?php echo $puesto;?>" placeholder="Nombre del puesto o Número de grado actual"  maxlength="100">
					</div>
					<div class="col-3">
						<label>Como te enteraste de IPSI:</label>
						<input type="text" class="form-control form-control-sm" name="ipsi" id="ipsi" value="<?php echo $ipsi;?>" placeholder="Como te enteraste de IPSI"  maxlength="100">
					</div>
				</div>
				<div class='row'>
					<div class="col-3">
						<label>Nombre de contacto:</label>
						<input type="text" class="form-control form-control-sm" name="contacto" id="contacto" value="<?php echo $contacto;?>" placeholder="Nombre de contacto"  maxlength="150">
					</div>
					<div class="col-3">
						<label>Parentesco:</label>
						<input type="text" class="form-control form-control-sm" name="parentesco" id="parentesco" value="<?php echo $parentesco;?>" placeholder="Parentesco"  maxlength="150">
					</div>
					<div class="col-3">
						<label>Telefono:</label>
						<input type="text" class="form-control form-control-sm" name="telparentesco" id="telparentesco" value="<?php echo $telparentesco;?>" placeholder="Telefono"  maxlength="150">
					</div>
				</div>

				<div class='row'>
					<div class='col-sm-4'>
						<label for='nombre'>Nombre del Psicólogo</label>
						<select name='idusuario' id='idusuario' class='form-control form-control-sm'>
						<?php
							foreach($per as $key){
								echo  "<option value=".$key->idusuario;
								if ($key->idusuario==$idusuario){
									echo  " selected ";
								}
								echo  ">".$key->nombre."</option>";
							}
						?>
						</select>
					</div>
				</div>




				<div class='row'>
					<div class="col-12">
						<label>Información personal:</label>
							<textarea class="form-control form-control-sm" name="observaciones" id="observaciones" placeholder="Información personal" rows=5><?php echo $observaciones;?></textarea>
					</div>
				</div>
				<div class='row'>
					<div class="col-12">
						<label>Enfermedades previas:</label>
							<textarea class="form-control form-control-sm" name="enfermedades" id="enfermedades" placeholder="Enfermedades previas" rows=5><?php echo $enfermedades;?></textarea>
					</div>
				</div>
				<div class='row'>
					<div class="col-12">
						<label>Medicamentos que consume:</label>
							<textarea class="form-control form-control-sm" name="medicamentos" id="medicamentos" placeholder="Medicamentos que consume" rows=5><?php echo $medicamentos;?></textarea>
					</div>
				</div>
			</div>
			<div class='card-footer'>
				<div class="row">
					<div class="col-sm-12">
						<button class="btn btn-warning btn-sm" type="submit">Guardar</button>
						<?php
							if($idpaciente>0){
								echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/form_foto' dix='nueva_sub' tp='edit' v_idpaciente='$idpaciente' omodal='1'>Foto</button>";
								echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/form_pass' dix='nueva_sub' tp='edit' v_idpaciente='$idpaciente' omodal='1'>Contraseña</button>";
								echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/paciente' v_idpaciente='$idpaciente' dix='trabajo'>Regresar</button>";
							}
							else{
								echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/paciente' dix='trabajo'>Regresar</button>";
							}
						?>

					</div>
				</div>
			</div>
		</div>
	</form>
</div>
