<?php 

    global $api;

    //require some fields
    $api->required_fields(array("id","path","data"));

    //check if existing account
    $exist = $api->permitting_accounts->exist(array("id"=>$api->params->id));
    if(!$exist)
        $api->out($api->params->user_name,0,"Account not found...");

    //get user
    $user = $api->permitting_accounts->get(array("id"=>$api->params->id))[0];

    $paths = explode("/",$api->params->path);
    switch (count($paths)) {
        case 1:
            $user->data->{$paths[0]} = $api->params->data;
            break;
        case 2:
            $user->data->{$paths[0]}->{$paths[1]} = $api->params->data;
            break;
        case 3:
            $user->data->{$paths[0]}->{$paths[1]}->{$paths[2]} = $api->params->data;
            break;
        case 4:
            $user->data->{$paths[0]}->{$paths[1]}->{$paths[2]}->{$paths[3]} = $api->params->data;
            break;
        
        default:
            $user->data = $api->params->data;
            break;
    }
    
    $api->permitting_accounts->update(array("data"=>$user->data),array("id"=>$api->params->id));

    //return
    $api->out( "account updated" );

?>