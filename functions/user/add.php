<?php 

global $api;
if(empty($api)) die();

//check fields
$api->required_fields(array("id_number","user_key","data","user_level","user_id"));

$x = $api->users->get(array("id"=>$api->params->user_id))[0];
if($x->user_level == 0 ) $api->out($api->params->user_id,0,"This account dont have the access ...");

//check duplicate
if($api->users->exist(array("id_number"=>$api->params->id_number))) $api->out( $api->params->id_number,0,"Username exist!" );

$h =  create_hash($api->params->user_key);// php 5

$api->users->create(array(
		"id_number" => $api->params->id_number,
		"user_key" => $h,
		"data" => $api->params->data,
		"user_level" => $api->params->user_level,
		"date" => date("Y-m-d H:i:s")
	));

$api->out( "Account Created!" );



 ?>