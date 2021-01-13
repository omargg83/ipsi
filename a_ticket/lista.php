<?php
	require_once("db_.php");
	$pd = $db->ticket_lista();
?>


<div class='container'>
	<div class='tabla_v' id='tabla_css'>

	<div class='header-row'>
		<div class='cell'>#</div>
		<div class='cell'>Número</div>
		<div class='cell'>Asunto</div>
		<div class='cell'>Estado</div>
	</div>

			<?php
				foreach($pd as $key){
					echo "<div class='body-row' draggable='true'>";
						echo "<div class='cell'>";
							echo "<div class='btn-group'>";

			?>
							<button class='btn btn-warning btn-sm' type="button" is="b-link" des='a_ticket/editar' dix='trabajo' tp="edit" v_idticket='<?php echo $key->idticket; ?>' title='editar'>Editar</button>
							</div>
						</div>

						<div class='cell' data-titulo='Número'><?php echo $key->numero; ?></div>
						<div class='cell' data-titulo='Asunto'><?php echo $key->asunto; ?></div>
						<div class='cell' data-titulo='Estado'><?php echo $key->estado; ?></div>

					</div>
			<?php
				}
			?>
	</div>
</div>
