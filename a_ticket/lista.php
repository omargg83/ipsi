<?php
	require_once("db_.php");

	$pag=0;
	$texto="";

	if(isset($_REQUEST['pag'])){
		$pag=$_REQUEST['pag'];
	}
	$pd = $db->ticket_lista($pag);

?>


<div class='container'>
	<div class='tabla_v' id='tabla_css'>

	<div class='header-row'>
		<div class='cell'>#</div>
		<div class='cell'>Número</div>
		<div class='cell'>De</div>
		<div class='cell'>Para</div>
		<div class='cell'>Asunto</div>
		<div class='cell'>Estado</div>
	</div>

			<?php
				foreach($pd as $key){
					echo "<div class='body-row' draggable='true'>";
						echo "<div class='cell'>";
							echo "<div class='btn-group'>";
							echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_ticket/editar' dix='trabajo' v_idticket='$key->idticket' title='editar'>Ver</button>";
							echo "</div>";
						echo "</div>";

						echo "<div class='cell' data-titulo='Número'>$key->numero</div>";
						echo "<div class='cell' data-titulo='De'>";
							if($key->idusuario>0){
								$de=$db->usuarios_editar($key->idusuario);
							}
							else{
								$de=$db->cliente_editar($key->idcliente);
							}
							echo $de->nombre." ".$de->apellidop." ".$de->apellidop;
						echo "</div>";
						echo "<div class='cell' data-titulo='Para'>";
							if($key->idpara>0){
								$per=$db->usuarios_editar($key->idpara);
							}
							echo $per->nombre." ".$per->apellidop." ".$per->apellidop;
						echo "</div>";
						echo "<div class='cell' data-titulo='Asunto'>$key->asunto</div>";
						echo "<div class='cell' data-titulo='Estado'>$key->estado</div>";
					echo "</div>";
				}
			?>
	</div>
	<?php
		if(strlen($texto)==0){
			$sql="select count(idticket) as total from ticket where (idusuario=".$_SESSION['idusuario']." or idpara='".$_SESSION['idusuario']."') and idpadre is null order by estado, numero desc";
			$sth = $db->dbh->query($sql);
			$contar=$sth->fetch(PDO::FETCH_OBJ);
			$paginas=ceil($contar->total/$_SESSION['pagina']);
			$pagx=$paginas-1;

			echo $db->paginar($paginas,$pag,$pagx,"a_ticket/lista","trabajo");
		}
	?>
</div>
