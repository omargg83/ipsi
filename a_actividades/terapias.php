<?php
	require_once("db_.php");
  $terapias=$db->terapias();

	/////////////////ordenar terapia
	$sql="SELECT * from terapias order by terapias.orden asc";
	$sth = $db->dbh->query($sql);
	$respx=$sth->fetchAll(PDO::FETCH_OBJ);

	$orden=0;
	foreach($respx as $row){
		$arreglo =array();
		$arreglo+=array('orden'=>$orden);
		$x=$db->update('terapias',array('id'=>$row->id), $arreglo);
		$orden++;
	}
?>

<nav aria-label='breadcrumb'>
  <ol class='breadcrumb'>
    <li class="breadcrumb-item" is="li-link" des="a_actividades/terapias" dix="trabajo" title="Inicio">Inicio</li>
  </ol>
</nav>

<div class="alert alert-warning text-center tituloventana" role="alert">
	Terapias
</div>

<div class='container'>
  <div class='row'>
  	<?php
  	foreach($terapias as $key){
  	?>
		<div class='col-4 p-2 w-50 actcard'>
			<div class='card' style='height:400px'>
					<img style="vertical-align: bottom;border-radius: 10px;max-width: 70px;margin: 0 auto;padding: 10px;" src="img/lapiz.png">
					<div class="card-header">
						<?php echo $key->nombre;

							echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' db='a_actividades/db_' fun='terapia_mover' des='a_actividades/terapias' v_idterapia='$key->id' v_dir='0' dix='trabajo' title='Arriba'><i class='fas fa-chevron-up'></i></button>";

							echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' db='a_actividades/db_' fun='terapia_mover' des='a_actividades/terapias' v_idterapia='$key->id' v_dir='1' dix='trabajo' title='Abajo'><i class='fas fa-chevron-down'></i></button>";

							echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' des='a_actividades/terapias' dix='trabajo' db='a_actividades/db_' fun='borrar_terapia' v_idterapia='$key->id' tp='¿Desea eliminar la terapia seleccionada?' tt='Ya no podrá deshacer el cambio' title='Borrar'><i class='far fa-trash-alt'></i></button>";

							echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' des='a_actividades_e/terapias_editar' dix='trabajo' v_idterapia='$key->id' title='Editar'><i class='fas fa-pencil-alt'></i></button>";

						?>

					</div>
  				<div class='card-body' style='overflow:auto; height:220px'>
  					<div class='row'>
							<div class='col-12'>
									<?php echo $key->descripcion; ?>
  						</div>
  					</div>
  				</div>
  				<div class='card-footer'>
  					<div class='row'>
  						<div class='col-12'>
  							<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_actividades/track" dix="trabajo" v_idterapia="<?php echo $key->id; ?>">Ver</button>
  						</div>
  					</div>
  				</div>
  			</div>
  		</div>
  	<?php
  	}
  	?>
	<div id='' class='col-4 p-3 w-50'>
      <div class="card" style='height:200px;'>
        <div class='card-body text-center'>
          <button class="btn btn-warning btn-block" type="button" is="b-link" des="a_actividades_e/terapias_editar" dix="trabajo" v_idterapia="0">Nueva terapia</button>
        </div>
      </div>
    </div>
  </div>
</div>
