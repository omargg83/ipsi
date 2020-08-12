<?php
	require_once("../a_pacientes/db_.php");

  $idcontexto=clean_var($_REQUEST['idcontexto']);
	$idactividad=clean_var($_REQUEST['idactividad']);
	$idpaciente=clean_var($_REQUEST['idpaciente']);


	$observaciones="";
	$texto="";
	$descripcion="";
	$incisos="0";
	$personalizado="0";
	$usuario="0";



	if($idcontexto==0){
		$idactividad=clean_var($_REQUEST['id2']);
		$idsubactividad=clean_var($_REQUEST['id3']);
	  $tipo=clean_var($_REQUEST['tipo']);
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
	}

	$sub=$db->subactividad_editar($idsubactividad);
	$idactividad=$sub->idactividad;
?>

<form is="f-submit" id="form-contexto" db="a_pacientes/db_" fun="guarda_contexto" des="a_pacientes/actividad_ver" v_idactividad="<?php echo $idactividad; ?>" v_idpaciente="<?php echo $idpaciente; ?>" cmodal="1">
	<input type="hidden" name="id1" id="id1" value="<?php echo $idcontexto; ?>">
	<input type="hidden" name="idsubactividad" id="idsubactividad" value="<?php echo $idsubactividad; ?>">
	<input type="hidden" name="tipo" id="tipo" value="<?php echo $tipo; ?>">

	<div class="card mb-3">
	  <div class="card-header">
	    Editar contexto
	  </div>
	  <div class="card-body">
			<label>Observaciones:</label>
			<textarea id='observaciones' name='observaciones' class="form-control"><?php echo $observaciones; ?></textarea>

	    <?php
	    if($tipo=="texto"){
				echo "<label>Texto:</label>";
		    echo "<textarea class='texto' id='texto' name='texto' rows=5>$texto</textarea>";
	    }
	    else if($tipo=="imagen"){
				echo "<label>Adjuntar imagen</label>";
				echo "<input type='file' class='form-control-file' id='texto' name='texto' accept='image/png, image/jpeg'>";
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
					echo "<div class='col-4'>";
						echo "<div class='form-check'>";
							echo "<input type='checkbox' class='form-check-input' name='personalizado' id='personalizado'  value='personalizado'"; if($personalizado=='1'){ echo 'checked'; }	echo ">";
							echo "<label class='form-check-label' for='personalizado'>Permitir agregar incisos personalizados</label>";
						echo "</div>";
					echo "</div>";
					echo "<div class='col-4'>";
						echo "<div class='form-check'>";
							echo "<input type='checkbox' class='form-check-input' name='usuario' id='usuario'  value='usuario'"; if($usuario=='1'){ echo 'checked'; } echo 	">";
							echo "<label class='form-check-label' for='usuario'>Texto de usuario despues de insiso</label>";
						echo "</div>";
					echo "</div>";
				echo "</div>";
	    }
			else if($tipo=="textores"){
				echo "<label>Agregar texto</label>";
				echo "<textarea class='form-control' id='texto' name='texto' rows=5 placeholder=''>$texto</textarea>";
			}
			else if($tipo=="fecha"){
				echo "<label>Fecha</label>";
				echo "<input type='date' name='texto' id='texto' value='$texto' class='form-control'>";
			}
			else if($tipo=="archivores"){
				echo "<label>Fecha</label>";
				echo "<input type='file' name='texto' id='texto' class='form-control'>";
			}
	    ?>
	  </div>
	  <div class="card-footer">
	    <button type='submit' class='btn btn-warning '> Guardar</button>
			<button class="btn btn-warning" type="button" is="b-link" cmodal="1">Regresar</button>
	  </div>
	</div>
</form>


<script type="text/javascript">
	$(function() {
		$('.texto').summernote({
			lang: 'es-ES',
			placeholder: 'Texto',
			tabsize: 5,
			height: 250
		});
	});
</script>
