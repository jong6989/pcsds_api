<?php 

    global $api;

    //require some fields
    $api->required_fields(array("id","data"));

    //check if existing account
    $exist = $api->permitting_accounts->exist(array("id"=>$api->params->id));
    if(!$exist)
        $api->out($api->params->user_name,0,"Account not found...");

    //get user
    $user = $api->permitting_accounts->get(array("id"=>$api->params->id))[0];

    if($user->data->chainsaws == null){
        $user->data->chainsaws = [];
    }
    $user->data->chainsaws[] = $api->params->data;
    
    $api->permitting_accounts->update(array("data"=>$user->data),array("id"=>$api->params->id));

    //return
    $api->out( $user->data );

?>