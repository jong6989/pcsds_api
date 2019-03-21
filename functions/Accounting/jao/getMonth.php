<?php
global $api;
if(empty($api)) die();

//$api->out( $api->Accounting_JAO->get01mj() );

//$api->required_fields(array("Year_Date"));


$api->out($api->Accounting_JAO->get01mj(array("Year_Date"=>$api->params->Year_Date)))

?>