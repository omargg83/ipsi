<?php
	require_once("db_.php");

	$idusuario=$_REQUEST['idusuario'];

	$pd = $db->usuario_editar($idusuario);
  $nombre_p=$pd->nombre." ".$pd->apellidop." ".$pd->apellidom;

?>

<nav aria-label='breadcrumb'>
	<ol class='breadcrumb'>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_terapeutas/index" dix="trabajo">Terapeuta</li>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_terapeutas/terapeuta" v_idusuario="<?php echo $idusuario; ?>" dix="trabajo"><?php echo $nombre_p; ?></li>
		<li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_terapeutas/pacientes" v_idusuario="<?php echo $idusuario; ?>" dix="trabajo">Pacientes</li>
		<li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_terapeutas/pacientes_agregar" v_idusuario="<?php echo $idusuario; ?>" dix="trabajo">Agregar paciente</li>
		<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_terapeutas/pacientes" dix="trabajo" v_idusuario="<?php echo $idusuario; ?>">Regresar</button>
	</ol>
</nav>

<div class="alert alert-danger text-center" role="alert">
	Agregar Paciente
</div>

<div class='container'>

    <form is="f-submit" id="form_ads" des="a_terapeutas/paciente_buscar" dix='resultados' action='' >
      <input type="hidden" id="idusuario" name='idusuario' value='<?php echo $idusuario;?>'/>
      <div class='row'>
        <div class='col-12'>
          <label>Buscar</label>
          <input type="text" id="buscar" name='buscar' placeholder="Buscar" class='form-control'/>
        </div>
      </div>
    </form>

    <div id='resultados'>
			<?php
				include "paciente_buscar.php";
			?>
    </div>
</div>
