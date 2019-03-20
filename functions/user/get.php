<?php 

global $api;
if(empty($api)) die();

//check fields
$api->required_fields(array("user_id"));

$where = array("id"=>$api->params->user_id);

if(!$api->users->exist($where)) $api->out( "",0,"Invalid User" );
$user = $api->users->get($where)[0];
if($user->user_level == 0) $api->out( "",0,"Invalid Access" );


$d = $api->users->get(null,"id,id_number,data,status,user_level,date,last_update");
$api->out( $d );



 ?>