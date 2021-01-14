<?php
	require_once("db_.php");

	$pag=0;
	$texto="";
	if(isset($_REQUEST['buscar'])){
		$texto=$_REQUEST['buscar'];
		$pd = $db->consultorio_buscar($texto);
		$texto=1;
	}
	else{
		if(isset($_REQUEST['pag'])){
			$pag=$_REQUEST['pag'];
		}
		$pd = $db->consultorio_lista($pag);
	}
?>
<div class='container'>
	<div class='tabla_v' id='tabla_css'>

	<div class='header-row'>
		<div class='cell'>#</div>
		<div class='cell'>Nombre</div>
		<div class='cell'>Sucursal</div>
		<div class='cell'>Dirección</div>
	</div>

		<?php
			foreach($pd as $key){
				echo "<div class='body-row' draggable='true'>";
					echo "<div class='cell'>";
						echo "<div class='btn-group'>";
						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_consultorios/editar' dix='trabajo' v_idconsultorio='$key->idconsultorio'><i class='fas fa-pencil-alt' ></i></button>";

						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_consultorios/horarios' dix='trabajo' v_idconsultorio='$key->idconsultorio'><i class='far fa-clock'></i></button>";

						echo "</div>";
					echo "</div>";
					echo "<div class='cell' data-titulo='Nombre'>".$key->nombre."</div>";
					echo "<div class='cell' data-titulo='Sucursal'>".$key->sucursal."</div>";
					echo "<div class='cell' data-titulo='Dirección'>".$key->ubicacion."</div>";
				echo "</div>";
			}
		?>
	</div>


	<?php
		if(strlen($texto)==0){
			$sql="SELECT count(idconsultorio) as total FROM consultorio";
			$sth = $db->dbh->query($sql);
			$contar=$sth->fetch(PDO::FETCH_OBJ);
			$paginas=ceil($contar->total/$_SESSION['pagina']);
			$pagx=$paginas-1;

			echo $db->paginar($paginas,$pag,$pagx,"a_consultorios/lista","trabajo");
		}
	?>

</div>
