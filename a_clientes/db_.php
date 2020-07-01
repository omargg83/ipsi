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
	public function personal(){
		try{
			parent::set_names();
			if($_SESSION['nivel']==1){
				$sql="select * from usuarios";
			}
			else{
				$sql="select * from usuarios where idusuario='".$_SESSION['idusuario']."'";
			}
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}
	public function clientes_lista(){
		try{
			self::set_names();
			if($_SESSION['nivel']==1){
				$sql="SELECT * FROM clientes";
			}
			else{
				$sql="SELECT * FROM clientes where idusuario='".$_SESSION['idusuario']."'";
			}
			$sth = $this->dbh->query($sql);
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}
	public function cliente_editar($id){
		try{
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
		if (isset($_REQUEST['idusuario'])){
			$arreglo+=array('idusuario'=>$_REQUEST['idusuario']);
		}
		if (isset($_REQUEST['observaciones'])){
			$arreglo+=array('observaciones'=>$_REQUEST['observaciones']);
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

	public function buscar_actividad(){
		try{
			$b_actividad=$_REQUEST['b_actividad'];
			$id=$_REQUEST['id'];
			$sql="select * from cuestionario where nombre like :nombre and tipo!='inicial'";
			$sth = $this->dbh->prepare($sql);
		  $sth->bindValue(":nombre","%".$b_actividad."%");
		  $sth->execute();
			$resp=$sth->fetchAll(PDO::FETCH_OBJ);
			$x="";

			foreach($resp as $key){
				$x.="<div class='row'>";
				$x.="<div class='col-2'>";
					$x.="<div class='btn-group'>";
					$x.="<button type='button' onclick='actividad_addv(".$key->idcuestionario.",$id)' class='btn btn-outline-secondary btn-sm' title='Seleccionar Actividad'><i class='fas fa-plus'></i></button>";
					$x.= "</div>";
				$x.="</div>";
				$x.="<div class='col-8'>";
				$x.=$key->nombre;
				$x.="</div>";
				$x.="</div>";
			}

		  return $x;
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function agrega_actividad(){
		try{
			$arreglo=array();
			$idactividad=$_REQUEST['actividad'];
			$idcliente=$_REQUEST['id'];
			$arreglo+=array('idcliente'=>$idcliente);
			$arreglo+=array('idcuestionario'=>$idactividad);
			$x=$this->insert('cliente_cuestionario', $arreglo);
			return $x;
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}

	public function individual($id,$tipo,$terapia){
		try{
			$sql="select * from cliente_cuestionario left outer join cuestionario on cuestionario.idcuestionario=cliente_cuestionario.idcuestionario where cuestionario.tipo=:tipo and cuestionario.terapia=:terapia and cliente_cuestionario.idcliente=:id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":tipo",$tipo);
			$sth->bindValue(":terapia",$terapia);
			$sth->bindValue(":id",$id);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
}

$db = new Cliente();
if(strlen($function)>0){
	echo $db->$function();
}
