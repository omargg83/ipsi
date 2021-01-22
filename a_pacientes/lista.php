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
			$sql="SELECT count(id) as total FROM clientes";
			$sth = $db->dbh->query($sql);
			$contar=$sth->fetch(PDO::FETCH_OBJ);
			$paginas=ceil($contar->total/$_SESSION['pagina']);
			$pagx=$paginas-1;

			echo $db->paginar($paginas,$pag,$pagx,"a_pacientes/lista","lista");
		}
	?>


</div>


<!--

	<div class='container'>

		<div class='row'>

				foreach($pd as $key){
					echo "<div id='".$key->id."' class='col-4 edit-t mb-3'>";
						echo "<div class='card '>";
						echo "<div class='card-body'>";
								echo "<div class='text-center'><img src='".$db->pac.$key->foto."' class='img-fluid img-thumbnail' alt='foto' width='100px'></div>";
								echo "<div class='text-center'>".$key->nombre." ".$key->apellidop." ".$key->apellidom."</div>";
								echo "<div class='text-center'>Paciente</div>";

								echo "<div class='row'>";
									echo "<div class='col-12  text-center'>";
										echo "<div class='btn-group'>";
											echo "<button class='btn btn-warning btn-block' is='b-link' id='edit_persona' title='Editar' des='a_pacientes/paciente' dix='trabajo' v_idpaciente='".$key->id."'>Ver perfil</button>";
										echo "</div>";
									echo "</div>";
								echo "</div>";
							echo "</div>";
						echo "</div>";
					echo "</div>";
				}


			<div id='".$key->id."' class='col-4 edit-t mb-3'>
				<div class='card '>
				<div class='card-body'>
						<div class='text-center'></div>
						<div class='text-center'>Agregar</div>
						<div class='text-center'><br><br></div>

						<div class='row'>
							<div class="col-12">
								<button class='btn btn-warning btn-block' type="button" is="b-link" des='a_pacientes/editar' dix='trabajo' v_idpaciente='0'>Nuevo</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
-->
