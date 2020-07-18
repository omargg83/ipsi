<?php
  require_once("db_.php");
  $idactividad=$_REQUEST['idactividad'];


  echo "<div class='container'>";
    echo "<nav aria-label='breadcrumb'>";
      echo "<ol class='breadcrumb'>";
        echo "<li class='breadcrumb-item' id='lista_comision' data-lugar='a_actividades/lista'>Actividades</li>";
        echo "<li class='breadcrumb-item' onclick='actividad($idactividad)'>Actividad</li>";
        echo "<li class='breadcrumb-item active' aria-current='page'>Pacientes</li>";
      echo "</ol>";
    echo "</nav>";

    $cuest=$db->actividad_editar($idactividad);
    echo "<div class='card'>";
      echo "<div class='card-header'>";
        echo "Actividad";
      echo "</div>";
      echo "<div class='card-body'>";
        echo "<div class='row'>";
          echo "<div class='col-12'>";
            echo $cuest->nombre;
            echo "<br>";
            echo $cuest->observaciones;
          echo "</div>";
        echo "</div>";
      echo "</div>";
      echo "<div class='card-footer'>";
        echo "<div class='row'>";
          echo "<div class='col-12'>";
            echo "<div class='btn-group'>";

            	echo "<button type='button' class='btn btn-warning ' placeholder='Click para agregar Cliente' id='winmodal_cliente' name='winmodal_cliente' data-id='0' data-id2='$idactividad' data-lugar='a_actividades/form_cliente' title='Click para agregar Cliente'><i class='fas fa-user-edit'></i>Asignar a paciente</button>";
              echo "<button type='button' class='btn btn-warning ' onclick='actividad($idactividad)'><i class='fas fa-undo-alt'></i> Regresar</button>";

            echo "</div>";
          echo "</div>";
        echo "</div>";
      echo "</div>";
    echo "</div>";
    echo "<br>";

    echo "<div class='card'>";
      echo "<div class='card-header'>";
        echo "Pacientes con la actividad asignada";
      echo "</div>";
      echo "<div class='card-body'>";
        echo "<div class='row'>";
          echo "<div class='col-12'>";
            echo $cuest->nombre;
            echo "<br>";
            echo $cuest->observaciones;
          echo "</div>";
        echo "</div>";
      echo "</div>";
    echo "</div>";
    echo "<br>";
?>
