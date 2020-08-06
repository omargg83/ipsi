<?php
	require_once("../a_actividades/db_.php");

  $id1=clean_var($_REQUEST['id1']);
	$observaciones="";
	$texto="";
	$descripcion="";
	$incisos="0";
	$personalizado="0";
	$usuario="0";
	if($id1==0){
		$idactividad=clean_var($_REQUEST['id2']);
		$idsubactividad=clean_var($_REQUEST['id3']);
	  $tipo=clean_var($_REQUEST['tipo']);
	}
	else{
		$con=$db->contexto_editar($id1);
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

<form is="f-submit" id="form-contexto" db="a_actividades/db_" fun="guarda_contexto" lug="a_actividades/actividad_ver" iddest="<?php echo $idactividad; ?>" cmodal="1">
	<input type="hidden" name="id1" id="id1" value="<?php echo $id1; ?>">
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
		    echo "<textarea class='texto' id='texto' name='texto' rows=10>$texto</textarea>";
	    }
	    else if($tipo=="imagen"){
				echo "<label>Adjuntar imagen</label>";
				echo "<input type='file' class='form-control-file' id='texto' name='texto' accept='image/png, image/jpeg'>";
	    }
	    else if($tipo=="video"){
				echo "<label>Video</label>";
				echo "<textarea id='texto' name='texto' rows=10 class='form-control'>$texto</textarea>";

			}
	    else if($tipo=="archivo"){
				echo "<label>Adjuntar archivo</label>";
	     	echo "<input type='file' class='form-control-file' id='texto' name='texto'>";
	    }
	    else if($tipo=="pregunta"){
	    ?>
				<div class='row'>
					<div class="col-12">
						<label>Agregue texto descriptivo a la respuesta:</label> <small>(Deje en blanco en caso de no requerir)</small>
						<input type="text" name="texto" id="texto" value="<?php echo $texto; ?>" class='form-control'>
					</div>
					<div class="col-4">
						<div class="form-check">
							<input type="checkbox" class="form-check-input" name="incisos" id="incisos" value="varios"
							<?php
								if($incisos=="1"){ echo "checked"; }
							 ?>
						 >
							<label class="form-check-label" for="incisos">Selección de varios incisos</label>
						</div>
					</div>
					<div class="col-4">
						<div class="form-check">
							<input type="checkbox" class="form-check-input" name="personalizado" id="personalizado"  value="personalizado"
							<?php
								if($personalizado=="1"){ echo "checked"; }
							?>
							>
							<label class="form-check-label" for="personalizado">Permitir agregar incisos personalizados</label>
						</div>
					</div>
					<div class="col-4">
						<div class="form-check">
							<input type="checkbox" class="form-check-input" name="usuario" id="usuario"  value="usuario"
							<?php
								if($usuario=="1"){ echo "checked"; }
							?>
							>
							<label class="form-check-label" for="usuario">Texto de usuario despues de insiso</label>
						</div>
					</div>
				</div>

	    <?php
	    }
			else{

			}
	    ?>
	  </div>
	  <div class="card-footer">
	    <button type='submit' class='btn btn-warning '> Guardar</button>
			<button class="btn btn-warning" type="button" is="b-link" des='a_actividades/actividad_ver' dix='trabajo' id1="<?php echo $idactividad; ?>" cmodal="1">Regresar</button>

	  </div>
	</div>
</form>


<script type="text/javascript">
	$(function() {
		$('.texto').summernote({
			lang: 'es-ES',
			placeholder: 'Texto',
			tabsize: 5,
			height: 350
		});
	});
</script>
