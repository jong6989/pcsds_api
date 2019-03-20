<?php 

global $api;
if(empty($api)) die();

//check fields
$api->required_fields(array("data"));

//check duplicate
if($api->intel->exist(array("data"=>$api->params->data))) 
	$api->out( $api->params->data,0,"Duplicated Info..." );

$api->intel->create(
	array(
		"data" => $api->params->data,
		"date" => date("Y-m-d H:i:s")
	));

$api->out( $api->intel->last() );



 ?>