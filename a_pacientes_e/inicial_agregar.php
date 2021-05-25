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
    $idtrack=$grupo->idtrack;

	}
	else{
    $tipo="modulo";

    $sql="select * from modulo where id=$grupo->idmodulo";
		$sth = $db->dbh->query($sql);
		$modulo=$sth->fetch(PDO::FETCH_OBJ);

		$idtrack=$modulo->idtrack;
  }

  $sql="select * from track where id=$idtrack";
  $sth = $db->dbh->query($sql);
  $track=$sth->fetch(PDO::FETCH_OBJ);

  $sql="select * from terapias where id=$track->idterapia";
  $sth = $db->dbh->query($sql);
  $terapia=$sth->fetch(PDO::FETCH_OBJ);

	$idterapia=$track->idterapia;
  $sql="select * from terapias where id=$idterapia";
  $sth = $db->dbh->query($sql);
  $terapia=$sth->fetch(PDO::FETCH_OBJ);

	$sql="select * from actividad where idgrupo=$idgrupo and idpaciente is null";
  $sth = $db->dbh->query($sql);
  $actividad=$sth->fetchAll(PDO::FETCH_OBJ);

echo "<nav aria-label='breadcrumb'>";
	echo "<ol class='breadcrumb'>";
		echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_pacientes/lista' dix='trabajo'>Pacientes</li>";
		echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_pacientes/paciente' v_idpaciente='$idpaciente' dix='trabajo'>$nombre</li>";
		echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_pacientes/terapias' v_idpaciente='$idpaciente' dix='trabajo'>Terapias</li>";
		echo "<li class='breadcrumb-item' is='li-link' des='a_pacientes/track' dix='trabajo' title='Terapias' v_idterapia='$idterapia' v_idpaciente='$idpaciente'>$terapia->nombre</li>";

		echo "<li class='breadcrumb-item' is='li-link' des='a_pacientes/modulos' dix='trabajo' title='Terapias' v_idtrack='$idtrack' v_idpaciente='$idpaciente'>$track->nombre</li>";

		echo "<li class='breadcrumb-item' is='li-link' des='a_pacientes/grupos' dix='trabajo' v_idgrupo='$grupo->idgrupo' v_idpaciente='$idpaciente'>$grupo->grupo</li>";

    echo "<li class='breadcrumb-item active' is='li-link' des='a_pacientes_e/inicial_agregar' dix='trabajo' title='Terapias' v_idgrupo='$idgrupo' v_idpaciente='$idpaciente'>Agregar actividad inicial</li>";

		echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/grupos' v_idgrupo='$idgrupo' v_idpaciente='$idpaciente' dix='trabajo'>Regresar</button>";
	echo "</ol>";
echo "</nav>";

  echo "<div class='alert alert-danger text-center' role='alert'>";
    echo "Agregar Actividad existentes";
  echo "</div>";

  echo "<div class='container'>";
    echo "<div class='row'>";

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

                    echo "<button class='btn btn-warning btn-block' type='button' is='b-link' db='a_pacientes/db_' fun='agregar_inicial' dix='trabajo' tp='¿Desea agregar la actividad inicial?' des='a_pacientes/grupos' v_idactividad='$key->idactividad' v_idgrupo='$idgrupo' v_idpaciente='$idpaciente'>Agregar</button>";

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
