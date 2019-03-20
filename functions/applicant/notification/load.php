<?php 
    global $api;
    
    //require some fields
    $api->required_fields(array("user_id"));

    //get notif
    $d = $api->permitting_notifications->get(array("user_id"=>$api->params->user_id),null,"DESC","id",100);
    
    if(count($d) > 0){
        $api->out( $d );
    }else {
        $api->out( "",0, " Empty Notification " );
    }
    

?>