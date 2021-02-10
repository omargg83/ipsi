<?php
	require_once("db_.php");
	$idactividad=$_REQUEST['idactividad'];
	$idpaciente=$_REQUEST['idpaciente'];
?>
<div class="modal-header">
  Agregar familiar
</div>
<div class="modal-body">
  <form is="f-submit" id="form_ads" des="a_pacientes/roles_buscar" dix='resultados' action='' >
    <input type="hidden" id="idactividad" name='idactividad' value='<?php echo $idactividad;?>'/>
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

<div class="modal-footer">
  <button type="button" class="btn btn-warning" data-dismiss="modal" title='Cancelar'>Cerrar</button>
</div>
