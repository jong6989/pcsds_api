<?php 

global $api;
if(empty($api)) die();

//check fields
$api->required_fields(array("id","password"));

$h =  create_hash($api->params->password);// php 5
// $h = password_hash($api->params->user_key, PASSWORD_ARGON2I);//php 7

$api->users->update(array("user_key"=>$h),array("id"=>$api->params->id));

$api->out( "Password Changed!" );



 ?>