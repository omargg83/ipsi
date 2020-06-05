<?php
require_once("../control_db.php");
if (isset($_REQUEST['function'])){$function=$_REQUEST['function'];}	else{ $function="";}

class Cliente extends ipsi{
	public $nivel_personal;
	public $nivel_captura;
	public function __construct(){
		parent::__construct();
		$this->doc="a_archivos/clientes/";

		if(isset($_SESSION['idusuario']) and $_SESSION['autoriza'] == 1) {

		}
		else{
			include "../error.php";
			die();
		}
	}
	public function clientes_lista(){
		try{
			self::set_names();
			$sql="SELECT * FROM clientes";
			$sth = $this->dbh->query($sql);
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function cliente_editar($id){
		try{
		  self::set_names();
		  $sql="select * from clientes where id=:id";
		  $sth = $this->dbh->prepare($sql);
		  $sth->bindValue(":id",$id);
		  $sth->execute();
		  return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
		  return "Database access FAILED!".$e->getMessage();
		}
	}

	public function guardar_cliente(){
		$x="";
		parent::set_names();
		$arreglo =array();
		$id=$_REQUEST['id'];
		if (isset($_REQUEST['nombre'])){
			$arreglo+=array('nombre'=>$_REQUEST['nombre']);
		}
		if (isset($_REQUEST['apellidop'])){
			$arreglo+=array('apellidop'=>$_REQUEST['apellidop']);
		}
		if (isset($_REQUEST['apellidom'])){
			$arreglo+=array('apellidom'=>$_REQUEST['apellidom']);
		}

		if (isset($_REQUEST['telefono'])){
			$arreglo+=array('telefono'=>$_REQUEST['telefono']);
		}
		if (isset($_REQUEST['correo'])){
			$arreglo+=array('correo'=>$_REQUEST['correo']);
		}

		if($id==0){
			$x=$this->insert('clientes', $arreglo);
		}
		else{
			$x=$this->update('clientes',array('id'=>$id), $arreglo);
		}
		return $x;
	}
	public function password(){
		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		if (isset($_REQUEST['pass1'])){$pass1=$_REQUEST['pass1'];}
		if (isset($_REQUEST['pass2'])){$pass2=$_REQUEST['pass2'];}
		if(trim($pass1)==($pass2)){
			$arreglo=array();
			$passPOST=md5(trim($pass1));
			$arreglo=array('pass'=>$passPOST);
			$x=$this->update('clientes',array('id'=>$id), $arreglo);
			return $x;
		}
		else{
			return "La contraseña no coincide";
		}
	}
}

$db = new Cliente();
if(strlen($function)>0){
	echo $db->$function();
}
