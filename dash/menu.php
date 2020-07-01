<?php
	session_start();
?>
<div class="sidebar-header" id='menu'>
    <?php
			echo "<div class='row'>";
	      echo "<div class='col-4 p-3'>";
	        echo "<img src='".$_SESSION['foto']."' class='img-thumbnail' width='200px'>";
				echo "</div>";
				echo "<div class='col-8 p-3'>";
	        echo "<h4>".$_SESSION['nombre']."</h4>";
	        echo "<h5>".$_SESSION['tipo_user']."</h5>";
	      echo "</div>";
			echo "</div>";
    ?>
</div>


<ul class="list-unstyled components p-3">
    <li class='active'>
        <a href="#"><i class="fas fa-home"></i> Inicio</a>
    </li>
		<?php
			if($_SESSION['admin']==1){
				echo "<li>";
						echo "<a href='#a_clientes/index' title='Pacientes'><i class='fas fa-user-tag'></i>Mis Pacientes</a>";
				echo "</li>";
				echo "<li>";
						echo "<a href='#a_actividades/index' title='Actividades'><i class='far fa-file-alt'></i>Actividades</a>";
				echo "</li>";
				if($_SESSION['nivel']==1){
					echo "<li >";
							echo "<a href='#homeSubmenu' data-toggle='collapse' aria-expanded='false' class='dropdown-toggle'><i class='fas fa-user-shield'></i> Administrador</a>";
							echo "<ul class='collapse list-unstyled' id='homeSubmenu'>";
								echo "<li>";
										echo "<a href='#a_usuarios/index' title='Usuarios'><i class='fas fa-users'></i>Cuentas</a>";
								echo "</li>";
								echo "<li>";
										echo "<a href='#a_clientes/index' title='Pacientes'><i class='fas fa-user-tag'></i>Pacientes</a>";
								echo "</li>";
								echo "<li>";
										echo "<a href='#a_citas/index' title='Pacientes'><i class='fas fa-user-tag'></i>Citas</a>";
								echo "</li>";
							echo "</ul>";
					echo "</li>";
				}
			}
		?>

</ul>

<ul class="list-unstyled CTAs">
    <li>
        <a onclick='salir()' href='#' class="btn btn-sm"><i class="fas fa-sign-out-alt"></i>Salir</a>
    </li>
</ul>
