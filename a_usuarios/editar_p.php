<?php
	require_once("db_.php");

	$idusuario=$_SESSION['idusuario'];
	$foto="";
	$autoriza="";
	$nombre="";
	$apellidop="";
	$apellidom="";
	$edad="";
	$nacionalidad="";
	$f_nacimiento="";
	$curp="";
	$correo="";
	$telefono="";
	$edo_civil="";
	$n_hijos="";
	$rfc="";
	$seguro="";
	$estudios="";
	$nombre_vive="";
	$parentesco_vive="";
	$telefono_vive="";

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

	$licenciatura="";
	$universidad="";
	$posgrado_1="";
	$universidad_1="";
	$posgrado_2="";
	$universidad_2="";
	$posgrado_3="";
	$universidad_3="";
	
	$nivel="";
	
	
	$idsucursal="";
	$autoriza="";
	
	


	if($idusuario>0){
		$pd = $db->usuario_editar($idusuario);
		$foto=$pd->foto;
		$autoriza=$pd->autoriza;
		$nombre=$pd->nombre;
		$apellidop=$pd->apellidop;
		$apellidom=$pd->apellidom;
		$edad=$pd->edad;
		$nacionalidad=$pd->nacionalidad;
		$f_nacimiento=$pd->f_nacimiento;
		$curp=$pd->curp;
		$correo=$pd->correo;
		$telefono=$pd->telefono;
		$edo_civil=$pd->edo_civil;
		$n_hijos=$pd->n_hijos;
		$rfc=$pd->rfc;
		$seguro=$pd->seguro;
		$estudios=$pd->estudios;
		$direccion=$pd->direccion;
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
		
		$nivel=$pd->nivel;
		
		$idsucursal=$pd->idsucursal;
		$autoriza=$pd->autoriza;

		$licenciatura=$pd->licenciatura;
		$universidad=$pd->universidad;
		$posgrado_1=$pd->posgrado_1;
		$universidad_1=$pd->universidad_1;
		$posgrado_2=$pd->posgrado_2;
		$universidad_2=$pd->universidad_2;
		$posgrado_3=$pd->posgrado_3;
		$universidad_3=$pd->universidad_3;
	}
echo "nivel:".$nivel;

?>

<div class="container">
	<form is="f-submit" id="form_personal" db="a_usuarios/db_" fun="guardar_usuario" des="a_usuarios/editar_p" dix='contenido' desid="idusuario" v_idusuario="<?php echo $idusuario; ?>">

		<input type="hidden" class="form-control form-control-sm" name="idusuario" id="idusuario" value="<?php echo $idusuario ;?>" placeholder="No" readonly>
		<div class='card'>
		<div class='card-body'>
			<?php
				echo "<div class='form-group' id='imagen_div'>";
					echo "<img src='".$db->doc.trim($foto)."' class='img-thumbnail' width='100px'>";
				echo "</div>";
			?>

			<div class='row'>
				
				<div class="col-3">
					<label for="">Nombre*:</label>
					<input type="text" class="form-control form-control-sm" name="nombre" id="nombre" value="<?php echo $nombre;?>" placeholder="Nombre" maxlength="100" required>
				</div>

				<div class="col-3">
					<label for="">Apellido Paterno*:</label>
					<input type="text" class="form-control form-control-sm" name="apellidop" id="apellidop" value="<?php echo $apellidop;?>" placeholder="Apellido Paterno" maxlength="100" required>
				</div>

				<div class="col-3">
					<label for="">Apellido Materno*:</label>
					<input type="text" class="form-control form-control-sm" name="apellidom" id="apellidom" value="<?php echo $apellidom;?>" placeholder="Apellido Materno" maxlength="100" required>
				</div>

				<div class="col-3">
					<label for="">Correo*:</label>
					<input type="text" class="form-control form-control-sm" name="correo" id="correo" value="<?php echo $correo;?>" placeholder="Correo" required maxlength="100">
				</div>

				<div class="col-3">
					<label for="">Fecha de nacimiento*:</label>
					<input type="date" class="form-control form-control-sm" name="f_nacimiento" id="f_nacimiento" value="<?php echo $f_nacimiento;?>" placeholder="Nacionalidad" required maxlength="100">
				</div>

				<div class="col-2">
					<label for="">Edad*:</label>
					<input type="text" class="form-control form-control-sm" name="edad" id="edad" value="<?php echo $edad;?>" placeholder="Edad" required maxlength="45">
				</div>

				<div class="col-3">
					<label for="">Nacionalidad*:</label>
					<input type="text" class="form-control form-control-sm" name="nacionalidad" id="nacionalidad" value="<?php echo $nacionalidad;?>" placeholder="Nacionalidad" required maxlength="100">
				</div>

			
			</div>
			<div class='row'>
				

				<div class="col-3">
					<label for="">RFC*:</label>
					<input type="text" class="form-control form-control-sm" name="rfc" id="rfc" value="<?php echo $rfc;?>" placeholder="RFC" required maxlength="13">
				</div>

				<div class="col-3">
					<label for="">CURP*:</label>
					<input type="text" class="form-control form-control-sm" name="curp" id="curp" value="<?php echo $curp;?>" placeholder="CURP" required maxlength="100">
				</div>

				<div class="col-3">
					<label for="">Numero de seguro social*:</label>
					<input type="text" class="form-control form-control-sm" name="seguro" id="seguro" value="<?php echo $seguro;?>" placeholder="Seguro social" required maxlength="13">
				</div>


				<div class="col-3">
					<label for="">Telefono/Celular*:</label>
					<input type="text" class="form-control form-control-sm" name="telefono" id="telefono" value="<?php echo $telefono;?>" placeholder="Teléfono" required maxlength="45">
				</div>
				<?php
					if($nivel==4){					
						echo "<div class='col-3'>";
							echo "<label for=''>Último grado de estudios*:</label>";
							echo "<input type='text' class='form-control form-control-sm' name='estudios' id='estudios' value='$estudios' placeholder='Último grado de estudios' required maxlength='200'>";
						echo "</div>";
					}
				?>

				<div class="col-3">
					<label for="">Estado civil*:</label>
					<select name="edo_civil" id="edo_civil" class="form-control form-control-sm" required>
						<option value="soltero" <?php if($edo_civil=='soltero') echo "selected"; ?>>Soltero</option>
						<option value="casado" <?php if($edo_civil=='casado') echo "selected"; ?>>Casado</option>
						<option value="divorciado" <?php if($edo_civil=='divorciado') echo "selected"; ?>>Divorciado</option>
						<option value="unión libre" <?php if($edo_civil=='unión libre') echo "selected"; ?>>Unión libre</option>
						<option value="viudo" <?php if($edo_civil=='viudo') echo "selected"; ?>>Viudo</option>
					</select>
				</div>
				<?php
					if($nivel==4)
					{
						echo "<div class='col-3'>";
							echo "<label for=''>Número de hijos*:</label>";
							echo "<input type='text' class='form-control form-control-sm' name='n_hijos' id='n_hijos' value='$n_hijos' placeholder='Número de hijos' required maxlength='45'>";
						echo "</div>";
					}
				?>
			
			</div>

			<div class='row'>
				<div class="col-12">
					<label for="" class='text-center'>Dirección en una linea*:</label>
					<input type="text" class="form-control form-control-sm" name="direccion" id="direccion" value="<?php echo $direccion;?>" placeholder="Dirección en una linea" required maxlength="250">
				</div>
			</div>
			<hr>

				<?php
					if($nivel==1 or $nivel==2){	
						echo "<div class='row'>";
							echo "<div class='col-6'>";
								echo "<label >Licenciatura*:</label>";
								echo "<input type='text' class='form-control form-control-sm' name='licenciatura' id='licenciatura' value='$licenciatura' placeholder='Licenciatura' required maxlength='200'>";
							echo "</div>";

							echo "<div class='col-6'>";
								echo "<label >Universidad*:</label>";
								echo "<input type='text' class='form-control form-control-sm' name='universidad' id='universidad' value='$universidad' placeholder='Universidad' required maxlength='200'>";
							echo "</div>";

							echo "<div class='col-6'>";
								echo "<label >Posgrado 1:</label>";
								echo "<input type='text' class='form-control form-control-sm' name='posgrado_1' id='posgrado_1' value='$posgrado_1' placeholder='Posgrado' maxlength='200'>";
							echo "</div>";

							echo "<div class='col-6'>";
								echo "<label >Universidad 1:</label>";
								echo "<input type='text' class='form-control form-control-sm' name='universidad_1' id='universidad_1' value='$universidad_1' placeholder='Universidad' maxlength='200'>";
							echo "</div>";

							echo "<div class='col-6'>";
								echo "<label >Posgrado 2:</label>";
								echo "<input type='text' class='form-control form-control-sm' name='posgrado_2' id='posgrado_2' value='$posgrado_2' placeholder='Posgrado' maxlength='200'>";
							echo "</div>";

							echo "<div class='col-6'>";
								echo "<label >Universidad 2:</label>";
								echo "<input type='text' class='form-control form-control-sm' name='universidad_2' id='universidad_2' value='$universidad_2' placeholder='Universidad' maxlength='200'>";
							echo "</div>";

							echo "<div class='col-6'>";
								echo "<label >Posgrado 3:</label>";
								echo "<input type='text' class='form-control form-control-sm' name='posgrado_3' id='posgrado_3' value='$posgrado_3' placeholder='Posgrado' maxlength='200'>";
							echo "</div>";

							echo "<div class='col-6'>";
								echo "<label >Universidad 3:</label>";
								echo "<input type='text' class='form-control form-control-sm' name='universidad_3' id='universidad_3' value='$universidad_3' placeholder='Universidad' maxlength='200'>";
							echo "</div>";
						echo "</div>";

					}
				?>
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
			
		</div>

		<div class='card-footer'>
			<div class='row'>
				<div class="col-sm-12">
					<button class="btn btn-warning btn-sm ml-1" type="submit">Guardar</button>
					<?php
						echo "<button class='btn btn-warning btn-sm ml-1' type='button' is='b-link' des='a_usuarios/form_foto' v_idusuario='$idusuario' omodal='1'>Foto</button>";
						echo "<button class='btn btn-warning btn-sm ml-1' type='button' is='b-link' des='a_usuarios/form_pass' v_idusuario='$idusuario' omodal='1'>Contraseña</button>";
					?>
				</div>
			</div>
		</div>
	</div>




	</form>
</div>
