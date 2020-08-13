<?php
	require_once("db_.php");
	$idpaciente=clean_var($_REQUEST['idpaciente']);

	$nombre="";
	$apellidop="";
	$apellidom="";
	$telefono="";
	$correo="";
	$foto="";
	$observaciones="";
	$idusuario="";
	$direccion="";
	$edad="";
	$sexo="";
	$peso="";
	$altura="";
	$enfermedades="";
	$medicamentos="";
	$per = $db->personal();

	if($idpaciente>0){
		$pd = $db->cliente_editar($idpaciente);
		$nombre=$pd->nombre;
		$apellidop=$pd->apellidop;
		$apellidom=$pd->apellidom;
		$telefono=$pd->telefono;
		$correo=$pd->correo;
		$foto=$pd->foto;
		$observaciones=$pd->observaciones;
		$idusuario=$pd->idusuario;
		$direccion=$pd->direccion;
		$edad=$pd->edad;
		$sexo=$pd->sexo;
		$peso=$pd->peso;
		$altura=$pd->altura;
		$enfermedades=$pd->enfermedades;
		$medicamentos=$pd->medicamentos;
	}
	?>
	<nav aria-label='breadcrumb'>
		<ol class='breadcrumb'>
			<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/lista" dix="contenido">Pacientes</li>
			<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/paciente" v_idpaciente="<?php echo $idpaciente; ?>" dix="contenido"><?php echo $nombre." ".$apellidop." ".$apellidom; ?></li>
			<li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_pacientes/editar" v_idpaciente="<?php echo $idpaciente; ?>" dix="contenido">Ficha de registro</li>
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
						<label>Nombre:</label>
							<input type="text" class="form-control form-control-sm" name="nombre" id="nombre" value="<?php echo $nombre;?>" placeholder="Nombre" maxlength="100" required >
					</div>

					<div class="col-3">
						<label>Apellido Paterno:</label>
							<input type="text" class="form-control form-control-sm" name="apellidop" id="apellidop" value="<?php echo $apellidop;?>" placeholder="Apellido Paterno" maxlength="50" required>
					</div>

					<div class="col-3">
						<label>Apellido materno:</label>
							<input type="text" class="form-control form-control-sm" name="apellidom" id="apellidom" value="<?php echo $apellidom;?>" placeholder="Apellido materno" maxlength="50">
					</div>

					<div class="col-3">
						<label>Correo:</label>
							<input type="text" class="form-control form-control-sm" name="correo" id="correo" value="<?php echo $correo;?>" placeholder="Correo" maxlength="100" required>
					</div>
				</div>
				<div class='row'>
					<div class="col-3">
						<label>Edad:</label>
							<input type="text" class="form-control form-control-sm" name="edad" id="edad" value="<?php echo $edad;?>" placeholder="Edad"  maxlength="20">
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

					<div class="col-8">
						<label>Dirección:</label>
							<input type="text" class="form-control form-control-sm" name="direccion" id="direccion" value="<?php echo $direccion;?>" placeholder="Dirección" maxlength="255">
					</div>

					<div class="col-4">
						<label>Teléfono:</label>
							<input type="text" class="form-control form-control-sm" name="telefono" id="telefono" value="<?php echo $telefono;?>" maxlength="20" placeholder="Teléfono">
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
								echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/form_foto' dix='nueva_sub' tp='edit' v_idpaciente='$idpaciente' omodal='1'><i class='fas fa-camera'></i>Foto</button>";
								echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/form_pass' dix='nueva_sub' tp='edit' v_idpaciente='$idpaciente' omodal='1'><i class='fas fa-key'></i>Contraseña</button>";
							}
						?>
						<button class='btn btn-warning btn-sm' type='button' is="b-link" des="a_pacientes/paciente" v_idpaciente="<?php echo $idpaciente; ?>" dix="contenido">Regresar</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
