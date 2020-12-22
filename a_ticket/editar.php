<?php
	require_once("db_.php");

	$idticket=$_REQUEST['idticket'];

	$numero="";
	$asunto="";
	$mensaje="";

	if($idticket>0){
		$pd = $db->ticket_editar($idticket);
		$numero=$pd->numero;
		$asunto=$pd->asunto;
		$mensaje=$pd->mensaje;
	}
?>

<div class="container">
	<form is="f-submit" id="form_personal" db="a_ticket/db_" fun="guardar_ticket" des="a_ticket/editar" desid="idticket">
		<input type="hidden" class="form-control form-control-sm" name="idticket" id="idticket" value="<?php echo $idticket ;?>" readonly>
		<div class='card'>
		<div class='card-header'>
			Ticket
		</div>
		<div class='card-body'>
			<div class='row'>
				<div class="col-4">
					<label for="">Número:</label>
					<input type="text" class="form-control form-control-sm" name="numero" id="numero" value="<?php echo $numero;?>" placeholder="Número" readonly>
				</div>
			</div>
			<div class='row'>
				<div class="col-12">
					<label for="">Asunto:</label>
					<input type="text" class="form-control form-control-sm" name="asunto" id="asunto" value="<?php echo $asunto;?>" placeholder="Asunto" required>
				</div>
			</div>
			<div class='row'>
				<div class="col-12">
					<label for="">Mensaje:</label>
					<?php
						echo "<div id='mensaje_$idticket' name='mensaje_$idticket' onclick='editable(this)' style='width:100%; height: 200px; border:1px solid silver'>$mensaje</div>";
					?>
				</div>
			</div>
			<div class='row'>
				<div class="col-12">
					<label for="">Adjunto:</label>
					<br>
					<input type="file" name="foto" id="foto" value="" multiple>
				</div>
			</div>
		</div>

		<div class='card-footer'>
			<div class='row'>
				<div class="col-sm-12">
					<button class="btn btn-warning btn-sm" type="submit"><i class='far fa-save'></i>Guardar</button>
					<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_usuarios/lista" dix="trabajo"><i class="fas fa-undo"></i>Regresar</button>
				</div>
			</div>
		</div>
	</div>
	</form>
</div>
