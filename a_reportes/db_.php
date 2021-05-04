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

  public function pacientes_lista(){
    try{
      if($_SESSION['nivel']==1 or $_SESSION['nivel']==4){
        $sql="SELECT * FROM clientes";
      }
      if($_SESSION['nivel']==2){
        $sql="SELECT * FROM clientes
        left outer join cliente_terapeuta on cliente_terapeuta.idcliente=clientes.id where cliente_terapeuta.idusuario='".$_SESSION['idusuario']."'";
      }
      if($_SESSION['nivel']==3){
        $sql="SELECT * FROM clientes where idsucursal='".$_SESSION['idsucursal']."'";
      }
      $sth = $this->dbh->prepare($sql);
      $sth->execute();
      return $sth->fetchAll(PDO::FETCH_OBJ);
    }
    catch(PDOException $e){
      return "Database access FAILED!".$e->getMessage();
    }
  }
}

$db = new Agenda();
if(strlen($function)>0){
	echo $db->$function();
}

?>
