<?php
	require_once("db_.php");

	$pacientes=$db->pacientes();
	$sucursal=$db->sucursal();
	$terapueutas=$db->terapueutas();
	$fecha="";
?>
<div class='container'>
	<div class='tabla_v' id='tabla_css'>
	<div class='body-filter'>
		<div class='filtro'>
			<form id='filtro_form' dix='resultado_sql' des='a_agenda/resultado' class='form_tablev'>
			<?php
				echo "<div class='cell2'>";
					echo "<select name='idsucursal' id='idsucursal' class='form-control form-control-sm filter_x' >";
						echo "<option value='' style='color:#e3e5e4 !important;'>Sucursal</option>";
						foreach($sucursal as $key){
							echo  "<option value=".$key->idsucursal.">$key->nombre</option>";
						}
					echo "</select>";
				echo "</div>";
				echo "<div class='cell2'>";
				echo "<select name='idusuario' id='idusuario' class='form-control form-control-sm filter_x' >";
					echo "<option value='' style='color:#e3e5e4 !important;'>Terapeuta</option>";
					foreach($terapueutas as $key){
						echo  "<option value=".$key->idusuario.">$key->nombre $key->apellidop $key->apellidom</option>";
					}
				echo "</select>";
				echo "</div>";
				echo "<div class='cell2'>";
				echo "<input type='date' name='fecha_cita' id='fecha_cita' value='$fecha' class='form-control form-control-sm filter_x'>";
				echo "</div>";
				echo "<div class='cell2'>";
				echo "<select name='idpaciente' id='idpaciente' class='form-control form-control-sm filter_x' >";
					echo "<option value='' style='color:#e3e5e4 !important;'>Paciente</option>";
					foreach($pacientes as $key){
						echo  "<option value=".$key->id.">$key->nombre $key->apellidop $key->apellidom</option>";
					}
				echo "</select>";
				echo "</div>";
			?>
			</form>
		</div>
	</div>

		<div class='data-row' id='resultado_sql'>
			<?php
				include 'resultado.php';
			?>
		</div>

	</div>

	<?php
		if(strlen($texto)==0){
			$sql="SELECT count(idcita) as total FROM citas";
			$sth = $db->dbh->query($sql);
			$contar=$sth->fetch(PDO::FETCH_OBJ);
			$paginas=ceil($contar->total/$_SESSION['pagina']);
			$pagx=$paginas-1;

			echo $db->paginar($paginas,$pag,$pagx,"a_agenda/resultado","resultado_sql");
		}
	?>
</div>
