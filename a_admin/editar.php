<?php
	require_once("db_.php");
	if (isset($_REQUEST['idmail'])){$idmail=$_REQUEST['idmail'];} else{ $idmail=0;}

	if($idmail>0){
		$pd = $db->config_editar($idmail);
		$correo=$pd->correo;
		$user=$pd->user;
		$pass=$pd->pass;
		$smtpsecure=$pd->smptsecure;
		$port=$pd->port;
		$tiempo=$pd->tiempo;
		$texto=$pd->texto;
		$asunto=$pd->asunto;
		
	}
?>

<div class="container">
	<form is="f-submit" id="form_cliente" db="a_admin/db_" fun="guardar_correo" des="a_admin/editar" desid='idmail'>
		<input type="hidden" name="idmail" id="idmail" value="<?php echo $idmail;?>">
		<div class='card'>
			<div class='card-header'>
				Editar correo
			</div>
			<div class='card-body'>
				<div class='form-group row'>
					<label class="col-2">Correo:</label>
					<div class='col-10'>
							<input type="text" class="form-control " name="correo" id="correo" value="<?php echo $correo;?>" placeholder="Nombre" readonly>
					</div>
				</div>

				<div class=' form-group row'>
					<label class="col-2">Usuario:</label>
					<div class='col-10'>
						<input type="text" class="form-control " name="user" id="user" value="<?php echo $user;?>" placeholder="Usuario" maxlength='155'>
					</div>
				</div>

				<div class=' form-group row'>
					<label class="col-2">Contraseña:</label>
					<div class='col-10'>	
						<input type="password" class="form-control " name="pass" id="pass" value="<?php echo $pass;?>" placeholder="Contraseña" maxlength='145' >
					</div>
				</div>

				<div class=' form-group row'>
					<label class="col-2">SMPTsecure:</label>
					<div class='col-10'>	
						<input type="text" class="form-control " name="smtpsecure" id="smtpsecure" value="<?php echo $smtpsecure;?>" placeholder="SMPTsecure" maxlength='145' >
					</div>
				</div>

				<div class=' form-group row'>
					<label class="col-2">Puerto:</label>
					<div class='col-10'>	
						<input type="text" class="form-control " name="port" id="port" value="<?php echo $port;?>" placeholder="Puerto" maxlength='145' >
					</div>
				</div>

				<div class=' form-group row'>
					<label class="col-2">Tiempo:</label>
					<div class='col-10'>	
						<input type="text" class="form-control " name="tiempo" id="tiempo" value="<?php echo $tiempo;?>" placeholder="Tiempo" maxlength='145' >
					</div>
				</div>

				<div class=' form-group row'>
					<label class="col-2">Asunto:</label>
					<div class='col-10'>	
						<input type="text" class="form-control " name="asunto" id="asunto" value="<?php echo $asunto;?>" placeholder="asunto" maxlength='145' >
					</div>
				</div>

				<div class=' form-group row'>
					<label class="col-2">Texto:</label>
					<div class='col-10'>
						<?php
							echo "<div id='div_$idmail' name='div_$idmail' onclick='editable(this)' style='width:100%; height: 200px; border:1px solid silver'>$texto</div>";
							echo "<small>De clic para editar</small>";
						?>
					</div>
				</div>

			</div>

			<div class='card-footer'>
				<div class="row">
					<div class='col-12'>

						<button class="btn btn-warning btn-sm" type="submit">Guardar</button>
						<button type='button' class='btn btn-warning btn-sm' id='lista_penarea' is='b-link' des='a_admin/lista' dix='trabajo' title='regresar'>Regresar</button>

					</div>
				</div>
			</div>
		</div>
	</form>
</div>
