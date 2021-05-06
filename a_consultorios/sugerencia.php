<?php
	require_once("db_.php");
  $idconsultorio=$_REQUEST['idconsultorio'];
  $pd = $db->consultorio($idconsultorio);
  $nombre=$pd->nombre;
?>


<nav aria-label='breadcrumb'>
 <ol class='breadcrumb'>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_consultorios/index" dix="contenido">Citas</li>
	 <li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_consultorios/sugerencia" v_idconsultorio="<?php echo $idconsultorio; ?>" dix="contenido"><?php echo $nombre; ?></li>
	 <button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_consultorios/index" dix="contenido">Regresar</button>
 </ol>
</nav>


<?php

echo "<div id='' class='col-4 p-3 w-50'>";
  echo "<div class='card' style='height:200px;'>";
    echo "<div class='card-body text-center'>";
      echo "<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_consultorios\sugerencia_agregar' dix='contenido' v_idconsultorio='$idconsultorio'>Agregar</button>";
    echo "</div>";
  echo "</div>";
echo "</div>";

?>
