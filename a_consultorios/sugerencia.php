<?php
	require_once("db_.php");
  $idconsultorio=$_REQUEST['idconsultorio'];
  $pd = $db->consultorio($idconsultorio);
  $nombre=$pd->nombre;


	/////////////////////Relaciones
	$sql="SELECT * FROM consultorio_sug LEFT OUTER JOIN usuarios ON consultorio_sug.idusuario = usuarios.idusuario WHERE consultorio_sug.idconsultorio =$idconsultorio";
	$sth = $db->dbh->prepare($sql);
	$sth->execute();
	$terap=$sth->fetchAll(PDO::FETCH_OBJ);
?>


<nav aria-label='breadcrumb'>
 <ol class='breadcrumb'>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_consultorios/index" dix="contenido">Citas</li>
	 <li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_consultorios/sugerencia" v_idconsultorio="<?php echo $idconsultorio; ?>" dix="contenido"><?php echo $nombre; ?></li>
	 <button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_consultorios/index" dix="contenido">Regresar</button>
 </ol>
</nav>

<div class='container'>
	<div class='row'>

		<?php

		foreach($terap as $key){
		?>
			<div class='col-4 p-3 w-50 actcard'>
				<div class='card'>
					<img style="vertical-align: bottom;border-radius: 10px;max-width: 70px;margin: 0 auto;padding: 10px;" src="<?php echo "a_archivos/terapeuta/".trim($key->foto); ?>">
					<div class='row'>
						<div class='col-12'>

							<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_consultorios/sugerencia" dix="contenido" db="a_consultorios/db_" fun="terapeutasuc_quitar" v_idconsultorio="<?php echo $idconsultorio; ?>"  v_id='<?php echo $key->id; ?>' tp="¿Desea eliminar la sugerencia seleccionada?" title="Borrar"><i class="far fa-trash-alt"></i></button>

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

<?php

echo "<div id='' class='col-4 p-3 w-50'>";
  echo "<div class='card' style='height:200px;'>";
    echo "<div class='card-body text-center'>";
      echo "<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_consultorios\sugerencia_agregar' dix='contenido' v_idconsultorio='$idconsultorio'>Agregar</button>";
    echo "</div>";
  echo "</div>";
echo "</div>";

?>
