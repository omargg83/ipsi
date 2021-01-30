<?php
	require_once("db_.php");


	$idconsultorio=$_REQUEST['idconsultorio'];
	$pd = $db->consultorio($idconsultorio);
	$nombre=$pd->nombre;
	$idsucursal=$pd->idsucursal;

	$sucursal = $db->sucursal($idsucursal);
  $snombre=$sucursal->nombre;

?>

<nav aria-label='breadcrumb'>
 <ol class='breadcrumb'>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_consultorios/index" dix="contenido">Citas</li>

	 <li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_consultorios/editar" v_idconsultorio="<?php echo $idconsultorio; ?>" dix="contenido"><?php echo $nombre;?></li>

	 <li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_consultorios/horarios" v_idconsultorio="<?php echo $idconsultorio; ?>" dix="contenido">Horarios</li>

	 <button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_consultorios/index" dix="contenido">Regresar</button>
 </ol>
</nav>


<div class="container">
		<div class='card'>
			<div class='card-header'>
				Horarios
			</div>
			<div class='card-body'>
				<button type='button' class='btn btn-warning btn-sm' id='lista_penarea' is='b-link' des='a_consultorios/editar_horario' dix='contenido' title='regresar' v_idconsultorio='<?php echo $idconsultorio;?>' v_idhorario='0'>Agregar horario</button>

				<div class='tabla_v' id='tabla_css'>

					<div class='header-row'>
						<div class='cell'>#</div>
						<div class='cell'>Dia</div>
						<div class='cell'>Desde</div>
						<div class='cell'>Hasta</div>
					</div>
					<?php
						$horarios=$db->lista_horarios($idconsultorio);
						foreach($horarios as $key){
							echo "<div class='body-row' >";
								echo "<div class='cell'>";

									echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_consultorios/editar_horario' dix='contenido' v_idhorario='$key->idhorario' v_idconsultorio='$idconsultorio'>Editar</button>";

									echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_consultorios/horarios' dix='contenido' db='a_consultorios/db_' fun='horario_quitar' v_idhorario='$key->idhorario' v_idconsultorio='$idconsultorio' tp='¿Desea eliminar el horario seleccionado?' title='Borrar'>Eliminar</button>";

								echo "</div>";
								echo "<div class='cell' data-titulo='Dia'>".$key->desde_dia."</div>";
								echo "<div class='cell' data-titulo='Desde'>".date ( 'h:i A' , strtotime($key->desde))."</div>";
								echo "<div class='cell' data-titulo='Hasta'>".date ( 'h:i A' , strtotime($key->hasta))."</div>";
							echo "</div>";
						}
					 ?>
				 </div>
			</div>
		</div>
</div>
