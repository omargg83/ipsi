<?php
	require_once("db_.php");
	$pd = $db->ticket_lista();
?>

<div class="container">

	<div class="row">
		<div class="col-2">#</div>
		<div class="col-2">Numero</div>
		<div class="col-3">Asunto</div>
		<div class="col-3">Estado</div>
	</div>
			<?php
				foreach($pd as $key){
			?>
					<div class='row'>
						<div class="col-2">
							<button class='btn btn-warning' type="button" is="b-link" des='a_ticket/editar' dix='trabajo' tp="edit" v_idticket='<?php echo $key->idticket; ?>' title='editar'>Editar</button>
						</div>
						<div class="col-2"><?php echo $key->numero; ?></div>
						<div class="col-3"><?php echo $key->asunto; ?></div>
						<div class="col-3"><?php echo $key->estado; ?></div>

					</div>
			<?php
				}
			?>
	</div>
</div>
