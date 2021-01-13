<?php
		require_once("db_.php");


		$idrelacion=$_REQUEST['idrelacion'];
		if($idrelacion==0){

		}
		else{
			$idpaciente=$_REQUEST['idpaciente'];
			$pd = $db->cliente_editar($idpaciente);
			$idrol="";

			$nombre=$pd->nombre;
			$edad=$pd->edad;
			$apellidop=$pd->apellidop;
			$apellidom=$pd->apellidom;
			$telefono=$pd->telefono;
			$correo=$pd->correo;
			$foto=$pd->foto;
			$observaciones=$pd->observaciones;

			$id=$_REQUEST['id'];
			$relacion = $db->cliente_editar($id);
			$nombre_rel=$relacion->nombre;
			$apellidop_rel=$pd->apellidop;
			$apellidom_rel=$pd->apellidom;
		}

		$rol=$db->rol_relacion();
  ?>

  <nav aria-label='breadcrumb'>
  	<ol class='breadcrumb'>
  		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/index" dix="trabajo">Pacientes</li>
  		<li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_pacientes/paciente" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo"><?php echo $nombre." ".$apellidop." ".$apellidom; ?></li>
  		<li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_pacientes/relaciones" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Relaciones</li>
  		<li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_pacientes/relaciones_agregar" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Agregar</li>
			<li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_pacientes/relaciones_editar" v_idpaciente="<?php echo $idpaciente; ?>" v_id="<?php echo $id; ?>" dix="trabajo">Asignar</li>
  		<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_pacientes/relaciones" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Regresar</button>
  	</ol>
  </nav>

	<div class='container'>
		<form is="f-submit" id="form_relacion" db="a_pacientes/db_" fun="rol_asignar" cmodal="1">
			<input type="hidden" name="idpaciente" id="idpaciente" value="<?php echo $idpaciente;?>" readonly>
			<input type="hidden" name="idrel" id="idrel" value="<?php echo $id;?>" readonly>
			<input type="hidden" name="id" id="id" value="0" readonly>
			<div class="card">
				<div class="card-header">
					Asignar relacion
				</div>
				<div class="card-body">
					<div class='row'>
						<div class="col-12">
							<label for="">Nombre</label>
							<input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $nombre_rel." ".$apellidop_rel." ".$apellidom_rel; ?>" readonly>
						</div>
						<div class="col-12">
							<label for="">Rol</label>
							<select name='idrol' id='idrol' class='form-control form-control-sm'>
							<?php
								foreach($rol as $key){
									echo  "<option value=".$key->idrol;
									if ($key->idrol==$idrol){
										echo  " selected ";
									}
									echo  ">".$key->rol."</option>";
								}
							?>
							</select>
						</div>
						<div class="col-12">
							<button class='btn btn-warning btn-sm' type='submit'>Guardar</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
