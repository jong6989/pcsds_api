<?php 
    global $api;
    
    //require some fields
    $api->required_fields(array("id","user_id"));

    $where = array("id"=>$api->params->user_id);
    if(!$api->users->exist($where)) $api->out( "",0,"Invalid User" );
    $user = $api->users->get($where)[0];
    if($user->user_level == 0) $api->out( "",0,"Invalid Access" );


    //return
    $d = $api->transactions->get(array("id"=>$api->params->id))[0];
    // echo var_dump($d);
    // die();
    $d->{"user"} = $api->permitting_accounts->get(array("id"=>$d->user_id ))[0];
    $api->out( $d );

?>