<?php
	require_once("../a_pacientes/db_.php");

	$idtrack=$_REQUEST['idtrack'];
	$idpaciente=$_REQUEST['idpaciente'];
	$idmodulo=0;
	/////////////////////breadcrumb
	$paciente = $db->cliente_editar($idpaciente);
	$nombre=$paciente->nombre." ".$paciente->apellidop." ".$paciente->apellidom;

	$sql="select * from track where id=:idtrack";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":idtrack",$idtrack);
	$sth->execute();
	$track=$sth->fetch(PDO::FETCH_OBJ);

	$sql="select * from terapias where id=:idterapia";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":idterapia",$track->idterapia);
	$sth->execute();
	$terapia=$sth->fetch(PDO::FETCH_OBJ);
	$idterapia=$track->idterapia;
  $modulo=$db->modulo_lista($idtrack);
?>

<nav aria-label='breadcrumb'>
 <ol class='breadcrumb'>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/lista" dix="trabajo">Pacientes</li>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/paciente" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo"><?php echo $nombre; ?></li>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/terapias" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Terapias</li>
	 <li class="breadcrumb-item" id='lista_track' is="li-link" des="a_pacientes/track" dix="trabajo" v_idterapia="<?php echo $terapia->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $terapia->nombre; ?></li>
	 <li class="breadcrumb-item" id='lista_track' is="li-link" des="a_pacientes/modulos" dix="trabajo" v_idtrack="<?php echo $idtrack; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $track->nombre; ?></li>
	 <li class="breadcrumb-item" id='lista_track active' is="li-link" des="a_pacientes_e/modulos_agregar" dix="trabajo" v_idtrack="<?php echo $idtrack; ?>" v_idpaciente="<?php echo $idpaciente; ?>">Agregar modulo</li>
 </ol>
</nav>


<div class="alert alert-danger text-center" role="alert">
  Agregar Modulo existente
	<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_pacientes/modulos" v_idtrack="<?php echo $idtrack; ?>" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Regresar</button>
</div>


<div class="container">
  <div class="row">
  <?php
    foreach($modulo as $key){
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
              <button class="btn btn-warning btn-block" type="button" is="b-link" db="a_pacientes/db_" fun='agregar_modulo' dix="trabajo" tp='¿Desea agregar el modulo?' des="a_pacientes/modulos" v_idmodulo="<?php echo $key->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>" v_idtrack="<?php echo $idtrack; ?>">Agregar</button>
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
          <button class="btn btn-warning btn-block" type="button" is="b-link" des="a_pacientes_e/modulos_editar" dix="trabajo" v_idmodulo="<?php echo $idmodulo; ?>" v_idtrack="<?php echo $idtrack; ?>" v_idterapia="<?php echo $idterapia; ?>" v_idpaciente='<?php echo $idpaciente; ?>' cmodal='2'>Nuevo modulo</button>
        </div>
      </div>
    </div>
  </div>

</div>
