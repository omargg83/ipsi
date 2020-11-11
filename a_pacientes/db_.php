<?php
require_once("../control_db.php");

if($_SESSION['des']==1 and strlen($function)==0)
{
	echo "<div class='alert alert-primary' role='alert'>";
	$arrayx=explode('/', $_SERVER['SCRIPT_NAME']);
	echo print_r($arrayx);
	echo "<hr>";
	echo print_r($_REQUEST);
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
	public function guarda_anotacion(){
		try{
			$arreglo=array();
			$x="";
			$idactividad=$_REQUEST['idactividad'];

			if (isset($_REQUEST['anotaciones'])){
				$arreglo+=array('anotaciones'=>$_REQUEST['anotaciones']);
			}
			$x=$this->update('actividad',array('idactividad'=>$idactividad), $arreglo);
			return $x;
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}
	public function guardar_cliente(){
		$x="";
		$arreglo =array();
		$idpaciente=$_REQUEST['idpaciente'];
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
		if (isset($_REQUEST['fnacimiento']) and strlen($_REQUEST['fnacimiento'])>4){
			$arreglo+=array('fnacimiento'=>clean_var($_REQUEST['fnacimiento']));
		}
		else{
			$arreglo+=array('fnacimiento'=>null);
		}
		if (isset($_REQUEST['hermanos']) and strlen($_REQUEST['hermanos']>0)){
			$arreglo+=array('hermanos'=>clean_var($_REQUEST['hermanos']));
		}
		else{
			$arreglo+=array('hermanos'=>0);
		}
		if (isset($_REQUEST['facebook'])){
			$arreglo+=array('facebook'=>clean_var($_REQUEST['facebook']));
		}
		if (isset($_REQUEST['estudios'])){
			$arreglo+=array('estudios'=>clean_var($_REQUEST['estudios']));
		}
		if (isset($_REQUEST['trabajo'])){
			$arreglo+=array('trabajo'=>clean_var($_REQUEST['trabajo']));
		}
		if (isset($_REQUEST['puesto'])){
			$arreglo+=array('puesto'=>clean_var($_REQUEST['puesto']));
		}
		if (isset($_REQUEST['ipsi'])){
			$arreglo+=array('ipsi'=>clean_var($_REQUEST['ipsi']));
		}
		if (isset($_REQUEST['contacto'])){
			$arreglo+=array('contacto'=>clean_var($_REQUEST['contacto']));
		}
		if (isset($_REQUEST['parentesco'])){
			$arreglo+=array('parentesco'=>clean_var($_REQUEST['parentesco']));
		}
		if (isset($_REQUEST['telparentesco'])){
			$arreglo+=array('telparentesco'=>clean_var($_REQUEST['telparentesco']));
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

		if($idpaciente==0){
			$x=$this->insert('clientes', $arreglo);
		}
		else{
			$x=$this->update('clientes',array('id'=>$idpaciente), $arreglo);
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

	public function terapias_lista(){
		try{
			$sql="select * from terapias";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function track_lista($idterapia){
		try{
			$sql="select * from track where idterapia=:idterapia";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":idterapia",$idterapia);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function modulo_lista($idtrack){
		try{
			$sql="select * from modulo where idtrack=:idtrack";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":idtrack",$idtrack);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function actividad_lista($idmodulo){
		try{
			$sql="select * from actividad where idmodulo=:idmodulo and idpaciente is null";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":idmodulo",$idmodulo);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}

	public function agregar_terapia(){
		$idterapia=clean_var($_REQUEST['idterapia']);
		$idpaciente=clean_var($_REQUEST['idpaciente']);
		$sql="select * from terapias_per where idterapia=:idterapia and idpaciente=:idpaciente";
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(":idterapia",$idterapia);
		$sth->bindValue(":idpaciente",$idpaciente);
		$sth->execute();
		if ($sth->rowCount()==0){
			$arreglo=array();
			$arreglo+=array('idterapia'=>$idterapia);
			$arreglo+=array('idpaciente'=>$idpaciente);
			$x=$this->insert('terapias_per', $arreglo);
			return $x;
		}
		else{
			$arreglo=array();
			$arreglo+=array('id1'=>0);
			$arreglo+=array('error'=>1);
			$arreglo+=array('terror'=>"La terapia ya existe");
			return json_encode($arreglo);
		}
	}
	public function agregar_track(){
		$idtrack=clean_var($_REQUEST['idtrack']);
		$idpaciente=clean_var($_REQUEST['idpaciente']);
		$sql="select * from track_per where idtrack=:idtrack and idpaciente=:idpaciente";
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(":idtrack",$idtrack);
		$sth->bindValue(":idpaciente",$idpaciente);
		$sth->execute();
		if ($sth->rowCount()==0){
			$arreglo=array();
			$arreglo+=array('idpaciente'=>$idpaciente);
			$arreglo+=array('idtrack'=>$idtrack);
			$x=$this->insert('track_per', $arreglo);
			return $x;
		}
		else{
			$arreglo=array();
			$arreglo+=array('id1'=>0);
			$arreglo+=array('error'=>1);
			$arreglo+=array('terror'=>"El track ya existe");
			return json_encode($arreglo);
		}
	}
	public function agregar_modulo(){
		$idmodulo=clean_var($_REQUEST['idmodulo']);
		$idpaciente=clean_var($_REQUEST['idpaciente']);
		$sql="select * from modulo_per where idmodulo=:idmodulo and idpaciente=:idpaciente";
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(":idmodulo",$idmodulo);
		$sth->bindValue(":idpaciente",$idpaciente);
		$sth->execute();
		if ($sth->rowCount()==0){
			$arreglo=array();
			$arreglo+=array('idpaciente'=>$idpaciente);
			$arreglo+=array('idmodulo'=>$idmodulo);
			$x=$this->insert('modulo_per', $arreglo);
			return $x;
		}
		else{
			$arreglo=array();
			$arreglo+=array('id1'=>0);
			$arreglo+=array('error'=>1);
			$arreglo+=array('terror'=>"El modulo ya existe");
			return json_encode($arreglo);
		}
	}

	//////////////estas 2 clonan al catalogo
	public function agregar_actividad(){
		$x="";
		$idactividad=$_REQUEST['idactividad'];
		$idpaciente=$_REQUEST['idpaciente'];

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
		$arreglo+=array('idtrack'=>$resp->idtrack);
		$arreglo+=array('idcreado'=>$resp->idcreado);
		$arreglo+=array('nombre'=>$resp->nombre);
		$arreglo+=array('indicaciones'=>$resp->indicaciones);
		$arreglo+=array('observaciones'=>$resp->observaciones);
		$arreglo+=array('visible'=>$resp->visible);
		$arreglo+=array('tipo'=>$resp->tipo);
		$arreglo+=array('fecha'=>$fecha);
		$x=$this->insert('actividad', $arreglo);
		$idactividad_array=json_decode($x,true);
		$idactividad_nueva=$idactividad_array['id1'];


		//////////////////clonar escala_sub
		$sql="select * from escala_actividad where idactividad=$idactividad";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		$excala_act=$sth->fetchall(PDO::FETCH_OBJ);
		foreach($excala_act as $v2){
			$arreglo=array();
			$arreglo+=array('nombre'=>$v2->nombre);
			$arreglo+=array('idactividad'=>$idactividad_array['id1']);
			$x=$this->insert('escala_actividad', $arreglo);
			$escala_actividad_clon=json_decode($x,true);

			$sql="select * from escala_act where idescala=$v2->id";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			$tmp=$sth->fetchall(PDO::FETCH_OBJ);
			foreach($tmp as $v3){
				$arreglo=array();
				$arreglo+=array('descripcion'=>$v3->descripcion);
				$arreglo+=array('minimo'=>$v3->minimo);
				$arreglo+=array('maximo'=>$v3->maximo);
				$arreglo+=array('idescala'=>$escala_actividad_clon['id1']);
				$x=$this->insert('escala_act', $arreglo);
				$escala_act_clon=json_decode($x,true);
			}

			$sql="select * from escala_contexto where idescala=$v2->id";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			$tmp=$sth->fetchall(PDO::FETCH_OBJ);
			foreach($tmp as $v4){
				$arreglo=array();
				$arreglo+=array('idcontexto'=>$v4->idcontexto);
				$arreglo+=array('idescala'=>$escala_actividad_clon['id1']);
				$x=$this->insert('escala_contexto', $arreglo);
				$escala_contexto_clon=json_decode($x,true);
			}

		}

		//////////////////Permisos
		$arreglo=array();
		$arreglo+=array('idpaciente'=>$idpaciente);
		$arreglo+=array('idactividad'=>$idactividad_array['id1']);
		$x=$this->insert('actividad_per', $arreglo);

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
			$x=$this->insert('subactividad', $arreglo);
			$subactividad_array=json_decode($x,true);


			/////////////clonando escala
			$sql="select * from escala_sub where idsubactividad='".$key->idsubactividad."'";
			$esc = $this->dbh->prepare($sql);
			$esc->execute();
			foreach($esc->fetchall(PDO::FETCH_OBJ) as $escala){
				$arreglo=array();
				$arreglo+=array('idsubactividad'=>$subactividad_array['id1']);
				$arreglo+=array('descripcion'=>$escala->descripcion);
				$arreglo+=array('minimo'=>$escala->minimo);
				$arreglo+=array('maximo'=>$escala->maximo);
				$x=$this->insert('escala_sub', $arreglo);
			}

			////////////Clonar Contexto
			$sql="select * from contexto where idsubactividad=:idsubactividad";
			$sth1 = $this->dbh->prepare($sql);
			$sth1->bindValue(":idsubactividad",$key->idsubactividad);
			$sth1->execute();

			foreach($sth1->fetchall(PDO::FETCH_OBJ) as $subkey){
				$arreglo=array();
				$arreglo+=array('idsubactividad'=>$subactividad_array['id1']);
				$arreglo+=array('tipo'=>$subkey->tipo);
				$arreglo+=array('observaciones'=>$subkey->observaciones);
				$arreglo+=array('texto'=>$subkey->texto);
				$arreglo+=array('orden'=>$subkey->orden);
				$arreglo+=array('incisos'=>$subkey->incisos);
				$arreglo+=array('usuario'=>$subkey->usuario);
				$arreglo+=array('descripcion'=>$subkey->descripcion);
				$arreglo+=array('idcond'=>$subkey->idcond);
				$x=$this->insert('contexto', $arreglo);
				$contexto_array=json_decode($x,true);

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
					$arreglo+=array('valor'=>$cont->valor);
					$arreglo+=array('pre'=>$cont->id);
					$x=$this->insert('respuestas', $arreglo);
				}
			}
		}

		$sql="select contexto.* from contexto
		left outer join subactividad on contexto.idsubactividad=subactividad.idsubactividad
		where subactividad.idactividad=".$idactividad_nueva." and contexto.idcond is not null";
		$condix = $this->dbh->prepare($sql);
		$condix->execute();
		$shy=$condix->fetchAll(PDO::FETCH_OBJ);
		foreach($shy as $v1){

			$sql="select respuestas.id as pre, contexto.id from respuestas
			left outer join contexto on contexto.id=respuestas.idcontexto
			left outer join subactividad on subactividad.idsubactividad=contexto.idsubactividad
			where idactividad='".$idactividad_nueva."' and pre='".$v1->idcond."'";
			$inserta = $this->dbh->prepare($sql);
			$inserta->execute();
			$inx=$inserta->fetch(PDO::FETCH_OBJ);

			$arreglo=array();
			$arreglo+=array('idcond'=>$inx->pre);
			$x=$this->update('contexto',array('id'=>$v1->id), $arreglo);
		}
		return $x;
	}
	public function agregar_inicial(){
		try{
			$x="";
			$idactividad=$_REQUEST['idactividad'];
			$idpaciente=$_REQUEST['idpaciente'];

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
			$arreglo+=array('idtrack'=>$resp->idtrack);
			$arreglo+=array('idcreado'=>$resp->idcreado);
			$arreglo+=array('nombre'=>$resp->nombre);
			$arreglo+=array('indicaciones'=>$resp->indicaciones);
			$arreglo+=array('observaciones'=>$resp->observaciones);
			$arreglo+=array('visible'=>$resp->visible);
			$arreglo+=array('tipo'=>$resp->tipo);
			$arreglo+=array('fecha'=>$fecha);
			$x=$this->insert('actividad', $arreglo);
			$idactividad_array=json_decode($x,true);

			//////////////////Permisos
			$arreglo=array();
			$arreglo+=array('idpaciente'=>$idpaciente);
			$arreglo+=array('idactividad'=>$idactividad_array['id1']);
			$x=$this->insert('actividad_per', $arreglo);


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
				$x=$this->insert('subactividad', $arreglo);
				$subactividad_array=json_decode($x,true);


				/////////////clonando escala
				$sql="select * from escala_sub where idsubactividad='".$key->idsubactividad."'";
				$esc = $this->dbh->prepare($sql);
				$esc->execute();
				foreach($esc->fetchall(PDO::FETCH_OBJ) as $escala){
					$arreglo=array();
					$arreglo+=array('idsubactividad'=>$subactividad_array['id1']);
					$arreglo+=array('descripcion'=>$escala->descripcion);
					$arreglo+=array('minimo'=>$escala->minimo);
					$arreglo+=array('maximo'=>$escala->maximo);
					$x=$this->insert('escala_sub', $arreglo);
				}

				////////////Clonar Contexto
				$sql="select * from contexto where idsubactividad=:idsubactividad";
				$sth1 = $this->dbh->prepare($sql);
				$sth1->bindValue(":idsubactividad",$key->idsubactividad);
				$sth1->execute();

				foreach($sth1->fetchall(PDO::FETCH_OBJ) as $subkey){
					$arreglo=array();
					$arreglo+=array('idsubactividad'=>$subactividad_array['id1']);
					$arreglo+=array('tipo'=>$subkey->tipo);
					$arreglo+=array('observaciones'=>$subkey->observaciones);
					$arreglo+=array('texto'=>$subkey->texto);
					$arreglo+=array('orden'=>$subkey->orden);
					$arreglo+=array('incisos'=>$subkey->incisos);
					$arreglo+=array('usuario'=>$subkey->usuario);
					$arreglo+=array('descripcion'=>$subkey->descripcion);
					$x=$this->insert('contexto', $arreglo);
					$contexto_array=json_decode($x,true);

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
						$arreglo+=array('valor'=>$cont->valor);
						$x=$this->insert('respuestas', $arreglo);
					}
				}
			}
			return $x;
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}

	public function quitar_terapia(){
		$idterapia=clean_var($_REQUEST['idterapia']);
		$idpaciente=clean_var($_REQUEST['idpaciente']);

		$sql="select * from terapias_per where idterapia=:idterapia and idpaciente=:idpaciente";
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(":idterapia",$idterapia);
		$sth->bindValue(":idpaciente",$idpaciente);
		$sth->execute();
		if ($sth->rowCount()>0){
			$res=$sth->fetch(PDO::FETCH_OBJ);
			return $this->borrar('terapias_per',"id",$res->id);
		}
	}
	public function quitar_track(){
		$idtrack=clean_var($_REQUEST['idtrack']);
		$idpaciente=clean_var($_REQUEST['idpaciente']);

		$sql="select * from track_per where idtrack=:idtrack and idpaciente=:idpaciente";
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(":idtrack",$idtrack);
		$sth->bindValue(":idpaciente",$idpaciente);
		$sth->execute();
		if ($sth->rowCount()>0){
			$res=$sth->fetch(PDO::FETCH_OBJ);
			return $this->borrar('track_per',"id",$res->id);
		}
	}
	public function quitar_modulo(){
		$idmodulo=clean_var($_REQUEST['idmodulo']);
		$idpaciente=clean_var($_REQUEST['idpaciente']);

		$sql="select * from modulo_per where idmodulo=:idmodulo and idpaciente=:idpaciente";
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(":idmodulo",$idmodulo);
		$sth->bindValue(":idpaciente",$idpaciente);
		$sth->execute();
		if ($sth->rowCount()>0){
			$res=$sth->fetch(PDO::FETCH_OBJ);
			return $this->borrar('modulo_per',"id",$res->id);
		}
	}

	public function quitar_actividad(){
		$idactividad=clean_var($_REQUEST['idactividad']);
		$idpaciente=clean_var($_REQUEST['idpaciente']);

		$sql="select * from actividad_per where idactividad=:idactividad and idpaciente=:idpaciente";
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(":idactividad",$idactividad);
		$sth->bindValue(":idpaciente",$idpaciente);
		$sth->execute();
		if ($sth->rowCount()>1){
			$res=$sth->fetch(PDO::FETCH_OBJ);
			return $this->borrar('actividad_per',"id",$res->id);
		}
		else if($sth->rowCount()==1){
			return $this->borrar('actividad',"idactividad",$idactividad);
		}
	}

	public function buscar_actividad($b_actividad){
		try{
			$idpaciente=$_REQUEST['idpaciente'];
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
	public function agregar_actividadold(){
		try{
			$x="";
			$idactividad=$_REQUEST['idactividad'];
			$idpaciente=$_REQUEST['idpaciente'];

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
				$subactividad_array=json_decode($this->insert('subactividad', $arreglo),true);

				////////////Clonar Contexto
				$sql="select * from contexto where idsubactividad=:idsubactividad";
				$sth1 = $this->dbh->prepare($sql);
				$sth1->bindValue(":idsubactividad",$key->idsubactividad);
				$sth1->execute();

				foreach($sth1->fetchall(PDO::FETCH_OBJ) as $subkey){
					$arreglo=array();
					$arreglo+=array('idsubactividad'=>$subactividad_array['id1']);
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
						$x=$this->insert('respuestas', $arreglo);
					}
				}
			}
			return $x;
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

	public function modulo_editar($id){
		try{
			$sql="select * from modulo where id=:id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":id",$id);
			$sth->execute();
			return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
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
	public function actividad_inicial($id){
		try{
			$sql="select * from actividad where idtrack=:id and idpaciente is null";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":id",$id);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}

	/////////////////////
	public function terapias_paciente($id){
		try{
			$sql="SELECT * from terapias_per left outer join terapias on terapias.id=terapias_per.idterapia where terapias_per.idpaciente=:id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":id",$id);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
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

	public function respuestas_ver($id){
		try{
			$sql="select * from respuestas where idcontexto=:id order by id asc";
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

$db = new Cliente();
if(strlen($function)>0){
	echo $db->$function();
}
