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


class Roles extends ipsi{
	public $nivel_personal;
	public $nivel_captura;
	public function __construct(){
		parent::__construct();

		if(isset($_SESSION['idusuario']) and $_SESSION['autoriza'] == 1) {

		}
		else{
			include "../error.php";
			die();
		}
	}


	public function roles_lista(){
		try{
		  $sql="select * from rol_familiar";
		  $sth = $this->dbh->query($sql);
		  return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
		  return "Database access FAILED!".$e->getMessage();
		}
	}
	public function rol_editar($idrol){
		try{
		  $sql="select * from rol_familiar where idrol='$idrol'";
		  $sth = $this->dbh->query($sql);
		  return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
		  return "Database access FAILED!".$e->getMessage();
		}
	}
	public function guardar_rol(){
		$x="";
		$arreglo =array();
		$idrol=$_REQUEST['idrol'];

		$arreglo+=array('rol'=>$_REQUEST['rol']);

		if($idrol==0){
			$x=$this->insert('rol_familiar', $arreglo);
		}
		else{
			$x=$this->update('rol_familiar',array('idrol'=>$idrol), $arreglo);
		}
		return $x;
	}
}

$db = new Roles();
if(strlen($function)>0){
	echo $db->$function();
}
