<?php
require_once("../control_db.php");

$_SESSION['des']=0;
if($_SESSION['des']==1 and strlen($function)==0)
{
	echo "ARCHIVO:";
	$arrayx=explode('/', $_SERVER['SCRIPT_NAME']);
	echo array_pop($arrayx);
	echo " : ".$_SERVER['REQUEST_METHOD'];
}

class Cuest extends ipsi{
	public function __construct(){
		parent::__construct();
		$this->doc="a_archivos/respuestas/";

	}

	public function terapias(){
		try{
			$sql="select * from terapias order by nombre asc";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}
	public function terapia_editar($id){
		try{
			$sql="select * from terapias where id=:id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":id",$id);
			$sth->execute();
			return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}

	public function track($id1){
		try{
			$sql="select * from track where idterapia=:id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":id",$id1);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}
	public function track_editar($id1){
		try{
			$sql="select * from track where id=:id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":id",$id1);
			$sth->execute();
			return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}



	public function modulos($id){
		try{
			$sql="select * from modulo where idtrack=:id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":id",$id);
			$sth->execute();
			return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
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
			$id1=$_REQUEST['id1'];

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
			if (isset($_REQUEST['track'])){
				$arreglo+=array('track'=>clean_var($_REQUEST['track']));
			}
			if($id1==0){
				$arreglo+=array('idcreado'=>clean_var($_SESSION['idusuario']));
				$x=$this->insert('actividad', $arreglo);
			}
			else{
				$x=$this->update('actividad',array('idactividad'=>$id1), $arreglo);
			}
			return $x;
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}
	public function actividad_del(){
		try{
			if (isset($_REQUEST['idactividad'])){$idactividad=$_REQUEST['idactividad'];}
			return $this->borrar('actividad',"idactividad",$idactividad);
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
	public function subactividad_guardar(){
		try{
			$arreglo=array();
			$x="";
			$id=clean_var($_REQUEST['id1']);
			$idactividad=clean_var($_REQUEST['id2']);

			$nombre=clean_var($_REQUEST['nombre']);
			$orden=clean_var($_REQUEST['orden']);
			$pagina=clean_var($_REQUEST['pagina']);

			$arreglo+=array('nombre'=>$nombre);
			$arreglo+=array('orden'=>$orden);
			$arreglo+=array('pagina'=>$pagina);

			if($id==0){
				$arreglo+=array('idactividad'=>$idactividad);
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
	public function subactividad_editar($id){
		try{
			$sql="select * from subactividad where idsubactividad=:id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":id",$id);
			$sth->execute();
			return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}
	public function subactividad_del(){
		try{
			if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
			return $this->borrar('subactividad',"idsubactividad",$id);
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
	public function contexto_editar($id){
		try{
			$sql="select * from contexto where id=:id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":id",$id);
			$sth->execute();
			return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}
	public function guarda_contexto(){
		try{
			$arreglo=array();
			$x="";
			$id1=clean_var($_REQUEST['id1']);
			$tipo=clean_var($_REQUEST['tipo']);
			$arreglo+=array('tipo'=>$tipo);

			$arreglo+=array('observaciones'=>clean_var($_REQUEST['observaciones']));
			if($tipo=="texto"){
				$arreglo+=array('texto'=>$_REQUEST['texto']);
			}
			if($tipo=="video"){
				$arreglo+=array('texto'=>$_REQUEST['video']);
			}
			if($tipo=="pregunta"){
				$arreglo+=array('texto'=>clean_var($_REQUEST['pregunta']));
				$arreglo+=array('descripcion'=>clean_var($_REQUEST['descripcion']));
				if(isset($_REQUEST['incisos'])){
					$arreglo+=array('incisos'=>1);
				}
				else{
					$arreglo+=array('incisos'=>null);
				}
				if(isset($_REQUEST['personalizado'])){
					$arreglo+=array('personalizado'=>1);
				}
				else{
					$arreglo+=array('personalizado'=>null);
				}
				if(isset($_REQUEST['usuario'])){
					$arreglo+=array('usuario'=>1);
				}
				else{
					$arreglo+=array('personalizado'=>null);
				}
			}

			if($id1==0){
				$arreglo+=array('idsubactividad'=>clean_var($_REQUEST['idsubactividad']));
				$arreglo+=array('idcreado'=>clean_var($_SESSION['idusuario']));
				$x=$this->insert('contexto', $arreglo);
			}
			else{
				$x=$this->update('contexto',array('id'=>$id1), $arreglo);
			}
			return $x;
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}

	public function inciso_editar($id){
		try{
			$sql="select * from inciso where id=:id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":id",$id);
			$sth->execute();
			return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}
	public function guarda_inciso(){
		try {
			$arreglo=array();
			$x="";
			$id1=clean_var($_REQUEST['id1']);


			$arreglo+=array('tipo'=>clean_var($_REQUEST['tipo']));
			$arreglo+=array('pregunta'=>clean_var($_REQUEST['pregunta']));

			if(isset($_REQUEST['varios']))
				$arreglo+=array('varios'=>clean_var($_REQUEST['varios']));
			else
			 $arreglo+=array('varios'=>NULL);

			 if(isset($_REQUEST['orden']))
			 $arreglo+=array('orden'=>clean_var($_REQUEST['orden']));

			if(isset($_REQUEST['personalizada']))
			$arreglo+=array('personalizada'=>clean_var($_REQUEST['personalizada']));

			if(isset($_REQUEST['texto']))
			$arreglo+=array('texto'=>clean_var($_REQUEST['texto']));

			if($id1==0){
				$arreglo+=array('idsubactividad'=>clean_var($_REQUEST['idsubactividad']));
				$x=$this->insert('inciso', $arreglo);
			}
			else{
				$x=$this->update('inciso',array('id'=>$id1), $arreglo);
			}
			return $x;
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}
	public function inciso_ver($id){
		try{
			$sql="select * from inciso where idsubactividad=:id order by orden asc";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":id",$id);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}

	public function guarda_respuesta(){
		try{
			$arreglo=array();
			$x="";
			$id=clean_var($_REQUEST['id1']);
			$respuesta=clean_var($_REQUEST['respuesta']);
			$idsubactividad=clean_var($_REQUEST['idsubactividad']);
			$orden=clean_var($_REQUEST['orden']);

			$extension = '';
		  $ruta = '../a_archivos/respuestas/';
		  $archivo = $_FILES['imagen']['tmp_name'];
		  $nombrearchivo = $_FILES['imagen']['name'];
			$tmp=$_FILES['imagen']['tmp_name'];
		  $info = pathinfo($nombrearchivo);
		  if($archivo!=""){
		    $extension = $info['extension'];
		    if ($extension=='png' || $extension=='PNG' || $extension=='jpg'  || $extension=='JPG') {
		      $nombreFile = "resp_".date("YmdHis").rand(0000,9999).".".$extension;
		      move_uploaded_file($tmp,$ruta.$nombreFile);
		      $ruta=$ruta."/".$nombreFile;
					$arreglo+=array('imagen'=>$nombreFile);
		    }
		    else{
		      echo "fail";
		      exit;
		    }
		  }


			$arreglo+=array('respuesta'=>$respuesta);
			$arreglo+=array('orden'=>$orden);

			if($id==0){
				$arreglo+=array('idinciso'=>$idsubactividad);
				$x=$this->insert('respuestas', $arreglo);
			}
			else{
				$x=$this->update('respuestas',array('id'=>$id), $arreglo);
			}
			return $x;
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}
	public function respuestas_ver($id){
		try{
			$sql="select * from respuestas where idinciso=:id order by orden";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":id",$id);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}
	public function respuestas_editar($id){
		try{
			$sql="select * from respuestas where id=:id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":id",$id);
			$sth->execute();
			return $sth->fetch(PDO::FETCH_OBJ);
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
