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
	

  
  
  
  	$enfermedad="";


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
		
		
	
		$enfermedad=$pd->enfermedad;
	
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
	<form is="f-submit" id="form_personal" db="a_usuarios/db_" fun="guardar_usuario" des="a_usuarios/editar_cuenta" dix="contenido" desid="idusuario" v_idusuario="<?php echo $idusuario; ?>">
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

					<button class="btn btn-warning btn-sm ml-1" type="submit">Guardar</button>
					<?php
						if($idusuario>0){
							echo "<button class='btn btn-warning btn-sm ml-1' type='button' is='b-link' des='a_usuarios/form_foto' v_idusuario='$idusuario' omodal='1'>Foto</button>";
							echo "<button class='btn btn-warning btn-sm ml-1' type='button' is='b-link' des='a_usuarios/form_pass' v_idusuario='$idusuario' omodal='1'>Contraseña</button>";
						}

						echo "<button class='btn btn-warning btn-sm ml-1' type='button' is='b-link' des='a_usuarios/index' dix='contenido'>Regresar</button>";

					?>

				</div>
			</div>
		</div>
	</div>
	</form>
</div>
