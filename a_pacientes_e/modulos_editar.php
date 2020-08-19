<?php
	require_once("../a_pacientes/db_.php");

  $idmodulo=$_REQUEST['idmodulo'];
  $idtrack=$_REQUEST['idtrack'];
  $idpaciente=$_REQUEST['idpaciente'];

	/////////////////////breadcrumb
	$paciente = $db->cliente_editar($idpaciente);
	$nombre_p=$paciente->nombre." ".$paciente->apellidop." ".$paciente->apellidom;

	$track=$db->track_editar($idtrack);
  $terapia=$db->terapia_editar($track->idterapia);
	$idterapia=$terapia->id;


  $nombre="Nuevo modulo";
	$descripcion="";
	if($idmodulo>0){
		$modulo=$db->modulo_editar($idmodulo);
		$nombre=$modulo->nombre;
		$descripcion=$modulo->descripcion;
	}
?>

<nav aria-label='breadcrumb'>
 <ol class='breadcrumb'>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/lista" dix="trabajo">Pacientes</li>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/paciente" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo"><?php echo $nombre_p; ?></li>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/terapias" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Terapias</li>
	 <li class="breadcrumb-item" id='lista_track' is="li-link" des="a_pacientes/track" dix="trabajo" v_idterapia="<?php echo $terapia->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $terapia->nombre; ?></li>
	 <li class="breadcrumb-item" id='lista_track' is="li-link" des="a_pacientes/modulos" dix="trabajo" v_idtrack="<?php echo $idtrack; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $track->nombre; ?></li>
	 <li class="breadcrumb-item" id='lista_track active' is="li-link" des="a_pacientes_e/modulos_editar" dix="trabajo" v_idmodulo="<?php echo $idmodulo; ?>" v_idtrack="<?php echo $idtrack; ?>" v_idpaciente="<?php echo $idpaciente; ?>">Nuevo modulo</li>
 </ol>
</nav>


<div class="container">
	<form is="f-submit" id="form_track" db="a_actividades/db_" fun="guardar_modulo" des="a_pacientes/modulos" v_idtrack="<?php echo $idtrack; ?>" v_idpaciente="<?php echo $idpaciente; ?>">
    <input type="hidden" name="idmodulo" id="idmodulo" value="<?php echo $idmodulo;?>">
    <input type="hidden" name="idtrack" id="idtrack" value="<?php echo $idtrack;?>">
		<input type="hidden" name="idpaciente" id="idpaciente" value="<?php echo $idpaciente; ?>">
    <div class='card'>
			<div class='card-header'>
				Editar Modulo
			</div>
			<div class='card-body'>
				<div class='row'>
					<div class="col-12">
						<label>Nombre:</label>
						<input type="text" class="form-control form-control-sm" name="nombre" id="nombre" value="<?php echo $nombre;?>" placeholder="Nombre" maxlength="100" required >
					</div>
					<div class="col-12">
						<label>Descripción:</label>
						<textarea name="descripcion" id="descripcion" rows="8" cols="80" placeholder="Descripción" class="form-control"><?php echo $descripcion;?></textarea>
					</div>
			  </div>

			</div>
			<div class='card-footer'>
				<div class="row">
					<div class="col-sm-12">
						<button class="btn btn-warning" type="submit">Guardar</button>
						<button class="btn btn-warning" type="button" is="b-link" des='a_actividades/modulos' id1="<?php echo $idtrack; ?>" dix='trabajo'>Regresar</button>
					</div>
				</div>
			</div>
		</div>
  </form>
</div>
