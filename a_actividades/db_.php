<?php
require_once("../control_db.php");

$_SESSION['des']=0;
if($_SESSION['des']==1 and strlen($function)==0)
{
	echo "<div class='alert alert-primary' role='alert'> ARCHIVO:";
	$arrayx=explode('/', $_SERVER['SCRIPT_NAME']);
	echo array_pop($arrayx);
	echo " : ".$_SERVER['REQUEST_METHOD'];
	echo "</div>";
}

class Cuest extends ipsi{
	public function __construct(){
		parent::__construct();
	}

	public function actividad_lista(){
		try{
			$sql="select * from actividad";
			$sth = $this->dbh->query($sql);
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}
	public function actividad_editar($id){
		try{
			$sql="select * from actividad where idactividad=:id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":id",$id);
			$sth->execute();
			return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}
	public function guarda_actividad(){
		try{
			$arreglo=array();
			$x="";
			$id=$_REQUEST['id'];

			if (isset($_REQUEST['nombre'])){
				$arreglo+=array('nombre'=>clean_var($_REQUEST['nombre']));
			}
			if (isset($_REQUEST['observaciones'])){
				$arreglo+=array('observaciones'=>clean_var($_REQUEST['observaciones']));
			}
			if (isset($_REQUEST['indicaciones'])){
				$arreglo+=array('indicaciones'=>clean_var($_REQUEST['indicaciones']));
			}
			if (isset($_REQUEST['tipo'])){
				$arreglo+=array('tipo'=>clean_var($_REQUEST['tipo']));
			}
			if (isset($_REQUEST['terapia'])){
				$arreglo+=array('terapia'=>clean_var($_REQUEST['terapia']));
			}
			if($id==0){
				$arreglo+=array('idcreado'=>clean_var($_SESSION['idusuario']));
				$x=$this->insert('actividad', $arreglo);
			}
			else{
				$x=$this->update('actividad',array('idactividad'=>$id), $arreglo);
			}
			return $x;
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}

	public function subactividad_ver($id){
		try{
			$sql="select * from subactividad where idactividad=:id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":id",$id);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}
	public function guarda_subactividad(){
		try{
			$arreglo=array();
			$x="";
			$id=clean_var($_REQUEST['id']);

			$tipo=clean_var($_REQUEST['tipo']);
			$arreglo+=array('tipo'=>$tipo);

			if($tipo=="texto"){
				$arreglo+=array('texto'=>$_REQUEST['tipo']);
			}
			if($tipo=="video"){
				$arreglo+=array('texto'=>$_REQUEST['video']);
			}

			if($id==0){
				$arreglo+=array('idactividad'=>clean_var($_REQUEST['idactividad']));
				$arreglo+=array('idcreado'=>clean_var($_SESSION['idusuario']));
				$x=$this->insert('subactividad', $arreglo);
			}
			else{
				$x=$this->update('subactividad',array('idsubactividad'=>$id), $arreglo);
			}
			return $x;
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}



	public function preguntas($id){
		try{

			$sql="select * from cuest_pregunta where idactividad=:cuest order by orden";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":cuest",$id);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}
	public function pregunta_edit($id){
		try{

			$sql="select * from cuest_pregunta where id=:id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":id",$id);
			$sth->execute();
			return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}
	public function pregunta_tipo(){
		try{
			$tipo=$_REQUEST['tipo'];
			$texto="a";
			if($tipo=="radio"){
				$texto="<input type='radio' id='customRadio1' name='customRadio'>";
			}
			else if($tipo=="caja"){
				$texto="<input type='checkbox' id='customRadio1' name='customRadio'>";
			}
			else{

			}
			return $texto;
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
  }
	public function guarda_pregunta(){
		try{
			$arreglo=array();
			$x="";
			$id=$_REQUEST['id'];
			$idactividad=$_REQUEST['id2'];
			$tipo=$_REQUEST['tipo'];
			$orden=$_REQUEST['orden'];
			$pregunta=$_REQUEST['pregunta'];

			$arreglo+=array('orden'=>$orden);
			$arreglo+=array('pregunta'=>$pregunta);
			$arreglo+=array('tipo'=>$tipo);

			if($id==0){
				$arreglo+=array('idactividad'=>$idactividad);
				$x=$this->insert('cuest_pregunta', $arreglo);
			}
			else{
				$x=$this->update('cuest_pregunta',array('id'=>$id), $arreglo);
			}
			return $x;
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}

	public function respuestas($idpregunta){
		try{

			$sql="select * from cuest_respuesta where idpregunta=:idpregunta order by orden";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":idpregunta",$idpregunta);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}

	}
	public function respuesta_edit($idrespuesta){
		try{

			$sql="select * from cuest_respuesta where id=:idpregunta";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":idpregunta",$idrespuesta);
			$sth->execute();
			return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}

	}
	public function guarda_respuesta(){
		try{
			$arreglo=array();
			$x="";
			$id=$_REQUEST['id'];
			$idpregunta=$_REQUEST['id2'];

			$respuesta=$_REQUEST['respuesta'];
			$valor=$_REQUEST['valor'];
			$orden=$_REQUEST['orden'];
			$arreglo+=array('respuesta'=>$respuesta);
			$arreglo+=array('valor'=>$valor);
			$arreglo+=array('orden'=>$orden);

			if($id==0){
				$arreglo+=array('idpregunta'=>$idpregunta);
				$x=$this->insert('cuest_respuesta', $arreglo);
			}
			else{
				$x=$this->update('cuest_respuesta',array('id'=>$id), $arreglo);
			}
			return $x;
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}



}

$db = new Cuest();
if(strlen($function)>0){
  echo $db->$function();
}

?>
