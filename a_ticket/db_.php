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

class Ticket extends ipsi{
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
	public function ticket_editar(){

		$idticket=$_REQUEST['idticket'];
		$sql="select * from ticket where idticket=$idticket";
		$sth = $this->dbh->query($sql);
		return $sth->fetch(PDO::FETCH_OBJ);
	}
	public function guardar_ticket(){
		$x="";
		$arreglo =array();
		$idticket=$_REQUEST['idticket'];

		if(!isset($_REQUEST['asunto']) or strlen(trim($_REQUEST['asunto']))==0){
			$arreglo+=array('id1'=>0);
			$arreglo+=array('error'=>1);
			$arreglo+=array('terror'=>"Falta asunto");
			return json_encode($arreglo);
		}

		if(!isset($_REQUEST['texto_ticket']) or strlen(trim($_REQUEST['texto_ticket']))==0){
			$arreglo+=array('id1'=>0);
			$arreglo+=array('error'=>1);
			$arreglo+=array('terror'=>"Falta mensaje");
			return json_encode($arreglo);
		}



		$arreglo+=array('asunto'=>$_REQUEST['asunto']);
		$arreglo+=array('mensaje'=>$_REQUEST['texto_ticket']);
		$extension = '';
		$ruta = '../a_archivos/ticket/';

		$archivo = $_FILES['foto1']['tmp_name'];
		$nombrearchivo = $_FILES['foto1']['name'];
		$tmp=$_FILES['foto1']['tmp_name'];
		$info = pathinfo($nombrearchivo);
		if($archivo!=""){
			$extension = $info['extension'];
			if ($extension=='png' || $extension=='PNG' || $extension=='jpg'  || $extension=='JPG') {
				$nombreFile = "resp1_".date("YmdHis").rand(0000,9999).".".$extension;
				move_uploaded_file($tmp,$ruta.$nombreFile);
				$arreglo+=array('imagen1'=>$nombreFile);
			}
		}

		$archivo = $_FILES['foto2']['tmp_name'];
		$nombrearchivo = $_FILES['foto2']['name'];
		$tmp=$_FILES['foto2']['tmp_name'];
		$info = pathinfo($nombrearchivo);
		if($archivo!=""){
			$extension = $info['extension'];
			if ($extension=='png' || $extension=='PNG' || $extension=='jpg'  || $extension=='JPG') {
				$nombreFile = "resp2_".date("YmdHis").rand(0000,9999).".".$extension;
				move_uploaded_file($tmp,$ruta.$nombreFile);
				$arreglo+=array('imagen2'=>$nombreFile);
			}
		}

		$archivo = $_FILES['foto3']['tmp_name'];
		$nombrearchivo = $_FILES['foto3']['name'];
		$tmp=$_FILES['foto3']['tmp_name'];
		$info = pathinfo($nombrearchivo);
		if($archivo!=""){
			$extension = $info['extension'];
			if ($extension=='png' || $extension=='PNG' || $extension=='jpg'  || $extension=='JPG') {
				$nombreFile = "resp3_".date("YmdHis").rand(0000,9999).".".$extension;
				move_uploaded_file($tmp,$ruta.$nombreFile);
				$arreglo+=array('imagen3'=>$nombreFile);
			}
		}

		$archivo = $_FILES['foto4']['tmp_name'];
		$nombrearchivo = $_FILES['foto4']['name'];
		$tmp=$_FILES['foto4']['tmp_name'];
		$info = pathinfo($nombrearchivo);
		if($archivo!=""){
			$extension = $info['extension'];
			if ($extension=='png' || $extension=='PNG' || $extension=='jpg'  || $extension=='JPG') {
				$nombreFile = "resp4_".date("YmdHis").rand(0000,9999).".".$extension;
				move_uploaded_file($tmp,$ruta.$nombreFile);
				$arreglo+=array('imagen4'=>$nombreFile);
			}
		}

		$archivo = $_FILES['foto5']['tmp_name'];
		$nombrearchivo = $_FILES['foto5']['name'];
		$tmp=$_FILES['foto5']['tmp_name'];
		$info = pathinfo($nombrearchivo);
		if($archivo!=""){
			$extension = $info['extension'];
			if ($extension=='png' || $extension=='PNG' || $extension=='jpg'  || $extension=='JPG') {
				$nombreFile = "resp5_".date("YmdHis").rand(0000,9999).".".$extension;
				move_uploaded_file($tmp,$ruta.$nombreFile);
				$arreglo+=array('imagen5'=>$nombreFile);
			}
		}

		if($idticket==0){
			$sql = "SELECT MAX(numero) as total FROM ticket";
			$statement = $this->dbh->prepare($sql);
			$statement->execute();
			$numero=$statement->fetchColumn()+1;

			$arreglo+=array('numero'=>$numero);
			$arreglo+=array('fecha'=>date("Y-m-d H:i:s"));
			$para=explode("_",$_REQUEST['idpara']);

			if($para[0]=="us"){
				$arreglo+=array('idpara_usuario'=>$para[1]);
			}
			else{
				$arreglo+=array('idpara_cliente'=>$para[1]);
			}

			if($_SESSION['nivel']==666){
				$arreglo+=array('idde_cliente'=>$_SESSION['idusuario']);
			}
			else{
				$arreglo+=array('idde_usuario'=>$_SESSION['idusuario']);
			}

			$arreglo+=array('estado'=>"Abierto");
			$x=$this->insert('ticket', $arreglo);
		}
		else{
			$x=$this->update('ticket',array('idticket'=>$idticket), $arreglo);
		}
		return $x;
	}
	public function guardar_hijo(){
		$x="";
		$arreglo =array();
		$idticket=$_REQUEST['idticket'];
		$arreglo+=array('idpadre'=>$idticket);

		if (isset($_REQUEST['asunto'])){
			$arreglo+=array('asunto'=>$_REQUEST['asunto']);
		}
		$arreglo+=array('mensaje'=>$_REQUEST['texto_hijo']);
		$extension = '';
		$ruta = '../a_archivos/ticket/';


		$archivo = $_FILES['foto1']['tmp_name'];
		$nombrearchivo = $_FILES['foto1']['name'];
		$tmp=$_FILES['foto1']['tmp_name'];
		$info = pathinfo($nombrearchivo);
		if($archivo!=""){
			$extension = $info['extension'];
			if ($extension=='png' || $extension=='PNG' || $extension=='jpg'  || $extension=='JPG') {
				$nombreFile = "resp1_".date("YmdHis").rand(0000,9999).".".$extension;
				move_uploaded_file($tmp,$ruta.$nombreFile);
				$arreglo+=array('imagen1'=>$nombreFile);
			}
		}

		$archivo = $_FILES['foto2']['tmp_name'];
		$nombrearchivo = $_FILES['foto2']['name'];
		$tmp=$_FILES['foto2']['tmp_name'];
		$info = pathinfo($nombrearchivo);
		if($archivo!=""){
			$extension = $info['extension'];
			if ($extension=='png' || $extension=='PNG' || $extension=='jpg'  || $extension=='JPG') {
				$nombreFile = "resp2_".date("YmdHis").rand(0000,9999).".".$extension;
				move_uploaded_file($tmp,$ruta.$nombreFile);
				$arreglo+=array('imagen2'=>$nombreFile);
			}
		}

		$archivo = $_FILES['foto3']['tmp_name'];
		$nombrearchivo = $_FILES['foto3']['name'];
		$tmp=$_FILES['foto3']['tmp_name'];
		$info = pathinfo($nombrearchivo);
		if($archivo!=""){
			$extension = $info['extension'];
			if ($extension=='png' || $extension=='PNG' || $extension=='jpg'  || $extension=='JPG') {
				$nombreFile = "resp3_".date("YmdHis").rand(0000,9999).".".$extension;
				move_uploaded_file($tmp,$ruta.$nombreFile);
				$arreglo+=array('imagen3'=>$nombreFile);
			}
		}

		$archivo = $_FILES['foto4']['tmp_name'];
		$nombrearchivo = $_FILES['foto4']['name'];
		$tmp=$_FILES['foto4']['tmp_name'];
		$info = pathinfo($nombrearchivo);
		if($archivo!=""){
			$extension = $info['extension'];
			if ($extension=='png' || $extension=='PNG' || $extension=='jpg'  || $extension=='JPG') {
				$nombreFile = "resp4_".date("YmdHis").rand(0000,9999).".".$extension;
				move_uploaded_file($tmp,$ruta.$nombreFile);
				$arreglo+=array('imagen4'=>$nombreFile);
			}
		}

		$archivo = $_FILES['foto5']['tmp_name'];
		$nombrearchivo = $_FILES['foto5']['name'];
		$tmp=$_FILES['foto5']['tmp_name'];
		$info = pathinfo($nombrearchivo);
		if($archivo!=""){
			$extension = $info['extension'];
			if ($extension=='png' || $extension=='PNG' || $extension=='jpg'  || $extension=='JPG') {
				$nombreFile = "resp5_".date("YmdHis").rand(0000,9999).".".$extension;
				move_uploaded_file($tmp,$ruta.$nombreFile);
				$arreglo+=array('imagen5'=>$nombreFile);
			}
		}
		$arreglo+=array('fecha'=>date("Y-m-d H:i:s"));

		if($_SESSION['nivel']==666){
			$arreglo+=array('idde_cliente'=>$_SESSION['idusuario']);
		}
		else{
			$arreglo+=array('idde_usuario'=>$_SESSION['idusuario']);
		}
		$x=$this->insert('ticket', $arreglo);

		$arreglo=array();
		$arreglo+=array('id1'=>$idticket);
		$arreglo+=array('error'=>0);
		return json_encode($arreglo);
	}
	public function ticket_registro($id){
		$sql="select * from ticket where idpadre='$id' order by fecha asc";
		$sth = $this->dbh->query($sql);
		return $sth->fetchAll(PDO::FETCH_OBJ);
	}
	public function ticket_lista($pagina){
		$pagina=$pagina*$_SESSION['pagina'];
		if($_SESSION['nivel']==666){
			$sql="select * from ticket where
			(idde_cliente=".$_SESSION['idusuario']." or idpara_cliente=".$_SESSION['idusuario'].")
			and idpadre is null and ticket.estado='Abierto' order by estado, numero desc limit $pagina,".$_SESSION['pagina']."";
		}

		//if($key->nivel==1) echo "Admin General";

		if($_SESSION['nivel']==1){
			$sql="select ticket.* from ticket
			where
			(ticket.idde_usuario=".$_SESSION['idusuario']." or ticket.idpara_usuario=".$_SESSION['idusuario']." or ticket.idde_cliente is not null)
			and ticket.idpadre is null and ticket.estado='Abierto' order by ticket.estado, ticket.numero desc limit $pagina,".$_SESSION['pagina']."";
		}
		//if($key->nivel==2) echo "Terapeuta";
		if($_SESSION['nivel']==2){
			$sql="select ticket.* from ticket where
			(idde_usuario=".$_SESSION['idusuario']." or idpara_usuario=".$_SESSION['idusuario'].")
			and idpadre is null and ticket.estado='Abierto' order by estado, numero desc limit $pagina,".$_SESSION['pagina']."";
		}
		//if($key->nivel==3) echo "Admin Sucursal";
		if($_SESSION['nivel']==3){
			$sql="select ticket.* from ticket
			LEFT OUTER JOIN clientes ON clientes.id = ticket.idde_cliente
			where
			(ticket.idde_usuario=".$_SESSION['idusuario']." or ticket.idpara_usuario=".$_SESSION['idusuario']." or clientes.idsucursal=".$_SESSION['idsucursal'].")
			and ticket.idpadre is null and ticket.estado='Abierto' order by ticket.estado, ticket.numero desc limit $pagina,".$_SESSION['pagina']."";
		}
		//if($key->nivel==4) echo "Secretaria";
		if($_SESSION['nivel']==4){
			$sql="select ticket.* from ticket
			where
			(ticket.idde_usuario=".$_SESSION['idusuario']." or ticket.idpara_usuario=".$_SESSION['idusuario']." or ticket.idde_cliente is not null)
			and ticket.idpadre is null and ticket.estado='Abierto' order by ticket.estado, ticket.numero desc limit $pagina,".$_SESSION['pagina']."";
		}

		//echo $sql;
		$sth = $this->dbh->query($sql);
		return $sth->fetchAll(PDO::FETCH_OBJ);
	}
	public function ticket_buscar($texto){

		if($_SESSION['nivel']==666){
			$sql="select * from ticket where
			(idde_cliente=".$_SESSION['idusuario']." or idpara_cliente=".$_SESSION['idusuario'].")
			and idpadre is null order by estado, numero desc ";
		}

		//if($key->nivel==1) echo "Admin General";

		if($_SESSION['nivel']==1){
			$sql="select ticket.* from ticket
			where
			(ticket.idde_usuario=".$_SESSION['idusuario']." or ticket.idpara_usuario=".$_SESSION['idusuario']." or ticket.idde_cliente is not null)
			and ticket.idpadre is null and (ticket.) order by ticket.estado, ticket.numero desc";
		}
		//if($key->nivel==2) echo "Terapeuta";
		if($_SESSION['nivel']==2){
			$sql="select ticket.* from ticket where
			(idde_usuario=".$_SESSION['idusuario']." or idpara_usuario=".$_SESSION['idusuario'].")
			and idpadre is null order by estado, numero desc";
		}
		//if($key->nivel==3) echo "Admin Sucursal";
		if($_SESSION['nivel']==3){
			$sql="select ticket.* from ticket
			LEFT OUTER JOIN clientes ON clientes.id = ticket.idde_cliente
			where
			(ticket.idde_usuario=".$_SESSION['idusuario']." or ticket.idpara_usuario=".$_SESSION['idusuario']." or clientes.idsucursal=".$_SESSION['idsucursal'].")
			and ticket.idpadre is null order by ticket.estado, ticket.numero desc ";
		}
		//if($key->nivel==4) echo "Secretaria";
		if($_SESSION['nivel']==4){
			$sql="select ticket.* from ticket
			where
			(ticket.idde_usuario=".$_SESSION['idusuario']." or ticket.idpara_usuario=".$_SESSION['idusuario']." or ticket.idde_cliente is not null)
			and ticket.idpadre is null order by ticket.estado, ticket.numero desc";
		}

		//echo $sql;
		$sth = $this->dbh->query($sql);
		return $sth->fetchAll(PDO::FETCH_OBJ);
	}

	public function personal_e(){
		$sql="select * from usuarios where idusuario!='".$_SESSION['idusuario']."'";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetchAll(PDO::FETCH_OBJ);
	}

	public function cliente_editar($id){
		try{
			$sql="select * from clientes where id=$id";
			$sth = $this->dbh->query($sql);
			return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function usuarios_editar($id){
		try{
			$sql="select * from usuarios where idusuario=$id";
			$sth = $this->dbh->query($sql);
			return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function cerrar_ticket(){
		$x="";
		$arreglo =array();
		$idticket=$_REQUEST['idticket'];
		$arreglo+=array('estado'=>"Finalizado");
		$x=$this->update('ticket',array('idticket'=>$idticket), $arreglo);
		return $x;
	}

}

$db = new Ticket();
if(strlen($function)>0){
	echo $db->$function();
}
