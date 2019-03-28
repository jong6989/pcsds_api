<?php
global $api;
if(empty($api)) die();

$api->out( $api->fuel_logs->get() );

?>