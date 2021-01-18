<?php
	require_once("db_.php");
	$pag=0;
	$texto="";
	if(isset($_REQUEST['buscar'])){
		$texto=$_REQUEST['buscar'];
		$pd = $db->agenda_buscar($texto);
		$texto=1;
	}
	else{
		if(isset($_REQUEST['pag'])){
			$pag=$_REQUEST['pag'];
		}
		$pd = $db->agenda_lista($pag);
	}
?>
<div class='container'>
	<div class='tabla_v' id='tabla_css'>

	<div class='header-row'>
		<div class='cell'>#</div>
		<div class='cell'>Nombre</div>
		<div class='cell'>Nivel</div>
		<div class='cell'>Correo</div>
		<div class='cell'>Activo</div>
	</div>

			<?php
				foreach($pd as $key){

					echo "<div class='body-row' draggable='true'>";
						echo "<div class='cell'>";
							echo "<div class='btn-group'>";
					?>
								<button class='btn btn-warning btn-sm' type="button" is="b-link" des='a_usuarios/editar' dix='trabajo' tp="edit" v_idusuario='<?php echo $key->idusuario; ?>' title='editar'>Editar</button>
								</div>
							</div>
						<div class='cell' data-titulo='Nombre'><?php echo $key->nombre; ?></div>
						<div class='cell' data-titulo='Nivel'><?php echo $key->nivel; ?></div>
						<div class='cell' data-titulo='Correo'><?php echo $key->correo; ?></div>
						<div class='cell' data-titulo='Activo'>
						<?php
							if ($key->autoriza==0) { echo "Inactivo"; }
							if ($key->autoriza==1) { echo "Activo"; }
						?>
						</div>
					</div>
			<?php
				}
			?>
	</div>

	<?php
		if(strlen($texto)==0){
			$sql="SELECT count(idusuario) as total FROM usuarios";
			$sth = $db->dbh->query($sql);
			$contar=$sth->fetch(PDO::FETCH_OBJ);
			$paginas=ceil($contar->total/$_SESSION['pagina']);
			$pagx=$paginas-1;

			echo $db->paginar($paginas,$pag,$pagx,"a_usuarios/lista","trabajo");
		}
	?>
</div>
