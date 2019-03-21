<?php
global $api;
if(empty($api)) die();

//$api->required_fields(array("ObrNo","data"));

if($api->Accounting_JAO->exist(array("ObrNo"=>$api->params->ObrNo))) $api->out( $api->params->ObrNo,0, "Already Exist Check the OBR Number!" );

$api->Accounting_JAO->create(array (
    "ObrNo" => $api->params->ObrNo,
    "data" => $api->params->data,
    "AllotmentClass" => $api->params->AllotmentClass,
    "Type_Expenses" => $api->params->Type_Expenses,
    "Month_Date" => $api->params->Month_DATE,
    "Year_Date" => $api->params->Year_Date,
    "DIVISION" => $api->params->DIVISION,
    
));

$api->out("DATA Added");
?>