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
				echo '<tr id="'.$key->idusuario.'" class="edit-t">';
					echo "<td>";
					echo "<div class='btn-group'>";
					echo "<button class='btn btn-sm' id='edit_persona' title='Editar' data-lugar='a_usuarios/editar'><i class='fas fa-pencil-alt'></i></button>";
					echo "</div>";
					echo "</td>";
				echo '<td>'.$key->nombre.'</td>';
				echo '<td>'.$key->nivel.'</td>';
				echo '<td>'.$key->correo.'</td>';
				echo '<td>';
				if ($key->autoriza==0) { echo "Inactivo"; }
				if ($key->autoriza==1) { echo "Activo"; }
				echo '</td>';
				echo '</tr>';
			}
		?>
	</tbody>
	</table>
</div>

<script>
	$(document).ready( function () {
		lista("x_user");
	});
</script>
