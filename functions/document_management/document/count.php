<?php 

global $api;
if(empty($api)) die();

$api->out( $api->wp53_pdt_documents->count() );

 ?>