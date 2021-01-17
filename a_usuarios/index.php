<?php
	require_once("db_.php");
?>
	<nav class='navbar navbar-expand-sm'>
	<a class='navbar-brand' ><i class='fas fa-user-check'></i> Usuarios</a>
	  <button class='navbar-toggler navbar-toggler-right' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='principal' aria-expanded='false' aria-label='Toggle navigation'>
		<span class='navbar-toggler-icon'></span>
	  </button>
		  <div class='collapse navbar-collapse' id='navbarSupportedContent'>

				<form class='form-inline my-2 my-lg-0' is="f-submit" id="form_busca" des="a_usuarios/lista" dix='trabajo' action='' >
					<input type="search" id="buscar" name='buscar' placeholder="Buscar" class='form-control'/>
				</form>
			<ul class='navbar-nav mr-auto'>
			<li class='nav-item active'>
				<a class='nav-link barranav' is="a-link" des='a_usuarios/lista' dix='trabajo' tp="router">Lista</a>
			</li>
			<?php
				if($_SESSION['nivel']==1){
			?>
				<li class='nav-item active'><a class='nav-link barranav izq' title='Nuevo' id='new_personal'  is='a-link' des='a_usuarios/editar' dix='trabajo' v_idusuario='0'>Nuevo</a></li>
			<?php
			}
			?>
			</ul>

	  </div>
	</nav>

<div id='trabajo'>
	<?php
		include 'lista.php';
	?>
</div>
