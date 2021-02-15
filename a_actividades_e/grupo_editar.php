<?php
	require_once("../a_actividades/db_.php");
	$idgrupo=$_REQUEST['idgrupo'];
	$tipo="";
	if(isset($_REQUEST['idmodulo'])){
		$tipo="modulo";
		$idmodulo=$_REQUEST['idmodulo'];
		$modulo=$db->modulo_editar($idmodulo);
		$track=$db->track_editar($modulo->idtrack);
		$terapia=$db->terapia_editar($track->idterapia);
	}
	if(isset($_REQUEST['idtrack'])){
		$tipo="track";
		$idtrack=$_REQUEST['idtrack'];

		$track=$db->track_editar($idtrack);
		$terapia=$db->terapia_editar($track->idterapia);
	}

	
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
            echo "<li class='breadcrumb-item' type='button' is='li-link' des='a_actividades/terapias' dix='trabajo'>Inicio</lis>";
            echo "<li class='breadcrumb-item' type='button' is='li-link' des='a_actividades/track' dix='trabajo' title='Track' v_idterapia='$terapia->id'>$terapia->nombre</li>";
            echo "<li class='breadcrumb-item' type='button' is='li-link' des='a_actividades/modulos' dix='trabajo' v_idtrack='$track->id'>$track->nombre</li>";
			if($tipo=="modulo"){
				echo "<li class='breadcrumb-item active' type='button' is='li-link' des='a_actividades/actividades' dix='trabajo' v_idmodulo='$idmodulo'>$modulo->nombre</li>";
			}
			 if($idgrupo==0){
				if($tipo=="modulo"){
                	echo "<li class='breadcrumb-item active' type='button' is='li-link' des='a_actividades_e/grupo_editar' dix='trabajo' v_idmodulo='$idmodulo' v_idgrupo='$idgrupo'>Nuevo grupo</li>";
				}
				else{
					echo "<li class='breadcrumb-item active' type='button' is='li-link' des='a_actividades_e/grupo_editar' dix='trabajo' v_idtrack='$idtrack' v_idgrupo='$idgrupo'>Nuevo grupo</li>";
				}
            }
            
           
            echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades/modulos' dix='trabajo' v_idtrack='$track->id'>Regresar</button>";
        echo "</ol>";
    echo "</nav>";
?>

<div class="container">
	<?php     
		if($tipo=="modulo"){
			echo "<form is='f-submit' id='form_grupo' db='a_actividades/db_' fun='guardar_grupo' des='a_actividades/actividades' v_idmodulo='$idmodulo' dix='trabajo'>";
        	echo "<input type='hidden' name='idmodulo' id='idmodulo' value='$idmodulo'>";
		}
		else{
			echo "<form is='f-submit' id='form_grupo' db='a_actividades/db_' fun='guardar_grupo' des='a_actividades/modulos' v_idtrack='$idtrack' dix='trabajo'>";
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
						<button class="btn btn-warning" type="button" is="b-link" des='a_actividades/actividades' v_idmodulo="<?php echo $idmodulo; ?>" dix='trabajo'>Regresar</button>
					</div>
				</div>
			</div>
		</div>
  </form>
</div>
