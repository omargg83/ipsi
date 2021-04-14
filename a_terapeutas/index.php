<?php
	require_once("db_.php");
?>
<div id='trabajo'>
	<nav class='navbar navbar-expand-sm'>
	<a class='navbar-brand'>Terapeutas</a>
	  <button class='navbar-toggler navbar-toggler-right' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='principal' aria-expanded='false' aria-label='Toggle navigation'>
		<span class='navbar-toggler-icon'></span>
	  </button>
		  <div class='collapse navbar-collapse' id='navbarSupportedContent'>

			<form class='form-inline my-2 my-lg-0' is="f-submit" id="form_busca" des="a_terapeutas/lista" dix='trabajo' action='' >
				<input type="search" id="buscar" name='buscar' placeholder="Buscar" class='form-control'/>
			</form>

			<ul class='navbar-nav mr-auto'>
			<li class='nav-item active'>
				<a class='nav-link barranav' is="a-link" des='a_terapeutas/lista' dix='lista' tp="router">Lista</a>
			</li>
			<?php
				if($_SESSION['nivel']==1 or $_SESSION['nivel']==3 or $_SESSION['nivel']==4){
			?>
				<li class='nav-item active'><a class='nav-link barranav izq' title='Nuevo' id='new_personal'  is='a-link' des='a_usuarios/editar_trabajo' dix='trabajo' v_idusuario='0' v_nivel='2'>Nuevo</a></li>
			<?php
			}
			?>
			</ul>

	  </div>
	</nav>

	<div id='lista'>
		<?php
			include 'lista.php';
		?>
	</div>
</div>
