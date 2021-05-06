<?php
	require_once("db_.php");
?>

<div class='container'>
  <div class='row'>
  	<?php

    if($_SESSION['nivel']==1 or $_SESSION['nivel']==4){
    		echo "<div class='col-4 p-2 w-50 actcard'>
  			<div class='card' style='height:400px'>
  					<img style='vertical-align: bottom;border-radius: 10px;max-width: 70px;margin: 0 auto;padding: 10px;' src='img/lapiz.png'>
    				<div class='card-header'>
  						Citas
  					</div>
    				<div class='card-body' style='overflow:auto; height:220px'>
    					<div class='row'>
    						<div class='col-12'>
    							Reporte de citas Pacientes
    						</div>
    					</div>
    				</div>
    				<div class='card-body'>
    					<div class='row'>
    						<div class='col-12'>
    							<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_reportes/001reporte' dix='contenido'>Ver</button>
    						</div>
    					</div>
    				</div>
    			</div>
    		</div>";
      }

      if($_SESSION['nivel']==1 or $_SESSION['nivel']==4){
      		echo "<div class='col-4 p-2 w-50 actcard'>
    			<div class='card' style='height:400px'>
    					<img style='vertical-align: bottom;border-radius: 10px;max-width: 70px;margin: 0 auto;padding: 10px;' src='img/lapiz.png'>
      				<div class='card-header'>
    						Citas
    					</div>
      				<div class='card-body' style='overflow:auto; height:220px'>
      					<div class='row'>
      						<div class='col-12'>
      							Reporte de citas Terapeutas
      						</div>
      					</div>
      				</div>
      				<div class='card-body'>
      					<div class='row'>
      						<div class='col-12'>
      							<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_reportes/002reporte' dix='contenido'>Ver</button>
      						</div>
      					</div>
      				</div>
      			</div>
      		</div>";
        }
    ?>


  </div>
