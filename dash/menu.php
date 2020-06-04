<div class="sidebar-header" id='menu'>
    <h3>Bootstrap Sidebar</h3>
</div>

<ul class="list-unstyled components">
    <p>Dummy Heading</p>
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
        <a href="#">Expediente</a>
    </li>
    <li>
        <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Pages</a>
        <ul class="collapse list-unstyled" id="pageSubmenu">
            <li>
                <a href="#">Page 1</a>
            </li>
            <li>
                <a href="#">Page 2</a>
            </li>
            <li>
                <a href="#">Page 3</a>
            </li>
        </ul>
    </li>
    <li>
        <a href="#">Portfolio</a>
    </li>
    <li>
        <a href="#">Contact</a>
    </li>
</ul>

<ul class="list-unstyled CTAs">
    <li>
        <a onclick='salir()' href='#' class="btn btn-sm"><i class="fas fa-sign-out-alt"></i>Salir</a>
    </li>
</ul>

<!--

        <a href='#dash/index' class='activeside'><i class='fas fa-home'></i><span>Inicio</span></a>
        <a href='#a_preguntas/index' title='Crear cuestionario'><i class='fas fa-user-tag'></i><span>Cuestionario</span></a>

-->
