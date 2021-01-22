<?php
	require_once("db_.php");

	$idsucursal=$_REQUEST['idsucursal'];
	$pd = $db->sucursal($idsucursal);

	$nombre=$pd->nombre;
	$ubicacion=$pd->ubicacion;
	$ciudad=$pd->ciudad;


	echo "<nav aria-label='breadcrumb'>";
		echo "<ol class='breadcrumb'>";
			echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_sucursal/index' dix='trabajo'>Sucursales</li>";
			echo "<li class='breadcrumb-item active' id='lista_track' is='li-link' des='a_sucursal/administrador' v_idsucursal='$idsucursal' dix='trabajo'>$nombre</li>";
			echo "<button class='btn btn-warning btn-sm' is='b-link' des='a_sucursal/lista' dix='trabajo'>Regresar</button>";
		echo "</ol>";
	echo "</nav>";
?>

<div class="alert alert-warning text-center tituloventana" role="alert">
	Agregar persona
</div>

<div class='container'>

    <form is="f-submit" id="form_ads" des="a_sucursal/administrador_buscar" dix='resultados' action='' >
      <input type="hidden" id="idsucursal" name='idsucursal' value='<?php echo $idsucursal;?>'/>
      <div class='row'>
        <div class='col-12'>
          <label>Buscar</label>
          <input type="text" id="buscar" name='buscar' placeholder="Buscar" class='form-control'/>
        </div>
      </div>
    </form>

    <div id='resultados'>
    </div>
</div>
