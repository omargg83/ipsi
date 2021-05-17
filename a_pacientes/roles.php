<?php
	require_once("db_.php");
	$idactividad=$_REQUEST['idactividad'];
	$idpaciente=$_REQUEST['idpaciente'];

	$sql="select * from actividad_per where idactividad=$idactividad order by id asc";
	$sth = $db->dbh->query($sql);
	$pd=$sth->fetchAll(PDO::FETCH_OBJ);
	echo "<div class='modal-header'>";
		echo "<b>Usuarios en la actividad</b>";
	echo "</div>";

	echo "<div class='tabla_v' id='tabla_css'>";

	 	echo "<div class='header-row'>";
	 		echo "<div class='cell'>#</div>";
	 		echo "<div class='cell'>Pacientes en esta Actividad</div>";
	 	echo "</div>";
		$uno=0;
		foreach($pd as $key){
				$sql="SELECT * FROM clientes
				where clientes.id=$key->idpaciente";
				$sth = $db->dbh->query($sql);
				$familiar=$sth->fetch(PDO::FETCH_OBJ);

				echo "<div class='body-row' >";
					echo "<div class='cell'>";

						if($uno!=0){
							echo "<button class='btn btn-warning btn-sm' id='can_$key->id' type='button' is='b-link' v_id='$key->id'  db='a_pacientes/db_' des='a_pacientes/actividad_ver' dix='trabajo' v_idactividad='$idactividad' v_idpaciente='$idpaciente' fun='eliminar_pareja' tp='¿Desea eliminar el usuario de la actividad seleccionada?' title='Borrar' cmodal='2'>Eliminar</button>";
						}
						$uno++;

					echo "</div>";
					echo "<div class='cell' data-titulo='Nombre'>".$familiar->nombre." ".$familiar->apellidop." ".$familiar->apellidom."</div>";
				echo "</div>";
		}
	echo "</div>";

?>


<div class="modal-header">
  <b>Agregar familiar</b>
</div>

<div class="modal-body">
  <form is="f-submit" id="form_ads" des="a_pacientes/roles_buscar" dix='resultados' action='' >
    <input type="hidden" id="idactividad" name='idactividad' value='<?php echo $idactividad;?>'/>
    <input type="hidden" id="idpaciente" name='idpaciente' value='<?php echo $idpaciente;?>'/>
    <div class='row'>
      <div class='col-12'>
        <label>Buscar</label>
        <input type="text" id="buscar" name='buscar' placeholder="Buscar" class='form-control'/>
      </div>
    </div>
  </form>

  <div id='resultados'>
  </div>

</div>

<div class="modal-footer">
  <button type="button" class="btn btn-warning" data-dismiss="modal" title='Cancelar'>Cerrar</button>
</div>
