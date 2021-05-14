<?php
	require_once("db_.php");

	$idpaciente=$_REQUEST['idpaciente'];
	$pd = $db->cliente_editar($idpaciente);

	$nombre=$pd->nombre;
	$edad=$pd->edad;
	$apellidop=$pd->apellidop;
	$apellidom=$pd->apellidom;
	$telefono=$pd->telefono;
	$correo=$pd->correo;
	$foto=$pd->foto;

	/////////////////////Relaciones
	$sql="select * from clientes_relacion where idcliente=:idcliente";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":idcliente",$idpaciente);
	$sth->execute();
	$relaciones=$sth->fetchAll(PDO::FETCH_OBJ);
?>

<nav aria-label='breadcrumb'>
	<ol class='breadcrumb'>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/index" dix="trabajo">Pacientes</li>
		<li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_pacientes/paciente" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo"><?php echo $nombre." ".$apellidop." ".$apellidom; ?></li>
		<li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_pacientes/relaciones" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Relaciones</li>
		<li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_pacientes/relaciones_agregar" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Agregar</li>
		<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_pacientes/relaciones" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Regresar</button>
	</ol>
</nav>

<div class="alert alert-warning text-center tituloventana" role="alert">
	Agregar persona
</div>

<div class='container'>

    <form is="f-submit" id="form_busca" des="a_pacientes/relaciones_buscar" dix='resultados' action='' >
      <input type="hidden" id="idpaciente" name='idpaciente' value='<?php echo $idpaciente;?>'/>
      <div class='row'>
        <div class='col-12'>
          <label>Buscar</label>
          <input type="text" id="buscar" name='buscar' placeholder="Buscar" class='form-control'/>
        </div>
      </div>
    </form>

    <div id='resultados'>
    </div>
</div>
