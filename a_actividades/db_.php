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

class Cuest extends ipsi{
	public function __construct(){
		parent::__construct();
		$this->doc="a_archivos/respuestas/";

	}

	public function terapias(){
		try{
			$sql="select * from terapias order by orden asc";
			$sth = $this->dbh->query($sql);
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
			$arreglo+=array('orden'=>99999);
			$x=$this->insert('terapias', $arreglo);

			$resp=json_decode($x);
			if (isset($_REQUEST['idpaciente'])){
				$idpaciente=$_REQUEST['idpaciente'];
				$arreglo =array();
				$arreglo+=array('idterapia'=>$resp->id1);
				$arreglo+=array('idpaciente'=>$idpaciente);
				$arreglo+=array('idterapeuta'=>$_SESSION['idusuario']);
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

		$sql="SELECT * from track where idterapia='$idterapia' order by track.inicial asc, track.orden asc";
		$sth = $this->dbh->query($sql);
		if($sth->rowCount()>0){
			$arreglo=array();
			$arreglo+=array('id1'=>0);
			$arreglo+=array('error'=>1);
			$arreglo+=array('terror'=>'Contiene track');
			return json_encode($arreglo);
		}
		return $this->borrar('terapias',"id",$idterapia);
	}

	public function track($id1){
		try{
			$sql="select * from track where idterapia=$id1 order by inicial desc, orden asc";
			$sth = $this->dbh->query($sql);
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

		$sql="select * from modulo where idtrack=$idtrack order by modulo.orden asc";
		$sth = $this->dbh->query($sql);
		if($sth->rowCount()>0){
			$arreglo=array();
			$arreglo+=array('id1'=>0);
			$arreglo+=array('error'=>1);
			$arreglo+=array('terror'=>'Contiene modulos');
			return json_encode($arreglo);
		}

		$sql="select * from grupo_actividad where idtrack=$idtrack";
		$sth = $this->dbh->query($sql);
		if($sth->rowCount()>0){
			$arreglo=array();
			$arreglo+=array('id1'=>0);
			$arreglo+=array('error'=>1);
			$arreglo+=array('terror'=>'Contiene grupos');
			return json_encode($arreglo);
		}
		return $this->borrar('track',"id",$idtrack);
	}

	public function modulos($id){
		try{
			$sql="select * from modulo where idtrack=$id order by modulo.orden asc";
			$sth = $this->dbh->query($sql);
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
		$sql="select * from grupo_actividad where idmodulo=$idmodulo";
		$sth = $this->dbh->query($sql);
		if($sth->rowCount()>0){
			$arreglo=array();
			$arreglo+=array('id1'=>0);
			$arreglo+=array('error'=>1);
			$arreglo+=array('terror'=>'Contiene Grupos');
			return json_encode($arreglo);
		}
		return $this->borrar('modulo',"id",$idmodulo);
	}

	public function actividad_lista($id){
		try{
			$sql="select * from actividad where idmodulo=$id and idpaciente is null";
			$sth = $this->dbh->query($sql);
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
			$sql="select * from actividad where idactividad=$id";
			$sth = $this->dbh->query($sql);
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

			if (isset($_REQUEST['idgrupo'])){
				$arreglo+=array('idgrupo'=>clean_var($_REQUEST['idgrupo']));
			}

			if($idactividad==0){
				$arreglo+=array('orden'=>9999);
				$arreglo+=array('fecha'=>date("Y-m-d H:i:s"));
				$arreglo+=array('idcreado'=>clean_var($_SESSION['idusuario']));
				if (isset($_REQUEST['idpaciente'])){
					$idpaciente=$_REQUEST['idpaciente'];
					$arreglo+=array('idpaciente'=>$idpaciente);
					$this->update('clientes',array('id'=>$idpaciente),array("estatus"=>"ACTIVO"));
				}
				$x=$this->insert('actividad', $arreglo);

				$resp=json_decode($x);
				if (isset($_REQUEST['idpaciente'])){
					$idpaciente=$_REQUEST['idpaciente'];
					$arreglo =array();
					$arreglo+=array('idpaciente'=>$idpaciente);
					$arreglo+=array('idactividad'=>$resp->id1);
					$this->insert('actividad_per',$arreglo);
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
		$sth = $this->dbh->query($sql);
		$resp=$sth->fetch(PDO::FETCH_OBJ);
		$fecha=date("Y-m-d H:i:s");

		////////////Clonar actividad
		$arreglo=array();
		$arreglo+=array('idgrupo'=>$resp->idgrupo);
		$arreglo+=array('idcreado'=>$resp->idcreado);
		$arreglo+=array('nombre'=>$resp->nombre);
		$arreglo+=array('indicaciones'=>$resp->indicaciones);
		$arreglo+=array('observaciones'=>$resp->observaciones);
		$arreglo+=array('tipo'=>$resp->tipo);
		$arreglo+=array('fecha'=>$fecha);
		$x=$this->insert('actividad', $arreglo);
		$idactividad_array=json_decode($x,true);
		$idactividad_nueva=$idactividad_array['id1'];

		//////////////////clonar escala_sub
		$sql="select * from escala_actividad where idactividad=$idactividad";
		$sth = $this->dbh->query($sql);
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
		$sql="select * from subactividad where idactividad=$idactividad";
		$sth = $this->dbh->query($sql);

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
			$sty = $this->dbh->query($sql);

			foreach($sty->fetchall(PDO::FETCH_OBJ) as $escala_sub){
				$arreglo=array();
				$arreglo+=array('descripcion'=>$escala_sub->descripcion);
				$arreglo+=array('minimo'=>$escala_sub->minimo);
				$arreglo+=array('maximo'=>$escala_sub->maximo);
				$arreglo+=array('idsubactividad'=>$subactividad_array['id1']);
				$x=$this->insert('escala_sub', $arreglo);
			}

			////////////Clonar Contexto
			$sql="select * from contexto where idsubactividad=$key->idsubactividad";
			$sth1 = $this->dbh->query($sql);

			foreach($sth1->fetchall(PDO::FETCH_OBJ) as $subkey){
				$arreglo=array();
				$arreglo+=array('idsubactividad'=>$subactividad_array['id1']);
				$arreglo+=array('tipo'=>$subkey->tipo);
				$arreglo+=array('observaciones'=>$subkey->observaciones);
				$arreglo+=array('texto'=>$subkey->texto);
				$arreglo+=array('incisos'=>$subkey->incisos);
				$arreglo+=array('usuario'=>$subkey->usuario);
				$arreglo+=array('descripcion'=>$subkey->descripcion);
				$arreglo+=array('idcond'=>$subkey->idcond);
				$x=$this->insert('contexto', $arreglo);
				$contexto_array=json_decode($x,true);

				////////////Clonar respuestas
				$sql="select * from respuestas where idcontexto=$subkey->id";
				$sth2 = $this->dbh->query($sql);

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
		$condix = $this->dbh->query($sql);

		$shy=$condix->fetchAll(PDO::FETCH_OBJ);
		foreach($shy as $v1){

			$sql="select respuestas.id as pre, contexto.id from respuestas
			left outer join contexto on contexto.id=respuestas.idcontexto
			left outer join subactividad on subactividad.idsubactividad=contexto.idsubactividad
			where idactividad='".$idactividad_nueva."' and pre='".$v1->idcond."'";
			$inserta = $this->dbh->query($sql);
			$inx=$inserta->fetch(PDO::FETCH_OBJ);

			$arreglo=array();
			$arreglo+=array('idcond'=>$inx->pre);
			$x=$this->update('contexto',array('id'=>$v1->id), $arreglo);
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

			if(isset($_REQUEST['pagina'])){
				$arreglo+=array('pagina'=>clean_var($_REQUEST['pagina']));
			}

			if(isset($_REQUEST["texto_".$id1])){
				$arreglo+=array('texto'=>$_REQUEST["texto_".$id1]);
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
			///////////////////////////////////////////////////////////
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
				$arreglo+=array('orden'=>$subkey->orden);

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

	public function subactividad_duplicar(){
		$idsubactividad=$_REQUEST['idsubactividad'];
		$sql="select * from subactividad where idsubactividad=$idsubactividad order by orden asc";
		$sth = $this->dbh->query($sql);
		$sub=$sth->fetch(PDO::FETCH_OBJ);

		///////////clonar subactividad
		$arreglo=array();
		$arreglo+=array('pagina'=>$sub->pagina);
		$arreglo+=array('orden'=>999999);
		$arreglo+=array('idactividad'=>$sub->idactividad);
		$arreglo+=array('nombre'=>$sub->nombre." Duplicada");

		$x=$this->insert('subactividad', $arreglo);
		$sub_nueva=json_decode($x,true);

		/////////////////clonar Escala subactividad
		$sql="select * from escala_sub where idsubactividad=$idsubactividad";
		$sty = $this->dbh->query($sql);
		foreach($sty->fetchall(PDO::FETCH_OBJ) as $escala_sub){
			$arreglo=array();
			$arreglo+=array('idsubactividad'=>$sub_nueva['id1']);
			$arreglo+=array('descripcion'=>$escala_sub->descripcion);
			$arreglo+=array('minimo'=>$escala_sub->minimo);
			$arreglo+=array('maximo'=>$escala_sub->maximo);
			$x=$this->insert('escala_sub', $arreglo);
		}

		////////////Clonar Contexto
		$sql="select * from contexto where idsubactividad=$idsubactividad";
		$sth1 = $this->dbh->query($sql);

		foreach($sth1->fetchall(PDO::FETCH_OBJ) as $subkey){
			$arreglo=array();
			$arreglo+=array('idsubactividad'=>$sub_nueva['id1']);
			$arreglo+=array('tipo'=>$subkey->tipo);
			$arreglo+=array('observaciones'=>$subkey->observaciones);
			$arreglo+=array('texto'=>$subkey->texto);
			$arreglo+=array('incisos'=>$subkey->incisos);
			$arreglo+=array('usuario'=>$subkey->usuario);
			$arreglo+=array('descripcion'=>$subkey->descripcion);
			$arreglo+=array('idcond'=>$subkey->idcond);
			$x=$this->insert('contexto', $arreglo);
			$contexto_nuevo=json_decode($x,true);

			////////////Clonar respuestas
			$sql="select * from respuestas where idcontexto=$subkey->id";
			$sth2 = $this->dbh->query($sql);

			foreach($sth2->fetchall(PDO::FETCH_OBJ) as $cont){
				$arreglo=array();
				$arreglo+=array('idcontexto'=>$contexto_nuevo['id1']);
				$arreglo+=array('orden'=>$cont->orden);
				$arreglo+=array('nombre'=>$cont->nombre);
				$arreglo+=array('imagen'=>$cont->imagen);
				$arreglo+=array('valor'=>$cont->valor);
				$arreglo+=array('pre'=>$cont->id);
				$x=$this->insert('respuestas', $arreglo);
			}
		}

		///////////////////////condicionales
		$sql="select contexto.* from contexto
		left outer join subactividad on contexto.idsubactividad=subactividad.idsubactividad
		where subactividad.idsubactividad='".$sub_nueva['id1']."' and contexto.idcond is not null";
		$condix = $this->dbh->query($sql);
		$shy=$condix->fetchAll(PDO::FETCH_OBJ);
		foreach($shy as $v1){

			$sql="select respuestas.id as pre, contexto.id from respuestas
			left outer join contexto on contexto.id=respuestas.idcontexto
			left outer join subactividad on subactividad.idsubactividad=contexto.idsubactividad
			where subactividad.idsubactividad='".$sub_nueva['id1']."' and pre='".$v1->idcond."'";
			$inserta = $this->dbh->query($sql);
			$inx=$inserta->fetch(PDO::FETCH_OBJ);

			$arreglo=array();
			$arreglo+=array('idcond'=>$inx->pre);
			$x=$this->update('contexto',array('id'=>$v1->id), $arreglo);

		}
		return $x;
	}
	public function actividad_duplicar(){
		$idactividad=$_REQUEST['idactividad'];
		$arreglo=array();

		$paciente=0;


		$sql="select * from actividad where idactividad=$idactividad";
		$sth = $this->dbh->query($sql);
		$resp=$sth->fetch(PDO::FETCH_OBJ);
		$fecha=date("Y-m-d H:i:s");

		if(isset($_REQUEST['idpaciente'])){
			$idpaciente=$_REQUEST['idpaciente'];
			$arreglo+=array('idpaciente'=>$resp->idpaciente);
			$paciente=1;
		}

		////////////Clonar actividad

		$arreglo+=array('idgrupo'=>$resp->idgrupo);
		$arreglo+=array('idcreado'=>$resp->idcreado);
		$arreglo+=array('nombre'=>$resp->nombre." Duplicada");
		$arreglo+=array('indicaciones'=>$resp->indicaciones);
		$arreglo+=array('observaciones'=>$resp->observaciones);
		$arreglo+=array('tipo'=>$resp->tipo);
		$arreglo+=array('fecha'=>$fecha);
		$x=$this->insert('actividad', $arreglo);
		$actividad_nueva=json_decode($x,true);
		$idactividad_nueva=$actividad_nueva['id1'];

		//////////////para los permisos
		if($paciente==1){
			$arreglo=array();
			$arreglo+=array('idactividad'=>$idactividad_nueva);
			$arreglo+=array('idpaciente'=>$idpaciente);
			$x=$this->insert('actividad_per', $arreglo);
		}

		//////////////////clonar escala_sub
		$sql="select * from escala_actividad where idactividad=$idactividad";
		$sth = $this->dbh->query($sql);
		foreach($sth->fetchall(PDO::FETCH_OBJ) as $v2){
			$arreglo=array();
			$arreglo+=array('nombre'=>$v2->nombre);
			$arreglo+=array('idactividad'=>$actividad_nueva['id1']);
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
		$sql="select * from subactividad where idactividad=$idactividad";
		$sth = $this->dbh->query($sql);

		foreach($sth->fetchall(PDO::FETCH_OBJ) as $key){
			$arreglo=array();
			$arreglo+=array('nombre'=>$key->nombre);
			$arreglo+=array('orden'=>$key->orden);
			$arreglo+=array('pagina'=>$key->pagina);
			$arreglo+=array('idactividad'=>$actividad_nueva['id1']);
			$x=$this->insert('subactividad', $arreglo);
			$subactividad_array=json_decode($x,true);

			/////////////////clonar Escala subactividad
			$sql="select * from escala_sub where idsubactividad=$key->idsubactividad";
			$sty = $this->dbh->query($sql);

			foreach($sty->fetchall(PDO::FETCH_OBJ) as $escala_sub){
				$arreglo=array();
				$arreglo+=array('descripcion'=>$escala_sub->descripcion);
				$arreglo+=array('minimo'=>$escala_sub->minimo);
				$arreglo+=array('maximo'=>$escala_sub->maximo);
				$arreglo+=array('idsubactividad'=>$subactividad_array['id1']);
				$x=$this->insert('escala_sub', $arreglo);
			}

			////////////Clonar Contexto
			$sql="select * from contexto where idsubactividad=$key->idsubactividad";
			$sth1 = $this->dbh->query($sql);

			foreach($sth1->fetchall(PDO::FETCH_OBJ) as $subkey){
				$arreglo=array();
				$arreglo+=array('idsubactividad'=>$subactividad_array['id1']);
				$arreglo+=array('tipo'=>$subkey->tipo);
				$arreglo+=array('observaciones'=>$subkey->observaciones);
				$arreglo+=array('texto'=>$subkey->texto);
				$arreglo+=array('incisos'=>$subkey->incisos);
				$arreglo+=array('usuario'=>$subkey->usuario);
				$arreglo+=array('descripcion'=>$subkey->descripcion);
				$arreglo+=array('idcond'=>$subkey->idcond);
				$x=$this->insert('contexto', $arreglo);
				$contexto_array=json_decode($x,true);

				////////////Clonar respuestas
				$sql="select * from respuestas where idcontexto=$subkey->id";
				$sth2 = $this->dbh->query($sql);

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
		$condix = $this->dbh->query($sql);

		$shy=$condix->fetchAll(PDO::FETCH_OBJ);
		foreach($shy as $v1){

			$sql="select respuestas.id as pre, contexto.id from respuestas
			left outer join contexto on contexto.id=respuestas.idcontexto
			left outer join subactividad on subactividad.idsubactividad=contexto.idsubactividad
			where idactividad='".$idactividad_nueva."' and pre='".$v1->idcond."'";
			$inserta = $this->dbh->query($sql);
			$inx=$inserta->fetch(PDO::FETCH_OBJ);

			$arreglo=array();
			$arreglo+=array('idcond'=>$inx->pre);
			$x=$this->update('contexto',array('id'=>$v1->id), $arreglo);
		}
		return $x;
	}

	public function contexto_actividades($idcontexto, $idactividad){
		$sql="select * from contexto where id=$idcontexto";
		$sth = $this->dbh->query($sql);
		$row=$sth->fetch(PDO::FETCH_OBJ);

		echo "<div class='card mt-2 ml-5'>";
			echo "<div class='card-header'>";
				echo "<div class='row'>";
					echo "<div class='col-4'>";
						//////////////////<!-- Editar Contexto --->
						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/contexto_editar' v_idcontexto='$row->id' omodal='1'><i class='fas fa-pencil-alt'></i></button>";

						///////////////editar incisos
						if($row->tipo=="pregunta"){
							echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/incisos_lista' v_idcontexto='$row->id' v_idactividad='$idactividad' omodal='1'><i class='fas fa-tasks'></i></button>";
						}

						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='contexto_duplicar' v_idactividad='$idactividad' v_idcontexto='$row->id' tp='¿Desea duplicar el bloque?' title='Borrar'><i class='far fa-copy'></i></button>";

						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='contexto_borrar' v_idactividad='$idactividad' v_idcontexto='$row->id' tp='¿Desea eliminar el bloque seleccionado?' tt='Ya no podrá deshacer el cambio' title='Borrar'><i class='far fa-trash-alt'></i></button>";

						echo "<button "; if($row->idcond){ echo "class='btn btn-danger btn-sm'"; } else { echo "class='btn btn-warning btn-sm'"; } echo "type='button' is='b-link' des='a_actividades_e/condicional_editar' v_idactividad='$idactividad' omodal='1' v_idcontexto='$row->id' title='Condicionar'><i class='fas fa-project-diagram'></i></button>";

						echo "<button "; if($row->salto){ echo "class='btn btn-danger btn-sm' "; } else { echo "class='btn btn-warning btn-sm'"; } echo " type='button' is='b-link' des='a_actividades/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='salto_pagina' tp='¿Desea";
						if(!$row->salto){ echo " insertar ";} else{ echo " quitar el ";}
						echo "salto de pagina?' v_idactividad='$idactividad' v_idcontexto='$row->id' v_salto='$row->salto' title='Salto de página'><i class='far fa-sticky-note'></i></button>";

						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' db='a_actividades/db_' fun='contexto_mover' des='a_actividades/actividad_ver' v_idactividad='$idactividad' v_idcontexto='$row->id' v_dir='0' dix='trabajo' title='Mover arriba'><i class='fas fa-chevron-up'></i></button>";

						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' db='a_actividades/db_' fun='contexto_mover' des='a_actividades/actividad_ver' v_idactividad='$idactividad' v_idcontexto='$row->id' v_dir='1' dix='trabajo' title='Mover abajo'><i class='fas fa-chevron-down'></i></button>";

					echo "</div>";
					echo "<div class='col-8'>";
							echo "Contexto ($row->tipo)";
					echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='card-body'>";

				if(strlen($row->observaciones)>0){
					echo "<div>";
						echo "<p>".$row->observaciones."</p>";
					echo "</div>";
					echo "<hr>";
				}
				if($row->tipo=="imagen"){
					echo "<div>";
						echo "<img src='".$this->doc.$row->texto."'/>";
						echo "<hr>";
					echo "</div>";
				}
				else if($row->tipo=="texto"){
					echo "<div>";
						echo $row->texto;
						echo "<hr>";
					echo "</div>";
				}
				else if($row->tipo=="video"){
					echo "<div>";
						echo $row->texto;
						echo "<hr>";
					echo "</div>";
				}
				else if($row->tipo=="archivo"){
					echo "<div>";
						echo "<a href='".$this->doc.$row->texto."' download='$row->texto'>Descargar</a>";
						echo "<hr>";
					echo "</div>";
				}
				else if($row->tipo=="pregunta"){
					echo "<div>";
						echo $row->texto;
						echo "<hr>";
					echo "</div>";
				}
				else if($row->tipo=="textores"){
					echo "<div>";
						echo "<textarea class='form-control' class='' id='texto' name='texto' rows=5 placeholder=''>$row->texto</textarea>";
						echo "<hr>";
					echo "</div>";
				}
				else if($row->tipo=="textocorto"){
					echo "<div>";
						echo "<input type='text' class='form-control' id='texto' name='texto' rows=5 placeholder=''>$row->texto</input>";
						echo "<hr>";
					echo "</div>";
				}
				else if($row->tipo=="fecha"){
					echo "<div>";
						echo "<input type='date' name='texto' id='texto' value='$row->texto' class='form-control'>";
						echo "<hr>";
					echo "</div>";
				}
				else if($row->tipo=="archivores"){
					echo "<div>";
						echo "<input type='file' name='texto' id='texto' class='form-control'>";
						echo "<hr>";
					echo "</div>";
				}

				//////<!-- Fin de contexto  -->
				//////<!-- Preguntas  -->
				echo "<div class='container-fluid'>";
						$rx=$this::respuestas_ver($row->id);
						if(strlen($row->incisos)==0 and $row->tipo=="pregunta" and strlen($row->personalizado)==0 ){
							echo "<div class='row'>";
								echo "<div class='col-8'>";
									echo "<select class='form-control'>";
									foreach ($rx as $respuesta) {
										echo "<option>$respuesta->nombre (".$respuesta->valor.")</option>";
									}
									echo "</select>";
								echo "</div>";
								echo "<div class='col-4'>";
									if($row->usuario==1){
										echo "<input type='text' name='' value='' placeholder='Define..' class='form-control'>";
									}
								echo "</div>";
							echo "</div>";
						}
						else{
							foreach ($rx as $respuesta) {
								echo "<div class='row'>";
									echo "<div class='col-1'>";
										if($row->incisos==1){
											echo "<input type='checkbox' name='' value=''>";
										}
										else{
											echo "<input type='radio' id='resp_".$row->id."' name='resp_".$row->id."' value='1'>";
										}
									echo "</div>";
									if (strlen($respuesta->imagen)>0){
										echo "<div class='col-1'>";
											echo "<img src='".$this->doc.$respuesta->imagen."' width='20px'>";
										echo "</div>";
									}
									echo "<div class='col-5'>";
										echo $respuesta->nombre;
										echo "(".$respuesta->valor.")";
									echo "</div>";
									echo "<div class='col-4'>";
										if($row->usuario==1){
											echo "<input type='text' name='' value='' placeholder='Define..' class='form-control'>";
										}
									echo "</div>";
								echo "</div>";
							}
							if($row->personalizado==1){
								echo "<div class='row'>";
									echo "<div class='col-1'>";
										if($row->incisos==1){
											echo "<input type='checkbox' name='' value=''>";
										}
										else{
											echo "<input type='radio' id='resp_".$row->id."' name='resp_".$row->id."' value='1'>";
										}
									echo "</div>";
									echo "<div class='col-3'>";
										echo "<input type='text' class='form-control' name='' value=''>";
									echo "</div>";
								echo "</div>";
							}
						}
				echo "</div>";
				if($row->tipo=="pregunta"){
					echo "<br>";
					echo "<div class='row'>";
						echo "<div class='col-12'>";
							echo "<button class='btn btn-warning' type='button' is='b-link' des='a_actividades_e/inciso_editar' v_idrespuesta='0' v_idcontexto='$row->id' v_idactividad='$idactividad' omodal='1' >Agregar inciso</button>";
						echo "</div>";
					echo "</div>";
				}
				//////////////////<!-- Fin Preguntas  -->
			echo "</div>";
		echo "</div>";
	}

	public function actividad_mover(){
		$idactividad=$_REQUEST['idactividad'];
		$dir=$_REQUEST['dir'];

		$sql="select * from actividad where idactividad=$idactividad";
		$sth = $this->dbh->query($sql);
		$actividad=$sth->fetch(PDO::FETCH_OBJ);
		if($dir==0){
			$orden=$actividad->orden-1.5;
		}
		else{
			$orden=$actividad->orden+1.5;
		}
		$arreglo=array();
		$arreglo+=array('orden'=>$orden);
		$x=$this->update('actividad',array('idactividad'=>$actividad->idactividad), $arreglo);
		return $x;
	}
	public function modulos_mover(){
		$idmodulo=$_REQUEST['idmodulo'];
		$dir=$_REQUEST['dir'];

		$sql="select * from modulo where id=$idmodulo";
		$sth = $this->dbh->query($sql);
		$modulo=$sth->fetch(PDO::FETCH_OBJ);
		if($dir==0){
			$orden=$modulo->orden-1.5;
		}
		else{
			$orden=$modulo->orden+1.5;
		}
		$arreglo=array();
		$arreglo+=array('orden'=>$orden);
		$x=$this->update('modulo',array('id'=>$modulo->id), $arreglo);
		return $x;
	}
	public function track_mover(){
		$idtrack=$_REQUEST['idtrack'];
		$dir=$_REQUEST['dir'];

		$sql="select * from track where id=$idtrack";
		$sth = $this->dbh->query($sql);
		$terapia=$sth->fetch(PDO::FETCH_OBJ);
		if($dir==0){
			$orden=$terapia->orden-1.5;
		}
		else{
			$orden=$terapia->orden+1.5;
		}

		$arreglo=array();
		$arreglo+=array('orden'=>$orden);
		$x=$this->update('track',array('id'=>$terapia->id), $arreglo);
		return $x;
	}
	public function terapia_mover(){
		$idterapia=$_REQUEST['idterapia'];
		$dir=$_REQUEST['dir'];

		$sql="select * from terapias where id=$idterapia";
		$sth = $this->dbh->query($sql);
		$terapia=$sth->fetch(PDO::FETCH_OBJ);
		if($dir==0){
			$orden=$terapia->orden-1.5;
		}
		else{
			$orden=$terapia->orden+1.5;
		}

		$arreglo=array();
		$arreglo+=array('orden'=>$orden);
		$x=$this->update('terapias',array('id'=>$terapia->id), $arreglo);
		return $x;
	}
	public function contexto_mover(){
		$idcontexto=$_REQUEST['idcontexto'];
		$dir=$_REQUEST['dir'];

		$sql="select * from contexto where id=$idcontexto";
		$sth = $this->dbh->query($sql);
		$contexto=$sth->fetch(PDO::FETCH_OBJ);
		if($dir==0){
			$orden=$contexto->orden-1.5;
		}
		else{
			$orden=$contexto->orden+1.5;
		}

		$arreglo=array();
		$arreglo+=array('orden'=>$orden);
		$x=$this->update('contexto',array('id'=>$contexto->id), $arreglo);

		$x=$this->salto_pagina();
		return $x;
	}
	public function salto_pagina(){
		$idactividad=$_REQUEST['idactividad'];

		if(isset($_REQUEST['salto'])){
			$idcontexto=$_REQUEST['idcontexto'];
			$salto=$_REQUEST['salto'];

			$arreglo =array();

			if($salto==0)
				$arreglo+=array('salto'=>1);
			if($salto==1)
				$arreglo+=array('salto'=>0);

			$x=$this->update('contexto',array('id'=>$idcontexto), $arreglo);
		}

		$sql="SELECT contexto.* FROM contexto
		left outer join subactividad on subactividad.idsubactividad=contexto.idsubactividad
		left outer join actividad on actividad.idactividad=subactividad.idactividad
		where actividad.idactividad=$idactividad order by subactividad.orden asc, contexto.orden asc";
		$sth = $this->dbh->query($sql);
		$orden=$sth->fetchAll(PDO::FETCH_OBJ);

		$pagina=0;
		$registro=0;
		foreach($orden as $row){
			if($registro==0){
				$salto=0;
				$pagina=0;
				$arreglo =array();
				$arreglo+=array('pagina'=>0);
				$arreglo+=array('salto'=>0);
				$x=$this->update('contexto',array('id'=>$row->id), $arreglo);
			}
			else{
				if($row->salto==1){
					$pagina++;
				}
				$arreglo =array();
				$arreglo+=array('pagina'=>$pagina);
				$x=$this->update('contexto',array('id'=>$row->id), $arreglo);
			}
			$registro++;
		}
		return $x;
	}
	public function subactividad_mover(){
		$idsubactividad=$_REQUEST['idsubactividad'];
		$dir=$_REQUEST['dir'];

		$sql="select * from subactividad where idsubactividad=$idsubactividad";
		$sth = $this->dbh->query($sql);
		$subactividad=$sth->fetch(PDO::FETCH_OBJ);
		if($dir==0){
			$orden=$subactividad->orden-1.5;
		}
		else{
			$orden=$subactividad->orden+1.5;
		}

		$arreglo=array();
		$arreglo+=array('orden'=>$orden);
		$x=$this->update('subactividad',array('idsubactividad'=>$subactividad->idsubactividad), $arreglo);
		$x=$this->salto_pagina();
		return $x;
	}

	public function guardar_grupo(){
		$idgrupo=$_REQUEST['idgrupo'];
		$arreglo=array();
		if(isset($_REQUEST['grupo'])){
			$arreglo+=array('grupo'=>$_REQUEST['grupo']);
		}
		if(isset($_REQUEST['idmodulo'])){
			$arreglo+=array('idmodulo'=>$_REQUEST['idmodulo']);
		}
		if(isset($_REQUEST['idtrack'])){
			$arreglo+=array('idtrack'=>$_REQUEST['idtrack']);
		}

		if(isset($_REQUEST['observaciones'])){
			$arreglo+=array('observaciones'=>$_REQUEST['observaciones']);
		}
		if($idgrupo==0){
			$arreglo+=array('orden'=>99999);
			$x=$this->insert('grupo_actividad',$arreglo);

			$resp=json_decode($x);
			if (isset($_REQUEST['idpaciente'])){
				$idpaciente=$_REQUEST['idpaciente'];
				$arreglo =array();
				$arreglo+=array('idgrupo'=>$resp->id1);
				$arreglo+=array('idpaciente'=>$idpaciente);
				$x=$this->insert('grupo_actividad_pre',$arreglo);
			}
		}
		else{
			$x=$this->update('grupo_actividad',array('idgrupo'=>$idgrupo), $arreglo);
		}
		return $x;
	}
	public function borrar_grupo(){
		if (isset($_REQUEST['idgrupo'])){$idgrupo=$_REQUEST['idgrupo'];}
		$sql="select * from actividad where idgrupo=$idgrupo";
		$sth = $this->dbh->query($sql);
		if($sth->rowCount()>0){
			$arreglo=array();
			$arreglo+=array('id1'=>0);
			$arreglo+=array('error'=>1);
			$arreglo+=array('terror'=>'Contiene Actividades');
			return json_encode($arreglo);
		}
		return $this->borrar('grupo_actividad',"idgrupo",$idgrupo);
	}
	public function grupo_mover(){
		$idgrupo=$_REQUEST['idgrupo'];
		$dir=$_REQUEST['dir'];

		$sql="select * from grupo_actividad where idgrupo=$idgrupo";
		$sth = $this->dbh->query($sql);
		$grupo=$sth->fetch(PDO::FETCH_OBJ);
		if($dir==0){
			$orden=$grupo->orden-1.5;
		}
		else{
			$orden=$grupo->orden+1.5;
		}
		$arreglo=array();
		$arreglo+=array('orden'=>$orden);
		$x=$this->update('grupo_actividad',array('idgrupo'=>$grupo->idgrupo), $arreglo);
		return $x;
	}

}

$db = new Cuest();
if(strlen($function)>0){
  echo $db->$function();
}

?>
