<?php 
    global $api;
    
    //require some fields
    $api->required_fields(array("user_id","id"));

    //get notif
    $d = $api->permitting_notifications->get(array("user_id"=>$api->params->user_id,"id"=>$api->params->id));
    $api->permitting_notifications->update(
        array( "status" => 1 ),
        array( "id" => $api->params->id )
    );
    if(count($d) > 0){
        $d = $d[0];
        $v = $api->transactions->get(array("id"=>$d->data->transaction_id))[0];
        $d->data = (object) array_merge((array) $d->data, (array) $v->data);
        $api->out( $d );
    }else {
        $api->out( "",0, " Notification not found! " );
    }
    

?>