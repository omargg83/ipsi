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

	/////////////////////Relaciones
	$sql="select * from cliente_terapeuta	left outer join clientes on clientes.id=cliente_terapeuta.idcliente where cliente_terapeuta.idusuario=$idusuario";
	$sth = $db->dbh->prepare($sql);
	$sth->execute();
	$terap=$sth->fetchAll(PDO::FETCH_OBJ);
?>

<nav aria-label='breadcrumb'>
	<ol class='breadcrumb'>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_terapeutas/index" dix="trabajo">Terapeuta</li>
		<li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_terapeutas/terapeuta" v_idusuario="<?php echo $idusuario; ?>" dix="trabajo"><?php echo $nombre." ".$apellidop." ".$apellidom; ?></li>
		<li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_terapeutas/pacientes" v_idusuario="<?php echo $idusuario; ?>" dix="trabajo">Pacientes</li>
		<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_terapeutas/terapeuta" v_idusuario="<?php echo $idusuario; ?>" dix="trabajo">Regresar</button>
	</ol>
</nav>

<div class="alert alert-warning text-center tituloventana" role="alert">
	Pacientes
</div>

<div class='container'>
	<div class='row'>

  	<?php
  	foreach($terap as $key){
  	?>
  		<div class='col-4 p-3 w-50 actcard'>
  			<div class='card'>
					<img style="vertical-align: bottom;border-radius: 10px;max-width: 70px;margin: 0 auto;padding: 10px;" src="<?php echo $db->pac.trim($key->foto); ?>">
					<div class='row'>
						<div class='col-12'>

							<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_terapeutas/pacientes" dix="trabajo" db="a_terapeutas/db_" fun="paciente_quitar" v_idterapeuta="<?php echo $key->idterapeuta; ?>" v_idusuario="<?php echo $idusuario; ?>"  tp="¿Desea eliminar la relacion seleccionada?" title="Borrar"><i class="far fa-trash-alt"></i></button>

						</div>
					</div>

					<div class='card-body'>
						<div class='row'>
							<div class='col-12 text-center'>
								<?php echo $key->nombre." ".$key->apellidop." ".$key->apellidom; ?>
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
          <button class="btn btn-warning btn-block" type="button" is="b-link" des="a_terapeutas\pacientes_agregar" dix="trabajo" v_idusuario='<?php echo $idusuario; ?>'>Agregar</button>
        </div>
      </div>
    </div>
  </div>
</div>
