<?php
	require_once("db_.php");

  $idcuest=$_REQUEST['id'];
  $pd=$db->preguntas($idcuest);
?>
  <div class='container'>
    <table id='x_cliente' class='dataTable compact hover row-border' style='font-size:10pt;'>
  	<thead>
  	<th>Orden</th>
  	<th>Nombre</th>
  	<th>Correo</th>
  	<th>Telefono</th>
  	</thead>
  	<tbody>
  		<?php
  			foreach($pd as $key){
  				echo "<tr id='".$key->id."''  class='edit-t'>";
            echo "<td>".$key->orden;
	            echo "<div class='btn-group'>";
	            echo "<button class='btn btn-outline-primary btn-sm' id='edit_persona' title='Editar' data-lugar='a_preguntas/preguntas' data-param1='$idcuest'><i class='fas fa-pencil-alt'></i></button>";
	            echo "</div>";
            echo "</td>";
  					echo "<td>".$key->pregunta."</td>";
  					echo "<td>".$key->tipo."</td>";

  				echo "</tr>";
  			}
  		?>
  	</div>
  	</tbody>
  	</table>
  </div>
