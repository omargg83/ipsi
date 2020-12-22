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

		///////////////////////////imagenes
		echo print_r($_FILES['foto']['tmp_name']);
		/*
		$arreglo =array();
		$idusuario=$_REQUEST['idusuario'];

		$extension = '';
		$ruta = '../'.$this->f_usuarios;
		$archivo = $_FILES['foto']['tmp_name'];
		$nombrearchivo = $_FILES['foto']['name'];
		$tmp=$_FILES['foto']['tmp_name'];
		$info = pathinfo($nombrearchivo);
		if($archivo!=""){
			$extension = $info['extension'];
			if ($extension=='png' || $extension=='PNG' || $extension=='jpg'  || $extension=='JPG') {
				$nombreFile = "resp_".date("YmdHis").rand(0000,9999).".".$extension;
				move_uploaded_file($tmp,$ruta.$nombreFile);
				$ruta=$ruta."/".$nombreFile;
				$_SESSION['foto']=$nombreFile;
				$arreglo+=array('archivo'=>$nombreFile);
			}
			else{
				echo "fail";
				exit;
			}
		}

		$sql="update chat_conectados set foto='$nombreFile' where idpersona='".$_SESSION['idusuario']."'";
		$this->dbh->query($sql);

		 $this->update('usuarios',array('idusuario'=>$idusuario), $arreglo);
		*/




		return $x;
	}
	public function ticket_lista(){
		/*if($_SESSION['nivel']==1){
			$sql="select * from usuarios";
		}
		else{
			$sql="select * from usuarios where idusuario=".$_SESSION['idusuario']."";
		}
		*/
		$sql="select * from ticket where idusuario=".$_SESSION['idusuario']."";
		$sth = $this->dbh->query($sql);
		return $sth->fetchAll(PDO::FETCH_OBJ);
	}
}

$db = new Ticket();
if(strlen($function)>0){
	echo $db->$function();
}
