<?php
	require_once("db_.php");
?>

<nav aria-label='breadcrumb'>
  <ol class='breadcrumb'>
    <li class="breadcrumb-item" is="li-link" des="a_reportes/index" dix="contenido" title="Inicio">Reportes</li>
    <li class="breadcrumb-item active" is="li-link" des="a_reportes/002reporte" dix="contenido">Reporte de citas</li>
	   <button class="btn btn-warning btn-sm float-right" is="b-link" des="a_reportes/index" dix="contenido" id1="">Regresar</button>
  </ol>
</nav>

<div class="alert alert-warning text-center tituloventana" role="alert">
  Reporte de citas
</div>

<div class='container'>
  <?php
    $hasta=date("Y-m-d");
    $nuevafecha = strtotime ( '-12 month' , strtotime ( $hasta ) ) ;
    $desde = date ( "Y-m-d" , $nuevafecha );
    echo "<form is='f-submit' id='form_cliente' des='a_reportes/002reporte_resp' dix='resp'>";
      echo "<div class='row'>";

        echo "<div class='col-2'>";
          echo "<label>Desde:</label>";
          echo "<input class='form-control' placeholder='Desde....' type='date' id='desde' name='desde' value='$desde' required>";
        echo "</div>";

        echo "<div class='col-2'>";
          echo "<label>Hasta:</label>";
          echo "<input class='form-control' placeholder='Hasta....' type='date' id='hasta' name='hasta' value='$hasta' required>";
        echo "</div>";

				echo "<div class='col-6'>";
					$pd=$db->terapeutas_lista();
          echo "<label>Terapeutas:</label>";
          echo "<select class='form-control' name='idusuario' id='idusuario' required>";
          echo "<option value='' selected style='color: silver;'>Seleccione ...</option>";
          foreach($pd as $key){
            echo  "<option value='".$key->idusuario."'>$key->nombre $key->apellidop $key->apellidom</option>";
          }
          echo  "</select>";
        echo "</div>";

      echo "</div>";
      echo "<div class='row'>";
        echo "<div class='col-sm-4'>";
          echo "<div class='btn-group'>";
          echo "<button class='btn btn-outline-secondary btn-sm' type='submit'><i class='fas fa-search'></i>Buscar</button>";
          echo "</div>";
        echo "</div>";
      echo "</div>";

    echo "</form>";

  ?>
	<div id='resp'>
	</div>
</div>
