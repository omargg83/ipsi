<?php
	require_once("db_.php");
?>
	<nav class='navbar navbar-expand-lg navbar-light bg-light '>
	<a class='navbar-brand' ><i class='fas fa-user-check'></i> Tracks</a>
	  <button class='navbar-toggler navbar-toggler-right' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='principal' aria-expanded='false' aria-label='Toggle navigation'>
		<span class='navbar-toggler-icon'></span>
	  </button>
		  <div class='collapse navbar-collapse' id='navbarSupportedContent'>
			<ul class='navbar-nav mr-auto'>
			<li class='nav-item active'><a class='nav-link barranav' title='Mostrar todo' id='lista_track' data-lugar='a_track/lista'><i class='fas fa-list-ul'></i><span>Lista</span></a></li>
			<li class='nav-item active'><a class='nav-link barranav izq' title='Nuevo' id='new_personal' data-lugar='a_track/editar'><i class='fas fa-plus'></i><span>Nuevo</span></a></li>
			</ul>
	  </div>
	</nav>

<div id='trabajo'>
	<?php
		include 'lista.php';
	?>
</div>
