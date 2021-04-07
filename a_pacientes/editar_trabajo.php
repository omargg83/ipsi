<?php
	require_once("db_.php");

	if($_SESSION['nivel']==666){
		$idpaciente=$_SESSION['idusuario'];
	}
	else{
		$idpaciente=clean_var($_REQUEST['idpaciente']);
	}

	$divdes="contenido";
	if(isset($_REQUEST['divdes']))
		$divdes=$_REQUEST['divdes'];
	
	$nombrec="Agregar paciente";
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
		
		$nombrec="$nombre $apellidop $apellidom";
	}

	
		echo "<nav aria-label='breadcrumb'>";
			echo "<ol class='breadcrumb'>";
				echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_pacientes/index' dix='trabajo'>Pacientes</li>";
				if($idpaciente>0)
					echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_pacientes/paciente' v_idpaciente='$idpaciente' dix='trabajo'>$nombrec</li>";
				else
					echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_pacientes/editar_trabajo' v_idpaciente='$idpaciente' dix='trabajo'>$nombrec</li>";

				echo "<li class='breadcrumb-item active' id='lista_track' is='li-link' des='a_pacientes/editar_trabajo' v_idpaciente='$idpaciente' dix='trabajo'>Ficha de registro</li>";
				if($idpaciente>0){
					echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/paciente' v_idpaciente='$idpaciente' dix='trabajo'>Regresar</button>";
				}
				else{
					echo "<button class='btn btn-warning btn-sm' type='button' is='b-link'  des='a_pacientes/index' dix='trabajo'>Regresar</button>";
				}
			echo "</ol>";
		echo "</nav>";
	

echo "<div class='container'>";
	
	echo "<form is='f-submit' id='form_cliente' db='a_pacientes/db_' fun='guardar_cliente' des='a_pacientes/editar_trabajo' desid='idpaciente' dix='trabajo'>";
		echo "<input type='hidden' name='idpaciente' id='idpaciente' value='$idpaciente'>";
		echo "<div class='card'>";
			include "editar_paciente.php";
		
			echo "<div class='card-footer'>";
				echo "<div class='row'>";
					echo "<div class='col-sm-12'>";
						echo "<button class='btn btn-warning btn-sm' type='submit'>Guardar</button>";
						
							if($idpaciente>0){
								echo "<button class='btn btn-warning btn-sm ml-1' type='button' is='b-link' des='a_pacientes/form_foto' v_desde='trabajo' v_idpaciente='$idpaciente' omodal='1'>Foto</button>";

								echo "<button class='btn btn-warning btn-sm ml-1' type='button' is='b-link' des='a_pacientes/form_pass' v_desde='trabajo' v_idpaciente='$idpaciente' omodal='1'>Contraseña</button>";
								
								echo "<button class='btn btn-warning btn-sm ml-1' type='button' is='b-link' des='a_pacientes/paciente' v_idpaciente='$idpaciente' dix='trabajo'>Regresar</button>";
							}
							else{
								echo "<button class='btn btn-warning btn-sm ml-1' type='button' is='b-link' des='a_pacientes/index' dix='trabajo'>Regresar</button>";
							}
							
					echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
	echo "</form>";
echo "</div>";
?>
