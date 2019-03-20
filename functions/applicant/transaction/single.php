<?php 
    global $api;
    
    //require some fields
    $api->required_fields(array("user_id"));

    //return
    $api->out( $api->transactions->get(array("user_id"=>$api->params->user_id)) );

?>