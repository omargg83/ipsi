<?php
require_once("../control_db.php");

if($_SESSION['des']==1 and strlen($function)==0)
{
	echo "<div class='alert alert-primary' role='alert'>";
	$arrayx=explode('/', $_SERVER['SCRIPT_NAME']);
	echo print_r($arrayx);
	echo "</div>";
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
	public function guardar_terapia(){
		$x="";
		$arreglo =array();
		$idterapia=clean_var($_REQUEST['idterapia']);
		if (isset($_REQUEST['nombre'])){
			$arreglo+=array('nombre'=>clean_var($_REQUEST['nombre']));
		}
		if (isset($_REQUEST['descripcion'])){
			$arreglo+=array('descripcion'=>clean_var($_REQUEST['descripcion']));
		}
		if($idterapia==0){
			$x=$this->insert('terapias', $arreglo);

			$resp=json_decode($x);
			if (isset($_REQUEST['idpaciente'])){
				$idpaciente=$_REQUEST['idpaciente'];
				$arreglo =array();
				$arreglo+=array('idterapia'=>$resp->id1);
				$arreglo+=array('idpaciente'=>$idpaciente);
				$x=$this->insert('terapias_per',$arreglo);
			}
		}
		else{
			$x=$this->update('terapias',array('id'=>$idterapia), $arreglo);
		}
		return $x;
	}
	public function borrar_terapia(){
		if (isset($_REQUEST['idterapia'])){$idterapia=$_REQUEST['idterapia'];}
		return $this->borrar('terapias',"id",$idterapia);
	}

	public function track($id1){
		try{
			$sql="select * from track where idterapia=:id order by inicial desc";
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
	public function guardar_track(){
		$x="";
		$arreglo =array();
		$idtrack=clean_var($_REQUEST['idtrack']);
		if (isset($_REQUEST['nombre'])){
			$arreglo+=array('nombre'=>clean_var($_REQUEST['nombre']));
		}
		if (isset($_REQUEST['video'])){
			$arreglo+=array('video'=>$_REQUEST['video']);
		}
		if (isset($_REQUEST['descripcion'])){
			$arreglo+=array('descripcion'=>clean_var($_REQUEST['descripcion']));
		}
		if (isset($_REQUEST['inicial'])){
			$arreglo+=array('inicial'=>clean_var($_REQUEST['inicial']));
		}
		if($idtrack==0){
			$arreglo+=array('idterapia'=>clean_var($_REQUEST['idterapia']));
			$x=$this->insert('track', $arreglo);

			$resp=json_decode($x);
			if (isset($_REQUEST['idpaciente'])){
				$idpaciente=$_REQUEST['idpaciente'];
				$arreglo =array();
				$arreglo+=array('idtrack'=>$resp->id1);
				$arreglo+=array('idpaciente'=>$idpaciente);
				$x=$this->insert('track_per',$arreglo);
			}
		}
		else{
			$x=$this->update('track',array('id'=>$idtrack), $arreglo);
		}
		return $x;
	}
	public function borrar_track(){
		if (isset($_REQUEST['idtrack'])){$idtrack=$_REQUEST['idtrack'];}
		return $this->borrar('track',"id",$idtrack);
	}

	public function modulos($id){
		try{
			$sql="select * from modulo where idtrack=:id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":id",$id);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
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
	public function guardar_modulo(){
		$x="";
		$arreglo =array();
		$idmodulo=clean_var($_REQUEST['idmodulo']);

		if (isset($_REQUEST['nombre'])){
			$arreglo+=array('nombre'=>clean_var($_REQUEST['nombre']));
		}
		if (isset($_REQUEST['descripcion'])){
			$arreglo+=array('descripcion'=>clean_var($_REQUEST['descripcion']));
		}
		if($idmodulo==0){
			$arreglo+=array('idtrack'=>clean_var($_REQUEST['idtrack']));
			$x=$this->insert('modulo', $arreglo);

			$resp=json_decode($x);
			if (isset($_REQUEST['idpaciente'])){
				$idpaciente=$_REQUEST['idpaciente'];
				$arreglo =array();
				$arreglo+=array('idmodulo'=>$resp->id1);
				$arreglo+=array('idpaciente'=>$idpaciente);
				$x=$this->insert('modulo_per',$arreglo);
			}
		}
		else{
			$x=$this->update('modulo',array('id'=>$idmodulo), $arreglo);
		}
		return $x;
	}
	public function borrar_modulo(){
		if (isset($_REQUEST['idmodulo'])){$idmodulo=$_REQUEST['idmodulo'];}
		return $this->borrar('modulo',"id",$idmodulo);
	}

	public function actividad_lista($id){
		try{
			$sql="select * from actividad where idmodulo=:id and idpaciente is null";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":id",$id);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
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
			$idactividad=$_REQUEST['idactividad'];

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
			if (isset($_REQUEST['visible'])){
				$arreglo+=array('visible'=>clean_var($_REQUEST['visible']));
			}

			if (isset($_REQUEST['idmodulo'])){
				$arreglo+=array('idmodulo'=>clean_var($_REQUEST['idmodulo']));
			}

			if (isset($_REQUEST['idtrack'])){
				$arreglo+=array('idtrack'=>clean_var($_REQUEST['idtrack']));
			}

			if($idactividad==0){
				$arreglo+=array('fecha'=>date("Y-m-d H:i:s"));
				$arreglo+=array('idcreado'=>clean_var($_SESSION['idusuario']));
				if (isset($_REQUEST['idpaciente'])){
					$idpaciente=$_REQUEST['idpaciente'];
					$arreglo+=array('idpaciente'=>$idpaciente);
				}
				$x=$this->insert('actividad', $arreglo);

				$resp=json_decode($x);
				if (isset($_REQUEST['idpaciente'])){
					$idpaciente=$_REQUEST['idpaciente'];
					$arreglo =array();
					$arreglo+=array('idpaciente'=>$idpaciente);
					$arreglo+=array('idactividad'=>$resp->id1);
					$x=$this->insert('actividad_per',$arreglo);
				}
			}
			else{
				$x=$this->update('actividad',array('idactividad'=>$idactividad), $arreglo);
			}
			return $x;
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}
	public function borrar_actividad(){
		if (isset($_REQUEST['idactividad'])){$idactividad=$_REQUEST['idactividad'];}
		return $this->borrar('actividad',"idactividad",$idactividad);
	}
	public function publicar_actividad(){
		$idactividad=$_REQUEST['idactividad'];

		$sql="select * from actividad where idactividad=$idactividad";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		$resp=$sth->fetch(PDO::FETCH_OBJ);
		$fecha=date("Y-m-d H:i:s");

		////////////Clonar actividad
		$arreglo=array();
		$arreglo+=array('idmodulo'=>$resp->idmodulo);
		$arreglo+=array('idtrack'=>$resp->idtrack);
		$arreglo+=array('idcreado'=>$resp->idcreado);
		$arreglo+=array('nombre'=>$resp->nombre);
		$arreglo+=array('indicaciones'=>$resp->indicaciones);
		$arreglo+=array('observaciones'=>$resp->observaciones);
		$arreglo+=array('tipo'=>$resp->tipo);
		$arreglo+=array('fecha'=>$fecha);
		$x=$this->insert('actividad', $arreglo);
		$idactividad_array=json_decode($x,true);

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

			/////////////////clonar Escala subactividad
			$sql="select * from escala_sub where idsubactividad=$key->idsubactividad";
			$sty = $this->dbh->prepare($sql);
			$sty->execute();
			foreach($sty->fetchall(PDO::FETCH_OBJ) as $escala_sub){
				$arreglo=array();
				$arreglo+=array('descripcion'=>$escala_sub->descripcion);
				$arreglo+=array('minimo'=>$escala_sub->minimo);
				$arreglo+=array('maximo'=>$escala_sub->maximo);
				$arreglo+=array('idsubactividad'=>$subactividad_array['id1']);
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
					$x=$this->insert('respuestas', $arreglo);
				}
			}
		}
		return $x;
	}

	public function guarda_escala(){
		try{
			$arreglo=array();
			$x="";
			$idescala=$_REQUEST['idescala'];
			$idsubactividad=$_REQUEST['idsubactividad'];
			$descripcion=$_REQUEST['descripcion'];
			$minimo=$_REQUEST['minimo'];
			$maximo=$_REQUEST['maximo'];

			$arreglo+=array('descripcion'=>$descripcion);
			$arreglo+=array('minimo'=>$minimo);
			$arreglo+=array('maximo'=>$maximo);

			if($idescala==0){

				$arreglo+=array('idsubactividad'=>$idsubactividad);
				$x=$this->insert('escala_sub',$arreglo);
			}
			else{
				$x=$this->update('escala_sub',array('id'=>$idescala), $arreglo);
			}
			return $x;
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}
	public function borrar_escala(){
		if (isset($_REQUEST['idescala'])){$idescala=$_REQUEST['idescala'];}
		return $this->borrar('escala_sub',"id",$idescala);
	}

	public function guarda_escalaglobal(){
		try{
			$arreglo=array();
			$x="";
			$idescala=$_REQUEST['idescala'];
			$idactividad=$_REQUEST['idactividad'];
			$nombre=$_REQUEST['nombre'];

			$arreglo+=array('nombre'=>$nombre);

			if($idescala==0){
				$arreglo+=array('idactividad'=>$idactividad);
				$x=$this->insert('escala_actividad',$arreglo);
			}
			else{
				$x=$this->update('escala_actividad',array('id'=>$idescala), $arreglo);
			}
			return $x;
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}
	public function guarda_escalaact(){
		try{
			$arreglo=array();
			$x="";
			$id=$_REQUEST['id'];
			$idescala=$_REQUEST['idescala'];
			$descripcion=$_REQUEST['descripcion'];
			$minimo=$_REQUEST['minimo'];
			$maximo=$_REQUEST['maximo'];

			$arreglo+=array('descripcion'=>$descripcion);
			$arreglo+=array('minimo'=>$minimo);
			$arreglo+=array('maximo'=>$maximo);

			if($id==0){
				$arreglo+=array('idescala'=>$idescala);
				$x=$this->insert('escala_act',$arreglo);
			}
			else{
				$x=$this->update('escala_act',array('id'=>$id), $arreglo);
			}
			return $x;
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}

	public function borrar_escalaactitivdad(){
		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		return $this->borrar('escala_actividad',"id",$id);
	}
	public function borrar_escalaact(){
		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		return $this->borrar('escala_act',"id",$id);
	}
	public function borrar_escalacont(){
		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		return $this->borrar('escala_contexto',"id",$id);
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
			$idsubactividad=clean_var($_REQUEST['idsubactividad']);
			$idactividad=clean_var($_REQUEST['idactividad']);

			$nombre=clean_var($_REQUEST['nombre']);
			$arreglo+=array('nombre'=>$nombre);

			if (isset($_REQUEST['orden'])){
				$arreglo+=array('orden'=>clean_var($_REQUEST['orden']));
			}
			if (isset($_REQUEST['pagina'])){
				$arreglo+=array('pagina'=>clean_var($_REQUEST['pagina']));
			}
			if($idsubactividad==0){
				$arreglo+=array('idactividad'=>$idactividad);
				$x=$this->insert('subactividad', $arreglo);
			}
			else{
				$x=$this->update('subactividad',array('idsubactividad'=>$idsubactividad), $arreglo);
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
	public function subactividad_borrar(){
		if (isset($_REQUEST['idsubactividad'])){$idsubactividad=$_REQUEST['idsubactividad'];}
		return $this->borrar('subactividad',"idsubactividad",$idsubactividad);
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
	public function guarda_contexto(){
		try{
			$arreglo=array();
			$x="";
			$id1=clean_var($_REQUEST['id1']);
			$tipo=clean_var($_REQUEST['tipo']);
			$arreglo+=array('tipo'=>$tipo);

			if(isset($_REQUEST['orden'])){
				$arreglo+=array('orden'=>clean_var($_REQUEST['orden']));
			}

			if(isset($_REQUEST['observaciones'])){
				$arreglo+=array('observaciones'=>clean_var($_REQUEST['observaciones']));
			}

			if($tipo=="texto"){
				$arreglo+=array('texto'=>$_REQUEST['texto']);
			}
			if($tipo=="video"){
				$arreglo+=array('texto'=>$_REQUEST['texto']);
			}
			if($tipo=="pregunta"){
				$arreglo+=array('texto'=>clean_var($_REQUEST['texto']));
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
					$arreglo+=array('usuario'=>null);
				}
			}
			if($tipo=="archivores" or $tipo=="textores" or $tipo=="pregunta" or $tipo=="fecha"){
				$arreglo+=array('evalua'=>1);
			}

			if($tipo=="imagen" or $tipo=="archivo"){
				$extension = '';
				$ruta = '../a_archivos/respuestas/';
				$archivo = $_FILES['texto']['tmp_name'];
				$nombrearchivo = $_FILES['texto']['name'];
				$tmp=$_FILES['texto']['tmp_name'];
				$info = pathinfo($nombrearchivo);
				if($archivo!=""){
					$extension = $info['extension'];
					if($tipo=="imagen"){
						if ($extension=='png' || $extension=='PNG' || $extension=='jpg'  || $extension=='JPG') {
						$nombreFile = "resp_".date("YmdHis").rand(0000,9999).".".$extension;
						move_uploaded_file($tmp,$ruta.$nombreFile);
						$ruta=$ruta."/".$nombreFile;
						$arreglo+=array('texto'=>$nombreFile);
					}
						else{

						echo "fail";
						exit;
					}
					}
					else{
						if ($extension=='pdf' || $extension=='doc' || $extension=='docx') {
							$nombreFile = "resp_".date("YmdHis").rand(0000,9999).".".$extension;
							move_uploaded_file($tmp,$ruta.$nombreFile);
							$ruta=$ruta."/".$nombreFile;
							$arreglo+=array('texto'=>$nombreFile);
						}
						else{
							echo "fail";
							exit;
						}
					}
				}
			}

			if($id1==0){
				$arreglo+=array('idsubactividad'=>clean_var($_REQUEST['idsubactividad']));
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
	public function contexto_borrar(){
		if (isset($_REQUEST['idcontexto'])){$idcontexto=$_REQUEST['idcontexto'];}
		return $this->borrar('contexto',"id",$idcontexto);
	}
	public function contexto_duplicar(){
		try{
			$idcontexto=$_REQUEST['idcontexto'];
			$x="1";
			////////////Clonar Contexto
			$sql="select * from contexto where id=:idcontexto";
			$sth1 = $this->dbh->prepare($sql);
			$sth1->bindValue(":idcontexto",$idcontexto);
			$sth1->execute();

			foreach($sth1->fetchall(PDO::FETCH_OBJ) as $subkey){
				$arreglo=array();
				$arreglo+=array('idsubactividad'=>$subkey->idsubactividad);
				$arreglo+=array('tipo'=>$subkey->tipo);
				$arreglo+=array('observaciones'=>$subkey->observaciones);
				$arreglo+=array('texto'=>$subkey->texto);
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
					$x=$this->insert('respuestas', $arreglo);
				}
			}
			return $x;
		}
		catch(PDOException $e){
			return json_encode($e->getMessage());
		}
	}

	public function guarda_respuesta(){
		try{
			$arreglo=array();
			$x="";
			$idrespuesta=clean_var($_REQUEST['idrespuesta']);
			$nombre=clean_var($_REQUEST['nombre']);
			$idcontexto=clean_var($_REQUEST['idcontexto']);

			if(isset($_REQUEST['valor'])){
				$valor=clean_var($_REQUEST['valor']);
				/*
				$sql="select * from respuestas where idcontexto=$idcontexto and valor=$valor and id!=$idrespuesta";
				$sth = $this->dbh->prepare($sql);
				$sth->execute();
				if($sth->rowCount()>0){
					$arreglo=array();
					$arreglo+=array('error'=>1);
					$arreglo+=array('terror'=>"Ya existe respuesta con el valor");
					return json_encode($arreglo);
				}
				*/
			}
			else{
				$sql="select max(valor) as total from respuestas where idcontexto=$idcontexto";
				$sth = $this->dbh->prepare($sql);
				$sth->execute();
				if($sth->rowCount()==0){
					$valor=0;
				}
				else{
					$resp=$sth->fetch(PDO::FETCH_OBJ);
					$valor=$resp->total+1;
				}
			}

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
			if (isset($_REQUEST['orden'])){
				$arreglo+=array('orden'=>clean_var($_REQUEST['orden']));
			}

			$arreglo+=array('nombre'=>$nombre);
			$arreglo+=array('valor'=>$valor);

			if($idrespuesta==0){
				$arreglo+=array('idcontexto'=>$idcontexto);
				$x=$this->insert('respuestas', $arreglo);
			}
			else{
				$x=$this->update('respuestas',array('id'=>$idrespuesta), $arreglo);
			}
			return $x;
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
	public function respuesta_borrar(){
		if (isset($_REQUEST['idrespuesta'])){$idrespuesta=$_REQUEST['idrespuesta'];}
		return $this->borrar('respuestas',"id",$idrespuesta);
	}

	public function guardar_condicion(){
		$idcond=$_REQUEST['idcond'];
		$idcontexto=$_REQUEST['idcontexto'];

		$arreglo=array();
		if(strlen($idcond)>0){
			$arreglo+=array('idcond'=>$idcond);
		}
		else{
			$arreglo+=array('idcond'=>null);
		}

		$x=$this->update('contexto',array('id'=>$idcontexto), $arreglo);
		return $x;
	}
	public function guardar_evalua(){
		$id=$_REQUEST['id'];
		$idcontexto=$_REQUEST['idcontexto'];
		$idescala=$_REQUEST['idescala'];

		$arreglo=array();
		$arreglo+=array('idescala'=>$idescala);
		$arreglo+=array('idcontexto'=>$idcontexto);
		if($id==0){
			$x=$this->insert('escala_contexto',$arreglo);
		}
		else{
			$x=$this->update('escala_contexto',array('id'=>$id), $arreglo);
		}
		return $x;
	}
	public function orden_subact(){
		$orden=$_REQUEST['destino'];
		$idsubactividad=$_REQUEST['id'];

		$sql="select * from subactividad where idsubactividad=$idsubactividad";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		$subac=$sth->fetch(PDO::FETCH_OBJ);


		$sql="select * from subactividad where idactividad=$subac->idactividad order by orden asc";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		$subact=$sth->fetchall(PDO::FETCH_OBJ);
		$contar=1;
		echo "orden:".$orden;
		foreach($subact as $v2){

			$arreglo =array();
			if($v2->idsubactividad==$idsubactividad){
				$arreglo+=array('orden'=>$orden);
			}
			else{
				$arreglo+=array('orden'=>$contar);
				$contar++;
			}
			$this->update('subactividad',array('idsubactividad'=>$v2->idsubactividad), $arreglo);
		}
	}
}

$db = new Cuest();
if(strlen($function)>0){
  echo $db->$function();
}

?>
