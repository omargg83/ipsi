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
	public function sucursal(){
		try{
			if($_SESSION['nivel']==1 OR $_SESSION['nivel']==4)
			$sql="SELECT * FROM sucursal";

			if($_SESSION['nivel']==2 or $_SESSION['nivel']==3)
			$sql="SELECT * FROM sucursal where idsucursal=".$_SESSION['idsucursal'];

			$sth = $this->dbh->query($sql);
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function usuario_lista($pagina){
		$pagina=$pagina*$_SESSION['pagina'];

		if($_SESSION['nivel']==1){
			$sql="select * from usuarios where idusuario!=".$_SESSION['idusuario']." and nivel=2 limit $pagina,".$_SESSION['pagina']."";
		}
		if($_SESSION['nivel']==2){
			$sql="select * from usuarios where idusuario=".$_SESSION['idusuario']." and nivel=2 limit $pagina,".$_SESSION['pagina']."";
		}
		if($_SESSION['nivel']==3){
			$sql="select * from usuarios where idsucursal=".$_SESSION['idsucursal']." and nivel=2 and idusuario!=".$_SESSION['idusuario']." limit $pagina,".$_SESSION['pagina']."";
		}
		if($_SESSION['nivel']==4){
			$sql="select * from usuarios where nivel=2 and idusuario!=".$_SESSION['idusuario']." limit $pagina,".$_SESSION['pagina']."";
		}
		$sth = $this->dbh->query($sql);
		return $sth->fetchAll(PDO::FETCH_OBJ);
	}
	public function usuario_buscar($texto){
		try{
			if($_SESSION['nivel']==1)
			$sql="SELECT * FROM usuarios where nivel=2 and nombre like '%$texto%'";

			if($_SESSION['nivel']==2)
			$sql="SELECT * FROM usuarios where nivel=2 and idusuario=".$_SESSION['idusuario']." and nombre like '%$texto%'";

			if($_SESSION['nivel']==3)
			$sql="SELECT * FROM usuarios where nivel=2 and idsucursal=".$_SESSION['idsucursal']." and nombre like '%$texto%'";

			if($_SESSION['nivel']==4)
			$sql="SELECT * FROM usuarios where nivel=2 and nombre like '%$texto%'";

			$sth = $this->dbh->query($sql);
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}

	public function usuario_horarios($id){
		try{
			$sql="SELECT * FROM usuarios_horarios where idusuario='$id' order by desde_num asc,desde asc";
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
		$correo=trim($_REQUEST['correo']);

		$arreglo+=array('nombre'=>$_REQUEST['nombre']);
		$arreglo+=array('apellidop'=>$_REQUEST['apellidop']);

		if (isset($_REQUEST['apellidom'])){
			$arreglo+=array('apellidom'=>$_REQUEST['apellidom']);
		}
		if (isset($_REQUEST['edad'])){
			$arreglo+=array('edad'=>$_REQUEST['edad']);
		}
		if (isset($_REQUEST['telefono'])){
			$arreglo+=array('telefono'=>$_REQUEST['telefono']);
		}
		if (isset($_REQUEST['edo_civil'])){
			$arreglo+=array('edo_civil'=>$_REQUEST['edo_civil']);
		}
		if (isset($_REQUEST['n_hijos'])){
			$arreglo+=array('n_hijos'=>$_REQUEST['n_hijos']);
		}
		if (isset($_REQUEST['direccion'])){
			$arreglo+=array('direccion'=>$_REQUEST['direccion']);
		}
		if (isset($_REQUEST['ocupacion'])){
			$arreglo+=array('ocupacion'=>$_REQUEST['ocupacion']);
		}
		if (isset($_REQUEST['escolaridad'])){
			$arreglo+=array('escolaridad'=>$_REQUEST['escolaridad']);
		}
		if (isset($_REQUEST['religion'])){
			$arreglo+=array('religion'=>$_REQUEST['religion']);
		}
		if (isset($_REQUEST['vive'])){
			$arreglo+=array('vive'=>$_REQUEST['vive']);
		}
		if (isset($_REQUEST['c_emergencia'])){
			$arreglo+=array('c_emergencia'=>$_REQUEST['c_emergencia']);
		}
		if (isset($_REQUEST['c_telefono'])){
			$arreglo+=array('c_telefono'=>$_REQUEST['c_telefono']);
		}
		if (isset($_REQUEST['enfermedad'])){
			$arreglo+=array('enfermedad'=>$_REQUEST['enfermedad']);
		}
		if (isset($_REQUEST['medicamento'])){
			$arreglo+=array('medicamento'=>$_REQUEST['medicamento']);
		}
		if (isset($_REQUEST['terapia'])){
			$arreglo+=array('terapia'=>$_REQUEST['terapia']);
		}

		$arreglo+=array('correo'=>$correo);

		if (isset($_REQUEST['autoriza'])){
			$arreglo+=array('autoriza'=>$_REQUEST['autoriza']);
		}

		if($_SESSION['nivel']==1){
			if (isset($_REQUEST['idsucursal'])){
				$arreglo+=array('idsucursal'=>$_REQUEST['idsucursal']);
			}
		}
		$_SESSION['nombrec']=$_REQUEST['nombre']." ".$_REQUEST['apellidop'];
		if($idusuario==0){

			$sql="select * from usuarios where correo='$correo'";
			$sth = $this->dbh->prepare($sql);
			$a=$sth->execute();
			if($sth->rowCount()>0){
				$arreglo+=array('id1'=>0);
				$arreglo+=array('error'=>1);
				$arreglo+=array('terror'=>"Ya existe el usuario favor de verificar");
				return json_encode($arreglo);
			}

			if($_SESSION['nivel']==3){
				$arreglo+=array('idsucursal'=>$_SESSION['idsucursal']);
			}
			$arreglo+=array('nivel'=>2);  ///terapeuta
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

	public function guardar_horario(){
		$x="";

		$idusuario=$_REQUEST['idusuario'];
		$idhorario=$_REQUEST['idhorario'];

		$arreglo =array();
		$desde_dia=$_REQUEST['desde_dia'];

		if (isset($_REQUEST['desde_dia'])){
			$arreglo+=array('desde_dia'=>$desde_dia);
		}

		if($desde_dia=="Domingo")
		$arreglo+=array('desde_num'=>0);

		if($desde_dia=="Lunes")
		$arreglo+=array('desde_num'=>1);

		if($desde_dia=="Martes")
		$arreglo+=array('desde_num'=>2);

		if($desde_dia=="Miercoles")
		$arreglo+=array('desde_num'=>3);

		if($desde_dia=="Jueves")
		$arreglo+=array('desde_num'=>4);

		if($desde_dia=="Viernes")
		$arreglo+=array('desde_num'=>5);

		if($desde_dia=="Sabado")
		$arreglo+=array('desde_num'=>6);

		if (isset($_REQUEST['recurrente'])){
			$arreglo+=array('recurrente'=>$_REQUEST['recurrente']);
		}
		else{
			$arreglo+=array('recurrente'=>null);
		}

		$desde="2021-01-01 ".$_REQUEST['desde_fecha'].":00";
		$arreglo+=array('desde'=>$desde);

		$hasta="2021-01-01 ".$_REQUEST['hasta_fecha'].":00";
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
			$arreglo+=array('idusuario'=>$idusuario);

			$sql="select * from usuarios_horarios where idusuario='$idusuario' and desde_dia='$desde_dia' and (
				('$desde' between desde and hasta) or ('$hasta' between desde and hasta) )";

			$sth = $this->dbh->prepare($sql);
			$a=$sth->execute();
			if($sth->rowCount()>0){
				$arreglo+=array('id1'=>0);
				$arreglo+=array('error'=>1);
				$arreglo+=array('terror'=>"Ya existe el horario favor de verificar");
				return json_encode($arreglo);
			}


			$x=$this->insert('usuarios_horarios', $arreglo);
		}
		else{
			$x=$this->update('usuarios_horarios',array('idhorario'=>$idhorario), $arreglo);
		}
		return $x;
	}
	public function horario_editar($idhorario){
		try{
			$sql="SELECT * FROM usuarios_horarios where idhorario='$idhorario'";
			$sth = $this->dbh->query($sql);
			return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function horario_quitar(){
		$idhorario=$_REQUEST['idhorario'];
		$idusuario=$_REQUEST['idusuario'];

		$x=$this->borrar('usuarios_horarios',"idhorario",$idhorario);

		return $x;
	}
	public function sucursal_ver($id){
		try{
			$sql="select * from sucursal where idsucursal=$id";
			$sth = $this->dbh->query($sql);
			return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}

	public function paciente_buscar($texto,$idsucursal){
		try{
			if($_SESSION['nivel']==1 or$_SESSION['nivel']==4)
			$sql="select * from clientes where (nombre like '%$texto%' or apellidop like '%$texto%' or apellidom like '%$texto%') limit 50";

			if($_SESSION['nivel']==2)
			$sql="select * from clientes where nombre='x' limit 50";

			if($_SESSION['nivel']==3)
			$sql="select * from clientes where (nombre like '%$texto%' or apellidop like '%$texto%' or apellidom like '%$texto%') and idsucursal='".$_SESSION['idsucursal']."' limit 50";

			$sth = $this->dbh->query($sql);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}
	public function sucursal_($id){
		try{
		  $sql="select * from sucursal where idsucursal=:id";
		  $sth = $this->dbh->prepare($sql);
		  $sth->bindValue(":id",$id);
		  $sth->execute();
		  return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
		  return "Database access FAILED!".$e->getMessage();
		}
	}
	public function asignar_paciente(){

		$idcliente=$_REQUEST['idpaciente'];
		$idusuario=$_REQUEST['idusuario'];

		$sql="select * from cliente_terapeuta where idcliente=:idcliente and idusuario=:idusuario";
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(":idcliente",$idcliente);
		$sth->bindValue(":idusuario",$idusuario);
		$sth->execute();
		if ($sth->rowCount()!=0){
			$arreglo=array();
			$arreglo+=array('id1'=>0);
			$arreglo+=array('error'=>1);
			$arreglo+=array('terror'=>"Ya tiene asignado el paciente");
			return json_encode($arreglo);
		}
		else{
			$arreglo =array();
			$arreglo+=array('idcliente'=>$idcliente);
			$arreglo+=array('idusuario'=>$idusuario);
			return $this->insert('cliente_terapeuta', $arreglo);
		}
	}
	public function cliente_($id){
		$sql="select * from clientes where id='$id'";
		$sth = $this->dbh->query($sql);
		return $sth->fetch(PDO::FETCH_OBJ);
	}
	public function paciente_quitar(){
		$idusuario=$_REQUEST['idusuario'];
		$idterapeuta=$_REQUEST['idterapeuta'];

		return $this->borrar('cliente_terapeuta',"idterapeuta",$idterapeuta);

	}
}

$db = new Usuario();
if(strlen($function)>0){
	echo $db->$function();
}
