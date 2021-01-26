<?php
	require_once("db_.php");
	$pag=0;
	$texto="";
	if(isset($_REQUEST['buscar'])){
		$texto=$_REQUEST['buscar'];
		$pd = $db->usuario_buscar($texto);
		$texto=1;
	}
	else{
		if(isset($_REQUEST['pag'])){
			$pag=$_REQUEST['pag'];
		}
		$pd = $db->usuario_lista($pag);
	}
?>
<div class='container'>
	<div class='tabla_v' id='tabla_css'>

	<div class='header-row'>
		<div class='cell'>#</div>
		<div class='cell'>Nombre</div>
		<div class='cell'>Correo</div>
		<div class='cell'>Sucursal</div>
		<div class='cell'>Activo</div>
	</div>

			<?php
				foreach($pd as $key){

					echo "<div class='body-row' draggable='true'>";
						echo "<div class='cell'>";
							echo "<div class='btn-group'>";
					?>
								<button class='btn btn-warning btn-sm' type="button" is="b-link" des='a_terapeutas/terapeuta' dix='trabajo' tp="edit" v_idusuario='<?php echo $key->idusuario; ?>' title='editar'>Editar</button>
								</div>
							</div>
						<div class='cell' data-titulo='Nombre'><?php echo $key->nombre; ?></div>

						<div class='cell' data-titulo='Correo'><?php echo $key->correo; ?></div>
						<div class='cell' data-titulo='Sucursal'><?php
							$suc=$db->sucursal_ver($key->idsucursal);
							echo $suc->nombre; ?></div>
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
			if($_SESSION['nivel']==1 OR $_SESSION['nivel']==4){
				$sql="SELECT count(idusuario) as total FROM usuarios";
			}
			if($_SESSION['nivel']==2){
				$sql="SELECT count(idusuario) as total FROM usuarios where idusuario=".$_SESSION['idusuario']."";
			}
			if($_SESSION['nivel']==3){
				$sql="SELECT count(idusuario) as total from usuarios where idsucursal=".$_SESSION['idsucursal']." and nivel=2";
			}
			if($_SESSION['nivel']==4){
				$sql="SELECT count(idusuario) as total from usuarios where nivel>1";
			}
			$sth = $db->dbh->query($sql);
			$contar=$sth->fetch(PDO::FETCH_OBJ);
			$paginas=ceil($contar->total/$_SESSION['pagina']);
			$pagx=$paginas-1;

			echo $db->paginar($paginas,$pag,$pagx,"a_terapeutas/lista","trabajo");
		}
	?>
</div>
