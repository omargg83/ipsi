<?php
	require_once("db_.php");

  $id=clean_var($_REQUEST['id']);
	$texto="";
	$descripcion="";
	if($id==0){
		$idactividad=clean_var($_REQUEST['idactividad']);
		$tipo=clean_var($_REQUEST['tipo']);
	}
	else{
		$sub=$db->subactividad_editar($id);
		$idactividad=$sub->idactividad;
		$tipo=$sub->tipo;
		$texto=$sub->texto;
		$descripcion=$sub->descripcion;
	}
?>
<form id='form_subact' action='' data-lugar='a_actividades/db_'  data-funcion='guarda_subactividad'>
	<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
	<input type="hidden" name="idactividad" id="idactividad" value="<?php echo $idactividad; ?>">
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
	    <button type='submit' class='btn btn-warning '><i class='far fa-save'></i> Guardar</button>
			<?php
			if($tipo=="pregunta"){
				?>
				<button type='button' class='btn btn-warning' onclick='respuestas_ver(<?php echo $idactividad; ?>)'><i class="fas fa-plus"></i>Respuestas</button>
			<?php
			}
			?>
			<button type='button' class='btn btn-warning' onclick='actividad_ver(<?php echo $idactividad; ?>)'><i class="fas fa-undo-alt"></i>Regresar</button>
	  </div>
	</div>
</form>

<div class='card mb-3'>
	<div class='card-header'>
		Respuestas
	</div>
	<div class='card-body'>
		<?php
			$pd=$db->repuestas($id);
			foreach($pd as $key){
				echo "<div id='".$key->id."''  class='row edit-t'>";

					echo "<div class='col-1'>";
						echo "<div class='btn-group'>";
						echo "<button class='btn btn-warning ' onclick='preguntas($idactividad,$key->id)'><i class='fas fa-pencil-alt'></i></button>";
						echo "</div>";
					echo "</div>";

					echo "<div class='col-10'>".$key->orden.".-".$key->respuesta."</div>";
				echo "</div>";
			}
		?>
	</div>
</div>


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
