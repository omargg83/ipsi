<?php
	require_once("../a_pacientes/db_.php");

  $idgrupo=$_REQUEST['idgrupo'];
  $idpaciente=$_REQUEST['idpaciente'];

  /////////////////////breadcrumb
  $paciente = $db->cliente_editar($idpaciente);
  $nombre=$paciente->nombre." ".$paciente->apellidop." ".$paciente->apellidom;


	$tipo="";
	$sql="SELECT * from grupo_actividad where idgrupo=$idgrupo";
	$sth = $db->dbh->query($sql);
	$grupo=$sth->fetch(PDO::FETCH_OBJ);
	if(strlen($grupo->idtrack)){
		$tipo="track";

		$sql="select * from track where id=$grupo->idtrack";
		$sth = $db->dbh->query($sql);
		$track=$sth->fetch(PDO::FETCH_OBJ);
		$inicial=$track->inicial;
		$idtrack=$track->id;
		$sql="select * from terapias where id=$track->idterapia";
		$sth = $db->dbh->query($sql);
		$terapia=$sth->fetch(PDO::FETCH_OBJ);
	}
	else{
		$tipo="modulos";
	}

	$idterapia=$track->idterapia;
  $sql="select * from terapias where id=$idterapia";
  $sth = $db->dbh->query($sql);
  $terapia=$sth->fetch(PDO::FETCH_OBJ);

	$sql="select * from actividad where idgrupo=$idgrupo";
  $sth = $db->dbh->query($sql);
  $actividad=$sth->fetchAll(PDO::FETCH_OBJ);

?>
<nav aria-label='breadcrumb'>
	<ol class='breadcrumb'>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/lista" dix="trabajo">Pacientes</li>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/paciente" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo"><?php echo $nombre; ?></li>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/terapias" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Terapias</li>
		<li class="breadcrumb-item" is="li-link" des="a_pacientes/track" dix="trabajo" title="Terapias" v_idterapia="<?php echo $idterapia; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $terapia->nombre; ?></li>

		<li class="breadcrumb-item" is="li-link" des="a_pacientes/modulos" dix="trabajo" title="Terapias" v_idtrack="<?php echo $idtrack; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $track->nombre; ?></li>
		<?php
		echo "<li class='breadcrumb-item' is='li-link' des='a_pacientes/grupos' dix='trabajo' v_idgrupo='$grupo->idgrupo' v_idpaciente='$idpaciente'>$grupo->grupo</li>";

		?>

    <li class="breadcrumb-item active" is="li-link" des="a_pacientes_e/inicial_agregar" dix="trabajo" title="Terapias" v_idgrupo="<?php echo $idgrupo; ?>" v_idpaciente="<?php echo $idpaciente; ?>">Agregar actividad inicial</li>

		<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_pacientes/grupos" v_idgrupo="<?php echo $idgrupo; ?>" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Regresar</button>
	</ol>
</nav>

  <div class="alert alert-danger text-center" role="alert">
    Agregar Actividad inicial existentes

  </div>

  <div class='container'>
    <div class='row'>
      <?php
      foreach($actividad as $key){

			echo "<div class='col-4 p-2 w-50 actcard'>";
				echo "<div class='card' style='height:400px'>";
            echo "<div class='card-header'>";
              echo $key->nombre;
            echo "</div>";
            	echo "<div class='card-body' style='overflow:auto; height:220px'>";
              echo "<div class='row'>";
                echo "<div class='col-12'>";
                  echo $key->observaciones;
                echo "</div>";
              echo "</div>";
            echo "</div>";
            echo "<div class='card-body'>";
              echo "<div class='row'>";
                echo "<div class='col-12'>";
                  echo "<button class='btn btn-warning btn-block' type='button' is='b-link' db='a_pacientes/db_' fun='agregar_inicial' dix='trabajo' tp='¿Desea agregar la actividad inicial?' des='a_pacientes/modulos' v_idactividad='$key->idactividad' v_idgrupo'$idgrupo' v_idpaciente='$idpaciente'>Agregar</button>";
                echo "</div>";
              echo "</div>";
            echo "</div>";
          echo "</div>";
        echo "</div>";
      }
      ?>

      <div id='' class='col-4 p-3 w-50'>
        <div class="card" style='height:200px;'>
          <div class='card-body text-center'>
            <button class="btn btn-warning btn-block" type="button" is="b-link" des="a_pacientes_e/actividad_editar" dix="trabajo" v_idactividad="0" v_idgrupo='<?php echo $idgrupo; ?>'  v_idpaciente="<?php echo $idpaciente; ?>" v_proviene='nuevaactividad'>Nueva Actividad</button>
          </div>
        </div>
      </div>

    </div>
  </div>
