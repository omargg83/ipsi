<?php
	require_once("db_.php");

	$idhorario=$_REQUEST['idhorario'];

  if($idhorario>0){
    $pd=$db->horario_editar($idhorario);
    $desde = date ( 'h:i' , strtotime($pd->desde));
    $hasta = date ( 'h:i' , strtotime($pd->hasta));
    $idconsultorio=$pd->idconsultorio;
  }
  else{
    $idconsultorio=$_REQUEST['idconsultorio'];
    $desde=date("h:i");
    $hasta = strtotime ( '+1 hour' , strtotime ($desde) ) ;
    $hasta = date ( 'h:i' , $hasta);
  }
?>

<div class="container">
		<form is="f-submit" id="form_cliente" db="a_consultorios/db_" fun="guardar_horario" des="a_consultorios/horarios" desid='idhorario' v_idconsultorio='<?php echo $idconsultorio;?>'>
			<input type="hidden" name="idhorario" id="idhorario" value="<?php echo $idhorario;?>">
			<input type="hidden" name="idconsultorio" id="idconsultorio" value="<?php echo $idconsultorio;?>">
			<div class="card">
				<div class='card-header'>
					Horarios
				</div>
				<div class='card-body'>

					<div class="row">
						<div class='col-6'>
							<label for='nombre'>Desde</label>
							<input type="time" class="form-control " name="desde" id="desde" value="<?php echo $desde;?>" placeholder="Desde" required>
						</div>

						<div class='col-6'>
							<label for='nombre'>Hasta</label>s
							<input type="time" class="form-control " name="hasta" id="hasta" value="<?php echo $hasta;?>" placeholder="Hasta" required>
						</div>
					</div>
					<div class="row">
						<div class='col-12'>
								<button class="btn btn-warning btn-sm" type="submit">Guardar</button>

                <button type='button' class='btn btn-warning btn-sm' id='lista_penarea' is='b-link' des='a_consultorios/horarios' dix='trabajo' title='regresar' v_idconsultorio='<?php echo $idconsultorio;?>'>Regresar</button>
						</div>
					</div>

				</div>
			</div>
		</form>
</div>
