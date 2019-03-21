<?php
global $api;
if(empty($api)) die();


$api->out( $api->Accounting_JAO->get1mj() );

?>