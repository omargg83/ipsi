<?php
	require_once("db_.php");
  $idtrack=$_REQUEST['idtrack'];
  $modulos=$db->modulos($idtrack);

	$track=$db->track_editar($idtrack);
	$terapia=$db->terapia_editar($track->idterapia);
?>

 <nav aria-label='breadcrumb'>
   <ol class='breadcrumb'>
     <li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/terapias" dix="trabajo" id1="" title="Inicio">Inicio</lis>
     <li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/track" dix="trabajo" title="Terapias" v_idterapia="<?php echo $terapia->id; ?>"><?php echo $terapia->nombre; ?></li>
     <li class="breadcrumb-item active" type="button" is="li-link" des="a_actividades/modulos" dix="trabajo" title="Track" v_idtrack="<?php echo $track->id; ?>" ><?php echo $track->nombre; ?></li>
   </ol>
 </nav>

 <div class="alert alert-warning text-center" role="alert">
   Modulos
	 <button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_actividades/track" dix="trabajo" v_idterapia="<?php echo $terapia->id; ?>">Regresar</button>
 </div>

<div class='container'>
  <div class='row'>

  <?php
  	foreach($modulos as $key){
  ?>
  		<div class='col-4 p-3 w-50'>
  			<div class='card' style='height:200px;'>
					<div class="card-header">
						<?php echo $key->nombre; ?>
						<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_actividades_e/modulos_editar" dix="trabajo" v_idmodulo="<?php echo $key->id; ?>" v_idtrack="<?php echo $idtrack; ?>"><i class="fas fa-pencil-alt"></i></button>
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
  							<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_actividades/actividades" dix="trabajo" v_idmodulo="<?php echo $key->id; ?>"  v_idtrack="<?php echo $idtrack; ?>">Ver</button>
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
          <button class="btn btn-warning btn-block" type="button" is="b-link" des="a_actividades_e/modulos_editar" dix="trabajo" v_idmodulo="0" v_idtrack="<?php echo $idtrack; ?>"   >Nuevo modulo</button>
        </div>
      </div>
    </div>
  </div>
</div>
