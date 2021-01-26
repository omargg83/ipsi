<?php
	require_once("db_.php");
?>
	<nav class='navbar navbar-expand-sm'>
	<a class='navbar-brand' >Tickets</a>
	  <button class='navbar-toggler navbar-toggler-right' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='principal' aria-expanded='false' aria-label='Toggle navigation'>
		<span class='navbar-toggler-icon'></span>
	  </button>
		  <div class='collapse navbar-collapse' id='navbarSupportedContent'>

			<form class='form-inline my-2 my-lg-0' is="f-submit" id="form_busca" des="a_ticket/lista" dix='trabajo' action='' >
				<input type="search" id="buscar" name='buscar' placeholder="Buscar" class='form-control'/>
			</form>

			<ul class='navbar-nav mr-auto'>
			<li class='nav-item active'>
				<a class='nav-link barranav' is="a-link" des='a_ticket/lista' dix='trabajo' tp="router"><i class='fas fa-list-ul'></i>Lista</a>
			</li>

				<li class='nav-item active'><a class='nav-link barranav izq' title='Nuevo' id='new_personal'  is='a-link' des='a_ticket/editar' dix='trabajo' v_idticket='0'><i class='fas fa-plus'></i>Nuevo</a></li>

			</ul>

	  </div>
	</nav>

<div id='trabajo'>
	<?php
		include 'lista.php';
	?>
</div>
