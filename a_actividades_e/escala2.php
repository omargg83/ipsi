<?php
	require_once("../a_actividades/db_.php");


  $idescala=$_REQUEST['idescala'];
  $idactividad=$_REQUEST['idactividad'];
  $paciente=0;
  if (isset($_REQUEST['idpaciente'])) {
    $idpaciente=clean_var($_REQUEST['idpaciente']);
    $paciente=1;
  }


  $nombre="";
  if($idescala>0){
    $sql="SELECT * from escala_actividad WHERE id=:idescala";
  	$sth = $db->dbh->prepare($sql);
  	$sth->bindValue(":idescala",$idescala);
  	$sth->execute();
  	$resp=$sth->fetch(PDO::FETCH_OBJ);
    $nombre=$resp->nombre;
  }


  if($paciente==0){
		echo "<form is='f-submit' id='form-escala' db='a_actividades/db_' fun='guarda_escalaglobal' des='a_actividades/actividad_ver' v_idactividad='$idactividad' cmodal='1'>";
	}
	else{
    echo "<form is='f-submit' id='form-escala' db='a_actividades/db_' fun='guarda_escalaglobal' des='a_pacientes/actividad_ver' v_idactividad='$idactividad' v_idpaciente='$idpaciente' cmodal='1'>";
	}

 ?>
  <div class="card">
    <div class="card-header">
      Editar escala
    </div>
    <div class="card-body">
        <input type="hidden" name="idescala" id="idescala" value="<?php echo $idescala;?>">
        <div class="row">
          <div class="col-12">
            <label>Nombre</label>
            <input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>" class="form-control" required>
          </div>

        </div>

    </div>
    <div class="card-footer">
      <button type='submit' class='btn btn-warning '> Guardar</button>
      <button class="btn btn-warning" type="button" is="b-link" cmodal="1">Regresar</button>
    </div>
  </div>
</form>
