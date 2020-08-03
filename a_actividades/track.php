<?php
	require_once("db_.php");
	$idterapia=$_REQUEST['id1'];

  $track=$db->track($idterapia);
  $terapia=$db->terapia_editar($idterapia);
	$idterapia=$terapia->id;
?>

<nav aria-label='breadcrumb'>
  <ol class='breadcrumb'>
    <li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/terapias" dix="trabajo" title="Inicio" id1="">Inicio</li>
    <li class="breadcrumb-item active" type="button" is="li-link" des="a_actividades/track" dix="trabajo" title="Terapias" id1="<?php echo $idterapia; ?>"><?php echo $terapia->nombre; ?></li>
  </ol>
</nav>


<div class="alert alert-warning text-center" role="alert">
  Track
	<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_actividades/terapias" dix="trabajo" id1="">Regresar</button>
</div>

<div class='container'>
  <div class='row'>
  	<?php
  	foreach($track as $key){
  	?>
  		<div class='col-4 p-3 w-50'>
  			<div class='card' style='height:200px;'>
  				<div class='card-header'>
						<?php echo $key->nombre; ?>
						<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_actividades_e/track_editar" dix="trabajo" id1="<?php echo $key->id; ?>" id2="<?php echo $idterapia; ?>">Editar</button>
					</div>
  				<div class='card-body'>
  					<div class='row'>
  						<div class='col-12'>
  							<?php echo $key->descripcion; ?>
  						</div>
  					</div>
  				</div>
  				<div class='card-body'>
  					<div class='row'>
  						<div class='col-12'>
  							<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_actividades/modulos" dix="trabajo" id1="<?php echo $key->id; ?>" id2="<?php echo $idterapia; ?>">Ver</button>
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
          <button class="btn btn-warning btn-block" type="button" is="b-link" des="a_actividades_e/track_editar" dix="trabajo" id1="0" id2="<?php echo $idterapia; ?>">Nuevo track</button>
        </div>
      </div>
    </div>
  </div>
</div>
