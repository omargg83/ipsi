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
			if($_SESSION['nivel']==1){
				$sql="select * from track";
			}
			else{
				$sql="SELECT * FROM track where idusuario='".$_SESSION['idusuario']."'";
			}
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
		$id1=clean_var($_REQUEST['id1']);
		if (isset($_REQUEST['nombre'])){
			$arreglo+=array('nombre'=>clean_var($_REQUEST['nombre']));
		}
		if (isset($_REQUEST['video'])){
			$arreglo+=array('video'=>$_REQUEST['video']);
		}
		if($id1==0){
			$arreglo+=array('idusuario'=>$_SESSION['idusuario']);
			$x=$this->insert('track', $arreglo);
		}
		else{
			$x=$this->update('track',array('id'=>$id1), $arreglo);
		}
		return $x;
	}
	public function borrar_track(){
		if (isset($_REQUEST['id1'])){$id1=$_REQUEST['id1'];}
		return $this->borrar('track',"id",$id1);
	}

	public function terapias_lista(){
		try{
			$sql="select * from terapias ";
			$sth = $this->dbh->query($sql);
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}

}

$db = new Cliente();
if(strlen($function)>0){
	echo $db->$function();
}
