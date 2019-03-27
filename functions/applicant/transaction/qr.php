<?php 
    global $api;
    
    //require some fields
    $api->required_fields(array("id"));

    $res = $api->transactions->get(array("id"=>$api->params->id));
    //return
    $api->out( (count($res) > 0)? $res[0] : 0 );

?>