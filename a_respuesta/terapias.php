<?php
  require_once("db_.php");
  $idpaciente=$_SESSION['idusuario'];

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
		<li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_respuesta/terapias"  dix="contenido">Terapias</li>

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
  							<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_respuesta/track" dix="contenido" v_idterapia="<?php echo $key->id; ?>" >Ver</button>
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
