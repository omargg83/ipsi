<?php
	require_once("db_.php");

  	$idconsultorio=$_REQUEST['idconsultorio'];

		$pd = $db->consultorio($idconsultorio);
		$nombre=$pd->nombre;
		$idsucursal=$pd->idsucursal;
	/////////////////////Relaciones

  $desde=date("Y-m-d");
  $nuevafecha = strtotime ( '+1 month' , strtotime ( $desde ) ) ;
  $hasta = date ( "Y-m-d" , $nuevafecha );

?>

<nav aria-label='breadcrumb'>
 <ol class='breadcrumb'>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_consultorios/index" dix="contenido">Citas</li>
	 <li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_consultorios/disponibilidad" v_idconsultorio="<?php echo $idconsultorio; ?>" dix="contenido"><?php echo $nombre; ?></li>
	 <button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_consultorios/index" dix="contenido">Regresar</button>
 </ol>
</nav>

  <div class="container">
  	<div class='card'>
      <div class='card-body'>

      <?php
        echo "<form id='disp' is='f-submit' des='a_consultorios/lista_disponibilidad' dix='horarios' autocomplete='off'>";
          echo "<input type='hidden' id='idconsultorio' name='idconsultorio' value='$idconsultorio'>";
          echo "<h5>Buscar</h5>";
          echo "<div class='row'>";

            echo "<div class='col-sm-6'>";
              echo "<label>Desde:</label>";
              echo "<input class='form-control form-control-sm' placeholder='Desde....' type='date' id='desde' name='desde' value='$desde'>";
            echo "</div>";

            echo "<div class='col-sm-6'>";
              echo "<label>Hasta:</label>";
              echo "<input class='form-control form-control-sm' placeholder='Hasta....' type='date' id='hasta' name='hasta' value='$hasta'>";
            echo "</div>";


          echo "</div><br>";
          echo "<div class='row'>";
            echo "<div class='col-sm-4'>";
              echo "<div class='btn-group'>";
              echo "<button class='btn btn-outline-secondary btn-sm' type='submit'><i class='fas fa-search'></i>Buscar</button>";
              echo "</div>";
            echo "</div>";
          echo "</div>";

        echo "</form>";
      echo "</div>";
      ?>
		</div>

    <div class='card mt-3' id='horarios'>
    </div>
  </div>
