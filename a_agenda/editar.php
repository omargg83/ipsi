<?php
	require_once("db_.php");

  $idcita=$_REQUEST['idcita'];
	$idpaciente="";
	$idsucursal="";
	$idusuario="";
	$fecha=date("Y-m-d");

	if($idcita>0){
		$cita=$db->cita($idcita);
		$idsucursal=$cita->idsucursal;
		$idpaciente=$cita->idpaciente;
		$idusuario=$cita->idusuario;

		$h_desde = new DateTime($cita->desde);
		$fecha=$h_desde->format("Y-m-d");
	}

	$sucursal=$db->sucursal();
	$terapueutas=$db->terapueutas();
	$pacientes=$db->pacientes();

	$fecha_min=date("Y-m-d");
?>

<nav aria-label='breadcrumb'>
 <ol class='breadcrumb'>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_agenda/index" dix="contenido">Citas</li>
	 <li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_agenda/editar" v_idcita="<?php echo $idcita; ?>" dix="contenido">Editar cita</li>
	 <button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_agenda/index" dix="contenido">Regresar</button>
 </ol>
</nav>



<div class="container">
	<form is="f-submit" id="form_personal" des="a_agenda/resultados" dix='resultados' >
		<input type="hidden" name="idcita" id="idcita" value="<?php echo $idcita;?>">
  	<div class="card">
			<div class="card-body">
			<div class="row">
				<div class="col-3">
					<label for="">Fecha</label>
					<input type="date" name="fecha_cita" id="fecha_cita" value="<?php echo $fecha;?>" min='<?php echo $fecha_min;?>' class='form-control' required>
				</div>

				<?php
				if($_SESSION['nivel']==1 or $_SESSION['nivel']==4){
					echo "<div class='col-3'>";
						echo "<label for='idsucursal'>Sucursal</label>";
						echo "<select name='idsucursal' id='idsucursal' class='form-control'>";
							foreach($sucursal as $key){
								echo  "<option value=".$key->idsucursal;
								if ($key->idsucursal==$idsucursal){
									echo  " selected ";
								}
								echo  ">$key->nombre</option>";
							}
						echo "</select>";
					echo "</div>";
				}

				if($_SESSION['nivel']==1 or $_SESSION['nivel']==2 or $_SESSION['nivel']==3 or $_SESSION['nivel']==4){
					echo "<div class='col-3'>";
						echo "<label for='idpaciente'>Pacientes</label>";
						echo "<select name='idpaciente' id='idpaciente' class='form-control' >";

							foreach($pacientes as $key){
								echo  "<option value=".$key->id;
								if ($key->id==$idpaciente){
									echo  " selected ";
								}
								echo  ">$key->nombre $key->apellidop $key->apellidom</option>";
							}
						echo "</select>";
					echo "</div>";
				}
				if($_SESSION['nivel']==1 or $_SESSION['nivel']==3 or $_SESSION['nivel']==4){
					echo "<div class='col-3'>";
						echo "<label for=''>Terapeuta</label>";
						echo "<select name='idusuario' id='idusuario' class='form-control'>";
							foreach($terapueutas as $key){
								echo  "<option value=".$key->idusuario;
								if ($key->idusuario==$idusuario){
									echo  " selected ";
								}
								echo  ">$key->nombre $key->apellidop $key->apellidom</option>";
							}
						echo "</select>";
					echo "</div>";
				}
			echo "</div>";
			?>

			<div class="" id='fechas_disponibles'>

			</div>
		</div>
			<div class='card-footer'>
				<button class="btn btn-warning" type="submit">Buscar</button>
				<button class="btn btn-warning" type="button" is="b-link" des="a_agenda/index" dix="contenido">Regresar</button>
			</div>
		</div>
	</form>
	<div id='resultados'>

	</div>
</div>
