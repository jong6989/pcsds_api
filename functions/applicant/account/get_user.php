<?php 

global $api;
if(empty($api)) die();

//check fields
$api->required_fields(array("id","key"));

//check exist
if(!$api->permitting_accounts->exist(array("id"=>$api->params->id))) $api->out( $api->params->id,0,"User Not Found" );

$user = $api->permitting_accounts->get(array("id"=>$api->params->id))[0];

if($api->params->key != $user->user_pass) $api->out( $api->params->key,0,"invalid key" );

$api->out( $user );
	

 ?>