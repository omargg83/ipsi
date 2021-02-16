<?php
	require_once("../a_pacientes/db_.php");
	$idterapia="";
	$idtrack=$_REQUEST['idtrack'];
	$idpaciente=$_REQUEST['idpaciente'];


  /////////////////////breadcrumb
  $paciente = $db->cliente_editar($idpaciente);
  $nombre=$paciente->nombre." ".$paciente->apellidop." ".$paciente->apellidom;

  $sql="select * from track where id=:idtrack";
  $sth = $db->dbh->prepare($sql);
  $sth->bindValue(":idtrack",$idtrack);
  $sth->execute();
  $track=$sth->fetch(PDO::FETCH_OBJ);
  $inicial=$track->inicial;

  $sql="select * from terapias where id=$track->idterapia";
  $sth = $db->dbh->query($sql);
  $terapia=$sth->fetch(PDO::FETCH_OBJ);


?>

  <nav aria-label='breadcrumb'>
   <ol class='breadcrumb'>
  	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/lista" dix="trabajo">Pacientes</li>
  	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/paciente" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo"><?php echo $nombre; ?></li>
  	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/terapias" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Terapias</li>
  	 <li class="breadcrumb-item" id='lista_track' is="li-link" des="a_pacientes/track" dix="trabajo" v_idterapia="<?php echo $terapia->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $terapia->nombre; ?></li>
  	 <li class="breadcrumb-item active" id='lista_track' is="li-link" des="a_pacientes/modulos" dix="trabajo" v_idtrack="<?php echo $idtrack; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $track->nombre; ?></li>

     <li class="breadcrumb-item active" id='lista_track' is="li-link" des="a_pacientes_e/grupo_agregar" dix="trabajo" v_idtrack="<?php echo $idtrack; ?>" v_idpaciente="<?php echo $idpaciente; ?>">Agregar grupo</li>

  	 <button class="btn btn-warning btn-sm " type="button" is="b-link" des="a_pacientes/modulos" dix="trabajo" v_idtrack="<?php echo $idtrack; ?>" v_idpaciente="<?php echo $idpaciente; ?>">Regresar</button>
   </ol>
  </nav>

  <div class="alert alert-danger text-center" role="alert">
    Agregar Grupo
  </div>
  <?php
  	$sql="select * from grupo_actividad where grupo_actividad.idtrack=$track->id order by grupo_actividad.orden asc";
  	$sth = $db->dbh->query($sql);
  	$grupos=$sth->fetchAll(PDO::FETCH_OBJ);
  	echo "<div class='container'>";
  		echo "<div class='row'>";
  		foreach($grupos as $key){
  			echo "<div class='col-4 p-2 w-50 actcard'>";
  				echo "<div class='card' style='height:400px'>";
  					echo "<div class='card-header'>";
  						echo "<div class='row'>";
  							echo "<div class='col-12'>";
  								echo $key->grupo;
  							echo "</div>";
  						echo "</div>";

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
  								echo "<button class='btn btn-warning btn-block' type='button' is='b-link' db='a_pacientes/db_' tp='¿Desea agregar el grupo?'fun='agregar_grupo' des='a_pacientes/modulos' dix='trabajo' v_idgrupo='$key->idgrupo' v_idpaciente='$idpaciente' v_idtrack='$idtrack'>Agregar</button>";
  							echo "</div>";
  						echo "</div>";
  					echo "</div>";
  				echo "</div>";
  			echo "</div>";
  		}

  			echo "<div id='' class='col-4 p-3 w-50'>";
  				echo "<div class='card' style='height:200px;'>";
  					echo "<div class='card-body text-center'>";
  						echo "<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_pacientes_e/grupo_editar' dix='trabajo' v_idgrupo='0' v_idtrack='$idtrack' v_idpaciente='$idpaciente'>Nuevo grupo</button>";
  					echo "</div>";
  				echo "</div>";
  			echo "</div>";
  		echo "</div>";
  	echo "</div>";

  ?>
