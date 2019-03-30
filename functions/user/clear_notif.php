<?php 

global $api;
if(empty($api)) die();

//check fields
$api->required_fields(array("user_id","count"));

$user = $api->users->get(array("id"=>$api->params->user_id));
if(count($user) == 0) $api->out( $api->params->user_id , 0 , "User Not found." );
$user = $user[0];
if(!isset($user->data->received_notifs)) $user->data->{"received_notifs"} = 0;

//new count
$user->data->received_notifs = $user->data->received_notifs + $api->params->count;

$api->users->update(array("data"=>$user->data),array("id"=>$api->params->user_id));

$api->out( $user );



 ?>