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

class Agenda extends ipsi{

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
	public function agenda_lista($pagina,$idsucursal,$idusuario,$fecha_cita,$idpaciente){
		try{
			$pagina=$pagina*$_SESSION['pagina'];

			$sql="SELECT idcita, citas.desde, citas.hasta, citas.estatus, citas.estatus_paciente, sucursal.nombre as sucursalx, clientes.nombre, clientes.apellidop, clientes.apellidom, usuarios.nombre as usnombre, usuarios.apellidop as usapellidp, usuarios.apellidom as usapellidom, consultorio.nombre as consultorio, citas.ubicacion FROM citas";
			$ac=0;
			$query="";

			if(strlen($idsucursal)>0){
				if($ac==1) $query.=" and ";
				$query.=" citas.idsucursal=$idsucursal";
				$ac=1;
			}
			if(strlen($idusuario)>0){
				if($ac==1) $query.=" and ";
				$query.=" citas.idusuario=$idusuario";
				$ac=1;
			}
			if(strlen($fecha_cita)>0){
				if($ac==1) $query.=" and ";
				$query.=" (desde>='$fecha_cita 00:00:00' and hasta<='$fecha_cita 23:59:59')";
				$ac=1;
			}
			if(strlen($idpaciente)>0){
				if($ac==1) $query.=" and ";
				$query.=" citas.idpaciente=$idpaciente";
				$ac=1;
			}
			$sql.=" left outer join sucursal on sucursal.idsucursal=citas.idsucursal";
			$sql.=" left outer join clientes on clientes.id=citas.idpaciente";
			$sql.=" left outer join usuarios on usuarios.idusuario=citas.idusuario";
			$sql.=" left outer join consultorio on consultorio.idconsultorio=citas.idconsultorio";
			if($ac==1){
				$sql=$sql." where ".$query." ";
			}
			if($_SESSION['nivel']==1 or $_SESSION['nivel']==4)
			{

			}
			if($_SESSION['nivel']==3){
				if($ac==1){
					$sql.=" and ";
				}
				else{
					$sql.=" where ";
				}
				$sql.="sucursal.idsucursal=".$_SESSION['idsucursal'];
			}
			if($_SESSION['nivel']==2){
				if($ac==1){
					$sql.=" and ";
				}
				else{
					$sql.=" where ";
				}
				$sql.="usuarios.idusuario=".$_SESSION['idusuario'];
			}

			$sql.=" limit $pagina,".$_SESSION['pagina']."";
			//echo $sql;
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function agenda_buscar($texto){
		$texto=clean_var($texto);
		try{
			/*
				if($_SESSION['nivel']==1 or $_SESSION['nivel']==4)
				$sql="SELECT idcita, citas.desde, citas.hasta, citas.estatus, citas.estatus_paciente, sucursal.nombre as sucursalx, clientes.nombre, clientes.apellidop, clientes.apellidom, usuarios.nombre as usnombre, usuarios.apellidop as usapellidp, usuarios.apellidom as usapellidom, consultorio.nombre as consultorio, citas.ubicacion FROM citas";

				if($_SESSION['nivel']==2)
				$sql="SELECT idcita, citas.desde, citas.hasta, citas.estatus, citas.estatus_paciente, sucursal.nombre as sucursalx, clientes.nombre, clientes.apellidop, clientes.apellidom, usuarios.nombre as usnombre, usuarios.apellidop as usapellidp, usuarios.apellidom as usapellidom, consultorio.nombre as consultorio, citas.ubicacion FROM citas where idusuario='".$_SESSION['idusuario']."'";

				if($_SESSION['nivel']==666)
				$sql="SELECT idcita, citas.desde, citas.hasta, citas.estatus, citas.estatus_paciente, sucursal.nombre as sucursalx, clientes.nombre, clientes.apellidop, clientes.apellidom, usuarios.nombre as usnombre, usuarios.apellidop as usapellidp, usuarios.apellidom as usapellidom, consultorio.nombre as consultorio, citas.ubicacion FROM citas where idpaciente='".$_SESSION['idusuario']."'";

			*/

			$sql="SELECT idcita, citas.desde, citas.hasta, citas.estatus, citas.estatus_paciente, sucursal.nombre as sucursalx, clientes.nombre, clientes.apellidop, clientes.apellidom, usuarios.nombre as usnombre, usuarios.apellidop as usapellidp, usuarios.apellidom as usapellidom, consultorio.nombre as consultorio, citas.ubicacion FROM citas";
			$ac=0;
			$query="";


			$sql.=" left outer join sucursal on sucursal.idsucursal=citas.idsucursal";
			$sql.=" left outer join clientes on clientes.id=citas.idpaciente";
			$sql.=" left outer join usuarios on usuarios.idusuario=citas.idusuario";
			$sql.=" left outer join consultorio on consultorio.idconsultorio=citas.idconsultorio";

			if($_SESSION['nivel']==1 or $_SESSION['nivel']==4){
				$sql.=" where clientes.nombre like '%$texto%'";
			}
			if($_SESSION['nivel']==3){
					$sql.="where sucursal.idsucursal=".$_SESSION['idsucursal'];
			}
			if($_SESSION['nivel']==2){
				$sql.=" where usuarios.idusuario=".$_SESSION['idusuario']." and clientes.nombre like '%$texto%'";
			}
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function cita($id){
		try{
			$sql="select * from citas where idcita=:id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":id",$id);
			$sth->execute();
			return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function conss($id){
		$sql="select * from consultorio where idconsultorio=$id";
		$sth = $this->dbh->query($sql);
		return $sth->fetch(PDO::FETCH_OBJ);
	}

	public function pacientes(){
		try{
			/*
			if($key->nivel==1) echo "Admin General";
			if($key->nivel==2) echo "Terapeuta";
			if($key->nivel==3) echo "Admin Sucursal";
			if($key->nivel==4) echo "Secretaria";
			*/

			if($_SESSION['nivel']==1 or $_SESSION['nivel']==4)
			$sql="SELECT * FROM clientes";

			if($_SESSION['nivel']==2)
			$sql="select * from cliente_terapeuta left outer join clientes on clientes.id=cliente_terapeuta.idcliente where idsucursal='".$_SESSION['idsucursal']."' and cliente_terapeuta.idusuario='".$_SESSION['idusuario']."'";

			if($_SESSION['nivel']==3)
			$sql="SELECT * FROM clientes where idsucursal='".$_SESSION['idsucursal']."'";

			if($_SESSION['nivel']==666)
			$sql="SELECT * FROM clientes where id='".$_SESSION['idusuario']."'";

			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function sucursal(){
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
	public function terapueutas(){
		if($_SESSION['nivel']==666){
			$sql="select * from cliente_terapeuta left outer join usuarios on usuarios.idusuario=cliente_terapeuta.idusuario where nivel=2 and cliente_terapeuta.idcliente='".$_SESSION['idusuario']."'";
		}

		if($_SESSION['nivel']==1 or $_SESSION['nivel']==4)
		$sql="select * from usuarios where nivel=2";

		if($_SESSION['nivel']==2)
		$sql="select * from usuarios where idusuario='".$_SESSION['idusuario']."'";

		if($_SESSION['nivel']==3)
		$sql="select * from usuarios where nivel=2 and idsucursal='".$_SESSION['idsucursal']."'";

		$sth = $this->dbh->query($sql);
		return $sth->fetchAll(PDO::FETCH_OBJ);
	}
	public function agregar_cita(){
		$arreglo =array();

		$idcita=$_REQUEST['idcita'];

		$fdesde=$_REQUEST['fdesden'];
		$fhasta=$_REQUEST['fhastan'];
		$fecha=$_REQUEST['fechan'];

		$h_desde = new DateTime($fdesde);
		$h_hasta = new DateTime($fhasta);

		$total_desde=$fecha." ".$h_desde->format("H:i");
		$total_hasta=$fecha." ".$h_hasta->format("H:i");

		$arreglo+=array('desde'=>$total_desde);
		$arreglo+=array('hasta'=>$total_hasta);

		if($idcita==0){
			if (isset($_REQUEST['idusuarion'])){
				$arreglo+=array('idusuario'=>$_REQUEST['idusuarion']);
			}
			if (isset($_REQUEST['idpacienten'])){
				$arreglo+=array('idpaciente'=>$_REQUEST['idpacienten']);
			}
			if (isset($_REQUEST['idsucursaln'])){
				$arreglo+=array('idsucursal'=>$_REQUEST['idsucursaln']);
			}
			$arreglo+=array('estatus'=>"Pendiente");
			$x=$this->insert('citas', $arreglo);
		}
		else{
			$x=$this->update('citas',array('idcita'=>$idcita), $arreglo);
		}
		return $x;
	}
	public function sucursal_($id){
		try{
			$sql="SELECT * FROM sucursal where idsucursal='$id'";
			$sth = $this->dbh->query($sql);
			return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function terapueuta_($id){
		$sql="select * from usuarios where idusuario='$id'";
		$sth = $this->dbh->query($sql);
		return $sth->fetch(PDO::FETCH_OBJ);
	}
	public function cliente_($id){
		$sql="select * from clientes where id='$id'";
		$sth = $this->dbh->query($sql);
		return $sth->fetch(PDO::FETCH_OBJ);
	}
	public function terapeuta_($id){
		$sql="select * from usuarios where idusuario='$id'";
		$sth = $this->dbh->query($sql);
		return $sth->fetch(PDO::FETCH_OBJ);
	}
	public function cita_quitar(){
		$idcita=$_REQUEST['idcita'];
		return $this->borrar('citas',"idcita",$idcita);
		/*
		$arreglo=array();
		$arreglo+=array('idconsultorio'=>null);
		$arreglo+=array('estatus'=>"Cancelada");
		$arreglo+=array('con_desde'=>null);
		$arreglo+=array('con_hasta'=>null);
		$arreglo+=array('desde_dia'=>null);
		$arreglo+=array('fecha_notif'=>null);
		$arreglo+=array('online'=>null);
		$arreglo+=array('estatus_paciente'=>null);
		$x=$this->update('citas',array('idcita'=>$idcita), $arreglo);
		return $x;
		*/


	}
	public function consultorios($desde,$hasta,$dia){
		try{
			$fdesde = new DateTime($desde);
			$xdesde="2021-01-01 ".$fdesde->format("H:i").":00";

			$sql="select * from consultorio_horarios left outer join consultorio on consultorio.idconsultorio=consultorio_horarios.idconsultorio
			where consultorio_horarios.desde_dia='$dia' and desde='$xdesde'";
			$sth = $this->dbh->query($sql);
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function consultorios_sug($desde,$hasta,$dia,$terapeuta){
		try{
			$fdesde = new DateTime($desde);
			$xdesde="2021-01-01 ".$fdesde->format("H:i").":00";

			$sql="select consultorio_horarios.*,consultorio.* from consultorio_horarios
			left outer join consultorio on consultorio.idconsultorio=consultorio_horarios.idconsultorio
			left outer join consultorio_sug on consultorio_sug.idconsultorio=consultorio.idconsultorio
			where consultorio_horarios.desde_dia='$dia' and desde='$xdesde' and consultorio_sug.idusuario=$terapeuta";
			$sth = $this->dbh->query($sql);
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}

	public function agregar_consultorio(){
		$arreglo =array();

		$idconsultorio=$_REQUEST['idconsultorio'];
		$idcita=$_REQUEST['idcita'];
		$cita=$this::cita($idcita);
		$cliente=$this::cliente_($cita->idpaciente);
		$terap=$this::terapeuta_($cita->idusuario);

		$desdedia=$_REQUEST['desdedia'];

		$condesde=$_REQUEST['condesde'];
		$fdesde = new DateTime($condesde);

		$conhasta=$_REQUEST['conhasta'];
		$fhasta = new DateTime($conhasta);

		$fechan=$_REQUEST['fechan'];
		$fcita = new DateTime($fechan);

		$pdesde=$fcita->format("Y-m-d")." ".$fdesde->format("H:i").":00";
		$phasta=$fcita->format("Y-m-d")." ".$fhasta->format("H:i").":00";

		$arreglo+=array('idconsultorio'=>$idconsultorio);
		$arreglo+=array('con_desde'=>$pdesde);
		$arreglo+=array('con_hasta'=>$phasta);
		$arreglo+=array('desde_dia'=>$desdedia);
		$arreglo+=array('estatus'=>"Aprobada");
		$arreglo+=array('ubicacion'=>"Fisica");
		$x=$this->update('citas',array('idcita'=>$idcita), $arreglo);

		$correo=$cliente->correo;
		$tipo="aprobar";
		$variables=array();
		$variables+=array("terapeuta"=>$terap->nombre." ".$terap->apellidop." ".$terap->apellidom);
		$variables+=array("horario"=>fecha($cita->desde,3));

		$ccp=array();
		$ccp+=array($cliente->correo);


		$this->correo($correo,$ccp, $variables, $tipo);
		return $x;
	}
	public function agregar_online(){
		$arreglo =array();
		$idcita=$_REQUEST['idcita'];
		$texto_linea=$_REQUEST['texto_linea'];

		$cita=$this::cita($idcita);
		$cliente=$this::cliente_($cita->idpaciente);
		$terap=$this::terapeuta_($cita->idusuario);

		$arreglo+=array('online'=>$texto_linea);
		$arreglo+=array('ubicacion'=>"En linea");
		$arreglo+=array('estatus'=>"Aprobada");
		$x=$this->update('citas',array('idcita'=>$idcita), $arreglo);

		$correo=$cliente->correo;
		$tipo="aprobar_online";
		$variables=array();
		$variables+=array("terapeuta"=>$terap->nombre." ".$terap->apellidop." ".$terap->apellidom);
		$variables+=array("horario"=>fecha($cita->desde,3));
		$variables+=array("enlace"=>$texto_linea);

		$ccp=array();
		$ccp+=array($terap->correo);

		$this->correo($correo, $ccp, $variables, $tipo);
		return $x;
	}
	public function paciente_confirma(){
		$idcita=$_REQUEST['idcita'];
		$arreglo=array();
		$arreglo+=array("estatus_paciente"=>"Confirmar");
		$x=$this->update('citas',array("idcita"=>$idcita),$arreglo);


		return $x;
	}


	public function terap_suc(){
		$idsucursal=$_REQUEST['idsucursal'];

		$sql="select * from usuarios where nivel=2 and idsucursal='$idsucursal'";
		$sth = $this->dbh->query($sql);
		$terapeutas=$sth->fetchAll(PDO::FETCH_OBJ);
		echo "<label for=''>Terapeuta</label>";
		echo "<select name='idusuario' id='idusuario' class='form-control'>";
		echo "<option value='' disabled selected>Seleccione una opcion</option>";
			foreach($terapeutas as $key){
				echo  "<option value='$key->idusuario' >$key->nombre $key->apellidop $key->apellidom</option>";
			}
		echo "</select>";

	}
	public function pac_suc(){
		$idsucursal=$_REQUEST['idsucursal'];
		$sql="select * from clientes where idsucursal='$idsucursal'";
		$sth = $this->dbh->query($sql);
		$pacientes=$sth->fetchAll(PDO::FETCH_OBJ);
		echo "<label for='idpaciente'>Pacientes</label>";
		echo "<select name='idpaciente' id='idpaciente' class='form-control' >";
		echo "<option value='' disabled selected>Seleccione una opcion</option>";
			foreach($pacientes as $key){
				echo  "<option value=".$key->id;
				if ($key->id==$idpaciente){
					echo  " selected ";
				}
				echo  ">$key->nombre $key->apellidop $key->apellidom</option>";
			}
		echo "</select>";

	}
}

$db = new Agenda();
if(strlen($function)>0){
	echo $db->$function();
}
