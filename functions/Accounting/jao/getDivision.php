<?php
global $api;
if(empty($api)) die();


$api->out( $api->Accounting_JAO->get02mj(array(
    "Month_Date"=>$api->params->Month_Date,
    "Year_Date"=>$api->params->Year_Date,
    )) );

?>