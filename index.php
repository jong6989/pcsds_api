<?php 
header('Access-Control-Allow-Origin: *'); 
header('content-type: application/json; charset=utf-8');
date_default_timezone_set('Asia/Manila');
$php_params = json_decode(file_get_contents('php://input'), true);
$request_params = $_REQUEST;
$params = array();

ini_set('display_errors',1); 
// error_reporting(E_ALL);

if(!empty($php_params)){
	foreach ($php_params as $key => $value) {
		$params[$key] = $value;
	}
}
if(!empty($request_params )){
	foreach ($request_params as $key => $value) {
		$params[$key] = $value;
	}
}	
if(empty($params)){
	echo "request is blocked!..";
	exit();
	die();	
}

require("settings.php");
require("JongDb.php");
require("api.php");

include 'includes/PasswordHash.php';

$api = new api();
$api->params = new _($params);

foreach (settings::$databaseInstall as $k => $v) {
	if(count($v) == 3)
		$api->{$v[1]} = new JongDb($v[0],$v[1],$v[2]);
}
if($api->users->count() == 0){
	foreach (settings::$initialData as $k => $v) {
		if(count($v) == 2){
			if(!$api->{$v[0]}->exist($v[1])){
				$v[1]["date"] = date("Y-m-d H:i:s");
				$api->{$v[0]}->create($v[1]);
			}
		}
	}
}

function convert_from_latin1_to_utf8_recursively($dat)
{
	if (is_string($dat)) {
		return utf8_encode($dat);
	} elseif (is_array($dat)) {
		$ret = [];
		foreach ($dat as $i => $d) $ret[ $i ] = convert_from_latin1_to_utf8_recursively($d);

		return $ret;
	} elseif (is_object($dat)) {
		foreach ($dat as $i => $d) $dat->$i = convert_from_latin1_to_utf8_recursively($d);

		return $dat;
	} else {
		return $dat;
	}
}

$api->required_fields(array("action"));
$f_name = "functions/" . $params["action"] . ".php";
$_GLOBAL["api"] = $api;
if( file_exists($f_name) ){
	include($f_name);
}else {
	$api->out($params["action"],0,"function not found!");
}

 ?>