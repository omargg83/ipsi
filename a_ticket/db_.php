<?php
require_once("../control_db.php");

if($_SESSION['des']==1 and strlen($function)==0)
{
	echo "<div class='alert alert-primary' role='alert'>";
	$arrayx=explode('/', $_SERVER['SCRIPT_NAME']);
	echo print_r($arrayx);
	echo "</div>";
}

class Ticket extends ipsi{
	public $nivel_personal;
	public $nivel_captura;

	public function __construct(){
		parent::__construct();
		$this->doc="a_archivos/terapeuta/";

		if(isset($_SESSION['idusuario']) and $_SESSION['autoriza'] == 1) {

		}
		else{
			include "../error.php";
			die();
		}
	}
	public function ticket_editar(){

		$idticket=$_REQUEST['idticket'];
		$sql="select * from ticket where idticket=$idticket";
		$sth = $this->dbh->query($sql);
		return $sth->fetch(PDO::FETCH_OBJ);
	}
	public function guardar_ticket(){
		$x="";
		$arreglo =array();
		$idticket=$_REQUEST['idticket'];

		$arreglo+=array('asunto'=>$_REQUEST['asunto']);
		$arreglo+=array('mensaje'=>$_REQUEST['texto_ticket']);
		$extension = '';
		$ruta = '../a_archivos/ticket/';
		
		$archivo = $_FILES['foto1']['tmp_name'];
		$nombrearchivo = $_FILES['foto1']['name'];
		$tmp=$_FILES['foto1']['tmp_name'];
		$info = pathinfo($nombrearchivo);
		if($archivo!=""){
			$extension = $info['extension'];
			if ($extension=='png' || $extension=='PNG' || $extension=='jpg'  || $extension=='JPG') {
				$nombreFile = "resp1_".date("YmdHis").rand(0000,9999).".".$extension;
				move_uploaded_file($tmp,$ruta.$nombreFile);
				$arreglo+=array('imagen1'=>$nombreFile);
			}
		}

		$archivo = $_FILES['foto2']['tmp_name'];
		$nombrearchivo = $_FILES['foto2']['name'];
		$tmp=$_FILES['foto2']['tmp_name'];
		$info = pathinfo($nombrearchivo);
		if($archivo!=""){
			$extension = $info['extension'];
			if ($extension=='png' || $extension=='PNG' || $extension=='jpg'  || $extension=='JPG') {
				$nombreFile = "resp2_".date("YmdHis").rand(0000,9999).".".$extension;
				move_uploaded_file($tmp,$ruta.$nombreFile);
				$arreglo+=array('imagen2'=>$nombreFile);
			}
		}

		$archivo = $_FILES['foto3']['tmp_name'];
		$nombrearchivo = $_FILES['foto3']['name'];
		$tmp=$_FILES['foto3']['tmp_name'];
		$info = pathinfo($nombrearchivo);
		if($archivo!=""){
			$extension = $info['extension'];
			if ($extension=='png' || $extension=='PNG' || $extension=='jpg'  || $extension=='JPG') {
				$nombreFile = "resp3_".date("YmdHis").rand(0000,9999).".".$extension;
				move_uploaded_file($tmp,$ruta.$nombreFile);
				$arreglo+=array('imagen3'=>$nombreFile);
			}
		}

		$archivo = $_FILES['foto4']['tmp_name'];
		$nombrearchivo = $_FILES['foto4']['name'];
		$tmp=$_FILES['foto4']['tmp_name'];
		$info = pathinfo($nombrearchivo);
		if($archivo!=""){
			$extension = $info['extension'];
			if ($extension=='png' || $extension=='PNG' || $extension=='jpg'  || $extension=='JPG') {
				$nombreFile = "resp4_".date("YmdHis").rand(0000,9999).".".$extension;
				move_uploaded_file($tmp,$ruta.$nombreFile);
				$arreglo+=array('imagen4'=>$nombreFile);
			}
		}

		$archivo = $_FILES['foto5']['tmp_name'];
		$nombrearchivo = $_FILES['foto5']['name'];
		$tmp=$_FILES['foto5']['tmp_name'];
		$info = pathinfo($nombrearchivo);
		if($archivo!=""){
			$extension = $info['extension'];
			if ($extension=='png' || $extension=='PNG' || $extension=='jpg'  || $extension=='JPG') {
				$nombreFile = "resp5_".date("YmdHis").rand(0000,9999).".".$extension;
				move_uploaded_file($tmp,$ruta.$nombreFile);
				$arreglo+=array('imagen5'=>$nombreFile);
			}
		}

		if($idticket==0){
			$sql = "SELECT MAX(numero) as total FROM ticket";
			$statement = $this->dbh->prepare($sql);
			$statement->execute();
			$numero=$statement->fetchColumn()+1;

			$arreglo+=array('numero'=>$numero);
			$arreglo+=array('fecha'=>date("Y-m-d H:i:s"));
			$arreglo+=array('idusuario'=>$_SESSION['idusuario']);
			$arreglo+=array('estado'=>"Abierto");
			$x=$this->insert('ticket', $arreglo);
		}
		else{
			$x=$this->update('ticket',array('idticket'=>$idticket), $arreglo);
		}
		return $x;
	}
	public function guardar_hijo(){
		$x="";

		

		$arreglo =array();

		$idticket=$_REQUEST['idticket'];
		$arreglo+=array('idpadre'=>$idticket);
		$arreglo+=array('asunto'=>$_REQUEST['asunto']);
		$arreglo+=array('mensaje'=>$_REQUEST['texto_hijo']);
		$extension = '';
		$ruta = '../a_archivos/ticket/';
		
		
		$archivo = $_FILES['foto1']['tmp_name'];
		$nombrearchivo = $_FILES['foto1']['name'];
		$tmp=$_FILES['foto1']['tmp_name'];
		$info = pathinfo($nombrearchivo);
		if($archivo!=""){
			$extension = $info['extension'];
			if ($extension=='png' || $extension=='PNG' || $extension=='jpg'  || $extension=='JPG') {
				$nombreFile = "resp1_".date("YmdHis").rand(0000,9999).".".$extension;
				move_uploaded_file($tmp,$ruta.$nombreFile);
				$arreglo+=array('imagen1'=>$nombreFile);
			}
		}

		$archivo = $_FILES['foto2']['tmp_name'];
		$nombrearchivo = $_FILES['foto2']['name'];
		$tmp=$_FILES['foto2']['tmp_name'];
		$info = pathinfo($nombrearchivo);
		if($archivo!=""){
			$extension = $info['extension'];
			if ($extension=='png' || $extension=='PNG' || $extension=='jpg'  || $extension=='JPG') {
				$nombreFile = "resp2_".date("YmdHis").rand(0000,9999).".".$extension;
				move_uploaded_file($tmp,$ruta.$nombreFile);
				$arreglo+=array('imagen2'=>$nombreFile);
			}
		}

		$archivo = $_FILES['foto3']['tmp_name'];
		$nombrearchivo = $_FILES['foto3']['name'];
		$tmp=$_FILES['foto3']['tmp_name'];
		$info = pathinfo($nombrearchivo);
		if($archivo!=""){
			$extension = $info['extension'];
			if ($extension=='png' || $extension=='PNG' || $extension=='jpg'  || $extension=='JPG') {
				$nombreFile = "resp3_".date("YmdHis").rand(0000,9999).".".$extension;
				move_uploaded_file($tmp,$ruta.$nombreFile);
				$arreglo+=array('imagen3'=>$nombreFile);
			}
		}

		$archivo = $_FILES['foto4']['tmp_name'];
		$nombrearchivo = $_FILES['foto4']['name'];
		$tmp=$_FILES['foto4']['tmp_name'];
		$info = pathinfo($nombrearchivo);
		if($archivo!=""){
			$extension = $info['extension'];
			if ($extension=='png' || $extension=='PNG' || $extension=='jpg'  || $extension=='JPG') {
				$nombreFile = "resp4_".date("YmdHis").rand(0000,9999).".".$extension;
				move_uploaded_file($tmp,$ruta.$nombreFile);
				$arreglo+=array('imagen4'=>$nombreFile);
			}
		}

		$archivo = $_FILES['foto5']['tmp_name'];
		$nombrearchivo = $_FILES['foto5']['name'];
		$tmp=$_FILES['foto5']['tmp_name'];
		$info = pathinfo($nombrearchivo);
		if($archivo!=""){
			$extension = $info['extension'];
			if ($extension=='png' || $extension=='PNG' || $extension=='jpg'  || $extension=='JPG') {
				$nombreFile = "resp5_".date("YmdHis").rand(0000,9999).".".$extension;
				move_uploaded_file($tmp,$ruta.$nombreFile);
				$arreglo+=array('imagen5'=>$nombreFile);
			}
		}


		$arreglo+=array('fecha'=>date("Y-m-d H:i:s"));
		$arreglo+=array('idusuario'=>$_SESSION['idusuario']);
		$x=$this->insert('ticket', $arreglo);
		
		$arreglo=array();
		$arreglo+=array('id1'=>$idticket);
		$arreglo+=array('error'=>0);
		return json_encode($arreglo);
	}
	public function ticket_registro($id){
		$sql="select * from ticket where idpadre='$id' order by fecha asc";
		$sth = $this->dbh->query($sql);
		return $sth->fetchAll(PDO::FETCH_OBJ);
	}
	public function ticket_lista(){
		$sql="select * from ticket where idusuario=".$_SESSION['idusuario']." and idpadre is null";
		$sth = $this->dbh->query($sql);
		return $sth->fetchAll(PDO::FETCH_OBJ);
	}
}

$db = new Ticket();
if(strlen($function)>0){
	echo $db->$function();
}

