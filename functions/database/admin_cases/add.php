<?php 

global $api;
if(empty($api)) die();

//check fields
$api->required_fields(array("case_no","date_filed","data"));

//check duplicate
if($api->pab_admin_cases->exist(array("case_no"=>$api->params->case_no))) 
	$api->out( $api->params->case_no,0,"Case exist!" );

$api->pab_admin_cases->create(
	array(
		"case_no" => $api->params->case_no,
		"date_filed" => $api->params->date_filed,
		"data" => $api->params->data,
		"date" => date("Y-m-d H:i:s")
	));

$api->out( "Case Added!" );



 ?>