<?php
  require_once("db_.php");
  $idpaciente=clean_var($_REQUEST['idpaciente']);

  $paciente = $db->cliente_editar($idpaciente);
  $nombre=$paciente->nombre." ".$paciente->apellidop." ".$paciente->apellidom;

  $sql="SELECT * from terapias_per left outer join terapias on terapias.id=terapias_per.idterapia where terapias_per.idpaciente=:id";
  $sth = $db->dbh->prepare($sql);
  $sth->bindValue(":id",$idpaciente);
  $sth->execute();
  $terapias=$sth->fetchAll(PDO::FETCH_OBJ);
?>

<nav aria-label='breadcrumb'>
	<ol class='breadcrumb'>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/lista" dix="trabajo">Pacientes</li>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/paciente" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo"><?php echo $nombre; ?></li>
		<li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_pacientes/terapias" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Terapias</li>
	</ol>
</nav>

<div class="alert alert-warning text-center" role="alert">
	Mis Terapias
</div>

<div class='container'>
  <div class='row'>
  	<?php
  	foreach($terapias as $key){
  	?>
  		<div class='col-4 p-3 w-50'>
  			<div class='card' style='height:200px;'>
					<div class="card-header">
						<?php echo $key->nombre; ?>
					</div>
  				<div class='card-body'>
  					<div class='row'>
							<div class='col-12'>
									<?php echo $key->descripcion; ?>
  						</div>
  					</div>
  				</div>
  				<div class='card-footer'>
  					<div class='row'>
  						<div class='col-12'>
  							<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_pacientes/track" dix="trabajo" v_idterapia="<?php echo $key->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>">Ver</button>
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
          <button class="btn btn-warning btn-block" type="button" is="b-link" des="a_pacientes_e/terapias_agregar" dix="trabajo" v_idterapia="0" v_idpaciente='<?php echo $idpaciente; ?>'>Nueva terapia</button>
        </div>
      </div>
    </div>
  </div>
</div>
