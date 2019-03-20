<?php 

global $api;
if(empty($api)) die();

$d = $api->wp53_pdt_assignee->get();

if(count($d) > 0){
    $api->out( $d );
}else {
    $api->out("No new Data...",0,"");
}

 ?>