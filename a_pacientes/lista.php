<?php
	require_once("db_.php");


	$pag=0;
	$texto="";
	if(isset($_REQUEST['buscar'])){
		$texto=$_REQUEST['buscar'];
		$pd = $db->pacientes_buscar($texto);
		$texto=1;
	}
	else{
		if(isset($_REQUEST['pag'])){
			$pag=$_REQUEST['pag'];
		}
		$pd = $db->pacientes_lista($pag);
	}
?>

	<nav aria-label='breadcrumb'>
		<ol class='breadcrumb'>
			<li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_pacientes/index" dix="trabajo">Pacientes</li>
		</ol>
	</nav>


	<div class='container'>
		<div class='tabla_v' id='tabla_css'>

		<div class='header-row'>
			<div class='cell'>#</div>
			<div class='cell'>Nombre</div>
			<div class='cell'>ID</div>
			<div class='cell'>Sucursal</div>
			<div class='cell'>Status</div>
			<div class='cell'>Correo</div>
		</div>

		<?php
			foreach($pd as $key){
				echo "<div class='body-row' draggable='true'>";
					echo "<div class='cell'>";
						echo "<div class='btn-group'>";

						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/paciente' dix='trabajo' v_idpaciente='$key->id'>Editar</button>";

						echo "</div>";
					echo "</div>";
					echo "<div class='cell' data-titulo='Nombre'>".$key->nombre." ".$key->apellidop." ".$key->apellidom."</div>";
					echo "<div class='cell' data-titulo='ID'>".$key->numero."</div>";

					$sucursal=$db->sucursal($key->idsucursal);
					echo "<div class='cell' data-titulo='Sucursal'>".$sucursal->nombre."</div>";

					echo "<div class='cell' data-titulo='Status'>".$key->estatus."</div>";
					echo "<div class='cell' data-titulo='correo'>".$key->correo."</div>";
				echo "</div>";
			}
		?>
	</div>

	<?php
		if(strlen($texto)==0){
			if($_SESSION['nivel']==1 or $_SESSION['nivel']==4){
				$sql="SELECT count(id) as total FROM clientes";
			}
			if($_SESSION['nivel']==2){
				$sql="SELECT count(id) as total FROM clientes
				left outer join cliente_terapeuta on cliente_terapeuta.idcliente=clientes.id where cliente_terapeuta.idusuario='".$_SESSION['idusuario']."'";
			}
			if($_SESSION['nivel']==3){
				$sql="SELECT count(id) as total FROM clientes where idsucursal='".$_SESSION['idsucursal']."'";
			}
			$sth = $db->dbh->query($sql);
			$contar=$sth->fetch(PDO::FETCH_OBJ);
			$paginas=ceil($contar->total/$_SESSION['pagina']);
			$pagx=$paginas-1;

			echo $db->paginar($paginas,$pag,$pagx,"a_pacientes/lista","lista");
		}
	?>
</div>
