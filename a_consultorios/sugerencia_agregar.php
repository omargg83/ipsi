<?php
	require_once("db_.php");

	$idconsultorio=$_REQUEST['idconsultorio'];

  $pd = $db->consultorio($idconsultorio);
  $nombre=$pd->nombre;


	$sql="select * from usuarios where nivel=2";
	$sth = $db->dbh->prepare($sql);
	$sth->execute();
	$relaciones=$sth->fetchAll(PDO::FETCH_OBJ);

?>

<nav aria-label='breadcrumb'>
 <ol class='breadcrumb'>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_consultorios/index" dix="contenido">Citas</li>
	 <li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_consultorios/sugerencia" v_idconsultorio="<?php echo $idconsultorio; ?>" dix="contenido"><?php echo $nombre; ?></li>
   <li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_consultorios/sugerencia_agregar" v_idconsultorio="<?php echo $idconsultorio; ?>" dix="contenido">Agregar Terapeuta</li>
	 <button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_consultorios/sugerencia" dix="contenido">Regresar</button>
 </ol>
</nav>


<div class="alert alert-danger text-center" role="alert">
	Agregar Terapeuta a Consultorio
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
                  echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' db='a_consultorios/db_' tp='¿Desea agregar el terapeuta seleccionado?' fun='agregar_terconsl' des='a_consultorios/sugerencia' iddes='idconsultorio' dix='contenido' tp='edit' v_idusuario='$key->idusuario' v_idconsultorio='$idconsultorio'>Agregar</button>";
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
