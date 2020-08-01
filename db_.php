<?php
require_once("control_db.php");

class dashboard extends ipsi{
	public $nivel_personal;
	public $nivel_captura;
	public function __construct(){
		parent::__construct();
	}
}

$db = new dashboard();
