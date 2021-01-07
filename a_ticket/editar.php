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
		$imagen1=$pd->imagen1;
		$imagen2=$pd->imagen2;
		$imagen3=$pd->imagen3;
		$imagen4=$pd->imagen4;
		$imagen5=$pd->imagen5;
	}
?>

<div class="container">
	<form is="f-submit" id="form_personal" db="a_ticket/db_" fun="guardar_ticket" des="a_ticket/editar" desid="idticket">
		<input type="hidden" class="form-control form-control-sm" name="idticket" id="idticket" value="<?php echo $idticket ;?>" readonly>
		<div class='card mb-3'>
			<div class='card-header'>
				Ticket <?php echo "#".$numero; ?>
			</div>
			<div class='card-body'>
				<div class='row'>
					<div class="col-12">
						<label for="">Asunto:</label>
						<input type="text" class="form-control form-control-sm" name="asunto" id="asunto" value="<?php echo $asunto;?>" placeholder="Asunto" required
						<?php 
							if($idticket!=0){
								echo "readonly";
							}
						?>
						
						>
					</div>
				</div>
				<div class='row'>
					<div class="col-12">
						<label for="">Mensaje:</label>
						<?php
							if($idticket==0){
								echo "<div id='mensaje_ticket' name='mensaje_ticket' onclick='editable(this)' style='width:100%; height: 200px; border:1px solid silver'>$mensaje</div>";
							}
							else{
								echo "<br>";
								echo "<textarea row='5' class='form-control' readonly>";
								echo strip_tags ($mensaje);
								echo "</textarea>";
							}
						?>
					</div>
				</div>
				<br>
				
				<?php
					if($idticket==0){
						echo "<div class='row'>";
							echo "<div class='col-10'>";
							echo "<input type='file' name='foto1' id='foto1' value=''>";
							echo "</div>";
							echo "<div class='col-2'>";
								echo "<button class='btn btn-warning btn-sm'>+ Agregar</button>";
							echo "</div>";
						echo "</div>";

						echo "<div class='row'>";
							echo "<div class='col-10'>";
							echo "<input type='file' name='foto2' id='foto2' value=''>";
							echo "</div>";
							echo "<div class='col-2'>";
								echo "<button class='btn btn-warning btn-sm'>+ Agregar</button>";
							echo "</div>";
						echo "</div>";

						echo "<div class='row'>";
							echo "<div class='col-10'>";
							echo "<input type='file' name='foto3' id='foto3' value=''>";
							echo "</div>";
							echo "<div class='col-2'>";
								echo "<button class='btn btn-warning btn-sm'>+ Agregar</button>";
							echo "</div>";
						echo "</div>";

						echo "<div class='row'>";
							echo "<div class='col-10'>";
							echo "<input type='file' name='foto4' id='foto4' value=''>";
							echo "</div>";
							echo "<div class='col-2'>";
								echo "<button class='btn btn-warning btn-sm'>+ Agregar</button>";
							echo "</div>";
						echo "</div>";

						echo "<div class='row'>";
							echo "<div class='col-10'>";
							echo "<input type='file' name='foto5' id='foto5' value=''>";
							echo "</div>";
							echo "<div class='col-2'>";
								echo "<button class='btn btn-warning btn-sm'>+ Agregar</button>";
							echo "</div>";
						echo "</div>";
					}
					else{
						echo "<div class='col-12'>";
							if(strlen($imagen1)>0 and file_exists("../a_archivos/ticket/$imagen1"))
							echo "<a href='a_archivos/ticket/$imagen1' download><img src='a_archivos/ticket/$imagen1' width='100px' height='100px' class='rounded-sm'></a>";

							if(strlen($imagen2)>0 and file_exists("../a_archivos/ticket/$imagen2"))
							echo "<a href='a_archivos/ticket/$imagen2' download><img src='a_archivos/ticket/$imagen2' width='100px' height='100px' class='rounded-sm'></a>";

							if(strlen($imagen3)>0 and file_exists("../a_archivos/ticket/$imagen3"))
							echo "<a href='a_archivos/ticket/$imagen3' download><img src='a_archivos/ticket/$imagen3' width='100px' height='100px' class='rounded-sm'></a>";

							if(strlen($imagen4)>0 and file_exists("../a_archivos/ticket/$imagen4"))
							echo "<a href='a_archivos/ticket/$imagen4' download><img src='a_archivos/ticket/$imagen4' width='100px' height='100px' class='rounded-sm'></a>";

							if(strlen($imagen5)>0 and file_exists("../a_archivos/ticket/$imagen5"))
							echo "<a href='a_archivos/ticket/$imagen5' download><img src='a_archivos/ticket/$imagen5' width='100px' height='100px' class='rounded-sm'></a>";
						echo "</div>";
					}	
				?>
			</div>

			<div class='card-footer'>
				<div class='row'>
					<div class="col-sm-12">
					<?php
						if($idticket==0){
							echo "<button class='btn btn-warning btn-sm' type='submit'><i class='far fa-save'></i>Guardar</button>";
						}
					?>
						<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_ticket/lista" dix="trabajo"><i class="fas fa-undo"></i>Regresar</button>
					</div>
				</div>
			</div>
		</div>
	</form>
<?php 

	

	$reg=$db->ticket_registro($idticket);
	foreach($reg as $v2){
		echo "<div class='card mb-3'>";
			echo "<div class='card-header'>";
				echo $v2->asunto;
				echo "<span class='text-right'>".fecha($v2->fecha,2)."</span>";
			echo "</div>";
			echo "<div class='card-body'>";
			echo strip_tags ($v2->mensaje);
			echo "</div>";

			echo "<div class='card-body'>";
			echo "<div class='col-12'>";
				if(strlen($v2->imagen1)>0 and file_exists("../a_archivos/ticket/$v2->imagen1"))
				echo "<a href='a_archivos/ticket/$v2->imagen1' download><img src='a_archivos/ticket/$v2->imagen1' width='100px' height='100px' class='rounded-sm'></a>";
				if(strlen($v2->imagen2)>0 and file_exists("../a_archivos/ticket/$v2->imagen2"))
				echo "<a href='a_archivos/ticket/$v2->imagen2' download><img src='a_archivos/ticket/$v2->imagen2' width='100px' height='100px' class='rounded-sm'></a>";
				if(strlen($v2->imagen3)>0 and file_exists("../a_archivos/ticket/$v2->imagen3"))
				echo "<a href='a_archivos/ticket/$v2->imagen3' download><img src='a_archivos/ticket/$v2->imagen3' width='100px' height='100px' class='rounded-sm'></a>";
				if(strlen($v2->imagen4)>0 and file_exists("../a_archivos/ticket/$v2->imagen4"))
				echo "<a href='a_archivos/ticket/$v2->imagen4' download><img src='a_archivos/ticket/$v2->imagen4' width='100px' height='100px' class='rounded-sm'></a>";
				if(strlen($v2->imagen5)>0 and file_exists("../a_archivos/ticket/$v2->imagen5"))
				echo "<a href='a_archivos/ticket/$v2->imagen5' download><img src='a_archivos/ticket/$v2->imagen5' width='100px' height='100px' class='rounded-sm'></a>";
			echo "</div>";
			echo "</div>";
		echo "</div>";
	}

	if($idticket!=0){
		echo "<form is='f-submit' id='form_hijo' db='a_ticket/db_' fun='guardar_hijo' des='a_ticket/editar' desid='idticket'>";
		echo "<div class='card mb-3'>";
			echo "<input type='hidden' class='form-control form-control-sm' name='idticket' id='idticket' value='$idticket' readonly>";
			echo "<div class='card-body'>";		
				echo "<div class='row'>";
					echo "<div class='col-12'>";
						echo "<label>Asunto:</label>";
						echo "<input type='text' class='form-control form-control-sm' name='asunto' id='asunto' value='' placeholder='Asunto' required>";
					echo "</div>";
				echo "</div>";
				echo "<div class='row'>";
					echo "<div class='col-12'>";
						echo "<label>Mensaje:</label>";
						echo "<div id='mensaje_hijo' name='mensaje_hijo' onclick='editable(this)' style='width:100%; height: 200px; border:1px solid silver'></div>";		
					echo "</div>";
				echo "</div>";

				echo "<div class='row'>";
					echo "<div class='col-10'>";
					echo "<input type='file' name='foto1' id='foto1' value=''>";
					echo "</div>";
					echo "<div class='col-2'>";
						echo "<button class='btn btn-warning btn-sm'>+ Agregar</button>";
					echo "</div>";
				echo "</div>";

				echo "<div class='row'>";
					echo "<div class='col-10'>";
					echo "<input type='file' name='foto2' id='foto2' value=''>";
					echo "</div>";
					echo "<div class='col-2'>";
						echo "<button class='btn btn-warning btn-sm'>+ Agregar</button>";
					echo "</div>";
				echo "</div>";

				echo "<div class='row'>";
					echo "<div class='col-10'>";
					echo "<input type='file' name='foto3' id='foto3' value=''>";
					echo "</div>";
					echo "<div class='col-2'>";
						echo "<button class='btn btn-warning btn-sm'>+ Agregar</button>";
					echo "</div>";
				echo "</div>";

				echo "<div class='row'>";
					echo "<div class='col-10'>";
					echo "<input type='file' name='foto4' id='foto4' value=''>";
					echo "</div>";
					echo "<div class='col-2'>";
						echo "<button class='btn btn-warning btn-sm'>+ Agregar</button>";
					echo "</div>";
				echo "</div>";

				echo "<div class='row'>";
					echo "<div class='col-10'>";
					echo "<input type='file' name='foto5' id='foto5' value=''>";
					echo "</div>";
					echo "<div class='col-2'>";
						echo "<button class='btn btn-warning btn-sm'>+ Agregar</button>";
					echo "</div>";
				echo "</div>";
				
			echo "</div>";
			echo "<div class='card-footer'>";
				echo "<div class='row'>";
					echo "<div class='col-sm-12'>";
						echo "<button class='btn btn-warning btn-sm' type='submit'><i class='far fa-save'></i>Guardar</button>";		
					echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
	echo "</form>";

	}
?>

</div>