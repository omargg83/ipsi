<?php
	require_once("../a_actividades/db_.php");
  $idsubactividad=clean_var($_REQUEST['idsubactividad']);
  $idactividad=clean_var($_REQUEST['idactividad']);

	$pacientes=0;
	if(isset($_REQUEST['idpaciente'])){
		$idpaciente=clean_var($_REQUEST['idpaciente']);
		$pacientes=1;
	}

	$nombre="";
	$orden="";
	$pagina="";
	if($idsubactividad){
		$res=$db->subactividad_editar($idsubactividad);
		$nombre=$res->nombre;
		$orden=$res->orden;
		$pagina=$res->pagina;
	}
	else{
		$sql="select max(orden) as maximo from subactividad where idactividad='$idactividad'";
		$sth = $db->dbh->prepare($sql);
		$sth->execute();
		$ordena=$sth->fetch(PDO::FETCH_OBJ);
		$orden=$ordena->maximo+1;
	}
?>

	<?php
		if($pacientes==0){
			echo "<form is='f-submit' id='form_sub' db='a_actividades/db_' fun='subactividad_guardar' des='a_actividades/actividad_ver' v_idactividad='$idactividad' dix='trabajo' cmodal='1'>";
		}
		else{
			echo "<form is='f-submit' id='form_sub' db='a_actividades/db_' fun='subactividad_guardar' des='a_pacientes/actividad_ver' v_idactividad='$idactividad'  v_idpaciente='$idpaciente' dix='trabajo' cmodal='1'>";
		}
	?>
  <input type="hidden" name="idsubactividad" id="idsubactividad" value="<?php  echo $idsubactividad; ?>">
  <input type="hidden" name="idactividad" id="idactividad" value="<?php  echo $idactividad; ?>">
	<div class="card">
	  <div class="card-header">
	    Editar subactividad
	  </div>
	  <div class="card-body">
	    <div class="row">
	      <div class="col-12">
	        <label for="">Nombre</label>
	        <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" class="form-control" required>
	      </div>
	    </div>
	  </div>
	  <div class="card-footer">
	    <button type='submit' class='btn btn-warning'> Guardar</button>
	    <button class="btn btn-warning" type="button" is="b-link" cmodal="1">Regresar</button>
	  </div>
  </div>
</form>
