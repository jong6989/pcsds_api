<?php 

global $api;
if(empty($api)) die();

//check fields
$api->required_fields(array("data_name","user_id","type"));
if(!isset($api->params->data_item)) $api->params->data_item = array();
$d = $api->permits->exist(array(
        "type"=>$api->params->type,
        "data"=>$api->params->data_item,
        "sheet"=>$api->params->data_name,
        "user_id"=>$api->params->user_id
    ));

if($d) $api->out( "",0,"exist" );

$api->permits->create(
    array(
        "data" => $api->params->data_item,
        "sheet"=>$api->params->data_name,
        "user_id" => $api->params->user_id,
        "type" => $api->params->type,
        "date" => date("Y-m-d H:i:s")
    ));
$api->out( $api->permits->last() );



 ?>