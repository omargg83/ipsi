<?php
	require_once("db_.php");
	$idactividad=$_REQUEST['idactividad'];
	$idpaciente=$_REQUEST['idpaciente'];
	$buscar=$_REQUEST['buscar'];

  if(isset($_REQUEST['buscar'])){
    $texto=$_REQUEST['buscar'];

    $sql="SELECT * FROM clientes_relacion
    left outer join clientes on clientes.id=clientes_relacion.idrel
    left outer join rol_familiar on rol_familiar.idrol=clientes_relacion.idrol
    where clientes_relacion.idcliente=$idpaciente";
    $sth = $db->dbh->query($sql);
    $pd=$sth->fetchAll(PDO::FETCH_OBJ);
  }
 ?>

 	<div class='tabla_v' id='tabla_css'>

 	<div class='header-row'>
 		<div class='cell'>#</div>
 		<div class='cell'>Nombre</div>
 		<div class='cell'>Nivel</div>
 	</div>

 		<?php
 			foreach($pd as $key){
 				echo "<div class='body-row' >";
 					echo "<div class='cell'>";
 						echo "<div class='btn-group'>";

				        echo "<button class='btn btn-warning btn-sm' id='can_$key->idrelacion' type='button' is='b-link' v_idpaciente='$idpaciente' v_idactividad='$idactividad' v_idrel='$key->idrel' db='a_pacientes/db_' des='a_pacientes/actividad_ver' dix='trabajo' fun='asignar_pareja' tp='¿Desea agregar el usuario a la actividad seleccionada?' title='Borrar'>Agregar</button>";

 						echo "</div>";
 					echo "</div>";
 					echo "<div class='cell' data-titulo='Nombre'>".$key->nombre." ".$key->apellidop." ".$key->apellidom."</div>";
 					echo "<div class='cell' data-titulo='Nivel'>$key->rol";
 					echo "</div>";
 				echo "</div>";
 			}
 		?>

 </div>
