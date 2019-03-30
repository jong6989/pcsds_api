<?php 

global $api;
if(empty($api)) die();

$api->required_fields(array("offset","last_id","user_id"));

$where = array(
    "user_id" => "%," . $api->params->user_id . ",%"
);

$d = $api->notification->search($where,null,"ASC","id", 50, $api->params->offset);

if(count($d) > 0){
    if($d[ count($d) - 1 ]->id != $api->params->last_id){
        $api->out( $d );
    }
}
$api->out("No new Data...",0,"");

 ?>