<?php
	require_once("db_.php");

  $id=clean_var($_REQUEST['id']);
  $idactividad=clean_var($_REQUEST['idactividad']);
  $tipo=clean_var($_REQUEST['tipo']);


?>
<form id='form_subact' action='' data-lugar='a_actividades/db_'  data-funcion='guarda_subactividad'>
	<input type="text" name="id" id="id" value="<?php echo $id; ?>">
	<input type="text" name="idactividad" id="idactividad" value="<?php echo $idactividad; ?>">
	<input type="text" name="tipo" id="tipo" value="<?php echo $tipo; ?>">

	<div class="card">
	  <div class="card-header">
	    Subactividad
	  </div>
	  <div class="card-body">
	    <?php
	    if($tipo=="texto"){
	    ?>
				<label>Texto:</label>
		    <textarea id='texto' name='texto'></textarea>
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
		    <textarea id='video' name='video' class='form-control' rows='10'></textarea>
	    <?php
	    }
	    else if($tipo=="archivo"){
	    ?>
				<label>Adjuntar archivo</label>
	     	<input type="file" class="form-control-file" id="exampleFormControlFile1">
	    <?php
	    }
	    else{
	    ?>

	    <?php
	    }
	    ?>
	  </div>
	  <div class="card-footer">
	    <button type='submit' class='btn btn-warning '><i class='far fa-save'></i> Guardar</button>
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
