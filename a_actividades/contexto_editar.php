<?php
	require_once("db_.php");

  $id1=clean_var($_REQUEST['id1']);
	$idactividad=clean_var($_REQUEST['id2']);
	$idsubactividad=clean_var($_REQUEST['id3']);
  $tipo=clean_var($_REQUEST['tipo']);

	$texto="";
	$descripcion="";
	if($id1==0){

	}
	else{
		$sub=$db->subactividad_editar($id);
		$idactividad=$sub->idactividad;
		$tipo=$sub->tipo;
		$texto=$sub->texto;
		$descripcion=$sub->descripcion;
	}
?>


<form is="f-submit" id="form-contexto" db="a_actividades/db_" fun="guarda_contexto" lug="a_actividades/contexto_editar">
	<input type="hidden" name="id1" id="id1" value="<?php echo $id1; ?>">
	<input type="hidden" name="idsubactividad" id="idsubactividad" value="<?php echo $idsubactividad; ?>">
	<input type="hidden" name="tipo" id="tipo" value="<?php echo $tipo; ?>">

	<div class="card mb-3">
	  <div class="card-header">
	    Subactividad
	  </div>
	  <div class="card-body">
	    <?php
	    if($tipo=="texto"){
	    ?>
				<label>Texto:</label>
		    <textarea id='texto' name='texto'><?php echo $texto; ?></textarea>
	    <?php
	    }
	    else if($tipo=="imagen"){
	    ?>
				<label>Adjuntar imagen</label>
				<input type="file" class="form-control-file" id="exampleFormControlFile1">
	    <?php
	    }
	    else if($tipo=="video"){
	    ?>
				<label>Video</label>
		    <textarea id='video' name='video' class='form-control' rows='10'><?php echo $texto; ?></textarea>
	    <?php
	    }
	    else if($tipo=="archivo"){
	    ?>
				<label>Adjuntar archivo</label>
	     	<input type="file" class="form-control-file" id="exampleFormControlFile1">
	    <?php
	    }
	    else if($tipo=="pregunta"){
	    ?>
				<div class='row'>
					<div class="col-12">
						<label>Pregunta:</label>
						<input type="text" name="pregunta" id="pregunta" value="<?php echo $texto; ?>" class='form-control'>
					</div>
				</div>
				<hr>
				<div class='row'>
					<div class="col-12">
						<label>Agregue texto descriptivo a la respuesta:</label> <small>(Deje en blanco en caso de no requerir)</small>
						<input type="text" name="descripcion" id="descripcion" value="<?php echo $descripcion; ?>" class='form-control'>
					</div>
					<div class="col-4">
						<div class="form-check">
							<input type="checkbox" class="form-check-input" name="incisos" id="incisos"  value="varios">
							<label class="form-check-label" for="incisos">Selección de varios incisos</label>
						</div>
					</div>
					<div class="col-4">
						<div class="form-check">
							<input type="checkbox" class="form-check-input" name="personalizado" id="personalizado"  value="personalizado">
							<label class="form-check-label" for="personalizado">Permitir agregar incisos personalizados</label>
						</div>
					</div>
					<div class="col-4">
						<div class="form-check">
							<input type="checkbox" class="form-check-input" name="usuario" id="usuario"  value="usuario">
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
			<button class="btn btn-warning" type="button" is="b-link" des="a_actividades/actividad_ver" dix="trabajo" iddest="<?php echo $idactividad; ?>">Regresar</button>
	  </div>
	</div>
</form>


<script type="text/javascript">
	$(function() {
		$('#texto').summernote({
			lang: 'es-ES',
			placeholder: 'Texto',
			tabsize: 5,
			height: 150
		});
	});
</script>
