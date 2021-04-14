<?php
	require_once("db_.php");
	$desde=$_REQUEST['desde'];
	$idusuario=$_REQUEST['idusuario'];
	$pd = $db->usuario_editar($idusuario);
	$nombre=$pd->nombre;
	$dix='trabajo';

	$desde="";
	if(isset($_REQUEST['desde'])){
		$desde=$_REQUEST['desde'];
	}
	$pd = $db->usuario_editar($idusuario);
	$nombre=$pd->nombre;
	$apellidop=$pd->apellidop;
	$apellidom=$pd->apellidom;

	if($desde=='contenido'){
		echo "<div class='card-header'>";
			echo "<button type='button' class='btn btn-warning btn-sm ml-1' id='lista_penarea' is='b-link' des='a_terapeutas/editar_horario' dix='modal_form' title='regresar' v_desde='$desde' v_idusuario='$idusuario' v_idhorario='0'>Agregar horario</button>";

			echo "<button type='button' class='btn btn-warning btn-sm ml-1' id='lista_penarea' is='b-link' cmodal='1'>Regresar</button>";
		echo "</div>";
	}
	else{
		echo "<nav aria-label='breadcrumb'>";
			echo "<ol class='breadcrumb'>";
			 	
				echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_terapeutas/index' dix='$dix'>Terapeuta</li>";
				echo "<li class='breadcrumb-item active' id='lista_track' is='li-link' des='a_terapeutas/terapeuta' v_idusuario='$idusuario' dix='$dix'>$nombre $apellidop $apellidom</li>";
				
				
				echo "<li class='breadcrumb-item active' id='lista_track' is='li-link' des='a_usuarios/editar_trabajo' v_desde='$desde' v_idusuario='$idusuario' dix='trabajo'>Editar</li>";
				echo "<li class='breadcrumb-item active' id='lista_track' is='li-link' des='a_usuarios/horarios' v_desde='$desde' v_idusuario='$idusuario' dix='$dix'>Horarios</li>";

				echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_usuarios/editar_trabajo' v_desde='$desde' v_idusuario='$idusuario' dix='trabajo'>Regresar</button>";

			echo "</ol>";
		echo "</nav>";

		echo "<div class='container'>";
			echo "<div class='card'>";
				echo "<div class='card-header'>";

												
					echo "<button type='button' class='btn btn-warning btn-sm' id='lista_penarea' is='b-link' des='a_terapeutas/editar_horario' dix='trabajo' title='regresar' v_desde='$desde' v_idusuario='$idusuario' v_idhorario='0' >Agregar horario</button>";
				
			echo "</div>";
	}

		echo "<div class='card-body'>";
			echo "<div class='tabla_v' id='tabla_css'>";
				echo "<div class='header-row'>";
					echo "<div class='cell'>#</div>";
					echo "<div class='cell'>Dia</div>";
					echo "<div class='cell'>Desde</div>";
					echo "<div class='cell'>Hasta</div>";
				echo "</div>";
				
					$horarios=$db->usuario_horarios($idusuario);
					foreach($horarios as $key){
						echo "<div class='body-row' >";
							echo "<div class='cell'>";
							
							if($desde=="contenido"){
								echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_usuarios/editar_horario' dix='modal_form' v_idhorario='$key->idhorario' v_desde='$desde'>Editar</button>";

								echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_usuarios/horarios' dix='modal_form' db='a_terapeutas/db_' fun='horario_quitar' v_idhorario='$key->idhorario' v_idusuario='$idusuario' tp='¿Desea eliminar el horario seleccionado?' title='Borrar' v_desde='$desde'>Eliminar</button>";
							}
							else{
								
								echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_usuarios/editar_horario' dix='trabajo' v_desde='$desde' v_idhorario='$key->idhorario'>Editar</button>";

								echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_usuarios/horarios' dix='trabajo' db='a_terapeutas/db_' fun='horario_quitar' v_desde='$desde' v_idhorario='$key->idhorario' v_idusuario='$idusuario' tp='¿Desea eliminar el horario seleccionado?' title='Borrar'>Eliminar</button>";
							}

							echo "</div>";
							echo "<div class='cell' data-titulo='Dia'>".$key->desde_dia."</div>";
							echo "<div class='cell' data-titulo='Desde'>".date ( 'h:i A' , strtotime($key->desde))."</div>";
							echo "<div class='cell' data-titulo='Hasta'>".date ( 'h:i A' , strtotime($key->hasta))."</div>";

						echo "</div>";
					}
					
			echo "</div>";

		echo "</div>";
if($desde=='trabajo'){
		echo "</div>";
	echo "</div>";
}
