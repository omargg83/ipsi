<?php
	require_once("db_.php");

	$pacientes=$db->pacientes();
	$sucursal=$db->sucursal();
	$terapueutas=$db->terapueutas();
	$fecha="";

	$texto="";
	if(isset($_REQUEST['buscar'])){
		$texto=$_REQUEST['buscar'];
	}
?>
<div class='container'>
	<div class='tabla_v' id='tabla_css'>
	<?php
	if(strlen($texto)==0){
		echo "<div class='body-filter'>";
		echo "<div class='filtro'>";
			echo "<form id='filtro_form' dix='resultado_sql' des='a_agenda/resultado' class='form_tablev'>";

					if($_SESSION['nivel']==1 or $_SESSION['nivel']==4){
						echo "<div class='cell2'>";
							echo "<select name='idsucursal' id='idsucursal' class='form-control form-control-sm filter_x' >";
								echo "<option value='' style='color:#e3e5e4 !important;'>Sucursal</option>";
								foreach($sucursal as $key){
									echo  "<option value=".$key->idsucursal.">$key->nombre</option>";
								}
							echo "</select>";
						echo "</div>";
					}
					if($_SESSION['nivel']==1 or $_SESSION['nivel']==3 or $_SESSION['nivel']==4){
						echo "<div class='cell2'>";
						echo "<select name='idusuario' id='idusuario' class='form-control form-control-sm filter_x' >";
							echo "<option value='' style='color:#e3e5e4 !important;'>Terapeuta</option>";
							foreach($terapueutas as $key){
								echo  "<option value=".$key->idusuario.">$key->nombre $key->apellidop $key->apellidom</option>";
							}
						echo "</select>";
						echo "</div>";
					}

					echo "<div class='cell2'>";
					echo "<input type='date' name='fecha_cita' id='fecha_cita' value='$fecha' class='form-control form-control-sm filter_x'>";
					echo "</div>";

					if($_SESSION['nivel']==1 or $_SESSION['nivel']==2 or $_SESSION['nivel']==3 or $_SESSION['nivel']==4){
						echo "<div class='cell2'>";
							echo "<select name='idpaciente' id='idpaciente' class='form-control form-control-sm filter_x' >";
								echo "<option value='' style='color:#e3e5e4 !important;'>Paciente</option>";
								foreach($pacientes as $key){
									echo  "<option value=".$key->id.">$key->nombre $key->apellidop $key->apellidom</option>";
								}
							echo "</select>";
						echo "</div>";
					}
			echo "</form>";
		echo "</div>";
	echo "</div>";
	}
	echo "<div class='data-row' id='resultado_sql'>";
		include 'resultado.php';
	echo "</div>";

	echo "</div>";


	?>
</div>
