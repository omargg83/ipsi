<?php
require_once("../control_db.php");

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

	public function track_lista(){
		try{
			$sql="SELECT * FROM track";
			$sth = $this->dbh->query($sql);
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}
	public function track_editar($id){
		try{
		  $sql="select * from track where id=:id";
		  $sth = $this->dbh->prepare($sql);
		  $sth->bindValue(":id",$id);
		  $sth->execute();
		  return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
		  return "Database access FAILED!".$e->getMessage();
		}
	}
	public function guardar_track(){
		$x="";
		$arreglo =array();
		$id=clean_var($_REQUEST['id']);
		if (isset($_REQUEST['nombre'])){
			$arreglo+=array('nombre'=>clean_var($_REQUEST['nombre']));
		}
		if (isset($_REQUEST['video'])){
			$arreglo+=array('video'=>$_REQUEST['video']);
		}
		if($id==0){
			$arreglo+=array('idpersona'=>$_SESSION['idusuario']);
			$x=$this->insert('track', $arreglo);
		}
		else{
			$x=$this->update('track',array('id'=>$id), $arreglo);
		}
		return $x;
	}
	public function borrar_track(){
		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		return $this->borrar('track',"id",$id);
	}

}

$db = new Cliente();
if(strlen($function)>0){
	echo $db->$function();
}
