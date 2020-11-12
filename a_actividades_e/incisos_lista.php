<?php
	require_once("../a_pacientes/db_.php");

  $idcontexto=$_REQUEST['idcontexto'];
  $idactividad=$_REQUEST['idactividad'];
	$idpaciente=0;
	if(isset($_REQUEST['idpaciente'])){
		$idpaciente=$_REQUEST['idpaciente'];
	}

  $sql="select * from contexto where id=$idcontexto";
  $sth = $db->dbh->prepare($sql);
  $sth->execute();
  $row=$sth->fetch(PDO::FETCH_OBJ);

  $sql="select * from subactividad where idsubactividad=$row->idsubactividad";
  $sth = $db->dbh->prepare($sql);
  $sth->execute();
  $subactividad=$sth->fetch(PDO::FETCH_OBJ);

  $sql="select * from actividad where idactividad=$subactividad->idactividad";
  $sth = $db->dbh->prepare($sql);
  $sth->execute();
  $actividad=$sth->fetch(PDO::FETCH_OBJ);
	echo "<div class='card'>";
		echo "<div class='card-header'>";
			echo "Editar inciso";
		echo "</div>";

		echo "<div class='card-body'>";

  echo "<div class='container-fluid'>";
    $rx=$db->respuestas_ver($idcontexto);

    foreach ($rx as $respuesta) {
      $texto_resp="";
      $valor_resp="";
      $resp_idrespuesta="";

      echo "<div class='row'>";
        echo "<div class='col-3'>";

					if($idpaciente>0){
						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/inciso_editar' v_idrespuesta='$respuesta->id' v_idcontexto='$idcontexto' v_idactividad='$idactividad' v_idpaciente='$idpaciente' omodal='1' ><i class='fas fa-pencil-alt'></i></button>";

						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='respuesta_borrar' v_idactividad='$idactividad' v_idrespuesta='$respuesta->id' v_idpaciente='$idpaciente' tp='¿Desea eliminar el inciso selecionado?' title='Borrar' cmodal=2><i class='far fa-trash-alt'></i></button>";
					}
					else{
						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/inciso_editar' v_idrespuesta='$respuesta->id' v_idcontexto='$idcontexto' v_idactividad='$idactividad' omodal='1' ><i class='fas fa-pencil-alt'></i></button>";

						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='respuesta_borrar' v_idactividad='$idactividad' v_idrespuesta='$respuesta->id' tp='¿Desea eliminar el inciso selecionado?' title='Borrar' cmodal=2><i class='far fa-trash-alt'></i></button>";
					}
          echo "</div>";

        //////////////////para obtener Respuestas
        $sql="select * from contexto_resp where idcontexto=:id and idrespuesta=:idrespuesta";
        $contx = $db->dbh->prepare($sql);
        $contx->bindValue(":id",$idcontexto);
        $contx->bindValue(":idrespuesta",$respuesta->id);
        $contx->execute();
        $resp=$contx->fetch(PDO::FETCH_OBJ);
        $correcta=0;
        $texto_resp="";
        if($contx->rowCount()>0){
          $correcta=1;
          $texto_resp=$resp->texto;
          $valor_resp=$resp->valor;
        }

        echo "<div class='col-1'>";
          if($row->incisos==1){
            $idx="";
            echo "<input type='checkbox' name='checkbox_".$respuesta->id."' value='$respuesta->id' ";
            if($correcta){ echo " checked";}
            echo ">";
          }
          else{
            $idx=$idcontexto;
            echo "<input type='radio' name='radio_".$idx."' value='$respuesta->id' ";
              if($correcta){
                echo " checked";
              }
            echo ">";
          }
        echo "</div>";

        if(strlen($respuesta->imagen)>0){
          echo "<div class='col-1'>";
              echo "<img src=".$db->doc.$respuesta->imagen." alt='' width='20px'>";
          echo "</div>";
        }

        echo "<div class='col-3'>";
          echo $respuesta->nombre;
        echo "</div>";

        ///////////////////////////////////aca el valor
        if($actividad->tipo=="evaluacion"){
          echo "<div class='col-1'>";
            echo $respuesta->valor;
          echo "</div>";
        }

        echo "<div class='col-3'>";
          if($row->usuario==1){
            echo "<input type='text' name='resp_".$respuesta->id."' id='resp_".$respuesta->id."' value='$texto_resp' placeholder='Define..' class='form-control form-control-sm'>";
          }
        echo "</div>";
      echo "</div>";
    }


    if($row->personalizado==1){
      $texto="";
      $otro=0;

      $sql="select * from contexto_resp where idcontexto=$idcontexto and valor='OTRO'";
      $contx = $db->dbh->prepare($sql);
      $contx->execute();
      if($contx->rowCount()>0){
        $resp=$contx->fetch(PDO::FETCH_OBJ);
        $texto=$resp->texto;
        $otro=1;
      }

      echo "<div class='row'>";
        echo "<div class='col-3'>";
        echo "</div>";
        if($row->incisos==1){
            echo "<div class='col-1'>";
              echo "<input type='checkbox' name='checkbox_otro'";
              if($otro==1){
                echo " checked";
              }
              echo " value='otro'>";
            echo "</div>";
            echo "<div class='col-6'>";
              echo "<input type='text' name='resp_otro' id='resp_otro' value='$texto' class='form-control form-control-sm' placeholder='Otro'>";
            echo "</div>";
          }
          else{
            echo "<div class='col-1'>";
              echo "<input type='radio' name='radio_".$idx."' value='otro'";
              if($otro==1){
                echo " checked";
              }
              echo ">";
            echo "</div>";
            echo "<div class='col-6'>";
              echo "<input type='text' name='resp_otro' id='per_".$idcontexto."' value='$texto' class='form-control form-control-sm' placeholder='otro'>";
            echo "</div>";
        }
      echo "</div>";
    }
  echo "</div>";
echo "</div>";

echo "<div class='card-footer'>";
?>

	<button class="btn btn-warning" type="button" is="b-link" des='a_actividades/actividad_ver' dix='trabajo' id1="<?php echo $idactividad; ?>" cmodal="1">Regresar</button>
</div>
