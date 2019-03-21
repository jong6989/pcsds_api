<?php
global $api;
if(empty($api)) die();

$api->required_fields(array("Year","data"));

//if($api->Accounting_JAO->exist(array("ObrNo"=>$api->params->ObrNo))) $api->out( $api->params->ObrNo,0, "Already Exist!" );

$api->Accounting_JAO_Budget->create(array (
    "Year" => $api->params->Year,
    "data" => $api->params->data,
    "Division" => $api->params->Division,
    "AllotmentClass" => $api->params->AllotmentClass,
    "Month" => $api->params->Month,

));

$api->out("DATA Added");
?>