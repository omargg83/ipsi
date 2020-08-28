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

  $track=$db->track_lista($idterapia);
?>

<nav aria-label='breadcrumb'>
	<ol class='breadcrumb'>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/lista" dix="trabajo">Pacientes</li>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/paciente" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo"><?php echo $nombre; ?></li>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/terapias" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Terapias</li>
		<li class="breadcrumb-item" is="li-link" des="a_pacientes/track" dix="trabajo" title="Terapias" v_idterapia="<?php echo $idterapia; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $terapia->nombre; ?></li>
		<li class="breadcrumb-item active" is="li-link" des="a_pacientes_e/track_agregar" dix="trabajo" title="Terapias" v_idterapia="<?php echo $idterapia; ?>" v_idpaciente="<?php echo $idpaciente; ?>">Agregar track</li>

		<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_pacientes/track" v_idterapia="<?php echo $idterapia; ?>" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Regresar</button>
	</ol>
</nav>

<div class="alert alert-danger text-center" role="alert">
  Agregar Track existentes

</div>


<div class="container">
  <div class="row">
  <?php
    foreach($track as $key){
  ?>
    <div class='col-4 p-3 w-50'>
      <div class='card' style='height:200px;'>
        <div class="card-header">
          <?php echo $key->nombre; ?>
        </div>
        <div class='card-body'>
          <div class='row'>
            <div class='col-12'>
                <?php echo $key->descripcion; ?>
            </div>
          </div>
        </div>
        <div class='card-footer'>
          <div class='row'>
            <div class='col-12'>
              <button class="btn btn-warning btn-block" type="button" is="b-link" db="a_pacientes/db_" fun='agregar_track' dix="trabajo" tp='¿Desea agregar el track?' des="a_pacientes/track" v_idtrack="<?php echo $key->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>" v_idterapia="<?php echo $idterapia; ?>">Agregar</button>
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
          <button class="btn btn-warning btn-block" type="button" is="b-link" des="a_pacientes_e/track_editar" dix="trabajo" v_idtrack="0" v_idterapia="<?php echo $idterapia; ?>" v_idpaciente='<?php echo $idpaciente; ?>' cmodal='2'>Nuevo track</button>
        </div>
      </div>
    </div>
  </div>

</div>
