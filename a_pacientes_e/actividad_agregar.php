<?php
	require_once("../a_pacientes/db_.php");
	$idmodulo=$_REQUEST['idmodulo'];
	$idpaciente=$_REQUEST['idpaciente'];

  /////////////////////breadcrumb
  $paciente = $db->cliente_editar($idpaciente);
  $nombre=$paciente->nombre." ".$paciente->apellidop." ".$paciente->apellidom;

  $sql="select * from modulo where id=:idmodulo";
  $sth = $db->dbh->prepare($sql);
  $sth->bindValue(":idmodulo",$idmodulo);
  $sth->execute();
  $modulo=$sth->fetch(PDO::FETCH_OBJ);

  $sql="select * from track where id=:idtrack";
  $sth = $db->dbh->prepare($sql);
  $sth->bindValue(":idtrack",$modulo->idtrack);
  $sth->execute();
  $track=$sth->fetch(PDO::FETCH_OBJ);

  $sql="select * from terapias where id=:idterapia";
  $sth = $db->dbh->prepare($sql);
  $sth->bindValue(":idterapia",$track->idterapia);
  $sth->execute();
  $terapia=$sth->fetch(PDO::FETCH_OBJ);

	$actividad=$db->actividad_lista($idmodulo);
?>

  <nav aria-label='breadcrumb'>
   <ol class='breadcrumb'>
  	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/lista" dix="trabajo">Pacientes</li>
  	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/paciente" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo"><?php echo $nombre; ?></li>
  	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/terapias" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Terapias</li>
  	 <li class="breadcrumb-item" id='lista_track' is="li-link" des="a_pacientes/track" dix="trabajo" v_idterapia="<?php echo $terapia->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $terapia->nombre; ?></li>
  	 <li class="breadcrumb-item" id='lista_track' is="li-link" des="a_pacientes/modulos" dix="trabajo" v_idtrack="<?php echo $track->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $track->nombre; ?></li>
  	 <li class="breadcrumb-item" id='lista_track' is="li-link" des="a_pacientes/actividades" dix="trabajo" v_idmodulo="<?php echo $modulo->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $modulo->nombre; ?></li>
  	 <li class="breadcrumb-item active" id='lista_track' is="li-link" des="a_pacientes_e/actividad_agregar" dix="trabajo" v_idmodulo="<?php echo $idmodulo; ?>" v_idpaciente="<?php echo $idpaciente; ?>">Agregar actividad</li>
   </ol>
  </nav>

  <div class="alert alert-danger text-center" role="alert">
    Agregar Actividad existente
  	<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_pacientes/actividades" v_idmodulo="<?php echo $idmodulo; ?>" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Regresar</button>
  </div>


	<div class="container">
	  <div class="row">
	  <?php
	    foreach($actividad as $key){
	  ?>
	    <div class='col-4 p-3 w-50'>
	      <div class='card' style='height:200px;'>
	        <div class="card-header">
	          <?php echo $key->nombre; ?>
	        </div>
	        <div class='card-body'>
	          <div class='row'>
	            <div class='col-12'>
	                <?php echo $key->observaciones; ?>
	            </div>
	          </div>
	        </div>
	        <div class='card-footer'>
	          <div class='row'>
	            <div class='col-12'>
	              <button class="btn btn-warning btn-block" type="button" is="b-link" db="a_pacientes/db_" fun='agregar_actividad' dix="trabajo" tp='¿Desea agregar la actividad?' des="a_pacientes/actividades"
								v_idactividad="<?php echo $key->idactividad; ?>" v_idpaciente="<?php echo $idpaciente; ?>" v_idmodulo="<?php echo $idmodulo; ?>">Agregar</button>
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
						<?php
	          	echo "<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_pacientes_e/actividad_editar' dix='trabajo' v_idactividad='0' v_idmodulo='$idmodulo' v_idpaciente='$idpaciente' cmodal='2'>Nueva actividad</button>";
						?>
	        </div>
	      </div>
	    </div>
	  </div>

	</div>
