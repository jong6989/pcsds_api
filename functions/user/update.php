<?php 

global $api;
if(empty($api)) die();

//check fields
$api->required_fields(array("id","id_number","data","user_id","user_level"));
//check exist
$d = array(
	"id_number" => $api->params->id_number,
	"user_level" => $api->params->user_level,
	"data" => $api->params->data
);
if(isset($api->params->user_key))
	$d["user_key"] = $api->params->user_key;
	
$api->users->update($d,array("id"=>$api->params->id));

$api->out( "Account Updated!" );



 ?>