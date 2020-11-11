<?php
	require_once("../a_actividades/db_.php");
  $idactividad=$_REQUEST['idactividad'];
  $idcontexto=$_REQUEST['idcontexto'];

	$paciente=0;
	if(isset($_REQUEST['idpaciente'])){
		$idpaciente=$_REQUEST['idpaciente'];
		$paciente=1;
	}

	$sql="SELECT respuestas.*, contexto.texto as cont  FROM respuestas
	LEFT OUTER JOIN contexto ON contexto.id = respuestas.idcontexto
	LEFT OUTER JOIN subactividad ON subactividad.idsubactividad = contexto.idsubactividad
	WHERE	subactividad.idactividad =:idactividad and contexto.id!=:idcontexto";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":idactividad",$idactividad);
	$sth->bindValue(":idcontexto",$idcontexto);
	$sth->execute();
	$resp=$sth->fetchAll(PDO::FETCH_OBJ);

	$contexto=$db->contexto_editar($idcontexto);

	if($paciente==1){
		echo "<form is='f-submit' id='form_terapia' db='a_actividades/db_' fun='guardar_condicion' des='a_pacientes/actividad_ver' v_idactividad='$idactividad' v_idpaciente='$idpaciente' dix='trabajo' cmodal='1'>";
	}
	else{
		echo "<form is='f-submit' id='form_terapia' db='a_actividades/db_' fun='guardar_condicion' des='a_actividades/actividad_ver' v_idactividad='$idactividad' dix='trabajo' cmodal='1'>";
	}
 ?>
	 <input type="hidden" name="idcontexto" id="idcontexto" value="<?php echo $idcontexto; ?>" cmodal="1">
	 <div class="card">
	   <div class="card-header">
	     Condicional
	   </div>
	   <div class="card-body">
			 <?php
			 	echo "<select id='idcond' name='idcond' class='form-control'>";
					echo "<option value=''></option>";
			 	foreach($resp as $key){
					echo "<option value='".$key->id."'";  if($contexto->idcond==$key->id){ echo " selected";}  echo ">".$key->cont." - ".$key->nombre."</option>";
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
