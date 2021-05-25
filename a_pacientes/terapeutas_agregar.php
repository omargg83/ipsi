<?php
	require_once("db_.php");

	$idpaciente=clean_var($_REQUEST['idpaciente']);

  $paciente = $db->cliente_editar($idpaciente);
  $nombre_p=$paciente->nombre." ".$paciente->apellidop." ".$paciente->apellidom;


  /////////////////////Relaciones
	$sql="select * from usuarios where idsucursal=$paciente->idsucursal and nivel=2";
	$sth = $db->dbh->prepare($sql);
	$sth->execute();
	$relaciones=$sth->fetchAll(PDO::FETCH_OBJ);
?>

<nav aria-label='breadcrumb'>
	<ol class='breadcrumb'>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/lista" dix="trabajo">Pacientes</li>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/paciente" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo"><?php echo $nombre_p; ?></li>
		<li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_pacientes/terapeutas_agregar" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Agregar terapeuta</li>
		<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_pacientes/paciente" dix="trabajo" v_idpaciente="<?php echo $idpaciente; ?>">Regresar</button>
	</ol>
</nav>

<div class="alert alert-danger text-center" role="alert">
	Agregar Terapeuta
</div>


<div class='container'>
  <div class='row'>

    <?php
    foreach($relaciones as $key){
    ?>
      <div class='col-4 p-3 w-50 actcard'>
        <div class='card'>
          <img style="vertical-align: bottom;border-radius: 10px;max-width: 70px;margin: 0 auto;padding: 10px;" src="<?php echo "a_archivos/terapeuta/".trim($key->foto); ?>">


          <div class='card-body'>
            <div class='row'>
              <div class='col-12 text-center'>
                <?php echo $key->nombre." ".$key->apellidop." ".$key->apellidom; ?>
              </div>
            </div>

            <div class='row'>
              <div class='col-12 text-center'>
                <?php
                  echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' db='a_pacientes/db_' tp='¿Desea agregar el terapeuta seleccionado?' fun='agregar_ter' des='a_pacientes/paciente' iddes='idpaciente' dix='trabajo' tp='edit' v_idusuario='$key->idusuario' v_idpaciente='$idpaciente'>Agregar</button>";
                ?>
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
