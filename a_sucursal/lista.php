<?php
	require_once("db_.php");

	$pag=0;
	$texto="";
	if(isset($_REQUEST['buscar'])){
		$texto=$_REQUEST['buscar'];
		$pd = $db->sucursal_buscar($texto);
		$texto=1;
	}
	else{
		if(isset($_REQUEST['pag'])){
			$pag=$_REQUEST['pag'];
		}
		$pd = $db->sucursal_lista($pag);
	}
?>
<div class='container'>
	<div class='tabla_v' id='tabla_css'>

	<div class='header-row'>
		<div class='cell'>#</div>
		<div class='cell'>Nombre</div>
		<div class='cell'>Ubicación</div>
		<div class='cell'>Teléfono 1</div>
		<div class='cell'>Teléfono 2</div>
	</div>

		<?php
			foreach($pd as $key){
				echo "<div class='body-row' draggable='true'>";
					echo "<div class='cell'>";

						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_sucursal/editar' dix='trabajo' v_idsucursal='$key->idsucursal'>Editar</button>";
						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_sucursal/administrador' dix='trabajo' v_idsucursal='$key->idsucursal'>Administrador</button>";

					echo "</div>";
					echo "<div class='cell' data-titulo='Nombre'>".$key->nombre."</div>";
					echo "<div class='cell' data-titulo='Ubicación'>".$key->ubicacion."</div>";
					echo "<div class='cell' data-titulo='Teléfono'>".$key->tel1."</div>";
					echo "<div class='cell' data-titulo='Teléfono'>".$key->tel2."</div>";
				echo "</div>";
			}
		?>
	</div>


	<?php
		if(strlen($texto)==0){
			$sql="SELECT count(idsucursal) as total FROM sucursal";
			$sth = $db->dbh->query($sql);
			$contar=$sth->fetch(PDO::FETCH_OBJ);
			$paginas=ceil($contar->total/$_SESSION['pagina']);
			$pagx=$paginas-1;

			echo $db->paginar($paginas,$pag,$pagx,"a_sucursal/lista","trabajo");
		}
	?>

</div>
