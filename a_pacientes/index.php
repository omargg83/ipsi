<?php
	require_once("db_.php");
?>
<div id='trabajo'>

	<nav class='navbar navbar-expand-sm'>
	<a class='navbar-brand' >Pacientes</a>
	<button class='navbar-toggler navbar-toggler-right' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='principal' aria-expanded='false' aria-label='Toggle navigation'>
		<span class='navbar-toggler-icon'></span>
	</button>
		  <div class='collapse navbar-collapse' id='navbarSupportedContent'>

		  <form class='form-inline my-2 my-lg-0' is="f-submit" id="form_busca" des="a_pacientes/lista" dix='trabajo' action='' >
				<input type="search" id="buscar" name='buscar' placeholder="Buscar" class='form-control'/>
			</form>

			<ul class='navbar-nav mr-auto'>

				<li class='nav-item active'><a class='nav-link barranav' is='a-link' title='Mostrar todo' id='lista_comision' des='a_pacientes/lista' dix='lista'><span>Pacientes</span></a></li>

				<li class='nav-item active'><a class='nav-link barranav izq' is='a-link' title='Nuevo' id='new_personal' des='a_pacientes/editar' v_idpaciente='0' dix='trabajo'><span>Agregar usuario</span></a></li>

				<li class='nav-item active'><a class='nav-link barranav' is='a-link' title='Mostrar todo' id='lista_comision' des='a_roles/lista' dix='lista'><span>Roles</span></a></li>

			</ul>
	  </div>
	</nav>

	<div id='lista'>
		<?php
			include 'lista.php';
		?>
	</div>

</div>
