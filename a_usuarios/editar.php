<?php
	require_once("db_.php");

	$idusuario=$_REQUEST['idusuario'];
	$sucursal = $db->sucursal();

	$nombre="";
	$apellidop="";
	$apellidom="";
	$autoriza="";
	$nivel="";
	$correo="";
	$foto="";
	$idsucursal="";
	$autoriza="";
	$edad="";
	$telefono="";
	$edo_civil="";
	$n_hijos="";
	$direccion="";
	$ocupacion="";
  $escolaridad="";
  $religion="";
  $vive="";
  $c_emergencia="";
  $c_telefono="";
  $enfermedad="";
  $medicamento="";
  $terapia="";

	if($idusuario>0){
		$pd = $db->usuario_editar($idusuario);
		$nombre=$pd->nombre;
		$apellidop=$pd->apellidop;
		$apellidom=$pd->apellidom;
		$autoriza=$pd->autoriza;
		$nivel=$pd->nivel;
		$correo=$pd->correo;
		$foto=$pd->foto;
		$idsucursal=$pd->idsucursal;
		$autoriza=$pd->autoriza;
		$edad=$pd->edad;
		$telefono=$pd->telefono;
		$edo_civil=$pd->edo_civil;
		$n_hijos=$pd->n_hijos;
		$direccion=$pd->direccion;
		$ocupacion=$pd->ocupacion;
		$escolaridad=$pd->escolaridad;
		$religion=$pd->religion;
		$vive=$pd->vive;
		$c_emergencia=$pd->c_emergencia;
		$c_telefono=$pd->c_telefono;
		$enfermedad=$pd->enfermedad;
		$medicamento=$pd->medicamento;
		$terapia=$pd->terapia;
	}

?>

<nav aria-label='breadcrumb'>
	<ol class='breadcrumb'>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_usuarios/index" dix="contenido">Cuentas</li>
		<li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_usuarios/editar" v_idusuario="<?php echo $idusuario; ?>" dix="contenido"><?php echo $nombre." ".$apellidop." ".$apellidom; ?></li>
		<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_usuarios/index" dix="contenido">Regresar</button>
	</ol>
</nav>

<div class="container">
	<form is="f-submit" id="form_personal" db="a_usuarios/db_" fun="guardar_usuario" des="a_usuarios/editar" dix="contenido" desid="idusuario" v_idusuario="<?php echo $idusuario; ?>">
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
					<label for="">Edad*:</label>
					<input type="text" class="form-control form-control-sm" name="edad" id="edad" value="<?php echo $edad;?>" placeholder="Edad" required maxlength="45">
				</div>
			</div>
			<div class='row'>
				<div class="col-3">
					<label for="">Correo*:</label>
					<input type="text" class="form-control form-control-sm" name="correo" id="correo" value="<?php echo $correo;?>" placeholder="Correo" required maxlength="100">
				</div>
				<div class="col-3">
					<label for="">Teléfono*:</label>
					<input type="text" class="form-control form-control-sm" name="telefono" id="telefono" value="<?php echo $telefono;?>" placeholder="Teléfono" required maxlength="45">
				</div>
				<div class="col-3">
					<label for="">Estado civil*:</label>
					<input type="text" class="form-control form-control-sm" name="edo_civil" id="edo_civil" value="<?php echo $edo_civil;?>" placeholder="Estado civil" required maxlength="45">
				</div>
				<div class="col-3">
					<label for="">Número de hijos*:</label>
					<input type="text" class="form-control form-control-sm" name="n_hijos" id="n_hijos" value="<?php echo $n_hijos;?>" placeholder="Número de hijos" required maxlength="45">
				</div>
			</div>

			<div class='row'>
				<div class="col-12">
					<label for="" class='text-center'>Dirección en una linea*:</label>
					<input type="text" class="form-control form-control-sm" name="direccion" id="direccion" value="<?php echo $direccion;?>" placeholder="Dirección en una linea" required maxlength="250">
				</div>
			</div>

			<div class='row'>
				<div class="col-3">
					<label>Ocupación*:</label>
					<input type="text" class="form-control form-control-sm" name="ocupacion" id="ocupacion" value="<?php echo $ocupacion;?>" placeholder="Ocupación" required maxlength="100">
				</div>
				<div class="col-3">
					<label>Escolaridad*:</label>
					<input type="text" class="form-control form-control-sm" name="escolaridad" id="escolaridad" value="<?php echo $escolaridad;?>" placeholder="Escolaridad" required maxlength="100">
				</div>
				<div class="col-3">
					<label>Religión*:</label>
					<input type="text" class="form-control form-control-sm" name="religion" id="religion" value="<?php echo $religion;?>" placeholder="Religión" required maxlength="100">
				</div>
				<div class="col-3">
					<label class='text-center'>¿Con quien vive actualmente?*:</label>
					<input type="text" class="form-control form-control-sm" name="vive" id="vive" value="<?php echo $vive;?>" placeholder="¿Con quien vive actualmente?" required maxlength="100">
				</div>
			</div>

			<div class='row'>
				<div class="col-12">
					<h5 class='text-center'><center>Contacto de emergencia:</center></h5>
				</div>
			</div>
			<div class='row'>
				<div class="col-6">
					<label for="" class='text-center'>Nombre Completo*:</label>
					<input type="text" class="form-control form-control-sm" name="c_emergencia" id="c_emergencia" value="<?php echo $c_emergencia;?>" placeholder="Nombre Completo" required maxlength="250">
				</div>
				<div class="col-6">
					<label for="" class='text-center'>Teléfono o Medio de contacto*:</label>
					<input type="text" class="form-control form-control-sm" name="c_telefono" id="c_telefono" value="<?php echo $c_telefono;?>" placeholder="Teléfono" required maxlength="250">
				</div>
			</div>

			<div class='row'>
				<div class="col-12">
					<h5 class='text-center'><center>Historial médico</center></h5>
				</div>
			</div>

			<div class='row'>
				<div class="col-12">
					<h5 class='text-center'><center>Si tienes alguna enfermedad física anotala</center></h5>
					<textarea class='form-control' id='enfermedad' name='enfermedad' rows=3 placeholder='Si tienes alguna enfermedad física anotala'><?php echo $enfermedad;?></textarea>
				</div>
				<div class="col-12">
					<h5 class='text-center'><center>Si tienes consumes algun medicamento anotalo</center></h5>
					<textarea class='form-control' id='medicamento' name='medicamento' rows=3 placeholder='Si tienes consumes algun medicamento anotalo'><?php echo $medicamento;?></textarea>
				</div>
				<div class="col-12">
					<h5 class='text-center'><center>Si haz tomado terapia o te han diagnosticado con una enfermedad mental ¿Qué diagnóstico te dieron? </center></h5>
					<textarea class='form-control' id='terapia' name='terapia' rows=3 placeholder='SI haz tomado terapia o te han diagnosticado con una enfermedad mental ¿Qué diagnóstico te dieron? '><?php echo $terapia;?></textarea>
				</div>
			</div>

			<div class='row'>
				<?php
				echo "<div class='col-4'>";
					echo "<label for=''>Activo:</label>";
					echo "<select class='form-control form-control-sm' name='autoriza' id='autoriza'>";
					echo "<option value='1'"; if($autoriza=="1") echo "selected"; echo ">Activo</option>";
					echo "<option value='0'"; if($autoriza=="0") echo "selected"; echo ">Inactivo</option>";
					echo "</select>";
				echo "</div>";


				if($_SESSION['nivel']==1 or $_SESSION['nivel']==3 or $_SESSION['nivel']==4){
					echo "<div class='col-4'>";
						echo "<label for=''>Nivel:</label>";
						echo "<select class='form-control form-control-sm' name='nivel' id='nivel'>";
							if($_SESSION['nivel']==1)
							echo "<option value='1'"; if($nivel=="1") echo "selected"; echo ">1 Administrador</option>";

							if(($_SESSION['nivel']==1 or ($_SESSION['nivel']==3 and $idusuario==$_SESSION['idusuario'])or $_SESSION['nivel']==4)){
								echo "<option value='3'"; if($nivel=="3") echo "selected"; echo ">3 Admin Sucursal</option>";
							}

							if($_SESSION['nivel']==1 or $_SESSION['nivel']==4)
							echo "<option value='4'"; if($nivel=="4") echo "selected"; echo ">4 Secretaria</option>";
							echo "</select>";
					echo "</div>";
				}
					if($_SESSION['nivel']==1){
						echo "<div class='col-4'>";
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
					}
					?>

			</div>
		</div>

		<div class='card-footer'>
			<div class='row'>
				<div class="col-sm-12">

					<button class="btn btn-warning" type="submit">Guardar</button>
					<?php
						if($idusuario>0){
							echo "<button class='btn btn-warning' type='button' is='b-link' des='a_usuarios/form_foto' v_idusuario='$idusuario' omodal='1'>Foto</button>";
							echo "<button class='btn btn-warning' type='button' is='b-link' des='a_usuarios/form_pass' v_idusuario='$idusuario' omodal='1'>Contraseña</button>";
						}

						echo "<button class='btn btn-warning' type='button' is='b-link' des='a_usuarios/index' dix='contenido'>Regresar</button>";

					?>

				</div>
			</div>
		</div>
	</div>
	</form>
</div>
