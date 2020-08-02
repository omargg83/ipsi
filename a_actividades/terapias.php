<?php
	require_once("db_.php");
  $terapias=$db->terapias();
?>

<nav aria-label='breadcrumb'>
  <ol class='breadcrumb'>
    <li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/terapias" dix="trabajo" id1="">Terapias</li>
  </ol>
</nav>

<div class="alert alert-warning text-center" role="alert">
	<div class="row">
		<div class="col-10">
			Terapias
		</div>
		<div class="col-2">
			<button class="btn btn-warning btn-sm" type="button" is="b-link" des="lugar/file" dix="trabajo" id1="">editar</button>
			<button class="btn btn-warning btn-sm" type="button" is="b-link" des="lugar/file" dix="trabajo" id1="">Nuevo</button>
		</div>
	</div>
</div>

<div class='container'>
  <div class='row'>
  	<?php
  	foreach($terapias as $key){
  	?>
  		<div class='col-4 p-3 w-50'>
  			<div class='card' style='height:200px;'>
  				<div class='card-body'>
  					<div class='row'>
  						<div class='col-12'>
								<label>Terapia:</label>
  							<div><?php echo $key->nombre; ?></div>
  						</div>
  					</div>
  				</div>
  				<div class='card-body'>
  					<div class='row'>
  						<div class='col-12'>
  							<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_actividades/track" dix="trabajo" id1="<?php echo $key->id; ?>">Ver</button>
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
          <button class="btn btn-warning btn-block" type="button" is="b-link" des="a_actividades/terapias_editar" dix="trabajo" id1="0">Nueva terapia</button>
        </div>
      </div>
    </div>
  </div>
</div>
