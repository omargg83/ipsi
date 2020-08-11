<?php
	require_once("db_.php");
	$pd = $db->clientes_lista();
	?>
	<nav aria-label='breadcrumb'>
		<ol class='breadcrumb'>
			<li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_pacientes/lista" dix="trabajo">Pacientes</li>
		</ol>
	</nav>


	<div class='container'>

		<div class='row'>
			<?php
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
			?>

			<div id='".$key->id."' class='col-3 edit-t mb-3'>
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
