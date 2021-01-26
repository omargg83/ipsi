<?php
	require_once("db_.php");

  $idsucursal=$_REQUEST['idsucursal'];

  if(isset($_REQUEST['buscar'])){
    $texto=$_REQUEST['buscar'];
    $pd = $db->relacion_buscar($texto, $idsucursal);
  }
?>

<div class='container'>
	<div class='tabla_v' id='tabla_css'>

	<div class='header-row'>
		<div class='cell'>#</div>
		<div class='cell'>Nombre</div>
		<div class='cell'>Nivel</div>
	</div>

		<?php
			foreach($pd as $key){
				echo "<div class='body-row' draggable='true'>";
					echo "<div class='cell'>";
						echo "<div class='btn-group'>";

						echo "<button class='btn btn-warning btn-sm' id='can_$key->idsucursal' type='button' is='b-link' v_idusuario='$key->idusuario' v_idsucursal='$idsucursal' db='a_sucursal/db_' des='a_sucursal/lista' dix='trabajo' fun='asignar_admin' tp='¿Desea seleccionar como administrador el usuario seleccionado?' title='Borrar'>Asignar</button>";

						echo "</div>";
					echo "</div>";
					echo "<div class='cell' data-titulo='Nombre'>".$key->nombre." ".$key->apellidop." ".$key->apellidom."</div>";
					echo "<div class='cell' data-titulo='Nivel'>";
						if($key->nivel==1) echo "Admin General";
						if($key->nivel==2) echo "Terapeuta";
						if($key->nivel==3) echo "Admin Sucursal";
						if($key->nivel==4) echo "Secretaria";
					echo "</div>";
				echo "</div>";
			}
		?>
	</div>
</div>
