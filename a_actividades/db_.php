<?php
require_once("../control_db.php");
if (isset($_REQUEST['function'])){$function=clean_var($_REQUEST['function']);}	else{ $function="";}

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

	public function cuestionario_lista(){
		try{
			self::set_names();
			$sql="select * from cuestionario";
			$sth = $this->dbh->query($sql);
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function actividad_editar($id){
		try{
			self::set_names();
			$sql="select * from cuestionario where idcuestionario=:id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":id",$id);
			$sth->execute();
			return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function guarda_cuestionario(){
		try{
			$arreglo=array();
			$x="";
			$id=$_REQUEST['id'];

			if (isset($_REQUEST['nombre'])){
				$arreglo+=array('nombre'=>$_REQUEST['nombre']);
			}
			if (isset($_REQUEST['observaciones'])){
				$arreglo+=array('observaciones'=>$_REQUEST['observaciones']);
			}
			if($id==0){
				$x=$this->insert('cuestionario', $arreglo);
			}
			else{
				$x=$this->update('cuestionario',array('idcuestionario'=>$id), $arreglo);
			}
			return $x;
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}

	public function preguntas($id){
		try{
			self::set_names();
			$sql="select * from cuest_pregunta where idcuestionario=:cuest order by orden";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":cuest",$id);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function pregunta_edit($id){
		try{
			self::set_names();
			$sql="select * from cuest_pregunta where id=:id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":id",$id);
			$sth->execute();
			return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
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
			return "Database access FAILED!".$e->getMessage();
		}
  }
	public function guarda_pregunta(){
		try{
			$arreglo=array();
			$x="";
			$id=$_REQUEST['id'];
			$idcuestionario=$_REQUEST['id2'];
			$tipo=$_REQUEST['tipo'];
			$orden=$_REQUEST['orden'];
			$pregunta=$_REQUEST['pregunta'];

			$arreglo+=array('orden'=>$orden);
			$arreglo+=array('pregunta'=>$pregunta);
			$arreglo+=array('tipo'=>$tipo);

			if($id==0){
				$arreglo+=array('idcuestionario'=>$idcuestionario);
				$x=$this->insert('cuest_pregunta', $arreglo);
			}
			else{
				$x=$this->update('cuest_pregunta',array('id'=>$id), $arreglo);
			}
			return $x;
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}

	public function respuestas($idpregunta){
		try{
			self::set_names();
			$sql="select * from cuest_respuesta where idpregunta=:idpregunta order by orden";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":idpregunta",$idpregunta);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}

	}
	public function respuesta_edit($idrespuesta){
		try{
			self::set_names();
			$sql="select * from cuest_respuesta where id=:idpregunta";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":idpregunta",$idrespuesta);
			$sth->execute();
			return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
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
			return "Database access FAILED!".$e->getMessage();
		}
	}

}

$db = new Cuest();
if(strlen($function)>0){
  echo $db->$function();
}

?>
