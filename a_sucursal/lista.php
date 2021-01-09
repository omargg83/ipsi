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


		<div class='row'>
			<div class='col-2'>#</div>
			<div class='col-4'>Nombre</div>
			<div class='col-2'>Ubicación</div>
			<div class='col-2'>Teléfono 1</div>
			<div class='col-2'>Teléfono 2</div>
		</div>

		<?php
			foreach($pd as $key){
				echo "<div class='row'>";
					echo "<div class='col-2'>";
						echo "<div class='btn-group'>";
						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_sucursal/editar' dix='trabajo' v_idsucursal='$key->idsucursal'><i class='fas fa-pencil-alt' ></i></button>";
						echo "</div>";
					echo "</div>";
					echo "<div class='col-4' >".$key->nombre."</div>";
					echo "<div class='col-2' >".$key->ubicacion."</div>";
					echo "<div class='col-2' >".$key->tel1."</div>";
					echo "<div class='col-2' >".$key->tel2."</div>";
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
