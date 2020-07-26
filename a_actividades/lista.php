<?php
	require_once("db_.php");
	$pd = $db->actividad_lista();

	echo "<nav aria-label='breadcrumb'>";
		echo "<ol class='breadcrumb'>";
			echo "<li class='breadcrumb-item active' aria-current='page'>Actividades</li>";
		echo "</ol>";
	echo "</nav>";

	echo "<div class='container' style='background-color:".$_SESSION['cfondo']."; '>";
?>

	<div class='row'>
		<div id='' class='col-4 p-3 w-50'>
			<div class="card" style='height:200px;'>
				<div class='card-body'>
					<button class='btn btn-warning  ' onclick='actividad_editar(0)'><i class='fas fa-pencil-alt'></i>Nueva actividad</button>
				</div>
			</div>
		</div>

	<?php
		foreach($pd as $key){
	?>
			<div id='<?php echo $key->idactividad; ?>' class='col-4 p-3 w-50'>
				<div class='card' style='height:200px;'>
					<div class='card-body'>
						<div class='row'>
							<div class='col-12'>
								<div><?php echo $key->nombre; ?></div>
								<div><?php echo $key->observaciones; ?></div>
							</div>
						</div>
					</div>
					<div class='card-body'>
						<div class='row'>
							<div class='col-12'>
								<button class='btn btn-warning btn-block' type="button" is="b-link" des='a_actividades/actividad_ver' dix='trabajo' tp="edit" id1='<?php echo $key->idactividad; ?>' title='editar'>Editar</button>

								<!--
								<button class='btn btn-warning btn-block' onclick='actividad_ver(<?php echo $key->idactividad; ?>)'><i class="fas fa-marker"></i>Ver</button>
							-->
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
		}
		?>


	</div>
</div>
