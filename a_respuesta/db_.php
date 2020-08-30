<?php
require_once("../control_db.php");

if($_SESSION['des']==1 and strlen($function)==0)
{
	echo "<div class='alert alert-primary' role='alert'>";
	$arrayx=explode('/', $_SERVER['SCRIPT_NAME']);
	echo print_r($arrayx);
	echo "</div>";
}

class Cliente extends ipsi{
	public $nivel_personal;
	public $nivel_captura;
	public function __construct(){
		parent::__construct();
		$this->pac="a_archivos/clientes/";
		$this->doc="a_archivos/respuestas/";
		$this->resp="a_archivos/terapias/";

		if(isset($_SESSION['idusuario']) and $_SESSION['autoriza'] == 1) {

		}
		else{
			include "../error.php";
			die();
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
			$sql="select * from contexto where idsubactividad=:id order by orden asc";
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
  public function guarda_respuesta(){
		try{
			$arreglo=array();
			$x="";
			$idpaciente=$_SESSION['idusuario'];
			$idcontexto=$_REQUEST['idcontexto'];


			$sql="select * from contexto where id=:id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":id",$idcontexto);
			$sth->execute();
			$contexto=$sth->fetch(PDO::FETCH_OBJ);

			if($contexto->tipo=="imagen"){
				$arreglo+=array('marca'=>"leido");
			}
			else if($contexto->tipo=="texto"){
				$arreglo+=array('marca'=>"leido");
			}
			else if($contexto->tipo=="video"){
				$arreglo+=array('marca'=>"leido");
			}
			else if($contexto->tipo=="archivo"){
				$arreglo+=array('marca'=>"leido");
			}
			else if($contexto->tipo=="textores"){
				$arreglo+=array('marca'=>"leido");
				$texto=$_REQUEST['texto'];
				$arreglo+=array('texto'=>$texto);
			}
			else if($contexto->tipo=="fecha"){
				$arreglo+=array('marca'=>"leido");
				$fecha=$_REQUEST['fecha'];
				$arreglo+=array('fecha'=>$fecha);
			}
			else if($contexto->tipo=="archivores"){
				$extension = '';
				$ruta = '../a_archivos/terapias/';
				$archivo = $_FILES['archivo']['tmp_name'];
				$nombrearchivo = $_FILES['archivo']['name'];
				$tmp=$_FILES['archivo']['tmp_name'];
				$info = pathinfo($nombrearchivo);
				if($archivo!=""){
					$extension = $info['extension'];
					$nombreFile = "resp_".$idcontexto."_".date("YmdHis").rand(0000,9999).".".$extension;
					move_uploaded_file($tmp,$ruta.$nombreFile);
					$ruta=$ruta."/".$nombreFile;
					$arreglo+=array('archivo'=>$nombreFile);
					$arreglo+=array('marca'=>"leido");
				}
			}
			else if($contexto->tipo=="pregunta"){

				$sql="delete from contexto_resp where idcontexto=$idcontexto";
				$delcontx = $this->dbh->query($sql);
				$arreglo=array();
				$arreglo+=array('id1'=>1);
				$arreglo+=array('error'=>0);
				$x=json_encode($arreglo);

				$sql="select * from contexto where id=:id";
				$sth = $this->dbh->prepare($sql);
				$sth->bindValue(":id",$idcontexto);
				$sth->execute();
				$contexto=$sth->fetch(PDO::FETCH_OBJ);

				foreach($_REQUEST as $key=>$value){
					$arreglo=array();
					if (strpos($key, 'checkbox') !== false) {
						$ic = explode("_", $key);
						$id_ctrol=$ic[1];
						$texto="";
						if(isset($_REQUEST["resp_".$id_ctrol])){
							$texto=clean_var($_REQUEST["resp_".$id_ctrol]);
						}

						$arreglo+=array('idrespuesta'=>$id_ctrol);
						$arreglo+=array('valor'=>$value);
						$arreglo+=array('texto'=>$texto);

						$arreglo+=array('idcontexto'=>$idcontexto);
						$arreglo+=array('marca'=>"leido");
						$x=$this->insert('contexto_resp', $arreglo);


					}
					if (strpos($key, 'radio') !== false) {
						$ic = explode("_", $key);
						$id_ctrol=$ic[1];

						$sql="select * from respuestas where idcontexto=:id and valor=:valor";
						$resp = $this->dbh->prepare($sql);
						$resp->bindValue(":id",$idcontexto);
						$resp->bindValue(":valor",$value);
						$resp->execute();
						if($resp->rowCount()>0){
							//////////para respuesta normal
							$inpx=$resp->fetch(PDO::FETCH_OBJ);
							$texto="";

							if(isset($_REQUEST["resp_".$inpx->id])){
								$texto=clean_var($_REQUEST["resp_".$inpx->id]);
							}

							$arreglo+=array('valor'=>$value);
							$arreglo+=array('texto'=>$texto);
							$arreglo+=array('idcontexto'=>$idcontexto);
							$arreglo+=array('idrespuesta'=>$inpx->id);
							$arreglo+=array('marca'=>"leido");
							$x=$this->insert('contexto_resp', $arreglo);
						}
						else{
							//////////para otra respuestas
							$inpx=$resp->fetch(PDO::FETCH_OBJ);
							$texto="";

							if(isset($_REQUEST["otrorad_".$idcontexto])){
								$texto=clean_var($_REQUEST["otrorad_".$idcontexto]);
							}

							$arreglo+=array('valor'=>$value);
							$arreglo+=array('texto'=>$texto);
							$arreglo+=array('idcontexto'=>$idcontexto);
							$arreglo+=array('otraresp'=>"OTRO");
							$arreglo+=array('marca'=>"leido");
							$x=$this->insert('contexto_resp', $arreglo);
						}
					}
					if (strpos($key, 'datacheck') !== false){
						$ic = explode("_", $key);
						$id_ctrol=$ic[1];
						if(isset($_REQUEST["otroche_".$id_ctrol])){
							$texto=clean_var($_REQUEST["otroche_".$id_ctrol]);
						}
						$arreglo+=array('otraresp'=>"OTRO");
						$arreglo+=array('texto'=>$texto);
						$arreglo+=array('idcontexto'=>$idcontexto);
						$arreglo+=array('marca'=>"leido");
						$x=$this->insert('contexto_resp', $arreglo);
					}
				}

			}

			if($contexto->tipo!="pregunta"){
				$sql="select * from contexto_resp where idcontexto=:id";
				$contx = $this->dbh->prepare($sql);
				$contx->bindValue(":id",$idcontexto);
				$contx->execute();
				if($contx->rowCount()>0){
					$resp=$contx->fetch(PDO::FETCH_OBJ);
					$x=$this->update('contexto_resp',array('id'=>$resp->id), $arreglo);
				}
				else{
					$arreglo+=array('idcontexto'=>$idcontexto);
					$x=$this->insert('contexto_resp', $arreglo);
				}
				//$x=$this->update('contexto_resp',array('idactividad'=>$idactividad), $arreglo);
			}
			return $x;
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



?>
