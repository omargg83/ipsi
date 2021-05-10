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
			if($_SESSION['nivel']==1  or $_SESSION['nivel']==4){
				$sql="SELECT consultorio.*, sucursal.nombre as sucursal, sucursal.ubicacion FROM consultorio
				left outer join sucursal on sucursal.idsucursal=consultorio.idsucursal
				limit $pagina,".$_SESSION['pagina']."";
			}
			if($_SESSION['nivel']==3){
				$sql="SELECT consultorio.*, sucursal.nombre as sucursal, sucursal.ubicacion FROM consultorio
				left outer join sucursal on sucursal.idsucursal=consultorio.idsucursal where sucursal.idsucursal='".$_SESSION['idsucursal']."'
				limit $pagina,".$_SESSION['pagina']."";
			}

			$sth = $this->dbh->query($sql);
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function consultorio_buscar($texto){
		try{
			if($_SESSION['nivel']==1 or $_SESSION['nivel']==4){
				$sql="SELECT consultorio.*, sucursal.nombre as sucursal, sucursal.ubicacion FROM consultorio
				left outer join sucursal on sucursal.idsucursal=consultorio.idsucursal
				where consultorio.nombre like '%$texto%'";
			}
			if($_SESSION['nivel']==3){
				$sql="SELECT consultorio.*, sucursal.nombre as sucursal, sucursal.ubicacion FROM consultorio
				left outer join sucursal on sucursal.idsucursal=consultorio.idsucursal
				where sucursal.idsucursal='".$_SESSION['idsucursal']."' and consultorio.nombre like '%$texto%'";
			}
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
			if($_SESSION['nivel']==1 or $_SESSION['nivel']==4){
				$sql="SELECT * FROM sucursal";
			}
			if($_SESSION['nivel']==3){
				$sql="SELECT * FROM sucursal where idsucursal='".$_SESSION['idsucursal']."'";
			}

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

		$desde_dia=$_REQUEST['desde_dia'];
		$arreglo+=array('desde_dia'=>$desde_dia);


		if($desde_dia=="Domingo")
		$arreglo+=array('hasta_dia'=>0);

		if($desde_dia=="Lunes")
		$arreglo+=array('hasta_dia'=>1);

		if($desde_dia=="Martes")
		$arreglo+=array('hasta_dia'=>2);

		if($desde_dia=="Miercoles")
		$arreglo+=array('hasta_dia'=>3);

		if($desde_dia=="Jueves")
		$arreglo+=array('hasta_dia'=>4);

		if($desde_dia=="Viernes")
		$arreglo+=array('hasta_dia'=>5);

		if($desde_dia=="Sabado")
		$arreglo+=array('hasta_dia'=>6);


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

		$fecha_desde = strtotime($desde);
		$fecha_hasta = strtotime($hasta);

		if($fecha_desde > $fecha_hasta){
			$arreglo+=array('id1'=>0);
			$arreglo+=array('error'=>1);
			$arreglo+=array('terror'=>"Error, verificar horario");
			return json_encode($arreglo);
		}

		if($idhorario==0){
			$arreglo+=array('idconsultorio'=>$idconsultorio);

			$sql="select * from consultorio_horarios where idconsultorio='$idconsultorio' and desde_dia='$desde_dia' and (
				('$desde' between desde and hasta) or ('$hasta' between desde and hasta) )";
			$sth = $this->dbh->prepare($sql);
			$a=$sth->execute();
			if($sth->rowCount()>0){
				$arreglo+=array('id1'=>0);
				$arreglo+=array('error'=>1);
				$arreglo+=array('terror'=>"Ya existe el horario favor de verificar");
				return json_encode($arreglo);
			}



			$x=$this->insert('consultorio_horarios', $arreglo);
		}
		else{
			$x=$this->update('consultorio_horarios',array('idhorario'=>$idhorario), $arreglo);
		}
		return $x;
	}
	public function lista_horarios($id){
		try{
			$sql="SELECT * FROM consultorio_horarios where idconsultorio='$id' order by hasta_dia asc";
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

	public function agregar_terconsl(){
		try{
			$sql="select * from consultorio_sug where idusuario=:idusuario and idconsultorio=:idconsultorio";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":idusuario",$_REQUEST['idusuario']);
			$sth->bindValue(":idconsultorio",$_REQUEST['idconsultorio']);
			$sth->execute();
			if ($sth->rowCount()==0){
				$arreglo=array();
				$x="";
				$arreglo+=array('idusuario'=>$_REQUEST['idusuario']);
				$arreglo+=array('idconsultorio'=>$_REQUEST['idconsultorio']);
				$this->insert('consultorio_sug',$arreglo);

				$arreglo=array();
				$arreglo+=array('id1'=>$_REQUEST['idconsultorio']);
				$arreglo+=array('error'=>0);
				return json_encode($arreglo);
			}
			else{
				$arreglo=array();
				$arreglo+=array('id1'=>0);
				$arreglo+=array('error'=>1);
				$arreglo+=array('terror'=>"el terapeuta ya esta asignado");
				return json_encode($arreglo);
			}
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}
	public function terapeutasuc_quitar(){
		$id=$_REQUEST['id'];
		return $this->borrar('consultorio_sug',"id",$id);
	}

}

$db = new Consultorio();
if(strlen($function)>0){
	echo $db->$function();
}
