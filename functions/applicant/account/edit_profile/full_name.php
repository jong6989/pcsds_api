<?php 

    global $api;

    //require some fields
    $api->required_fields(array("id","password","data"));

    $fData = $api->params->data;

    //check if existing account
    $exist = $api->permitting_accounts->exist(array("id"=>$api->params->id));
    if(!$exist)
        $api->out($api->params->user_name,0,"Account not found...");

    //get user
    $user = $api->permitting_accounts->get(array("id"=>$api->params->id))[0];

    $c_pass = $user->user_pass;

    //check password
    // $v =  password_verify($api->params->password, $c_pass);// php 7
    $v =  validate_password($api->params->password, $c_pass); //php 5
    if(!$v) $api->out( $api->params->password,0,"Password incorrect!" );

    $user->data->first_name = $fData->first_name;
    $user->data->middle_name = $fData->middle_name;
    $user->data->last_name = $fData->last_name;
    $user->data->extension_name = $fData->extension_name;
    
    $api->permitting_accounts->update(array("data"=>$user->data),array("id"=>$api->params->id));

    //return
    $api->out( $user->data );

?>