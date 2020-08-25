<?php
	require_once("../a_actividades/db_.php");
  $idactividad=$_REQUEST['idactividad'];
  $idcontexto=$_REQUEST['idcontexto'];

	$sql="SELECT respuestas.*, contexto.texto as cont  FROM respuestas
	LEFT OUTER JOIN contexto ON contexto.id = respuestas.idcontexto
	LEFT OUTER JOIN subactividad ON subactividad.idsubactividad = contexto.idsubactividad
	WHERE	subactividad.idactividad =:idactividad and contexto.id!=:idcontexto";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":idactividad",$idactividad);
	$sth->bindValue(":idcontexto",$idcontexto);
	$sth->execute();
	$resp=$sth->fetchAll(PDO::FETCH_OBJ);

 ?>
 <form is="f-submit" id="form_terapia" db="a_actividades/db_" fun="guardar_modulo">
	 <div class="card">
	   <div class="card-header">
	     Condicional
	   </div>
	   <div class="card-body">
			 <?php
			 	echo "<select id='condicinal' name='condicional' class='form-control'>";
			 	foreach($resp as $key){
					echo "<option value='".$key->id."'>".$key->cont." - ".$key->nombre."</option>";
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
