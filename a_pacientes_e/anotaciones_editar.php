<?php
	require_once("../a_actividades/db_.php");
  $idpaciente=clean_var($_REQUEST['idpaciente']);
  $idactividad=clean_var($_REQUEST['idactividad']);

  $actividad=$db->actividad_editar($idactividad);
  $anotaciones=$actividad->anotaciones;
  $texto="";

  echo "<form is='f-submit' id='form-contexto' db='a_pacientes/db_' fun='guarda_anotacion' des='a_pacientes/actividad_ver' v_idactividad='$idactividad' v_idpaciente='$idpaciente' cmodal='1'>";
?>
 <div class="card">
   <div class="card-header">
     Anotaciones
   </div>
   <div class="card-body">

     <label>Anotaciones:</label>
     <textarea class='texto' id='anotaciones' name='anotaciones' rows=5><?php echo $anotaciones; ?></textarea>
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
 			height: 250
 		});
 	});
 </script>
