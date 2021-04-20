<?php
require_once("../control_db.php");

if($_SESSION['des']==1 and strlen($function)==0)
{
	echo "<div class='alert alert-primary' role='alert' style='font-size:10px'>";
	$arrayx=explode('/', $_SERVER['SCRIPT_NAME']);
	echo print_r($arrayx);
	echo "<br>";
	echo print_r($_REQUEST);
	echo "</div>";
}

class Configuración extends ipsi{
	
	public function __construct(){
		parent::__construct();

	}
	public function config_lista(){
		$sql="SELECT * FROM correo";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetchAll(PDO::FETCH_OBJ);		
	}

	public function config_editar($idmail){
		try{
		  $sql="select * from correo where idmail=:idmail";
		  $sth = $this->dbh->prepare($sql);
		  $sth->bindValue(":idmail",$idmail);
		  $sth->execute();
		  return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
		  return "Database access FAILED!".$e->getMessage();
		}
	}
	public function guardar_correo(){
		$x="";
		$arreglo =array();
		$idmail=$_REQUEST['idmail'];

		if (isset($_REQUEST['user'])){
			$arreglo+=array('user'=>$_REQUEST['user']);
		}
		if (isset($_REQUEST['pass'])){
			$arreglo+=array('pass'=>$_REQUEST['pass']);
		}
		if (isset($_REQUEST['smptsecure'])){
			$arreglo+=array('smptsecure'=>$_REQUEST['smptsecure']);
		}
		if (isset($_REQUEST['smptsecure'])){
			$arreglo+=array('smptsecure'=>$_REQUEST['smptsecure']);
		}
		if (isset($_REQUEST['port'])){
			$arreglo+=array('port'=>$_REQUEST['port']);
		}
		if (isset($_REQUEST['tiempo'])){
			$arreglo+=array('tiempo'=>$_REQUEST['tiempo']);
		}
	
	
	

		if($idmail==0){
			$x=$this->insert('correo', $arreglo);
		}
		else{
			$x=$this->update('correo',array('idmail'=>$idmail), $arreglo);
		}
		return $x;
	}
	public function borrar_sucursal(){
		$idsucursal=$_REQUEST['idsucursal'];
		$x=$this->borrar('sucursal',"idsucursal",$idsucursal);
		return $x;
	}

	public function relacion_buscar($texto,$idsucursal){
		try{
			$sql="select * from usuarios where nivel=3 and (nombre like '%$texto%' or apellidop like '%$texto%' or apellidom like '%$texto%')";
			$sth = $this->dbh->query($sql);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}
	public function asignar_admin(){
		$arreglo =array();
		$arreglo+=array('idsucursal'=>$_REQUEST['idsucursal']);
		$arreglo+=array('idusuario'=>$_REQUEST['idusuario']);
		return $this->insert('sucursal_administracion', $arreglo);
	}
	public function quitar_admin(){
		$idsucursal=$_REQUEST['idsucursal'];
		$idadmi=$_REQUEST['idadmi'];
		return $this->borrar('sucursal_administracion',"idadmi",$idadmi);
	}

}

$db = new Configuración();
if(strlen($function)>0){
	echo $db->$function();
}
