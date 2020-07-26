<?php
	require_once("db_.php");
	$pd = $db->usuario_lista();
	echo "<div class='container' style='background-color:".$_SESSION['cfondo']."; '>";
?>

	<table id='x_user' class='table table-striped table-bordered compact' style='font-size:10pt;'>
	<thead>
	<th>Numero</th>
	<th>Nombre</th>
	<th>Nivel</th>
	<th>Tienda</th>
	<th>Activo</th>
	</thead>
	<tbody>
		<?php
			foreach($pd as $key){
		?>
				<tr>
					<td>
					<button class='btn btn-warning' type="button" is="b-link" des='a_usuarios/editar' dix='trabajo' tp="edit" id1='<?php echo $key->id; ?>' title='editar'>Editar</button>
					</td>
				<td><?php echo $key->nombre; ?></td>
				<td><?php echo $key->nivel; ?></td>
				<td><?php echo $key->correo; ?></td>
				<td>
				<?php
					if ($key->autoriza==0) { echo "Inactivo"; }
					if ($key->autoriza==1) { echo "Activo"; }
				?>
				</td>
				</tr>
		<?php
			}
		?>
	</tbody>
	</table>
</div>
