<?php
	require_once("../a_actividades/db_.php");
  $id=$_REQUEST['id'];
  $idescala=$_REQUEST['idescala'];
  $idactividad=$_REQUEST['idactividad'];

	$paciente=0;
	if(isset($_REQUEST['idpaciente'])){
		$idpaciente=$_REQUEST['idpaciente'];
		$paciente=1;
	}

	$sql="SELECT contexto.* FROM contexto LEFT OUTER JOIN subactividad ON subactividad.idsubactividad = contexto.idsubactividad
	WHERE	subactividad.idactividad=$idactividad and contexto.tipo='pregunta'";
  $sth = $db->dbh->prepare($sql);
	$sth->execute();
	$resp=$sth->fetchAll(PDO::FETCH_OBJ);

	$idrespuesta=0;
	if($id>0){
		$sql="select * from escala_contexto where id=$id";
		$sth = $db->dbh->prepare($sql);
		$sth->execute();
		$respx=$sth->fetch(PDO::FETCH_OBJ);
		$idrespuesta=$respx->idrespuesta;
	}

	if($paciente==1){
		echo "<form is='f-submit' id='form_terapia' db='a_actividades/db_' fun='guardar_evalua' des='a_pacientes/actividad_ver' v_idactividad='$idactividad' v_idpaciente='$idpaciente' v_idescala='$idescala' dix='trabajo' cmodal='1'>";
	}
	else{
		echo "<form is='f-submit' id='form_terapia' db='a_actividades/db_' fun='guardar_evalua' des='a_actividades/actividad_ver' v_idactividad='$idactividad' v_idescala='$idescala' dix='trabajo' cmodal='1'>";

	}
 ?>
	 <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" cmodal="1">
	 <div class="card">
	   <div class="card-header">
	     Condicional
	   </div>
	   <div class="card-body">
			 <?php
			 	echo "<select id='idcontexto' name='idcontexto' class='form-control'>";
					echo "<option value=''></option>";
			 	foreach($resp as $key){
					echo "<option value='".$key->id."'";  if($idrespuesta==$key->id){ echo " selected";}  echo ">".$key->texto."</option>";
				}
				echo "</select>";
			 ?>

	   </div>
	   <div class="card-footer">
			 <button class="btn btn-warning" type="submit">Guardar</button>
	     <button class="btn btn-warning" type="button" is="b-link" des='a_actividades/actividad_ver' dix='trabajo' id1="<?php echo $idactividad; ?>" cmodal="1">Regresar</button>
	   </div>
	 </div>
</form>
