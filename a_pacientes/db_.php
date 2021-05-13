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

	public function pacientes_lista($pagina){
		try{
			$pagina=$pagina*$_SESSION['pagina'];

			if($_SESSION['nivel']==1 or $_SESSION['nivel']==4){
				$sql="SELECT * FROM clientes limit $pagina,".$_SESSION['pagina']."";
			}

			if($_SESSION['nivel']==2){
				$sql="SELECT * FROM clientes
				left outer join cliente_terapeuta on cliente_terapeuta.idcliente=clientes.id where cliente_terapeuta.idusuario='".$_SESSION['idusuario']."' limit $pagina,".$_SESSION['pagina']."";
			}
			if($_SESSION['nivel']==3){
				$sql="SELECT * FROM clientes where idsucursal='".$_SESSION['idsucursal']."' limit $pagina,".$_SESSION['pagina']."";
			}

			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function pacientes_buscar($texto){
		try{
			if($_SESSION['nivel']==1 or $_SESSION['nivel']==4){
				$sql="SELECT * FROM clientes where nombre like '%$texto%'";
			}
			if($_SESSION['nivel']==2){
				$sql="SELECT * FROM clientes left outer join cliente_terapeuta on cliente_terapeuta.idcliente=clientes.id where cliente_terapeuta.idusuario='".$_SESSION['idusuario']."' and clientes.nombre like '%$texto%'";
			}
			if($_SESSION['nivel']==3){
				$sql="SELECT * FROM clientes where idsucursal='".$_SESSION['idsucursal']."' and nombre like '%$texto%'";
			}

			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
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
	public function sucursal($id){
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
	public function sucursal_lista(){
		try{
			$sql="SELECT * FROM sucursal";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function terapeuta($id){
		try{
		  $sql="select * from usuarios where idusuario=:id";
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
		$idpaciente=$_REQUEST['idpaciente'];
		if (isset($_REQUEST['nombre'])){
			$arreglo+=array('nombre'=>clean_var($_REQUEST['nombre']));
		}
		if (isset($_REQUEST['numero'])){
			$arreglo+=array('numero'=>clean_var($_REQUEST['numero']));
		}
		if (isset($_REQUEST['apellidop'])){
			$arreglo+=array('apellidop'=>clean_var($_REQUEST['apellidop']));
		}
		if (isset($_REQUEST['apellidom'])){
			$arreglo+=array('apellidom'=>clean_var($_REQUEST['apellidom']));
		}
		if (isset($_REQUEST['edad'])){
			$arreglo+=array('edad'=>clean_var($_REQUEST['edad']));
		}
		$correo=$_REQUEST['correo'];
		$arreglo+=array('correo'=>$correo);

		if (isset($_REQUEST['telefono'])){
			$arreglo+=array('telefono'=>clean_var($_REQUEST['telefono']));
		}
		if (isset($_REQUEST['estatus'])){
			$arreglo+=array('estatus'=>clean_var($_REQUEST['estatus']));
		}
		if (isset($_REQUEST['civil'])){
			$arreglo+=array('civil'=>clean_var($_REQUEST['civil']));
		}
		if (isset($_REQUEST['hijos'])){
			$arreglo+=array('hijos'=>clean_var($_REQUEST['hijos']));
		}
		if (isset($_REQUEST['direccion'])){
			$arreglo+=array('direccion'=>clean_var($_REQUEST['direccion']));
		}
		if (isset($_REQUEST['ocupacion'])){
			$arreglo+=array('ocupacion'=>clean_var($_REQUEST['ocupacion']));
		}
		if (isset($_REQUEST['escolaridad'])){
			$arreglo+=array('escolaridad'=>clean_var($_REQUEST['escolaridad']));
		}
		if (isset($_REQUEST['religion'])){
			$arreglo+=array('religion'=>clean_var($_REQUEST['religion']));
		}
		if (isset($_REQUEST['vive'])){
			$arreglo+=array('vive'=>clean_var($_REQUEST['vive']));
		}
		if (isset($_REQUEST['nombre_vive'])){
			$arreglo+=array('nombre_vive'=>clean_var($_REQUEST['nombre_vive']));
		}
		if (isset($_REQUEST['telefono_vive'])){
			$arreglo+=array('telefono_vive'=>clean_var($_REQUEST['telefono_vive']));
		}
		if (isset($_REQUEST['parentesco_vive'])){
			$arreglo+=array('parentesco_vive'=>clean_var($_REQUEST['parentesco_vive']));
		}

		if (isset($_REQUEST['idsucursal'])){
			$arreglo+=array('idsucursal'=>clean_var($_REQUEST['idsucursal']));
		}

		if (isset($_REQUEST['enfermedad_cronica'])){
			$arreglo+=array('enfermedad_cronica'=>clean_var($_REQUEST['enfermedad_cronica']));
		}
		if (isset($_REQUEST['enfermedad'])){
			$arreglo+=array('enfermedad'=>clean_var($_REQUEST['enfermedad']));
		}
		if (isset($_REQUEST['enfermedad_mental'])){
			$arreglo+=array('enfermedad_mental'=>clean_var($_REQUEST['enfermedad_mental']));
		}
		if (isset($_REQUEST['e_mental'])){
			$arreglo+=array('e_mental'=>clean_var($_REQUEST['e_mental']));
		}
		if (isset($_REQUEST['consumo_medicamentos'])){
			$arreglo+=array('consumo_medicamentos'=>clean_var($_REQUEST['consumo_medicamentos']));
		}
		if (isset($_REQUEST['c_medicamentos'])){
			$arreglo+=array('c_medicamentos'=>clean_var($_REQUEST['c_medicamentos']));
		}
		if (isset($_REQUEST['alergias'])){
			$arreglo+=array('alergias'=>clean_var($_REQUEST['alergias']));
		}
		if (isset($_REQUEST['c_alergias'])){
			$arreglo+=array('c_alergias'=>clean_var($_REQUEST['c_alergias']));
		}
		if (isset($_REQUEST['lesiones'])){
			$arreglo+=array('lesiones'=>clean_var($_REQUEST['lesiones']));
		}
		if (isset($_REQUEST['c_lesiones'])){
			$arreglo+=array('c_lesiones'=>clean_var($_REQUEST['c_lesiones']));
		}
		if (isset($_REQUEST['autoriza'])){
			$arreglo+=array('autoriza'=>clean_var($_REQUEST['autoriza']));
		}
		if (isset($_REQUEST['tipo_paciente'])){
			$arreglo+=array('tipo_paciente'=>clean_var($_REQUEST['tipo_paciente']));
		}

		if($idpaciente==0){
			$sql="select * from clientes where correo='$correo'";
			$sth = $this->dbh->prepare($sql);
			$a=$sth->execute();
			if($sth->rowCount()>0){
				$arreglo+=array('id1'=>0);
				$arreglo+=array('error'=>1);
				$arreglo+=array('terror'=>"Ya existe el usuario favor de verificar");
				return json_encode($arreglo);
			}
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
			if ($extension=='png' || $extension=='PNG' || $extension=='jpg'  || $extension=='JPG' || $extension=='jpeg' || $extension=='JPEG') {
				$nombreFile = "resp_".date("YmdHis").rand(0000,9999).".".$extension;
				move_uploaded_file($tmp,$ruta.$nombreFile);
				$ruta=$ruta."/".$nombreFile;
				$arreglo+=array('foto'=>$nombreFile);
				if($_SESSION['idusuario']==$id1){
					$_SESSION['foto']="a_archivos/clientes/".$nombreFile;
				}


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
			$arreglo+=array('idterapeuta'=>$_SESSION['idusuario']);
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
			$x=$this->update('clientes',array('id'=>$idpaciente),array("estatus"=>"ACTIVO"));


			$sql="select * from actividad where idactividad=:idactividad";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":idactividad",$idactividad);
			$sth->execute();
			$resp=$sth->fetch(PDO::FETCH_OBJ);

			$fecha=date("Y-m-d H:i:s");
			////////////Clonar actividad
			$arreglo=array();
			$arreglo+=array('idgrupo'=>$resp->idgrupo);
			$arreglo+=array('idpaciente'=>$idpaciente);
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
			$arreglo+=array('idterapeuta'=>$_SESSION['idusuario']);
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

		$sql="SELECT * from track_per left outer join track on track.id=track_per.idtrack where track_per.idpaciente=$idpaciente and track.idterapia=$idterapia order by track.inicial desc, track.orden asc";
		$sth = $this->dbh->query($sql);
		if($sth->rowCount()==0){
			$sql="select * from terapias_per where idterapia=$idterapia and idpaciente=$idpaciente";
			$sth = $this->dbh->query($sql);
			if ($sth->rowCount()>0){
				$res=$sth->fetch(PDO::FETCH_OBJ);
				return $this->borrar('terapias_per',"id",$res->id);
			}
		}
		else{
			$arreglo=array();
			$arreglo+=array('id1'=>0);
			$arreglo+=array('error'=>1);
			$arreglo+=array('terror'=>'Contiene tracks');
			return json_encode($arreglo);
		}
	}

	public function quitar_track(){

		$idtrack=clean_var($_REQUEST['idtrack']);
		$idpaciente=clean_var($_REQUEST['idpaciente']);


		$sql="SELECT * from modulo_per
		left outer join modulo on modulo.id=modulo_per.idmodulo where modulo_per.idpaciente=$idpaciente and modulo.idtrack=$idtrack order by modulo.orden asc";

		$sth = $this->dbh->query($sql);
		if($sth->rowCount()>0){
			$arreglo=array();
			$arreglo+=array('id1'=>0);
			$arreglo+=array('error'=>1);
			$arreglo+=array('terror'=>'Contiene modulos');
			return json_encode($arreglo);
		}

		$sql="select * from grupo_actividad_pre left outer join grupo_actividad on grupo_actividad.idgrupo=grupo_actividad_pre.idgrupo where grupo_actividad.idtrack=$idtrack and grupo_actividad_pre.idpaciente=$idpaciente order by grupo_actividad.orden asc";
		$sth = $this->dbh->query($sql);
		if($sth->rowCount()>0){
			$arreglo=array();
			$arreglo+=array('id1'=>0);
			$arreglo+=array('error'=>1);
			$arreglo+=array('terror'=>'Contiene grupos');
			return json_encode($arreglo);
		}

		$sql="select * from track_per where idtrack=$idtrack and idpaciente=$idpaciente";
		$sth = $this->dbh->query($sql);
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
	public function borrar_grupo(){
		if (isset($_REQUEST['idgrupo'])){$idgrupo=$_REQUEST['idgrupo'];}
		if (isset($_REQUEST['idper'])){$idper=$_REQUEST['idper'];}

		$sql="select * from actividad where idgrupo=$idgrupo";
		$sth = $this->dbh->query($sql);
		if($sth->rowCount()>0){
			$arreglo=array();
			$arreglo+=array('id1'=>0);
			$arreglo+=array('error'=>1);
			$arreglo+=array('terror'=>'Contiene Actividades');
			return json_encode($arreglo);
		}
		return $this->borrar('grupo_actividad_pre',"idper",$idper);
	}
	public function quitar_actividad(){
		$idactividad=clean_var($_REQUEST['idactividad']);
		$idpaciente=clean_var($_REQUEST['idpaciente']);


		return $this->borrar('actividad',"idactividad",$idactividad);
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
			$sql="SELECT * from terapias_per left outer join terapias on terapias.id=terapias_per.idterapia where terapias_per.idpaciente=$id";
			$sth = $this->dbh->prepare($sql);
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

	public function contexto_pacientes($idcontexto, $idactividad, $idpaciente){

		$sql="select * from actividad where idactividad=:idactividad";
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(":idactividad",$idactividad);
		$sth->execute();
		$actividad=$sth->fetch(PDO::FETCH_OBJ);

		$sql="select * from contexto where id=:id";
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(":id",$idcontexto);
		$sth->execute();
		$row=$sth->fetch(PDO::FETCH_OBJ);

		$sql="select * from contexto_resp where idcontexto=:id";
		$contx = $this->dbh->prepare($sql);
		$contx->bindValue(":id",$row->id);
		$contx->execute();
		$texto="";
		$fecha="";
		$archivo="";
		$marca="";
		if($contx->rowCount()>0){
			$contexto_resp=$contx->fetch(PDO::FETCH_OBJ);
			$texto=$contexto_resp->texto;
			$fecha=$contexto_resp->fecha;
			$archivo=$contexto_resp->archivo;
			$marca=$contexto_resp->marca;
		}

		/////////////////////////////////////////////////////////////////////////////////////////////////////////
			echo "<div class='card mt-2 ml-5'>";
				echo "<div class='card-header'>";
					echo "<div class='row'>";
						echo "<div class='col-5'>";
							///////////////editar contexto
							echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/contexto_editar' v_idcontexto='$row->id' v_idactividad='$idactividad' v_idpaciente='$idpaciente' omodal='1' title='Editar contexto'><i class='fas fa-pencil-alt'></i></button>";

							///////////////editar incisos
							if($row->tipo=="pregunta"){
								echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/incisos_lista' v_idcontexto='$row->id' v_idactividad='$idactividad' v_idpaciente='$idpaciente' omodal='1' title='Editar incisos'><i class='fas fa-tasks'></i></button>";
							}

							////////////////copiar
							echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='contexto_duplicar' v_idactividad='$idactividad' v_idcontexto='$row->id' v_idpaciente='$idpaciente' tp='¿Desea duplicar el bloque?' title='Duplicar actividad'><i class='far fa-copy'></i></button>";

							////////////////eliminar bloque
							echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='contexto_borrar' v_idactividad='$idactividad' v_idcontexto='$row->id' v_idpaciente='$idpaciente' tp='¿Desea eliminar el bloque selecionado?' title='Eliminar bloque'><i class='far fa-trash-alt'></i></button>";

							////////////////condiciones
							echo "<button "; if($row->idcond){ echo "class='btn btn-danger btn-sm' "; } else { echo "class='btn btn-warning btn-sm'"; } echo " type='button' is='b-link' des='a_actividades_e/condicional_editar' v_idactividad='$idactividad' v_idpaciente='$idpaciente' omodal='1' v_idcontexto='$row->id' title='Condicional' ><i class='fas fa-project-diagram'></i></button>";

							echo "<button "; if($row->salto){ echo "class='btn btn-danger btn-sm' "; } else { echo "class='btn btn-warning btn-sm'"; } echo " type='button' is='b-link' des='a_pacientes/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='salto_pagina' tp='¿Desea";
							if(!$row->salto){ echo " insertar ";} else{ echo " quitar el ";}
							echo "salto de pagina?' v_idactividad='$idactividad' v_idcontexto='$row->id' v_idpaciente='$idpaciente' v_salto='$row->salto' title='Salto de página'><i class='far fa-sticky-note'></i></button>";

							echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' db='a_pacientes/db_' fun='contexto_mover' des='a_pacientes/actividad_ver' v_idactividad='$idactividad' v_idpaciente='$idpaciente' v_idcontexto='$row->id' v_dir='0' dix='trabajo' title='Mover arriba'><i class='fas fa-chevron-up'></i></button>";

							echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' db='a_pacientes/db_' fun='contexto_mover' des='a_pacientes/actividad_ver' v_idactividad='$idactividad' v_idpaciente='$idpaciente' v_idcontexto='$row->id' v_dir='1' dix='trabajo' title='Mover abajo'><i class='fas fa-chevron-down'></i></button>";

						echo "</div>";
						echo "<div class='col-5'>";
							echo "<button class='btn btn-link' data-toggle='collapse' data-target='#collapsecon_".$row->id."' aria-expanded='true' aria-controls='collapsecon_".$row->id."'>";
								echo "Contexto ";
							echo "</button>";
						echo "</div>";
						echo "<div class='col-2 text-right'>";
							if(strlen($marca)!=0){
								echo "<i class='fas fa-check'></i>";
							}
						echo "</div>";
					echo "</div>";
				echo "</div>";


				echo "<div class='card-body'>";

							echo "<form is='act-submit' id='form_g_".$row->id."' db='a_respuesta/db_' fun='guarda_respuesta' v_idactividad='$idactividad' v_idpaciente='$idpaciente' v_idcontexto='$row->id'>";

							if(strlen($row->observaciones)>0){
								echo "<div class='mb-3'>";
									echo $row->observaciones;
								echo "</div>";
								echo "<hr>";
							}

							echo "<div class='mb-3'>";
							if($row->tipo=="imagen"){
								echo "<img src='".$this->doc.$row->texto."'/>";
							}
							else if($row->tipo=="texto"){
								echo $row->texto;
							}
							else if($row->tipo=="video"){
								echo $row->texto;
							}
							else if($row->tipo=="archivo"){
								echo "<a href='".$this->doc.$row->texto."' download='$row->texto'>Descargar</a>";
							}
							else if($row->tipo=="textores"){
								echo "<div id='div_$row->id' name='div_$row->id' onclick='editable(this)' style='width:100%; height: 200px; border:1px solid silver'>$texto</div>";
								echo "<small>De clic para editar</small>";
							}
							else if($row->tipo=="textocorto"){
								echo "<textarea class='form-control' id='texto_$row->id' name='texto_$row->id' rows=5 placeholder=''>$texto</textarea>";
							}
							else if($row->tipo=="fecha"){
								echo "<input type='date' name='fecha' id='fecha' value='$fecha' class='form-control'>";
							}
							else if($row->tipo=="archivores"){
								if(strlen($archivo)>0){
									echo "<a href='".$this->resp.$archivo."' download='$archivo'>Ver</a>";
								}
								echo "<input type='file' name='archivo' id='archivo' class='form-control'>";
							}
							else if($row->tipo=="pregunta"){
								echo $row->texto;

								///////////<!-- Respuestas  -->
								echo "<div>";
									$rx=$this->respuestas_ver($row->id);
									if(strlen($row->incisos)==0 and $row->tipo=="pregunta" and strlen($row->personalizado)==0){
										$idx=$row->id;
										echo "<div class='row'>";
											echo "<div class='col-8'>";

												$sql="select * from contexto_resp where idcontexto=$row->id";
												$contx = $this->dbh->query($sql);
												$resp=$contx->fetch(PDO::FETCH_OBJ);
												$correcta=0;
												$texto_resp="";
												if($contx->rowCount()>0){
													$correcta=$resp->idrespuesta;
													$texto_resp=$resp->texto;
													$valor_resp=$resp->valor;
												}

												echo "<select class='form-control form-control-sm' name='select_".$idx."'>";
												echo "<option value='' selected disabled>Seleccione una opcion</option>";
												foreach ($rx as $respuesta) {
													//////////////////para obtener Respuestas
													echo "<option value='$respuesta->id' ";
													if($correcta==$respuesta->id){ echo " selected"; }
													echo ">$respuesta->nombre (".$respuesta->valor.")</option>";
												}
												echo "</select>";
											echo "</div>";
											echo "<div class='col-4'>";
												if($row->usuario==1){
													echo "<input type='text' name='resp_".$idx."' id='resp_".$idx."' value='$texto_resp' placeholder='Define..' class='form-control form-control-sm'>";
												}
											echo "</div>";
										echo "</div>";
									}
									else{
										foreach ($rx as $respuesta) {
											$texto_resp="";
											$valor_resp="";
											$resp_idrespuesta="";

											echo "<div class='row'>";

												//////////////////para obtener Respuestas
												$sql="select * from contexto_resp where idcontexto=$row->id and idrespuesta=$respuesta->id";
												$contx = $this->dbh->query($sql);
												$resp=$contx->fetch(PDO::FETCH_OBJ);
												$correcta=0;
												$texto_resp="";
												if($contx->rowCount()>0){
													$correcta=1;
													$texto_resp=$resp->texto;
													$valor_resp=$resp->valor;
												}

												echo "<div class='col-1'>";
													if($row->incisos==1){
														$idx="";
														echo "<input type='checkbox' name='checkbox_".$respuesta->id."' value='$respuesta->id' ";
														if($correcta){ echo " checked";}
														echo ">";
													}
													else{
														$idx=$row->id;
														echo "<input type='radio' name='radio_".$idx."' value='$respuesta->id' ";
															if($correcta){
																echo " checked";
															}
														echo ">";
													}
												echo "</div>";

												if(strlen($respuesta->imagen)>0){
													echo "<div class='col-1'>";
															echo "<img src=".$this->doc.$respuesta->imagen." alt='' width='20px'>";
													echo "</div>";
												}

												echo "<div class='col-6'>";
													echo $respuesta->nombre;
												echo "</div>";

												///////////////////////////////////aca el valor
												if($actividad->tipo=="evaluacion"){
													echo "<div class='col-1'>";
														echo $respuesta->valor;
													echo "</div>";
												}

												echo "<div class='col-3'>";
													if($row->usuario==1){
														echo "<input type='text' name='resp_".$respuesta->id."' id='resp_".$respuesta->id."' value='$texto_resp' placeholder='Define..' class='form-control form-control-sm'>";
													}
												echo "</div>";
											echo "</div>";
										}
										if($row->personalizado==1){
											$texto="";
											$otro=0;

											$sql="select * from contexto_resp where idcontexto=$row->id and valor='OTRO'";
											$contx = $this->dbh->prepare($sql);
											$contx->execute();
											if($contx->rowCount()>0){
												$resp=$contx->fetch(PDO::FETCH_OBJ);
												$texto=$resp->texto;
												$otro=1;
											}

											echo "<div class='row'>";
												echo "<div class='col-3'>";
												echo "</div>";
												if($row->incisos==1){
														echo "<div class='col-1'>";
															echo "<input type='checkbox' name='checkbox_otro'";
															if($otro==1){
																echo " checked";
															}
															echo " value='otro'>";
														echo "</div>";
														echo "<div class='col-6'>";
															echo "<input type='text' name='resp_otro' id='resp_otro' value='$texto' class='form-control form-control-sm' placeholder='Otro'>";
														echo "</div>";
													}
													else{
														echo "<div class='col-1'>";
															echo "<input type='radio' name='radio_".$idx."' value='otro'";
															if($otro==1){
																echo " checked";
															}
															echo ">";
														echo "</div>";
														echo "<div class='col-6'>";
															echo "<input type='text' name='resp_otro' id='per_".$row->id."' value='$texto' class='form-control form-control-sm' placeholder='otro'>";
														echo "</div>";
												}
											echo "</div>";
										}
									}
								echo "</div>";
							}
						echo "</div>";

							//////////<!-- Fin Preguntas  -->
							echo "<div class='row mb-3'>";
								echo "<div class='col-12'>";
									if($row->tipo=="pregunta"){
										echo "<button class='btn btn-warning btn-sm mx-1' type='button' is='b-link' des='a_actividades_e/inciso_editar' v_idrespuesta='0' v_idcontexto='$row->id' v_idactividad='$idactividad' v_idpaciente='$idpaciente' omodal='1' >Agregar inciso</button>";
									}

									if($row->tipo=="textocorto" or $row->tipo=="textores" or $row->tipo=="fecha" or $row->tipo=="archivores" or $row->tipo=="pregunta"){
										echo "<button class='btn btn-warning btn-sm mx-1' type='submit'>Responder</button>";
									}
								echo "</div>";
							echo "</div>";

						echo "</form>";
					echo "</div>";

			echo "</div>";
		/////////////////////////////////////////////////////////////////////////////////////////////////////////
	}

	public function upd(){
		$idcontexto=$_REQUEST['idcontexto'];
		$idactividad=$_REQUEST['idactividad'];
		$idpaciente=$_REQUEST['idpaciente'];
		$x=$this->contexto_pacientes($idcontexto, $idactividad, $idpaciente);
		return $x;
	}
	public function relacion_buscar($texto,$idpaciente){
		try{
			if($_SESSION['nivel']==1)
			$sql="select * from clientes where id!='".$idpaciente."' and (nombre like '%$texto%' or apellidop like '%$texto%' or apellidom like '%$texto%')";


			if($_SESSION['nivel']==2)
			$sql="select * from clientes left outer join cliente_terapeuta on cliente_terapeuta.idcliente=clientes.id where id!='".$idpaciente."' and cliente_terapeuta.idusuario='".$_SESSION['idusuario']."' and (nombre like '%$texto%' or apellidop like '%$texto%' or apellidom like '%$texto%')";


			if($_SESSION['nivel']==3)
			$sql="select * from clientes where id!='".$idpaciente."' and idsucursal='".$_SESSION['idsucursal']."' and (nombre like '%$texto%' or apellidop like '%$texto%' or apellidom like '%$texto%')";

			if($_SESSION['nivel']==4)
			$sql="select * from clientes where id!='".$idpaciente."' and (nombre like '%$texto%' or apellidop like '%$texto%' or apellidom like '%$texto%')";

			$sth = $this->dbh->query($sql);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}

	public function rol_relacion(){
		try{
		  $sql="select * from rol_familiar";
		  $sth = $this->dbh->query($sql);
		  return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
		  return "Database access FAILED!".$e->getMessage();
		}
	}
	public function rol_asignar(){
		try{

			$x="";
			$idpaciente=$_REQUEST['idpaciente'];
			$idrel=$_REQUEST['idrel'];
			$idrelacion=$_REQUEST['idrelacion'];

			if($idrelacion==0){
				$sql="select * from clientes_relacion where idcliente='$idpaciente' and idrel='$idrel'";
				$sth = $this->dbh->prepare($sql);
				$sth->execute();
				if ($sth->rowCount()>0){
					$arreglo=array();
					$arreglo+=array('id1'=>0);
					$arreglo+=array('error'=>1);
					$arreglo+=array('terror'=>"La relación ya existe");
					return json_encode($arreglo);
				}
			}


			$arreglo=array();
			$arreglo+=array('idrol'=>$_REQUEST['idrol']);
			if($idrelacion>0){
				$x=$this->update('clientes_relacion',array('idrelacion'=>$idrelacion), $arreglo);
			}
			else{
				$arreglo+=array('idcliente'=>$_REQUEST['idpaciente']);
				$arreglo+=array('idrel'=>$_REQUEST['idrel']);
				$x=$this->insert('clientes_relacion',$arreglo);
			}
			return $x;
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}
	public function rol_quitar(){
		$idpaciente=$_REQUEST['idpaciente'];
		$idrelacion=$_REQUEST['idrelacion'];

		return $this->borrar('clientes_relacion',"idrelacion",$idrelacion);

	}
	public function relacion_editar($idrelacion){
		try{
		  $sql="select * from clientes_relacion where idrelacion='$idrelacion'";
		  $sth = $this->dbh->query($sql);
		  return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
		  return "Database access FAILED!".$e->getMessage();
		}
	}

	public function agregar_ter(){
		try{
			$sql="select * from cliente_terapeuta where idusuario=:idusuario and idcliente=:idpaciente";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":idusuario",$_REQUEST['idusuario']);
			$sth->bindValue(":idpaciente",$_REQUEST['idpaciente']);
			$sth->execute();
			if ($sth->rowCount()==0){
				$arreglo=array();
				$x="";
				$arreglo+=array('idusuario'=>$_REQUEST['idusuario']);
				$arreglo+=array('idcliente'=>$_REQUEST['idpaciente']);
				$this->insert('cliente_terapeuta',$arreglo);

				$arreglo=array();
				$arreglo+=array('id1'=>$_REQUEST['idpaciente']);
				$arreglo+=array('error'=>0);
				return json_encode($arreglo);
			}
			else{
				$arreglo=array();
				$arreglo+=array('id1'=>0);
				$arreglo+=array('error'=>1);
				$arreglo+=array('terror'=>"el terapeuta ya esta asignado");
				return json_encode($arreglo);
			}
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
	}
	public function terapeuta_quitar(){
		$idpaciente=$_REQUEST['idpaciente'];
		$idterapeuta=$_REQUEST['idterapeuta'];

		return $this->borrar('cliente_terapeuta',"idterapeuta",$idterapeuta);

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

	public function asignar_pareja(){
		$idactividad=$_REQUEST['idactividad'];
		$idpaciente=$_REQUEST['idpaciente'];
		$idrel=$_REQUEST['idrel'];

		$sql="select * from actividad_per where idpaciente=$idrel and idactividad=$idactividad";
		$sth = $this->dbh->query($sql);
		$activ_per=$sth->fetch(PDO::FETCH_OBJ);
		if($sth->rowCount()==0){

			$arreglo=array();
			$arreglo+=array('idpaciente'=>$idrel);
			$arreglo+=array('idactividad'=>$idactividad);
			$x=$this->insert('actividad_per', $arreglo);

			$sql="select * from actividad where idactividad=$idactividad";
			$sth = $this->dbh->query($sql);
			$actividad=$sth->fetch(PDO::FETCH_OBJ);
			if($actividad->idtrack){
				$idtrack=$actividad->idtrack;

			}
			if($actividad->idmodulo){

				$sql="select * from modulo_per where idpaciente=$idrel and idmodulo=$actividad->idmodulo";
				$sth = $this->dbh->query($sql);
				if($sth->rowCount()==0){
					$arreglo=array();
					$arreglo+=array('idpaciente'=>$idrel);
					$arreglo+=array('idmodulo'=>$actividad->idmodulo);
					$x=$this->insert('modulo_per', $arreglo);
				}

				$sql="select * from modulo where id=$actividad->idmodulo";
				$sth = $this->dbh->query($sql);
				$modulo=$sth->fetch(PDO::FETCH_OBJ);
				$idtrack=$modulo->idtrack;

			}
			$sql="select * from track_per where idpaciente=$idrel and idtrack=$idtrack";
			$sth = $this->dbh->query($sql);
			if($sth->rowCount()==0){
				$arreglo=array();
				$arreglo+=array('idpaciente'=>$idrel);
				$arreglo+=array('idtrack'=>$idtrack);
				$x=$this->insert('track_per', $arreglo);
			}

			////////////////////////
			$sql="select * from track where id=$idtrack";
			$sth = $this->dbh->query($sql);
			$track=$sth->fetch(PDO::FETCH_OBJ);

			$sql="select * from terapias_per where idpaciente=$idrel and idterapia=$track->idterapia";
			$sth = $this->dbh->query($sql);
			if($sth->rowCount()==0){
				$arreglo=array();
				$arreglo+=array('idpaciente'=>$idrel);
				$arreglo+=array('idterapia'=>$track->idterapia);
				$x=$this->insert('terapias_per', $arreglo);
			}
			return $x;
		}
		else{
			$arreglo=array();
			$arreglo+=array('id1'=>0);
			$arreglo+=array('error'=>1);
			$arreglo+=array('terror'=>'Ya existe en esta actividad');
			$x=json_encode($arreglo);
		}
		return $x;
	}
	public function eliminar_pareja(){
		$idactividad=$_REQUEST['idactividad'];
		$idpaciente=$_REQUEST['idpaciente'];
		$idper=$_REQUEST['idper'];

		return $this->borrar('actividad_per',"id",$idper);
	}

	public function agregar_grupo(){
		$idgrupo=clean_var($_REQUEST['idgrupo']);
		$idpaciente=clean_var($_REQUEST['idpaciente']);
		$sql="select * from grupo_actividad_pre where idgrupo=:idgrupo and idpaciente=:idpaciente";
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(":idgrupo",$idgrupo);
		$sth->bindValue(":idpaciente",$idpaciente);
		$sth->execute();
		if ($sth->rowCount()==0){
			$arreglo=array();
			$arreglo+=array('idpaciente'=>$idpaciente);
			$arreglo+=array('idgrupo'=>$idgrupo);
			$x=$this->insert('grupo_actividad_pre', $arreglo);
			return $x;
		}
		else{
			$arreglo=array();
			$arreglo+=array('id1'=>0);
			$arreglo+=array('error'=>1);
			$arreglo+=array('terror'=>"El grupo ya existe");
			return json_encode($arreglo);
		}
	}



}

$db = new Cliente();
if(strlen($function)>0){
	echo $db->$function();
}
