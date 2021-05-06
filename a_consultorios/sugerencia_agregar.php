<?php
	require_once("db_.php");

	$idconsultorio=$_REQUEST['idconsultorio'];

  $pd = $db->consultorio($idconsultorio);
  $nombre=$pd->nombre;

?>

<nav aria-label='breadcrumb'>
 <ol class='breadcrumb'>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_consultorios/index" dix="contenido">Citas</li>
	 <li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_consultorios/sugerencia" v_idconsultorio="<?php echo $idconsultorio; ?>" dix="contenido"><?php echo $nombre; ?></li>
   <li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_consultorios/sugerencia_agregar" v_idconsultorio="<?php echo $idconsultorio; ?>" dix="contenido">Agregar Terapeuta</li>
	 <button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_consultorios/sugerencia" dix="contenido">Regresar</button>
 </ol>
</nav>


<div class="alert alert-danger text-center" role="alert">
	Agregar Paciente
</div>

<div class='container'>

    <form is="f-submit" id="form_ads" des="a_terapeutas/paciente_buscar" dix='resultados' action='' >
      <input type="hidden" id="idconsultorio" name='idconsultorio' value='<?php echo $idconsultorio;?>'/>
      <div class='row'>
        <div class='col-12'>
          <label>Buscar</label>
          <input type="text" id="buscar" name='buscar' placeholder="Buscar" class='form-control'/>
        </div>
      </div>
    </form>

    <div id='resultados'>
			<?php
				include "sugerencia_buscar.php";
			?>
    </div>
</div>
