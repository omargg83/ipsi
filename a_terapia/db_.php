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

	public function terapias_lista(){
		try{
			$sql="SELECT * FROM terapias";
			$sth = $this->dbh->query($sql);
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}
	public function terapia_editar($id){
		try{
		  $sql="select * from terapias where id=:id";
		  $sth = $this->dbh->prepare($sql);
		  $sth->bindValue(":id",$id);
		  $sth->execute();
		  return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
		  return "Database access FAILED!".$e->getMessage();
		}
	}
	public function guardar_terapia(){
		$x="";
		$arreglo =array();
		$id=clean_var($_REQUEST['id']);
		if (isset($_REQUEST['nombre'])){
			$arreglo+=array('nombre'=>clean_var($_REQUEST['nombre']));
		}
		if($id==0){
			$x=$this->insert('terapias', $arreglo);
		}
		else{
			$x=$this->update('terapias',array('id'=>$id), $arreglo);
		}
		return $x;
	}
	public function borrar_terapia(){
		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		return $this->borrar('terapias',"id",$id);
	}

}

$db = new Cliente();
if(strlen($function)>0){
	echo $db->$function();
}
