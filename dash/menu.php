<div class="sidebar-header" id='menu'>
    <h3>Bootstrap Sidebar</h3>
</div>

<ul class="list-unstyled components">
    <li class='active'>
        <a href="#"><i class="fas fa-home"></i> Inicio</a>
    </li>
    <li >
        <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-user-shield"></i> Administrador</a>
        <ul class="collapse list-unstyled" id="homeSubmenu">
            <li>
                <a href='#a_usuarios/index' title='Usuarios'><i class='fas fa-users'></i>Usuarios</a>
            </li>
            <li>
                <a href='#a_clientes/index' title='Clientes'><i class='fas fa-user-tag'></i>Clientes</a>
            </li>
        </ul>
    </li>
    <li>
        <a href='#a_preguntas/index' title='Actividades'><i class="far fa-file-alt"></i>Actividades</a>
    </li>

</ul>

<ul class="list-unstyled CTAs">
    <li>
        <a onclick='salir()' href='#' class="btn btn-sm"><i class="fas fa-sign-out-alt"></i>Salir</a>
    </li>
</ul>
