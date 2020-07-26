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
			<li class='nav-item active'>
				<a class='nav-link barranav' is="a-link" des='a_track/lista' dix='trabajo' tp="router"> <i class='fas fa-plus'></i>Lista</a>
			</li>
			<li class='nav-item active'>
				<a class='nav-link barranav' is="a-link" des='a_track/editar' dix='trabajo' tp="router"> <i class='fas fa-plus'></i>Nuevo</a>				
			</li>
			</ul>
	  </div>
	</nav>

<div id='trabajo'>
	<?php
		include 'lista.php';
	?>
</div>
