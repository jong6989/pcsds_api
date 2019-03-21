<?php
global $api;
if(empty($api)) die();

$api->out( $api->Accounting_JAO_Budget->get(array (
    "Year" => $api->params->Year,
    "Division" => $api->params->Division,
    "AllotmentClass" => $api->params->AllotmentClass,
    "Month" => $api->params->Month,

)));

?>