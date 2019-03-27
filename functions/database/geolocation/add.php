<?php 

global $api;
if(empty($api)) die();

//check fields
$api->required_fields(array("data"));

$api->geolocation->create(
	array(
		"data" => $api->params->data,
		"date" => date("Y-m-d H:i:s")
	));

$api->out( "Geolocation saved!" );



 ?>