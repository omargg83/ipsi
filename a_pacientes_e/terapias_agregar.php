<?php
	require_once("../a_pacientes/db_.php");

	$idpaciente=clean_var($_REQUEST['idpaciente']);

  $paciente = $db->cliente_editar($idpaciente);
  $nombre_p=$paciente->nombre." ".$paciente->apellidop." ".$paciente->apellidom;

  $terapias=$db->terapias_lista();
?>

<nav aria-label='breadcrumb'>
	<ol class='breadcrumb'>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/lista" dix="trabajo">Pacientes</li>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/paciente" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo"><?php echo $nombre_p; ?></li>
		<li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_pacientes_e/terapias_agregar" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Agregar terapia</li>
		<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_pacientes/paciente" dix="trabajo" v_idpaciente="<?php echo $idpaciente; ?>">Regresar</button>
	</ol>
</nav>

<div class="alert alert-danger text-center" role="alert">
	Agregar Terapias existentes

</div>


    <div class="container">
      <div class="row">
      <?php
        foreach($terapias as $key){
      ?>
				<div class='col-4 p-2 w-50 actcard'>
					<div class='card' style='height:400px'>
            <div class="card-header">
              <?php echo $key->nombre; ?>
            </div>
            <div class='card-body' style='overflow:auto; height:220px'>
              <div class='row'>
                <div class='col-12'>
                    <?php echo $key->descripcion; ?>
                </div>
              </div>
            </div>
            <div class='card-footer'>
              <div class='row'>
                <div class='col-12'>
                  <button class="btn btn-warning btn-block" type="button" is="b-link" db="a_pacientes/db_" fun='agregar_terapia' dix="trabajo" tp='¿Desea agregar la terapia?' des="a_pacientes/terapias" v_idterapia="<?php echo $key->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>">Agregar</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php
        }

      ?>
        <div id='' class='col-4 p-3 w-50'>
          <div class="card" style='height:200px;'>
            <div class='card-body text-center'>
              <button class="btn btn-warning btn-block" type="button" is="b-link" des="a_pacientes_e/terapias_editar" dix="trabajo" v_idterapia="0" v_idpaciente='<?php echo $idpaciente; ?>' cmodal='2'>Nueva terapia</button>
            </div>
          </div>
        </div>
      </div>

    </div>
