<?php
	require_once("db_.php");

  $id=clean_var($_REQUEST['id']);

	$sub=$db->subactividad_editar($id);
	$idactividad=$sub->idactividad;
	$tipo=$sub->tipo;
	$texto=$sub->texto;
	$descripcion=$sub->descripcion;

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
				<br>
		   	<?php echo $texto; ?>
	    <?php
	    }
	    else if($tipo=="imagen"){
	    ?>
				<label>Imagen</label>
				<?php echo $texto; ?>
	    <?php
	    }
	    else if($tipo=="video"){
	    ?>
				<label>Video</label>
				<?php echo $texto; ?>
	    <?php
	    }
	    else if($tipo=="archivo"){
	    ?>
				<label>Adjuntar archivo</label>
	     	<?php echo $texto; ?>
	    <?php
	    }
	    else if($tipo=="pregunta"){
	    ?>
				<div class='row'>
					<div class="col-12">
						<label><?php echo $texto; ?></label>
					</div>
				</div>
				<hr>
				<div class='row'>
					<div class="col-12">
						<label><?php echo $descripcion; ?></label>
					</div>
					<div class="col-4">
						<div class="form-check">
							<input type="checkbox" class="form-check-input" name="incisos" id="incisos"  value="varios" disabled>
							<label class="form-check-label" for="incisos">Selección de varios incisos</label>
						</div>
					</div>
					<div class="col-4">
						<div class="form-check">
							<input type="checkbox" class="form-check-input" name="personalizado" id="personalizado"  value="personalizado" disabled>
							<label class="form-check-label" for="personalizado">Permitir agregar incisos personalizados</label>
						</div>
					</div>
					<div class="col-4">
						<div class="form-check">
							<input type="checkbox" class="form-check-input" name="usuario" id="usuario"  value="usuario" disabled>
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
			<button type='button' class='btn btn-warning' onclick='subactividad_editar(<?php echo $id; ?>)'><i class='fas fa-pencil-alt'></i>Editar</button>
			<button type='button' class='btn btn-warning' onclick='actividad_ver(<?php echo $idactividad; ?>)'><i class="fas fa-undo-alt"></i>Regresar</button>
	  </div>
	</div>
</form>

<div class='card mb-3'>
	<div class='card-header'>
		Respuestas
	</div>
	<div class='card-body' id='respuestas'>
		<div class="row">
			<?php
				$pd=$db->repuestas($id);
				foreach($pd as $key){
					echo "<div id='".$key->id."''  class='edit-t col-3 mb-3'>";
						echo "<div class='row'>";
						echo "<div class='col-3'>";
							echo "<div class='btn-group'>";
							echo "<button class='btn btn-warning ' onclick='respuestas_editar($key->id,$idactividad,$key->idsubactividad)'><i class='fas fa-pencil-alt'></i></button>";
							echo "</div>";
						echo "</div>";

						echo "<div class='col-3'>";
						if(strlen($key->imagen)>0){
							echo "<img src='".$db->doc.$key->imagen."' width='200px'>";
						}
						echo "</div>";
						echo "<div class='col-6'>".$key->orden.".-".$key->respuesta."</div>";
						echo "</div>";
					echo "</div>";
				}
		echo "</div>";
				if($tipo=="pregunta"){
					echo "<div class='row'>";
						echo "<div class='col-12'>";
							echo "<button type='button' class='btn btn-warning' onclick='respuestas_editar(0,$idactividad,$id)'><i class='fas fa-plus'></i>Inciso</button>";
						echo "</div>";
					echo "</div>";
				}
			?>
		</div>
	</div>
</div>
