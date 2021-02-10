<?php
	require_once("../a_actividades/db_.php");

  $idcontexto=clean_var($_REQUEST['idcontexto']);
	$paciente=0;
	if (isset($_REQUEST['idpaciente'])) {
		$idpaciente=clean_var($_REQUEST['idpaciente']);
		$paciente=1;
	}

	$observaciones="";
	$texto="";
	$descripcion="";
	$incisos="0";
	$personalizado="0";
	$usuario="0";
	$orden="";
	$pagina="0";
	if($idcontexto==0){
		$idactividad=clean_var($_REQUEST['idactividad']);
		$idsubactividad=clean_var($_REQUEST['idsubactividad']);
	  $tipo=clean_var($_REQUEST['tipo']);

		$sql="select max(orden) as maximo from contexto where idsubactividad='$idsubactividad'";
		$sth = $db->dbh->prepare($sql);
		$sth->execute();
		$ordena=$sth->fetch(PDO::FETCH_OBJ);
		$orden=$ordena->maximo+1;

	}
	else{
		$con=$db->contexto_editar($idcontexto);
		$idsubactividad=$con->idsubactividad;
		$tipo=$con->tipo;
		$texto=$con->texto;
		$descripcion=$con->descripcion;
		$observaciones=$con->observaciones;
		$incisos=$con->incisos;
		$personalizado=$con->personalizado;
		$usuario=$con->usuario;
		$orden=$con->orden;
		$pagina=$con->pagina;
	}

	$sub=$db->subactividad_editar($idsubactividad);
	$idactividad=$sub->idactividad;

	$actividad=$db->actividad_editar($idactividad);
	$tipo_actividad=$actividad->tipo;

	if($paciente==0){
		echo "<form is='f-submit' id='form-contexto' db='a_actividades/db_' fun='guarda_contexto' des='a_actividades/actividad_ver' v_idactividad='$idactividad' cmodal='1'>";
	}
	else{
		echo "<form is='f-submit' id='form-contexto' db='a_actividades/db_' fun='guarda_contexto' des='a_pacientes/actividad_ver' v_idactividad='$idactividad' v_idpaciente='$idpaciente' cmodal='1'>";
	}

?>
	<input type="hidden" name="id1" id="id1" value="<?php echo $idcontexto; ?>">
	<input type="hidden" name="idsubactividad" id="idsubactividad" value="<?php echo $idsubactividad; ?>">
	<input type="hidden" name="tipo" id="tipo" value="<?php echo $tipo; ?>">

	<div class="modal-header">
	  Editar contexto
	</div>

	<div class="modal-body">
			<?php

			echo "<input type='hidden' class='form-control-file' id='orden' name='orden' value='$orden'>";
			echo "<label>Observaciones:</label>";
			echo "<textarea id='observaciones' name='observaciones' class='form-control'>$observaciones</textarea>";


	    if($tipo=="texto"){
				echo "<label>Texto:</label>";
				echo "<div id='div_$idcontexto' name='div_$idcontexto' onclick='editable(this)' style='width:100%; height: 200px; border:1px solid silver'>$texto</div>";
				echo "<small>De clic para editar</small>";
	    }
	    else if($tipo=="imagen"){
				echo "<label>Adjuntar imagen</label>";
				echo "<input type='file' id='texto_$idcontexto' name='texto_$idcontexto' accept='image/png, image/jpeg'>";
				echo "<hr>";
				if(strlen($texto)>0){
					echo "<img src='".$db->doc.$texto."' width='500px'>";
				}
	    }
	    else if($tipo=="video"){
				echo "<label>Video</label>";
				echo "<textarea id='texto' name='texto' rows=5 class='form-control'>$texto</textarea>";
			}
	    else if($tipo=="archivo"){
				echo "<label>Adjuntar archivo</label>";
	     	echo "<input type='file' class='form-control-file' id='texto' name='texto'>";
	    }
	    else if($tipo=="pregunta"){
				echo "<div class='row'>";
					echo "<div class='col-12'>";
						echo "<label>Agregue texto descriptivo a la respuesta:</label> <small>(Deje en blanco en caso de no requerir)</small>";
						echo "<input type='text' name='texto' id='texto' value='$texto' class='form-control'>";
					echo "</div>";
						echo "<div class='col-4'>";
							echo "<div class='form-check'>";
								echo "<input type='checkbox' class='form-check-input' name='incisos' id='incisos' value='varios'"; if($incisos=='1'){ echo "checked"; } echo ">";
								echo "<label class='form-check-label' for='incisos'>Selección de varios incisos</label>";
							echo "</div>";
						echo "</div>";
						if($tipo_actividad=="normal"){
							echo "<div class='col-4'>";
								echo "<div class='form-check'>";
									echo "<input type='checkbox' class='form-check-input' name='personalizado' id='personalizado'  value='personalizado'"; if($personalizado=='1'){ echo 'checked'; }	echo ">";
									echo "<label class='form-check-label' for='personalizado'>Permitir agregar incisos personalizados</label>";
								echo "</div>";
							echo "</div>";
						}
						echo "<div class='col-4'>";
							echo "<div class='form-check'>";
								echo "<input type='checkbox' class='form-check-input' name='usuario' id='usuario'  value='usuario'"; if($usuario=='1'){ echo 'checked'; } echo 	">";
								echo "<label class='form-check-label' for='usuario'>Texto de usuario despues de inciso</label>";
							echo "</div>";
						echo "</div>";
				echo "</div>";
	    }
			else if($tipo=="textores"){

			}
			else if($tipo=="textocorto"){

			}
			else if($tipo=="fecha"){

			}
			else if($tipo=="archivores"){

			}


	    ?>
  </div>
  <div class="modal-footer">
    <button type='submit' class='btn btn-warning '> Guardar</button>
		<button class="btn btn-warning" type="button" is="b-link" des='a_actividades/actividad_ver' dix='trabajo' id1="<?php echo $idactividad; ?>" cmodal="1">Regresar</button>
  </div>

</form>
