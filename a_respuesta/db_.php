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
				$texto=$_REQUEST['texto_'.$idcontexto];
				$arreglo+=array('texto'=>$texto);
			}
			else if($contexto->tipo=="textocorto"){
				$arreglo+=array('marca'=>"leido");
				$texto=$_REQUEST['texto_'.$idcontexto];
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
						if($id_ctrol!="otro"){
							$arreglo+=array('idrespuesta'=>$_REQUEST["checkbox_".$id_ctrol]);
							$sql="select * from respuestas where id=".$_REQUEST["checkbox_".$id_ctrol];
							$sth = $this->dbh->prepare($sql);
							$sth->execute();
							$resp=$sth->fetch(PDO::FETCH_OBJ);
							$arreglo+=array('valor'=>$resp->valor);
						}
						else{
							$arreglo+=array('valor'=>"OTRO");
						}
						$arreglo+=array('texto'=>$texto);
						$arreglo+=array('idcontexto'=>$idcontexto);
						$arreglo+=array('marca'=>"leido");
						$x=$this->insert('contexto_resp', $arreglo);
					}
					if (strpos($key, 'radio') !== false) {
						$ic = explode("_", $key);
						$id_ctrol=$ic[1];

						$texto="";
						$valor=clean_var($_REQUEST["radio_".$id_ctrol]);

						if(isset($_REQUEST["resp_".$valor])){
							$texto=clean_var($_REQUEST["resp_".$valor]);
						}
						if($valor!="otro"){
							$sql="select * from respuestas where id=".$_REQUEST["radio_".$id_ctrol];
							$sth = $this->dbh->prepare($sql);
							$sth->execute();
							$resp=$sth->fetch(PDO::FETCH_OBJ);
							$arreglo+=array('idrespuesta'=>$resp->id);
							$arreglo+=array('valor'=>$resp->valor);
						}
						else{
							$arreglo+=array('valor'=>"OTRO");
						}
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
			}
			$resp=json_decode($x);
			if($resp->error==0){
				$arreglo=array();
				$arreglo+=array('id1'=>$resp->id1);
				$arreglo+=array('error'=>$resp->error);
				$arreglo+=array('idsubactividad'=>$contexto->idsubactividad);

				$sql="SELECT count(contexto.id) as total from contexto where idsubactividad = $contexto->idsubactividad and (contexto.tipo='pregunta' or contexto.tipo='textores' or contexto.tipo='textocorto' or contexto.tipo='fecha'  or contexto.tipo='archivores')";
				$contx = $this->dbh->prepare($sql);
				$contx->execute();
				$bloques=$contx->fetch(PDO::FETCH_OBJ);

				$sql="SELECT count(contexto_resp.id) as total FROM	contexto right OUTER JOIN contexto_resp ON contexto_resp.idcontexto=contexto.id WHERE	idsubactividad = :id	group by contexto.id";
				$contx = $this->dbh->prepare($sql);
				$contx->bindValue(":id",$contexto->idsubactividad);
				$contx->execute();
				$total=0;
				if($contx->rowCount()){
					$total=(100*$contx->rowCount())/$bloques->total;
				}
				$y= "(".$contx->rowCount()."/".$bloques->total.")<br>";
				$y.= "<progress id='file' value='$total' max='100'> $total %</progress>";

				$arreglo+=array('progreso'=>$y);

				$sql="select * from subactividad where idsubactividad=$contexto->idsubactividad";
				$sth = $this->dbh->prepare($sql);
				$sth->execute();
				$sub=$sth->fetch(PDO::FETCH_OBJ);
				$arreglo+=array('idactividad'=>$sub->idactividad);
				$idactividad=$sub->idactividad;
				//////////////////////
				$sql="SELECT count(contexto.id) as total from contexto
				left outer join subactividad on subactividad.idsubactividad=contexto.idsubactividad
				where subactividad.idactividad=$idactividad and (contexto.tipo='pregunta' or contexto.tipo='textores'  or contexto.tipo='textocorto' or contexto.tipo='fecha'  or contexto.tipo='archivores')";
				$contx = $this->dbh->prepare($sql);
				$contx->execute();
				$bloques=$contx->fetch(PDO::FETCH_OBJ);

				$sql="SELECT count(contexto_resp.id) as total FROM	contexto
				right OUTER JOIN contexto_resp ON contexto_resp.idcontexto=contexto.id
				left outer join subactividad on subactividad.idsubactividad=contexto.idsubactividad
				where subactividad.idactividad=$idactividad
				group by contexto.id";
				$contx = $this->dbh->prepare($sql);
				$contx->execute();
				$total=0;
				if($contx->rowCount()){
					$total=(100*$contx->rowCount())/$bloques->total;
				}

					$y="(".$contx->rowCount()."/".$bloques->total.")<br>";
					$y.= "<progress id='file' value='$total' max='100'> $total %</progress>";
					$arreglo+=array('proact'=>$y);
				//////////////////////
				$x=json_encode($arreglo);
			}
			return $x;
		}
		catch(PDOException $e){
			return "Database access FAILED!";
		}
  }

	public function contexto_respuesta($idcontexto, $idactividad, $idpaciente){

		$sql="select * from contexto where id=:id";
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(":id",$idcontexto);
		$sth->execute();
		$row=$sth->fetch(PDO::FETCH_OBJ);


		$sql="select * from contexto_resp where idcontexto=$row->id";
		$contx = $this->dbh->prepare($sql);
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

		$visible=1;
		if($row->idcond){
			$visible=0;
			$sql="select * from contexto_resp where idrespuesta='$row->idcond'";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			$sth->fetch(PDO::FETCH_OBJ);
			if($sth->rowCount()){
				$visible=1;
			}
		}
		//if($visible){

			echo "<div class='card mb-2 cond_$row->idcond'>";
				echo "<div class='card-body'>";
					echo "<form is='resp-submit' id='form_g_".$row->id."' db='a_respuesta/db_' fun='guarda_respuesta' v_idactividad='$idactividad' v_idpaciente='$idpaciente' v_idcontexto='$row->id'>";

					if(strlen($row->observaciones)>0){
						echo "<div class='mb-3'>";
							echo $row->observaciones;
						echo "</div>";
						echo "<br>";
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
							echo "<textarea class='texto' id='texto_$row->id' name='texto_$row->id' rows=5 placeholder=''>$texto</textarea>";
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
							echo "<div class='container-fluid'>";
								$rx=$this->respuestas_ver($row->id);
								foreach ($rx as $respuesta) {
									$texto_resp="";
									$valor_resp="";
									$resp_idrespuesta="";

									//////////////////para obtener Respuestas
									$sql="select * from contexto_resp where idcontexto=:id and idrespuesta=:idrespuesta";
									$contx = $this->dbh->prepare($sql);
									$contx->bindValue(":id",$row->id);
									$contx->bindValue(":idrespuesta",$respuesta->id);
									$contx->execute();
									$resp=$contx->fetch(PDO::FETCH_OBJ);
									$correcta=0;
									$texto_resp="";
									if($contx->rowCount()>0){
										$correcta=1;
										$texto_resp=$resp->texto;
										$valor_resp=$resp->valor;
									}

									echo "<div class='row'>";
										echo "<div class='col-1'>";
											if($row->incisos==1){
												$idx="";
												echo "<input type='checkbox' is='s-submit' id='checkbox_".$respuesta->id."' name='checkbox_".$respuesta->id."' value='$respuesta->id' ";
												if($respuesta->valor==$valor_resp){ echo " checked";}
												echo ">";
											}
											else{
												$idx=$row->id;
												echo "<input type='radio' is='s-submit' id='radio_".$idx."' name='radio_".$idx."' value='$respuesta->id' ";
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

										echo "<div class='col-4'>";
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
										if($row->incisos==1){
												echo "<div class='col-1'>";
													echo "<input type='checkbox' is='s-submit' name='checkbox_otro'";
													if($otro==1){
														echo " checked";
													}
													echo " value='otro'>";
												echo "</div>";
												echo "<div class='col-10'>";
													echo "<input type='text' name='resp_otro' id='resp_otro' value='$texto' class='form-control form-control-sm' placeholder='otro'>";
												echo "</div>";
											}
											else{
												echo "<div class='col-1'>";
													echo "<input type='radio' is='s-submit' id='radio_".$idx."' name='radio_".$idx."' value='otro'";
													if($otro==1){
														echo " checked";
													}
													echo " value='1'>";
												echo "</div>";
												echo "<div class='col-10'>";
													echo "<input type='text' name='resp_otro' id='per_".$row->id."' value='$texto' class='form-control form-control-sm' placeholder='otro'>";
												echo "</div>";
										}
									echo "</div>";
								}
							echo "</div>";
						}
					echo "</div>";
					//<!-- Fin Preguntas  -->

					if($row->tipo=="textocorto" or $row->tipo=="textores" or $row->tipo=="fecha" or $row->tipo=="archivores"){
						if(strlen($marca)==0){
							echo "<button class='btn btn-danger btn-sm' type='submit'><i class='far fa-check-circle'></i>Contestar</button>";
						}
						else{
							echo "<button class='btn btn-warning btn-sm' type='submit'><i class='fas fa-check-double'></i>Actualizar</button>";
						}
					}
					echo "</form>";
				echo "</div>";
			echo "</div>";
	}
	public function upd(){
		$idcontexto=$_REQUEST['idcontexto'];
		$idactividad=$_REQUEST['idactividad'];
		$idpaciente=$_REQUEST['idpaciente'];
		$x=$this->contexto_respuesta($idcontexto, $idactividad, $idpaciente);
		return $x;
	}
}

$db = new Cliente();
if(strlen($function)>0){
	echo $db->$function();
}



?>
