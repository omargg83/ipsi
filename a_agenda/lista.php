<?php
	require_once("db_.php");
	$pag=0;
	$texto="";
	if(isset($_REQUEST['buscar'])){
		$texto=$_REQUEST['buscar'];
		$pd = $db->agenda_buscar($texto);
		$texto=1;
	}
	else{
		if(isset($_REQUEST['pag'])){
			$pag=$_REQUEST['pag'];
		}
		$pd = $db->agenda_lista($pag);
	}

	$pacientes=$db->pacientes();
	$sucursal=$db->sucursal();
	$terapueutas=$db->terapueutas();

	$fecha="";
?>
<div class='container'>
	<div class='tabla_v' id='tabla_css'>
	<div class='body-filter'>
		<div class='filtro'>
			<?php
				echo "<select name='idsucursal' id='idsucursal' class='form-control form-control-sm'>";
					echo "<option value=''>Sucursal</option>";
					foreach($sucursal as $key){
						echo  "<option value=".$key->idsucursal.">$key->nombre</option>";
					}
				echo "</select>";

				echo "<select name='idusuario' id='idusuario' class='form-control form-control-sm'>";
					echo "<option value=''>Terapeuta</option>";
					foreach($terapueutas as $key){
						echo  "<option value=".$key->idusuario.">$key->nombre $key->apellidop $key->apellidom</option>";
					}
				echo "</select>";
				echo "<input type='date' name='fecha_cita' id='fecha_cita' value='$fecha' class='form-control form-control-sm'>";

				echo "<select name='idpaciente' id='idpaciente' class='form-control form-control-sm' >";
					echo "<option value=''>Paciente</option>";
					foreach($pacientes as $key){
						echo  "<option value=".$key->id.">$key->nombre $key->apellidop $key->apellidom</option>";
					}
				echo "</select>";
			?>
		</div>
	</div>

	<div class='header-row'>
		<div class='cell'>#</div>
		<div class='cell'>Sucursal</div>
		<div class='cell'>Terapeuta</div>
		<div class='cell'>Hora</div>
		<div class='cell'>Fecha</div>
		<div class='cell'>Paciente</div>
		<div class='cell'>status</div>
	</div>

		<?php
			foreach($pd as $key){
				echo "<div class='body-row' draggable='true'>";
					echo "<div class='cell'>";

						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_usuarios/editar' dix='trabajo' tp='edit' v_idcita='$key->idcita' title='editar'>Editar</button>";

						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_agenda/lista' dix='trabajo' db='a_agenda/db_' fun='cita_quitar' v_idcita='$key->idcita' tp='¿Desea eliminar la cita seleccionada?' title='Borrar'>Eliminar</button>";

					echo "</div>";

					echo "<div class='cell' data-titulo='Sucursal'>";
						echo $db->sucursal_($key->idsucursal)->nombre;
					echo "</div>";

					echo "<div class='cell' data-titulo='Terapeuta'>";
						$ter=$db->terapueuta_($key->idusuario);
						echo $ter->nombre." ".$ter->apellidop." ".$ter->apellidom;
					echo "</div>";

					echo "<div class='cell' data-titulo='Hora'>";
						$hora = new DateTime($key->desde);
						echo $hora->format("h:i");
					echo "</div>";

					echo "<div class='cell' data-titulo='Fecha'>";
						echo $hora->format("d-m-Y");
					echo "</div>";

					echo "<div class='cell' data-titulo='Paciente'>";
						$ter=$db->cliente_($key->idpaciente);
						echo $ter->nombre." ".$ter->apellidop." ".$ter->apellidom;
					echo "</div>";

					echo "<div class='cell' data-titulo='Status'>";
						echo $key->estatus;
					echo "</div>";
				echo "</div>";
			}
		?>
	</div>

	<?php
		if(strlen($texto)==0){
			$sql="SELECT count(idusuario) as total FROM usuarios";
			$sth = $db->dbh->query($sql);
			$contar=$sth->fetch(PDO::FETCH_OBJ);
			$paginas=ceil($contar->total/$_SESSION['pagina']);
			$pagx=$paginas-1;

			echo $db->paginar($paginas,$pag,$pagx,"a_usuarios/lista","trabajo");
		}
	?>
</div>
