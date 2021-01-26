<?php
	require_once("db_.php");

  $idusuario=$_REQUEST['idusuario'];

  $pd = $db->usuario_editar($idusuario);
	$nombre=$pd->nombre;
	$apellidop=$pd->apellidop;
	$apellidom=$pd->apellidom;
	$correo=$pd->correo;
	$foto=$pd->foto;
	$numero=$pd->numero;
	$edad=$pd->edad;
	$telefono=$pd->telefono;
	$observaciones=$pd->observaciones;


	/////////////////////Relaciones

?>

  <nav aria-label='breadcrumb'>
  	<ol class='breadcrumb'>
  		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_terapeutas/index" dix="trabajo">Terapeuta</li>
  		<li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_terapeutas/terapeuta" v_idusuario="<?php echo $idusuario; ?>" dix="trabajo"><?php echo $nombre." ".$apellidop." ".$apellidom; ?></li>
  		<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_terapeutas/index" dix="trabajo">Regresar</button>
  	</ol>
  </nav>

  <div class="container">
  	<div class='row'>
  		<div class='col-5'>
  			<div class='row p-3'>
  				<div class='card col-12'>
  					<div class='card-body'>
  						<div class='col-12'>
  							<?php
  								echo "<div class='form-group text-center' id='imagen_div'>";
  									echo "<img src='".$db->doc.trim($foto)."' class='img-thumbnail' width='200px'>";
  									echo "<div class='text-center'>".$nombre." ".$apellidop." ".$apellidom."</div>";
  									echo "<div class='text-center'>#".$numero."</div>";
  									echo "<div class='text-center'>Terapeuta</div>";
  								echo "</div>";
  							?>
  						</div>
  					</div>
  				</div>
  			</div>

  			<div class='row p-3'>
  				<div class='card col-12'>
  					<div class='card-body'>
  						<div class='row'>
  							<div class='col-12 text-center'>
  								<h5>Pacientes</h5>
  							</div>
  						</div>
  					</div>
  					<?php
              $sql="select * from cliente_terapeuta	left outer join clientes on clientes.id=cliente_terapeuta.idcliente where cliente_terapeuta.idusuario=$idusuario";
  						$sth = $db->dbh->prepare($sql);
  						$sth->execute();
  						$terap=$sth->fetchAll(PDO::FETCH_OBJ);
  						foreach($terap as $key){
  							echo "<button class='btn btn-warning btn-block' type='button' >$key->nombre $key->apellidop $key->apellidom</button>";
  						}
  					?>
  					<div class='card-body'>
  						<div class='col-12 text-center'>
  							<?php
  								echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_terapeutas/terapeutas' dix='trabajo' v_idusuario='$idusuario' >Ver mas</button>";
  							?>
  						</div>
  					</div>
  				</div>
  			</div>
  		</div>
  		<div class='col-7'>
  			<div class='row p-3'>
  				<div class='card col-12'>
  					<div class='card-body'>
  						<div class='row'>
  							<div class='col-12'>
  								<h5>Información básica</h5>
  							</div>
  							<div class='col-4'>
  								<?php
  									echo "<label>Edad</label>";
  									echo "<input class='form-control form-control-sm' value='$edad' readonly/>";
  								?>
  							</div>
  							<div class='col-4'>
  								<?php
  									echo "<label>Correo</label>";
  									echo "<input class='form-control form-control-sm' value='$correo' readonly/>";
  								?>
  							</div>
  							<div class='col-4'>
  								<?php
  									echo "<label>Teléfono</label>";
  									echo "<input class='form-control form-control-sm' value='$telefono' readonly/>";
  								?>
  							</div>
  						</div>
  						<hr>
  						<div class='row'>
  							<div class='col-12'>
  								<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_terapeutas/editar" dix="trabajo" v_idusuario="<?php echo $idusuario;?>">Ver más</button>
  							</div>
  						</div>
  					</div>
  				</div>
  			</div>

  		</div>
  	</div>
  </div>
