<?php
	require_once("db_.php");
  	$idgrupo=$_REQUEST['idgrupo'];
    $visible="-1";
	if(isset($_REQUEST['visible'])){
		$visible=$_REQUEST['visible'];
	}
    $inicial=0;

    $sql="SELECT * from grupo_actividad where idgrupo=$idgrupo";
    $sth = $db->dbh->query($sql);
    $grupo=$sth->fetch(PDO::FETCH_OBJ);
    if(strlen($grupo->idtrack)){
        $idtrack=$grupo->idtrack;

       	$modulos=$db->modulos($idtrack);
        $track=$db->track_editar($idtrack);
        $inicial=1;
        $terapia=$db->terapia_editar($track->idterapia);
    }
    else{
        $sql="SELECT * from modulo where id=$grupo->idmodulo";
        $sth = $db->dbh->query($sql);
        $modulos=$sth->fetch(PDO::FETCH_OBJ);

        $track=$db->track_editar($modulos->idtrack);
        $terapia=$db->terapia_editar($track->idterapia);
    }




echo "<nav aria-label='breadcrumb'>";
   echo "<ol class='breadcrumb'>";
    echo "<li class='breadcrumb-item' is='li-link' des='a_actividades/terapias' dix='trabajo' title='Inicio'>Inicio</lis>";
    echo "<li class='breadcrumb-item' is='li-link' des='a_actividades/track' dix='trabajo' title='Terapias' v_idterapia='$terapia->id'>$terapia->nombre</li>";
    echo "<li class='breadcrumb-item' is='li-link' des='a_actividades/modulos' dix='trabajo' title='Track' v_idtrack='$track->id'>$track->nombre</li>";
    if($inicial==0){
        echo "<li class='breadcrumb-item' is='li-link' des='a_actividades/actividades' dix='trabajo' title='Grupo' v_idmodulo='$modulos->id'>$modulos->nombre</li>";
    }
    echo "<li class='breadcrumb-item active' is='li-link' des='a_actividades/grupos' dix='trabajo' title='Grupo' v_idgrupo='$grupo->idgrupo'>$grupo->grupo</li>";

    if($inicial==1){
        echo "<button class='btn btn-warning btn-sm' is='b-link' des='a_actividades/modulos' dix='trabajo' v_idtrack='$grupo->idtrack' v_idterapia='$terapia->id'>Regresar</button>";
    }
    else{
        echo "<button class='btn btn-warning btn-sm' is='b-link' des='a_actividades/actividades' dix='trabajo' v_idmodulo='$modulos->id'>Regresar</button>";
    }
   echo "</ol>";
 echo "</nav>";

    echo "<div class='container' id='filtro'>";
        echo "<form id='filtro_form' des='a_actividades/grupos'>";
            echo "<input type='hidden' name='idgrupo' id='idgrupo' value='$grupo->idgrupo'>";
            echo "<div class='row justify-content-end'>";
                echo "<div class='col-2'>";
                    echo "<select name='visible' id='visible' class='form-control form-control-sm filter_x' >";
                        echo "<option value='-1' "; if($visible=="-1"){ echo "selected"; } echo ">Todas</option>";
                        echo "<option value='1' "; if($visible==1){ echo "selected"; } echo ">Visibles</option>";
                        echo "<option value='0' "; if($visible==0){ echo "selected"; } echo ">Ocultas</option>";
                    echo "</select>";
                echo "</div>";
            echo "</div>";
        echo "</form>";
    echo "</div>";

    echo "<div class='container'>";
		echo "<div class='row'>";

        if($visible=="-1"){
            /////////////////ordenar modulos
            $sql="SELECT * from actividad where idgrupo=$grupo->idgrupo order by actividad.orden asc";
            $sth = $db->dbh->query($sql);
            $respx=$sth->fetchAll(PDO::FETCH_OBJ);
            $orden=0;
            foreach($respx as $row){
                $arreglo =array();
                $arreglo+=array('orden'=>$orden);
                $x=$db->update('actividad',array('idactividad'=>$row->idactividad), $arreglo);
                $orden++;
            }
        }


        $sql="select * from actividad where idgrupo=$grupo->idgrupo";
        if($visible>=0)
        $sql.=" and actividad.visible=$visible";

        $sql.=" order by actividad.orden asc";

        $sth = $db->dbh->query($sql);
        $actividad=$sth->fetchAll(PDO::FETCH_OBJ);

			foreach($actividad as $key){
				echo "<div class='col-4 p-2 w-50 actcard'>";
					echo "<div class='card' style='height:400px'>";
						echo "<div class='card-header'>";
							echo "<div class='row'>";
								echo "<div class='col-12'>";
									echo $key->nombre;
								echo "</div>";
							echo "</div>";
							echo "<div class='row'>";
								echo "<div class='col-12'>";

									echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' db='a_actividades/db_' fun='actividad_mover' des='a_actividades/grupos' v_idactividad='$key->idactividad' v_idgrupo='$idgrupo' v_dir='0' dix='trabajo' title='Arriba'><i class='fas fa-chevron-up'></i></button>";

									echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' db='a_actividades/db_' fun='actividad_mover' des='a_actividades/grupos' v_idactividad='$key->idactividad' v_idgrupo='$idgrupo' v_dir='1' dix='trabajo' title='Abajo'><i class='fas fa-chevron-down'></i></button>";

									echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' des='a_actividades/grupos' dix='trabajo' db='a_actividades/db_' fun='borrar_actividad' v_idactividad='$key->idactividad' v_idgrupo='$idgrupo' tp='¿Desea eliminar la actividad inicial seleccionada?' tt='Ya no podrá deshacer el cambio' title='Borrar'><i class='far fa-trash-alt'></i></button>";

									echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' db='a_actividades/db_' fun='actividad_duplicar' v_idactividad='$key->idactividad' v_idgrupo='$idgrupo' des='a_actividades/grupos' tp='¿Desea duplicar la actividad seleccionada?' title='Duplicar' dix='trabajo'><i class='far fa-clone'></i></button>";

									echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' des='a_actividades_e/actividad_editar' dix='trabajo' v_idactividad='$key->idactividad' v_idgrupo='$idgrupo' v_proviene='grupos'><i class='fas fa-pencil-alt'></i></button>";

								echo "</div>";
							echo "</div>";
						echo "</div>";
						echo "<div class='card-body' style='overflow:auto; height:220px'>";
							echo "<div class='row'>";
								echo "<div class='col-12'>";
									echo $key->observaciones;
								echo "</div>";
							echo "</div>";
						echo "</div>";
						echo "<div class='card-body'>";
							echo "<div class='row'>";
								echo "<div class='col-12'>";
									echo "<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_actividades/actividad_ver' dix='trabajo' v_idactividad='$key->idactividad'>Ver</button>";
								echo "</div>";
							echo "</div>";
						echo "</div>";
					echo "</div>";
				echo "</div>";
			}

			echo "<div id='' class='col-4 p-3 w-50'>";
				echo "<div class='card' style='height:200px;'>";
					echo "<div class='card-body text-center'>";
						echo "<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_actividades_e/actividad_editar' dix='trabajo' v_idactividad='0'  v_proviene='grupos' v_idgrupo='$idgrupo'>Nueva Actividad</button>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
        echo "</div>";
    echo "</div>";

?>
