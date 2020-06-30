<?php
	session_start();
?>
<div class="sidebar-header" id='menu'>
    <?php
      echo "<div class='form-group' id='imagen_div'>";
        echo "<img src='".$_SESSION['foto']."' class='img-thumbnail' width='100px'>";
        echo $_SESSION['nombre'];
        echo $_SESSION['tipo_user'];
      echo "</div>";
    ?>
</div>

<ul class="list-unstyled components">
    <li class='active'>
        <a href="#"><i class="fas fa-home"></i> Inicio</a>
    </li>
    <li >
        <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-user-shield"></i> Administrador</a>
        <ul class="collapse list-unstyled" id="homeSubmenu">
          <li>
              <a href='#a_usuarios/index' title='Usuarios'><i class='fas fa-users'></i>Cuentas</a>
          </li>
          <li>
              <a href='#a_clientes/index' title='Pacientes'><i class='fas fa-user-tag'></i>Pacientes</a>
          </li>
					<li>
              <a href='#a_citas/index' title='Pacientes'><i class='fas fa-user-tag'></i>Citas</a>
          </li>
        </ul>
    </li>
    <li>
        <a href='#a_actividades/index' title='Actividades'><i class="far fa-file-alt"></i>Actividades</a>
    </li>

</ul>

<ul class="list-unstyled CTAs">
    <li>
        <a onclick='salir()' href='#' class="btn btn-sm"><i class="fas fa-sign-out-alt"></i>Salir</a>
    </li>
</ul>
