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
		<li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_pacientes/terapias" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Terapias</li>
	</ol>
</nav>

<div class="container">
	<form is="f-submit" id="form_terapia" db="a_actividades/db_" fun="guardar_terapia">
    <input type="hidden" name="id1" id="id1" value="<?php echo $idterapia;?>">
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
						<button class="btn btn-warning" type="button" is="b-link" des='a_actividades/terapias' dix='trabajo'>Regresar</button>
					</div>
				</div>
			</div>
		</div>
  </form>
</div>
