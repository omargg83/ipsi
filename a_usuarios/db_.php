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

class Usuario extends ipsi{

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
	public function usuario_lista($pagina){
		$pagina=$pagina*$_SESSION['pagina'];

		if($_SESSION['nivel']==1){
			$sql="select * from usuarios limit $pagina,".$_SESSION['pagina']."";
		}
		else{
			$sql="select * from usuarios where idusuario=".$_SESSION['idusuario']." limit $pagina,".$_SESSION['pagina']."";
		}
		$sth = $this->dbh->query($sql);
		return $sth->fetchAll(PDO::FETCH_OBJ);
	}
	public function usuario_buscar($texto){
		try{
			$sql="SELECT * FROM usuarios where nombre like '%$texto%'";
			$sth = $this->dbh->query($sql);
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}

	public function usuario_editar($id){

		$sql="select * from usuarios where idusuario='$id'";
		$sth = $this->dbh->query($sql);
		return $sth->fetch(PDO::FETCH_OBJ);
	}
	public function guardar_usuario(){
		$x="";
		$arreglo =array();
		$idusuario=$_REQUEST['idusuario'];

		$arreglo+=array('nombre'=>$_REQUEST['nombre']);
		$arreglo+=array('apellidop'=>$_REQUEST['apellidop']);

		if (isset($_REQUEST['apellidom'])){
			$arreglo+=array('apellidom'=>$_REQUEST['apellidom']);
		}
		if (isset($_REQUEST['correo'])){
			$arreglo+=array('correo'=>$_REQUEST['correo']);
		}
		if (isset($_REQUEST['nivel'])){
			$arreglo+=array('nivel'=>$_REQUEST['nivel']);
		}

		$_SESSION['nombrec']=$_REQUEST['nombre']." ".$_REQUEST['apellidop'];

		if($idusuario==0){
			$x=$this->insert('usuarios', $arreglo);
		}
		else{
			$x=$this->update('usuarios',array('idusuario'=>$idusuario), $arreglo);
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
			$x=$this->update('usuarios',array('idusuario'=>$id), $arreglo);
			return $x;
		}
		else{
			return "La contraseña no coincide";
		}
	}
	public function foto(){
		$x="";
		$arreglo =array();
		$id1=$_REQUEST['id1'];

		$extension = '';
		$ruta = '../a_archivos/terapeuta/';
		$archivo = $_FILES['foto']['tmp_name'];
		$nombrearchivo = $_FILES['foto']['name'];
		$tmp=$_FILES['foto']['tmp_name'];
		$info = pathinfo($nombrearchivo);
		if($archivo!=""){
			$extension = $info['extension'];
			if ($extension=='png' || $extension=='PNG' || $extension=='jpg'  || $extension=='JPG') {
				$nombreFile = "resp_".date("YmdHis").rand(0000,9999).".".$extension;
				move_uploaded_file($tmp,$ruta.$nombreFile);
				$ruta=$ruta."/".$nombreFile;
				$arreglo+=array('foto'=>$nombreFile);
				$_SESSION['foto']="a_archivos/terapeuta/".$nombreFile;
			}
			else{
				echo "fail";
				exit;
			}
		}
		return $this->update('usuarios',array('idusuario'=>$id1), $arreglo);
	}
}

$db = new Usuario();
if(strlen($function)>0){
	echo $db->$function();
}
