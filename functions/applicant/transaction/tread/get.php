<?php 
    global $api;
    //require some fields
    $api->required_fields(array("id"));
    $d = $api->conversation->get(array("item_id"=>$api->params->id,"item_type"=>"transaction"));
    if(count($d) < 1)
        $api->out( "",0,"Data not found" );
    $api->out( $d[0]->data );
?>