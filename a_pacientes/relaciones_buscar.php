<?php
	require_once("db_.php");

  $idpaciente=$_REQUEST['idpaciente'];

  if(isset($_REQUEST['buscar'])){
    $texto=$_REQUEST['buscar'];
    $pd = $db->relacion_buscar($texto, $idpaciente);
  }
?>
<div class='container'>
		<div class='row'>
			<div class='col-2'>#</div>
      <div class='col-3'>Número</div>
			<div class='col-4'>Nombre</div>
		</div>

		<?php
			foreach($pd as $key){
				echo "<div class='row'>";
					echo "<div class='col-2'>";
						echo "<div class='btn-group'>";
						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/relacion_editar' dix='trabajo' v_id='$key->id' v_idpaciente='$idpaciente'>Seleccionar</button>";
						echo "</div>";
					echo "</div>";
          echo "<div class='col-3' >".$key->numero."</div>";
					echo "<div class='col-4' >".$key->nombre." ".$key->apellidop." ".$key->apellidom."</div>";
				echo "</div>";
			}
		?>
	</div>
