<?php
	require_once("../a_pacientes/db_.php");

	$idterapia=clean_var($_REQUEST['idterapia']);
	$idpaciente=clean_var($_REQUEST['idpaciente']);

	$paciente = $db->cliente_editar($idpaciente);
  $nombre_p=$paciente->nombre." ".$paciente->apellidop." ".$paciente->apellidom;

  $nombre="Terapia nueva";
  $descripcion="";
  if($idterapia>0){
		$pd = $db->terapia_editar($idterapia);
    $nombre=$pd->nombre;
    $descripcion=$pd->descripcion;
  }
?>

<nav aria-label='breadcrumb'>
	<ol class='breadcrumb'>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/lista" dix="trabajo">Pacientes</li>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/paciente" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo"><?php echo $nombre_p; ?></li>
		<li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_pacientes_e/terapias_editar" v_idpaciente="<?php echo $idpaciente; ?>" v_idterapia='0' dix="trabajo">Nueva Terapias</li>
	</ol>
</nav>

<div class="alert alert-warning text-center tituloventana" role="alert">
	Nueva Terapia
  <button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_pacientes/paciente" dix="trabajo" v_idpaciente="<?php echo $idpaciente; ?>">Regresar</button>
</div>

<div class="container">
	<form is="f-submit" id="form_terapia" db="a_actividades/db_" fun="guardar_terapia" des="a_pacientes/paciente" v_idpaciente="<?php echo $idpaciente; ?>">
    <input type="hidden" name="idterapia" id="idterapia" value="<?php echo $idterapia;?>">
    <input type="hidden" name="idpaciente" id="idpaciente" value="<?php echo $idpaciente; ?>">
    <div class='card'>
			<div class='card-header'>
				Editar Terapia
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
						<button class="btn btn-warning" type="button" is="b-link" des='a_pacientes/paciente' v_idpaciente='<?php echo $idpaciente; ?>' dix='trabajo'>Regresar</button>
					</div>
				</div>
			</div>
		</div>
  </form>
</div>
