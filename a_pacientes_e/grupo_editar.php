<?php
	require_once("../a_pacientes/db_.php");
	$idterapia="";

	if(isset($_REQUEST['idtrack'])){
		$idtrack=$_REQUEST['idtrack'];
		$tipo="track";
	}
	if(isset($_REQUEST['idmodulo'])){
		$idmodulo=$_REQUEST['idmodulo'];
		$tipo="modulo";
	}

	$idpaciente=$_REQUEST['idpaciente'];
	$idgrupo=$_REQUEST['idgrupo'];

	/////////////////////breadcrumb
	$paciente = $db->cliente_editar($idpaciente);
	$nombre=$paciente->nombre." ".$paciente->apellidop." ".$paciente->apellidom;
	
	if($tipo=="modulo"){
		$sql="select * from modulo where id=$idmodulo";
		$sth = $db->dbh->query($sql);
		$modulo=$sth->fetch(PDO::FETCH_OBJ);

		$idtrack=$modulo->idtrack;
	}

	$sql="select * from track where id=$idtrack";
	$sth = $db->dbh->query($sql);
	$track=$sth->fetch(PDO::FETCH_OBJ);
	$inicial=$track->inicial;

	$sql="select * from terapias where id=$track->idterapia";
	$sth = $db->dbh->query($sql);
	$terapia=$sth->fetch(PDO::FETCH_OBJ);


	$grupo="";
	$observaciones="";
	if($idgrupo>0){
		$sql="SELECT * FROM grupo_actividad	WHERE idgrupo=$idgrupo";
		$sth = $db->dbh->query($sql);
		$grupodb=$sth->fetch(PDO::FETCH_OBJ);
		$grupo=$grupodb->grupo;
		$observaciones=$grupodb->observaciones;
	}


echo "<nav aria-label='breadcrumb'>";
 echo "<ol class='breadcrumb'>";
   echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_pacientes/lista' dix='trabajo'>Pacientes</li>";
   echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_pacientes/paciente' v_idpaciente='$idpaciente' dix='trabajo'>$nombre</li>";
   echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_pacientes/terapias' v_idpaciente='$idpaciente' dix='trabajo'>Terapias</li>";
   echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_pacientes/track' dix='trabajo' v_idterapia='$terapia->id' v_idpaciente='$idpaciente'>$terapia->nombre</li>";
   echo "<li class='breadcrumb-item active' id='lista_track' is='li-link' des='a_pacientes/modulos' dix='trabajo' v_idtrack='$idtrack' v_idpaciente='$idpaciente'>$track->nombre</li>";
   echo "<li class='breadcrumb-item active' id='lista_track' is='li-link' des='a_pacientes_e/grupo_agregar' dix='trabajo' v_idtrack='$idtrack' v_idpaciente='$idpaciente'>Agregar grupo</li>";
   if($tipo=="track"){
     echo "<li class='breadcrumb-item active' id='lista_track' is='li-link' des='a_pacientes_e/grupo_editar' dix='trabajo' v_idtrack='$idtrack' v_idpaciente='$idpaciente' v_idgrupo='$idgrupo'>Editar grupo</li>";
   }
   echo "<button class='btn btn-warning btn-sm ' type='button' is='b-link' des='a_pacientes_e/grupo_agregar' dix='trabajo' v_idtrack='$idtrack' v_idpaciente='$idpaciente'>Regresar</button>";
 echo "</ol>";
echo "</nav>";


echo "<div class='container'>";

		if($tipo=="modulo"){
			echo "<form is='f-submit' id='form_grupo' db='a_actividades/db_' fun='guardar_grupo' des='a_pacientes/actividades' v_idmodulo='$idmodulo' v_idpaciente='$idpaciente' dix='trabajo'>";
        	echo "<input type='hidden' name='idmodulo' id='idmodulo' value='$idmodulo'>";
		}
		else{
			echo "<form is='f-submit' id='form_grupo' db='a_actividades/db_' fun='guardar_grupo' des='a_pacientes/modulos' v_idtrack='$idtrack' v_idpaciente='$idpaciente' dix='trabajo'>";
			echo "<input type='hidden' name='idtrack' id='idtrack' value='$idtrack'>";
		}
		echo "<input type='hidden' name='idgrupo' id='idgrupo' value='$idgrupo'>";
    ?>
    <div class='card'>
			<div class='card-header'>
				Editar Grupo
			</div>
			<div class='card-body'>
				<div class='row'>
					<div class="col-12">
						<label>Nombre:</label>
						<input type="text" class="form-control form-control-sm" name="grupo" id="grupo" value="<?php echo $grupo;?>" placeholder="Nombre" maxlength="100" required >
					</div>
					<div class="col-12">
						<label>Descripción:</label>
						<textarea name="observaciones" id="observaciones" rows="8" cols="80" placeholder="Descripción" class="form-control"><?php echo $observaciones;?></textarea>
					</div>
			  </div>

			</div>
			<div class='card-footer'>
				<div class="row">
					<div class="col-sm-12">
						<button class="btn btn-warning" type="submit">Guardar</button>
						<?php
						if($tipo=="modulo"){
							echo "<button class='btn btn-warning' type='button' is='b-link' des='a_pacientes_e/actividades' v_idmodulo='$idmodulo' dix='trabajo'>Regresar #PENDIENTE</button>";
						}
						else{
							echo "<button class='btn btn-warning' type='button' is='b-link' des='a_pacientes_e/grupo_agregar' dix='trabajo' v_idtrack='$idtrack' v_idpaciente='$idpaciente'>Regresar</button>";
						}
						?>
					</div>
				</div>
			</div>
		</div>
  </form>
</div>
