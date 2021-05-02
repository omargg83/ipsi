<?php
	require_once("db_.php");

	$idpaciente=$_SESSION['idusuario'];


	$paciente = $db->cliente_editar($idpaciente);
	$nombre=$paciente->nombre." ".$paciente->apellidop." ".$paciente->apellidom;


	echo "<nav aria-label='breadcrumb'>";
	 echo "<ol class='breadcrumb'>";
		 echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_pacientes/terapeuta_paciente' dix='contenido'>Terapeutas</li>";


	 echo "</ol>";
	echo "</nav>";


	echo "<div class='alert alert-warning text-center tituloventana' role='alert'>";
	  echo "Mis terapeutas";
	echo "</div>";


  $sql="SELECT * from cliente_terapeuta left outer join usuarios on usuarios.idusuario= cliente_terapeuta.idusuario where idcliente=$idpaciente";

  $sth = $db->dbh->query($sql);
  $acinicial=$sth->fetchAll(PDO::FETCH_OBJ);

	echo "<div class='container'>";
		echo "<div class='row'>";

		  foreach($acinicial as $key){
		    echo "<div class='col-4 p-2 w-50 actcard'>";
		      echo "<div class='card' style='height:400px'>";
		        echo "<img style='vertical-align: bottom;border-radius: 10px;max-width: 70px;margin: 0 auto;padding: 10px;' src='img/lapiz.png'>";
		        echo "<div class='card-header'>";

	            echo "<div class='row'>";
	              echo "<div class='col-12'>";
	                echo $key->nombre." ".$key->apellidop." ".$key->apellidom;
	              echo "</div>";
	            echo "</div>";

		        echo "</div>";
		        echo "<div class='card-body' style='overflow:auto; height:220px'>";
		          echo "<div class='row'>";
		            echo "<div class='col-12'>";
                  $sql="select * from ";
                  echo "Terapias:";
		             // echo $key->observaciones;
		            echo "</div>";
		          echo "</div>";
		        echo "</div>";

		      echo "</div>";
		    echo "</div>";
		  }


	echo "</div>";
echo "</div>";


?>
