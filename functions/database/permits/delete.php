<?php 

global $api;
if(empty($api)) die();

//check fields
$api->required_fields(array("user_id","type"));

$d = $api->permits->get(array(
        "type"=>$api->params->type
    ));

if(count($d) == 0) $api->out( "",0,"no data.." );

$now = DateTime::createFromFormat('U.u', microtime(true));
$upload_folder = "/uploads/database/permits/deleted/";
    if (!file_exists($upload_folder)) { mkdir($upload_folder, 0777, true); }

$saveJson = fopen($upload_folder. $api->params->type . "-" . date('Y-m-d').".json","w");
fwrite($saveJson,json_encode($d));
fclose($saveJson);

$api->permits->delete(
    array(
        "type"=>$api->params->type,
        "user_id"=>$api->params->user_id
    ));
$api->out( "Database Deleted" );



 ?>