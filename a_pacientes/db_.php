<?php
require_once("../control_db.php");

$_SESSION['des']=1;
if($_SESSION['des']==1 and strlen($function)==0)
{
	echo "<div class='alert alert-primary' role='alert'> ARCHIVO:";
	$arrayx=explode('/', $_SERVER['SCRIPT_NAME']);
	echo array_pop($arrayx);
	echo " : ".$_SERVER['REQUEST_METHOD'];
	echo "</div>";
}


class Cliente extends ipsi{
	public $nivel_personal;
	public $nivel_captura;
	public function __construct(){
		parent::__construct();
		$this->pac="a_archivos/clientes/";
		$this->doc="a_archivos/respuestas/";

		if(isset($_SESSION['idusuario']) and $_SESSION['autoriza'] == 1) {

		}
		else{
			include "../error.php";
			die();
		}
	}
	public function personal(){
		try{

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
		$id1=$_REQUEST['id1'];
		if (isset($_REQUEST['nombre'])){
			$arreglo+=array('nombre'=>clean_var($_REQUEST['nombre']));
		}
		if (isset($_REQUEST['apellidop'])){
			$arreglo+=array('apellidop'=>clean_var($_REQUEST['apellidop']));
		}
		if (isset($_REQUEST['apellidom'])){
			$arreglo+=array('apellidom'=>clean_var($_REQUEST['apellidom']));
		}
		if (isset($_REQUEST['telefono'])){
			$arreglo+=array('telefono'=>clean_var($_REQUEST['telefono']));
		}
		if (isset($_REQUEST['correo'])){
			$arreglo+=array('correo'=>clean_var($_REQUEST['correo']));
		}
		if (isset($_REQUEST['idusuario'])){
			$arreglo+=array('idusuario'=>clean_var($_REQUEST['idusuario']));
		}
		if (isset($_REQUEST['observaciones'])){
			$arreglo+=array('observaciones'=>clean_var($_REQUEST['observaciones']));
		}
		if (isset($_REQUEST['edad'])){
			$arreglo+=array('edad'=>clean_var($_REQUEST['edad']));
		}
		if (isset($_REQUEST['sexo'])){
			$arreglo+=array('sexo'=>clean_var($_REQUEST['sexo']));
		}
		if (isset($_REQUEST['peso'])){
			$arreglo+=array('peso'=>clean_var($_REQUEST['peso']));
		}
		if (isset($_REQUEST['altura'])){
			$arreglo+=array('altura'=>clean_var($_REQUEST['altura']));
		}
		if (isset($_REQUEST['direccion'])){
			$arreglo+=array('direccion'=>clean_var($_REQUEST['direccion']));
		}
		if (isset($_REQUEST['enfermedades'])){
			$arreglo+=array('enfermedades'=>clean_var($_REQUEST['enfermedades']));
		}
		if (isset($_REQUEST['medicamentos'])){
			$arreglo+=array('medicamentos'=>clean_var($_REQUEST['medicamentos']));
		}

		if($id1==0){
			$x=$this->insert('clientes', $arreglo);
		}
		else{
			$x=$this->update('clientes',array('id'=>$id1), $arreglo);
		}
		return $x;
	}
	public function password(){
		if (isset($_REQUEST['id1'])){$id=$_REQUEST['id1'];}
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
	public function foto(){
		$x="";
		$arreglo =array();
		$id1=$_REQUEST['id1'];

		$extension = '';
		$ruta = '../a_archivos/clientes/';
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
			}
			else{
				echo "fail";
				exit;
			}
		}
		return $this->update('clientes',array('id'=>$id1), $arreglo);
	}

	public function buscar_actividad($b_actividad){
		try{
			$id1=$_REQUEST['id1'];
			$sql="select * from actividad where nombre like :nombre and tipo!='inicial' and idpaciente is null";
			$sth = $this->dbh->prepare($sql);
		  $sth->bindValue(":nombre","%".$b_actividad."%");
		  $sth->execute();
			$resp=$sth->fetchAll(PDO::FETCH_OBJ);
		  return $resp;
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function agregar_actividad(){
		try{
			$idactividad=$_REQUEST['id2'];
			$idpaciente=$_REQUEST['id1'];

			$sql="select * from actividad where idactividad=:idactividad";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":idactividad",$idactividad);
			$sth->execute();
			$resp=$sth->fetch(PDO::FETCH_OBJ);

			$fecha=date("Y-m-d H:i:s");

			////////////Clonar actividad
			$arreglo=array();
			$arreglo+=array('idmodulo'=>$resp->idmodulo);
			$arreglo+=array('idpaciente'=>$idpaciente);
			$arreglo+=array('idcreado'=>$resp->idcreado);
			$arreglo+=array('nombre'=>$resp->nombre);
			$arreglo+=array('indicaciones'=>$resp->indicaciones);
			$arreglo+=array('observaciones'=>$resp->observaciones);
			$arreglo+=array('tipo'=>$resp->tipo);
			$arreglo+=array('fecha'=>$fecha);
			$idactividad_array=json_decode($this->insert('actividad', $arreglo),true);

			////////////Clonar Subactividad
			$sql="select * from subactividad where idactividad=:idactividad";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":idactividad",$idactividad);
			$sth->execute();

			foreach($sth->fetchall(PDO::FETCH_OBJ) as $key){
				$arreglo=array();
				$arreglo+=array('nombre'=>$key->nombre);
				$arreglo+=array('orden'=>$key->orden);
				$arreglo+=array('pagina'=>$key->pagina);
				$arreglo+=array('idactividad'=>$idactividad_array['id1']);
				$arreglo+=array('idcreado'=>$_SESSION['idusuario']);
				$subactividad_array=json_decode($this->insert('subactividad', $arreglo),true);

				////////////Clonar Contexto
				$sql="select * from contexto where idsubactividad=:idsubactividad";
				$sth1 = $this->dbh->prepare($sql);
				$sth1->bindValue(":idsubactividad",$key->idsubactividad);
				$sth1->execute();

				foreach($sth1->fetchall(PDO::FETCH_OBJ) as $subkey){
					$arreglo=array();
					$arreglo+=array('idsubactividad'=>$subactividad_array['id1']);
					$arreglo+=array('idcreado'=>$_SESSION['idusuario']);
					$arreglo+=array('tipo'=>$subkey->tipo);
					$arreglo+=array('observaciones'=>$subkey->observaciones);
					$arreglo+=array('texto'=>$subkey->texto);
					$arreglo+=array('incisos'=>$subkey->incisos);
					$arreglo+=array('usuario'=>$subkey->usuario);
					$arreglo+=array('descripcion'=>$subkey->descripcion);
					$contexto_array=json_decode($this->insert('contexto', $arreglo),true);

					////////////Clonar respuestas
					$sql="select * from respuestas where idcontexto=:idcontexto";
					$sth2 = $this->dbh->prepare($sql);
					$sth2->bindValue(":idcontexto",$subkey->id);
					$sth2->execute();

					foreach($sth2->fetchall(PDO::FETCH_OBJ) as $cont){
						$arreglo=array();
						$arreglo+=array('idcontexto'=>$contexto_array['id1']);
						$arreglo+=array('orden'=>$cont->orden);
						$arreglo+=array('nombre'=>$cont->nombre);
						$arreglo+=array('imagen'=>$cont->imagen);
						$respuestas_array=json_decode($this->insert('respuestas', $arreglo),true);
					}
				}
			}
			return 1;
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}

	public function terapias_paciente($id){
		try{
			$sql="select * from actividad where idpaciente=:id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":id",$id);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
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

	public function subactividad_ver($id){
		try{
			$sql="select * from subactividad where idactividad=:id order by orden asc";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":id",$id);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}
	public function contexto_ver($id){
		try{
			$sql="select * from contexto where idsubactividad=:id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":id",$id);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}
	public function respuestas_ver($id){
		try{
			$sql="select * from respuestas where idcontexto=:id order by orden";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":id",$id);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}
}

$db = new Cliente();
if(strlen($function)>0){
	echo $db->$function();
}
