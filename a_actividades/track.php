<?php
	require_once("db_.php");
  $id1=$_REQUEST['id1'];

  $track=$db->track($id1);
  $terapia=$db->terapia_editar($id1);
?>

<nav aria-label='breadcrumb'>
  <ol class='breadcrumb'>
    <li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/terapias" dix="trabajo" title="Terapias" id1="">Terapias</li>
    <li class="breadcrumb-item active" type="button" is="li-link" des="a_actividades/track" dix="trabajo" title="Track" id1="<?php echo $id1; ?>"><?php echo $terapia->nombre; ?></li>
  </ol>
</nav>

<div class="alert alert-warning text-center" role="alert">
  Track
</div>

<div class='container'>
  <div class='row'>
    <div id='' class='col-4 p-3 w-50'>
      <div class="card" style='height:200px;'>
        <div class='card-body text-center'>
          <button class="btn btn-warning btn-block" type="button" is="b-link" des="a_actividades/actividad_editar" dix="trabajo" id1="0">Nuevo track</button>
        </div>
      </div>
    </div>

  <?php
  	foreach($track as $key){
  ?>
  		<div class='col-4 p-3 w-50'>
  			<div class='card' style='height:200px;'>
  				<div class='card-body'>
  					<div class='row'>
  						<div class='col-12'>
  							<div><?php echo $key->nombre; ?></div>
  						</div>
  					</div>
  				</div>
  				<div class='card-body'>
  					<div class='row'>
  						<div class='col-12'>
  							<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_actividades/modulos" dix="trabajo" id1="<?php echo $key->id; ?>">Ver</button>
  						</div>
  					</div>
  				</div>
  			</div>
  		</div>
  	<?php
  	}
  	?>
  </div>
</div>
