<?php 

global $api;
if(empty($api)) die();

//check fields
$api->required_fields(array("id"));
//check exist
if(!$api->users->exist(array("id"=>$api->params->id))) $api->out( $api->params->id,0,"Account ID doesn't exist!" );

$user = $api->users->get(array("id"=>$api->params->id))[0];
$status = ($user->status==0 || $user->status=="0") ? 1:0;
$respond = ($user->status==0 || $user->status=="0") ? "Account Activated!":"Account De-activated!";
$api->users->update(array("status" => $status),array("id"=>$api->params->id));

$api->out( $respond );



 ?>