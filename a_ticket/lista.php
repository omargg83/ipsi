<?php
	require_once("db_.php");


	$pag=0;
	$texto="";
	if(isset($_REQUEST['buscar'])){
		$texto=$_REQUEST['buscar'];
		$pd = $db->ticket_buscar($texto);
		$texto=1;
	}
	else{
		if(isset($_REQUEST['pag'])){
			$pag=$_REQUEST['pag'];
		}
		$pd = $db->ticket_lista($pag);
	}
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
					echo "<div class='body-row'>";
						echo "<div class='cell'>";
							echo "<div class='btn-group'>";
							echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_ticket/editar' dix='trabajo' v_idticket='$key->idticket' title='editar'>Ver</button>";
							echo "</div>";
						echo "</div>";

						echo "<div class='cell' data-titulo='Número'>$key->numero</div>";
						echo "<div class='cell' data-titulo='De'>";
						/*
						echo "<br>usuario:".$key->idde_usuario;
						echo "<br>cliente:".$key->idde_cliente;
						*/
							if($key->idde_usuario>0){
								$de=$db->usuarios_editar($key->idde_usuario);
							}
							else{
								$de=$db->cliente_editar($key->idde_cliente);
							}
							echo $de->nombre." ".$de->apellidop." ".$de->apellidop;
						echo "</div>";
						echo "<div class='cell' data-titulo='Para'>";
						/*
						echo "<br>usuario:".$key->idpara_usuario;
						echo "<br>cliente:".$key->idpara_cliente;
						*/
							if($key->idpara_usuario>0){
								$para=$db->usuarios_editar($key->idpara_usuario);
							}
							else{
								$para=$db->cliente_editar($key->idpara_cliente);
							}
							echo $para->nombre." ".$para->apellidop." ".$para->apellidop;
						echo "</div>";
						echo "<div class='cell' data-titulo='Asunto'>$key->asunto</div>";
						echo "<div class='cell' data-titulo='Estado'>$key->estado</div>";
					echo "</div>";
				}
			?>
	</div>
	<?php
	/*
		if(strlen($texto)==0){
			$sql="select count(idticket) as total from ticket where (idusuario=".$_SESSION['idusuario']." or idpara='".$_SESSION['idusuario']."') and idpadre is null order by estado, numero desc";
			$sth = $db->dbh->query($sql);
			$contar=$sth->fetch(PDO::FETCH_OBJ);
			$paginas=ceil($contar->total/$_SESSION['pagina']);
			$pagx=$paginas-1;

			echo $db->paginar($paginas,$pag,$pagx,"a_ticket/lista","trabajo");
		}
		*/
	?>
</div>
