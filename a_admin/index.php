<?php
	require_once("db_.php");
?>

	<nav class='navbar navbar-expand-sm'>
	<a class='navbar-brand' > Configuración</a>
	<button class='navbar-toggler navbar-toggler-right' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='principal' aria-expanded='false' aria-label='Toggle navigation'>
		<span class='navbar-toggler-icon'></span>
	</button>
		  <div class='collapse navbar-collapse' id='navbarSupportedContent'>

			<ul class='navbar-nav mr-auto'>

				<li class='nav-item active'><a class='nav-link barranav' is='a-link' title='Mostrar todo' id='lista_comision' des='a_admin/lista' dix='trabajo'><span>Correos</span></a></li>

				

			</ul>
	  </div>
	</nav>
<div id='trabajo'>
	<?php
		include 'lista.php';
	?>
</div>
