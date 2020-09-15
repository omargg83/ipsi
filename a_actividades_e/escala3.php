<?php
	require_once("../a_actividades/db_.php");
  $id=$_REQUEST['id'];

  $idescala=$_REQUEST['idescala'];
  $idactividad=$_REQUEST['idactividad'];
  $paciente=0;
  if (isset($_REQUEST['idpaciente'])) {
    $idpaciente=clean_var($_REQUEST['idpaciente']);
    $paciente=1;
  }

  $descripcion="";
  $minimo="";
  $maximo="";
  if($id>0){
    $sql="SELECT * from escala_act WHERE id=:id";
  	$sth = $db->dbh->prepare($sql);
  	$sth->bindValue(":id",$id);
  	$sth->execute();
  	$resp=$sth->fetch(PDO::FETCH_OBJ);
    $descripcion=$resp->descripcion;
    $minimo=$resp->minimo;
    $maximo=$resp->maximo;
  }


  if($paciente==0){
		echo "<form is='f-submit' id='form-escala' db='a_actividades/db_' fun='guarda_escalaact' des='a_actividades/actividad_ver' v_idactividad='$idactividad' cmodal='1'>";
	}
	else{
    echo "<form is='f-submit' id='form-escala' db='a_actividades/db_' fun='guarda_escalaact' des='a_pacientes/actividad_ver' v_idactividad='$idactividad' v_idpaciente='$idpaciente' cmodal='1'>";
	}

 ?>
  <div class="card">
    <div class="card-header">
      Editar escala
    </div>
    <div class="card-body">
        <input type="hidden" name="id" id="id" value="<?php echo $id;?>">
        <input type="hidden" name="idescala" id="idescala" value="<?php echo $idescala;?>">
        <div class="row">
          <div class="col-6">
            <label>Descripción</label>
            <input type="text" name="descripcion" id="descripcion" value="<?php echo $descripcion; ?>" class="form-control" required>
          </div>
          <div class="col-3">
            <label>Minimo</label>
            <input type="text" name="minimo" id="minimo" value="<?php echo $minimo; ?>" class="form-control" required>
          </div>
          <div class="col-3">
            <label>Maximo</label>
            <input type="text" name="maximo" id="maximo" value="<?php echo $maximo; ?>" class="form-control" required>
          </div>
        </div>

    </div>
    <div class="card-footer">
      <button type='submit' class='btn btn-warning '> Guardar</button>
      <button class="btn btn-warning" type="button" is="b-link" cmodal="1">Regresar</button>
    </div>
  </div>
</form>
