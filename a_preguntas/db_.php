<?php
require_once("control_db.php");
if (isset($_REQUEST['function'])){$function=$_REQUEST['function'];}	else{ $function="";}

class Preguntas extends ipsi{
	private $accesox;
	private $comic;
	private $editar;

	public function __construct(){
		parent::__construct();
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

$db = new Preguntas();
if(strlen($function)>0){
  echo $db->$function();
}

?>
