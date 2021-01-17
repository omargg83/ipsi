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

class Consultorio extends ipsi{
	public $nivel_personal;
	public $nivel_captura;
	public function __construct(){
		parent::__construct();

	}
	public function consultorio_lista($pagina){
		try{
			$pagina=$pagina*$_SESSION['pagina'];

			$sql="SELECT consultorio.*, sucursal.nombre as sucursal, sucursal.ubicacion FROM consultorio
			left outer join sucursal on sucursal.idsucursal=consultorio.idsucursal
			limit $pagina,".$_SESSION['pagina']."";
			$sth = $this->dbh->query($sql);
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function consultorio_buscar($texto){
		try{
			$sql="SELECT consultorio.*, sucursal.nombre as sucursal, sucursal.ubicacion FROM consultorio
			left outer join sucursal on sucursal.idsucursal=consultorio.idsucursal
			where consultorio.nombre like '%$texto%'";
			$sth = $this->dbh->query($sql);
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function consultorio($id){
		try{
		  $sql="select * from consultorio where idconsultorio=:id";
		  $sth = $this->dbh->prepare($sql);
		  $sth->bindValue(":id",$id);
		  $sth->execute();
		  return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
		  return "Database access FAILED!".$e->getMessage();
		}
	}
	public function guardar_consultorio(){
		$x="";
		$arreglo =array();
		$idconsultorio=$_REQUEST['idconsultorio'];

		if (isset($_REQUEST['nombre'])){
			$arreglo+=array('nombre'=>$_REQUEST['nombre']);
		}

		if (isset($_REQUEST['idsucursal'])){
			$arreglo+=array('idsucursal'=>$_REQUEST['idsucursal']);
		}

		if($idconsultorio==0){
			$x=$this->insert('consultorio', $arreglo);
		}
		else{
			$x=$this->update('consultorio',array('idconsultorio'=>$idconsultorio), $arreglo);
		}
		return $x;
	}
	public function borrar_sucursal(){
		$idconsultorio=$_REQUEST['idconsultorio'];
		$x=$this->borrar('consultorio',"idconsultorio",$idconsultorio);
		return $x;
	}
	public function sucursal_lista(){
		try{
			$sql="SELECT * FROM sucursal";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function sucursal($idsucursal){
		try{
			$sql="SELECT * FROM sucursal where idsucursal=$idsucursal";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}

	public function guardar_horario(){
		$x="";

		$idhorario=$_REQUEST['idhorario'];
		$idconsultorio=$_REQUEST['idconsultorio'];
		$arreglo =array();

		if (isset($_REQUEST['desde_dia'])){
			$arreglo+=array('desde_dia'=>$_REQUEST['desde_dia']);
		}

		if (isset($_REQUEST['recurrente'])){
			$arreglo+=array('recurrente'=>$_REQUEST['recurrente']);
		}
		else{
			$arreglo+=array('recurrente'=>null);
		}

		$desde="2021/01/01 ".$_REQUEST['desde'].":00";
		$arreglo+=array('desde'=>$desde);

		$hasta="2021/01/01 "." ".$_REQUEST['hasta'].":00";
		$arreglo+=array('hasta'=>$hasta);

		if($idhorario==0){
			$arreglo+=array('idconsultorio'=>$idconsultorio);
			$x=$this->insert('consultorio_horarios', $arreglo);
		}
		else{
			$x=$this->update('consultorio_horarios',array('idhorario'=>$idhorario), $arreglo);
		}
		return $x;
	}
	public function lista_horarios($id){
		try{
			$sql="SELECT * FROM consultorio_horarios where idconsultorio='$id'";
			$sth = $this->dbh->query($sql);
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function horario_editar($idhorario){
		try{
			$sql="SELECT * FROM consultorio_horarios where idhorario='$idhorario'";
			$sth = $this->dbh->query($sql);
			return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function horario_quitar(){
		$idhorario=$_REQUEST['idhorario'];
		$x=$this->borrar('consultorio_horarios',"idhorario",$idhorario);
		return $x;
	}

}

$db = new Consultorio();
if(strlen($function)>0){
	echo $db->$function();
}
