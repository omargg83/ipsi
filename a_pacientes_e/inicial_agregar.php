<?php
	require_once("../a_pacientes/db_.php");
  $idterapia=$_REQUEST['idterapia'];
  $idpaciente=$_REQUEST['idpaciente'];

  /////////////////////breadcrumb
  $paciente = $db->cliente_editar($idpaciente);
  $nombre=$paciente->nombre." ".$paciente->apellidop." ".$paciente->apellidom;

  $sql="select * from terapias where id=:idterapia";
  $sth = $db->dbh->prepare($sql);
  $sth->bindValue(":idterapia",$idterapia);
  $sth->execute();
  $terapia=$sth->fetch(PDO::FETCH_OBJ);

  $actividad=$db->actividad_inicial($idterapia);
?>
<nav aria-label='breadcrumb'>
	<ol class='breadcrumb'>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/lista" dix="trabajo">Pacientes</li>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/paciente" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo"><?php echo $nombre; ?></li>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/terapias" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Terapias</li>
		<li class="breadcrumb-item" type="button" is="li-link" des="a_pacientes/track" dix="trabajo" title="Terapias" v_idterapia="<?php echo $idterapia; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $terapia->nombre; ?></li>
    <li class="breadcrumb-item active" type="button" is="li-link" des="a_pacientes_e/inicial_agregar" dix="trabajo" title="Terapias" v_idterapia="<?php echo $idterapia; ?>" v_idpaciente="<?php echo $idpaciente; ?>">Agregar actividad inicial</li>
	</ol>
</nav>

  <div class="alert alert-danger text-center" role="alert">
    Agregar Actividad inicial existentes
  	<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_pacientes/track" v_idterapia="<?php echo $idterapia; ?>" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Regresar</button>
  </div>

  <div class='container'>
    <div class='row'>
      <?php
      foreach($actividad as $key){
      ?>
        <div class='col-4 p-3 w-50'>
          <div class='card' style='height:200px;'>
            <div class='card-header'>
              <?php echo $key->nombre; ?>
            </div>
            <div class='card-body'>
              <div class='row'>
                <div class='col-12'>
                  <?php echo $key->observaciones; ?>
                </div>
              </div>
            </div>
            <div class='card-body'>
              <div class='row'>
                <div class='col-12'>
                  <button class="btn btn-warning btn-block" type="button" is="b-link" db="a_pacientes/db_" fun='agregar_inicial' dix="trabajo" tp='¿Desea agregar la actividad inicial?' des="a_pacientes/track" v_idactividad="<?php echo $key->idactividad; ?>" v_idpaciente="<?php echo $idpaciente; ?>" v_idterapia="<?php echo $idterapia; ?>">Agregar</button>
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
            <button class="btn btn-warning btn-block" type="button" is="b-link" des="a_pacientes_e/actividad_editar" dix="trabajo" v_idactividad="0" v_idterapia='<?php echo $idterapia; ?>'  v_idpaciente="<?php echo $idpaciente; ?>">Nueva Actividad inicial</button>
          </div>
        </div>
      </div>

    </div>
  </div>
