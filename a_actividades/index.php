<?php
	require_once("db_.php");
	$tipo_terapia="";
	if(isset($_REQUEST['id1'])){
		$tipo_terapia=$_REQUEST['id1'];
		echo $tipo_terapia;
	}

	echo "<div id='trabajo'>";
		include 'lista.php';
	echo "</div>";
?>
