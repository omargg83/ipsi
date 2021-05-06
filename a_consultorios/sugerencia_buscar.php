<?php
	require_once("db_.php");

  $idconsultorio=$_REQUEST['idconsultorio'];

  if(isset($_REQUEST['buscar'])){
    $texto=$_REQUEST['buscar'];
    $pd = $db->paciente_buscar($texto, $idusuario);
  }
	else{
		$pd = $db->paciente_buscar("", $idusuario);
	}
?>

<div class='container'>
	<div class='tabla_v' id='tabla_css'>

	<div class='header-row'>
		<div class='cell'>#</div>
		<div class='cell'>Nombre</div>
		<div class='cell'>Sucursal</div>
	</div>

		<?php
			foreach($pd as $key){
				echo "<div class='body-row' >";
					echo "<div class='cell'>";
						echo "<div class='btn-group'>";

						echo "<button class='btn btn-warning btn-sm' id='can_$key->id' type='button' is='b-link' v_idpaciente='$key->id' v_idusuario='$idusuario' db='a_terapeutas/db_' des='a_terapeutas/pacientes' dix='trabajo' fun='asignar_paciente' tp='¿Desea asignar el paciente al terapeuta seleccionado?' title='Borrar'>Asignar</button>";

						echo "</div>";
					echo "</div>";
					echo "<div class='cell' data-titulo='Nombre'>".$key->nombre." ".$key->apellidop." ".$key->apellidom."</div>";
					echo "<div class='cell' data-titulo='Sucursal'>";
					$suc=$db->sucursal_($key->idsucursal);
					echo $suc->nombre;
					echo "</div>";

				echo "</div>";
			}
		?>
	</div>
</div>
