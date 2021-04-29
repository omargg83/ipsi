<?php
	require_once("db_.php");
  $desde=$_REQUEST['desde'];
  $hasta=$_REQUEST['hasta'];
  $idusuario=$_REQUEST['idusuario'];

  $begin = new DateTime( $desde );
  $end   = new DateTime( $hasta );


	echo "<div class='container'>";
		echo "<div class='tabla_v' id='tabla_css'>";

		echo "<div class='header-row'>";
			echo "<div class='cell'>Fecha</div>";
			echo "<div class='cell'>Dia</div>";
			echo "<div class='cell'>Hora</div>";
			echo "<div class='cell'>Estado</div>";
			echo "<div class='cell'>Paciente</div>";
			echo "<div class='cell'>Estatus cita</div>";
		echo "</div>";

  for($i = $begin; $i <= $end; $i->modify('+1 day')){
		$dia=$i->format("Y-m-d");
		//echo "<br>".$i->format("Y-m-d");
		//echo "------------>".$i->format("w");
			$dia_sem=$i->format("w");
	    $sql="select * from usuarios_horarios where idusuario=$idusuario and desde_num=$dia_sem";
	    $sth = $db->dbh->prepare($sql);
	  	$sth->execute();
			$num=$sth->rowCount();
			if($num>0){


					$disponibles=$sth->fetchAll(PDO::FETCH_OBJ);
			    foreach($disponibles as $key){
						$horario_dis = new DateTime( $key->desde );
						$hora=$horario_dis->format("H:i");

						echo "<div class='body-row' >";
							echo "<div class='cell'>";
								echo $i->format("Y-m-d");
							echo "</div>";
							echo "<div class='cell'>";
								echo $key->desde_dia;
							echo "</div>";

							echo "<div class='cell'>";
								echo $hora;
							echo "</div>";


								$sql="select clientes.nombre,clientes.apellidop, clientes.apellidom, citas.estatus from citas left outer join clientes on clientes.id=citas.idpaciente where citas.idusuario=$idusuario and citas.desde='$dia $hora'";
								$cit_qry = $db->dbh->prepare($sql);
								$cit_qry->execute();
								$num_citas=$cit_qry->rowCount();
								if($num_citas>0){
									$cita_resp=$cit_qry->fetch(PDO::FETCH_OBJ);
									echo "<div class='cell'>";
										echo "No disponible<br>";
									echo "</div>";
									echo "<div class='cell'>";
										echo $cita_resp->nombre." ".$cita_resp->apellidop." ".$cita_resp->apellidom;
									echo "</div>";
									echo "<div class='cell'>";
										echo $cita_resp->estatus;
									echo "</div>";
								}
								else{
									echo "<div class='cell'>";
										echo "Disponible";
									echo "</div>";
									echo "<div class='cell'>";
									echo "</div>";
									echo "<div class='cell'>";
									echo "</div>";
								}

						echo "</div>";
			    }

			}

	}
 ?>
