<?php
	require_once("db_.php");
	$desde="";

	if(isset($_REQUEST['idusuario']))
		$idusuario=$_REQUEST['idusuario'];
	else
		$idusuario=$_SESSION['idusuario'];
	
	if(isset($_REQUEST['desde'])){
		$desde=$_REQUEST['desde'];		
	}
	
	
	$sucursal = $db->sucursal();
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
	
	
	$idsucursal=$_SESSION['idsucursal'];
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
		$autoriza=$pd->autoriza;
		$idsucursal=$pd->idsucursal;
	}

	
	echo "<nav aria-label='breadcrumb'>";
		echo "<ol class='breadcrumb'>";
			echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_terapeutas/index' dix='trabajo'>Terapeuta</li>";
			echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_terapeutas/terapeuta' v_idusuario='$idusuario' dix='trabajo'>$nombre $apellidop $apellidom</li>";
			echo "<li class='breadcrumb-item active' id='lista_track' is='li-link' des='a_usuarios/editar_trabajo' v_desde='$desde' v_idusuario='$idusuario' dix='trabajo'>Editar</li>";
			echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_terapeutas/terapeuta' v_idusuario='$idusuario' dix='trabajo'>Regresar</button>";
		echo "</ol>";
	echo "</nav>";

	echo "<div class='container'>";

		echo "<form is='f-submit' id='form_personal' db='a_usuarios/db_' fun='guardar_usuario' des='a_usuarios/editar_trabajo' dix='trabajo' desid='idusuario' v_idusuario='$idusuario' v_desde='$desde'>";
		echo "<input type='hidden' class='form-control form-control-sm' name='idusuario' id='idusuario' value='$idusuario' placeholder='No' readonly>";
			echo "<div class='card'>";
			include "editar_usuario.php";
	
?>

		<div class='card-footer'>
			<div class='row'>
				<div class="col-sm-12">
					<button class="btn btn-warning btn-sm ml-1" type="submit">Guardar</button>
					<?php
						echo "<button class='btn btn-warning btn-sm ml-1' type='button' is='b-link' des='a_usuarios/form_foto' v_idusuario='$idusuario' omodal='1' v_desde='trabajo'>Foto</button>";
						echo "<button class='btn btn-warning btn-sm ml-1' type='button' is='b-link' des='a_usuarios/form_pass' v_idusuario='$idusuario' omodal='1' v_desde='trabajo'>Contraseña</button>";

						echo "<button class='btn btn-warning btn-sm ml-1' type='button' is='b-link' des='a_usuarios/horarios' v_desde='trabajo' v_idusuario='$idusuario' dix='trabajo'>Horarios</button>";
						echo "<button class='btn btn-warning btn-sm ml-1' type='button' is='b-link' des='a_terapeutas/terapeuta' v_desde='trabajo' v_idusuario='$idusuario' dix='trabajo'>Regresar</button>";
						
						
					?>
				</div>
			</div>
		</div>
	</div>




	</form>
</div>
