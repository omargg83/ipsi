<?php
	require_once("db_.php");

  $idpaciente=$_REQUEST['idpaciente'];

  if(isset($_REQUEST['buscar'])){
    $texto=$_REQUEST['buscar'];
    $pd = $db->relacion_buscar($texto, $idpaciente);
  }
?>

<div class='container'>
	<div class='tabla_v' id='tabla_css'>

	<div class='header-row'>
		<div class='cell'>#</div>
		<div class='cell'>Número</div>
		<div class='cell'>Nombre</div>
	</div>



		<?php
			foreach($pd as $key){
				echo "<div class='body-row' >";
					echo "<div class='cell'>";
						echo "<div class='btn-group'>";
						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/relaciones_editar' dix='trabajo' v_idrelacion='0' v_id='$key->id' v_idpaciente='$idpaciente'>Seleccionar</button>";
						echo "</div>";
					echo "</div>";
          echo "<div class='cell' data-titulo='Número'>".$key->numero."</div>";
					echo "<div class='cell' data-titulo='Nombre'>".$key->nombre." ".$key->apellidop." ".$key->apellidom."</div>";
				echo "</div>";
			}
		?>
	</div>
