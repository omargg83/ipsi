<?php
require_once("../control_db.php");
if (isset($_REQUEST['function'])){$function=$_REQUEST['function'];}	else{ $function="";}

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
}

$db = new Cuest();
if(strlen($function)>0){
  echo $db->$function();
}

?>
