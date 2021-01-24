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

class Agenda extends ipsi{

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
	public function agenda_lista($pagina){
		try{
			$pagina=$pagina*$_SESSION['pagina'];
			$sql="SELECT * FROM citas";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function pacientes(){
		try{
			$sql="SELECT * FROM clientes";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function sucursal(){
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
	public function terapueutas(){
		$sql="select * from usuarios where idsucursal='".$_SESSION['idsucursal']."' and nivel=2";
		$sth = $this->dbh->query($sql);
		return $sth->fetchAll(PDO::FETCH_OBJ);
	}
	public function agregar_cita(){
		$arreglo =array();

		$idcita=$_REQUEST['idcita'];


		$idpaciente=$_REQUEST['idpaciente'];
		$idsucursal=$_REQUEST['idsucursal'];
		$idusuario=$_REQUEST['idusuario'];

		$fdesde=$_REQUEST['fdesde'];
		$fhasta=$_REQUEST['fhasta'];
		$fecha=$_REQUEST['fecha'];

		$h_desde = new DateTime($fdesde);
		$h_hasta = new DateTime($fhasta);

		$total_desde=$fecha." ".$h_desde->format("h:i");
		$total_hasta=$fecha." ".$h_hasta->format("h:i");

		$arreglo+=array('desde'=>$total_desde);
		$arreglo+=array('hasta'=>$total_hasta);

		if (isset($_REQUEST['idusuario'])){
			$arreglo+=array('idusuario'=>$_REQUEST['idusuario']);
		}
		if (isset($_REQUEST['idpaciente'])){
			$arreglo+=array('idpaciente'=>$_REQUEST['idpaciente']);
		}

		if (isset($_REQUEST['idsucursal'])){

			$arreglo+=array('idsucursal'=>$_REQUEST['idsucursal']);
		}
		if($idcita==0){
			$arreglo+=array('estatus'=>"Pendiente");
			$x=$this->insert('citas', $arreglo);
		}
		else{
			$x=$this->insert('citas', $arreglo);
		}

		return $x;
	}
	public function sucursal_($id){
		try{
			$sql="SELECT * FROM sucursal where idsucursal='$id'";
			$sth = $this->dbh->query($sql);
			return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function terapueuta_($id){
		$sql="select * from usuarios where idusuario='$id'";
		$sth = $this->dbh->query($sql);
		return $sth->fetch(PDO::FETCH_OBJ);
	}
	public function cliente_($id){
		$sql="select * from clientes where id='$id'";
		$sth = $this->dbh->query($sql);
		return $sth->fetch(PDO::FETCH_OBJ);
	}
	public function cita_quitar(){
		$idcita=$_REQUEST['idcita'];
		$x=$this->borrar('citas',"idcita",$idcita);
		return $x;
	}

}


$db = new Agenda();
if(strlen($function)>0){
	echo $db->$function();
}
