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
			return $tipo;
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
