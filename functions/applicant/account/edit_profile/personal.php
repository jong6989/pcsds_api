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

    $user->data->place_of_birth = $fData->place_of_birth;
    $user->data->nationality = $fData->nationality;
    $user->data->gender = $fData->gender;
    $user->data->civil_status = $fData->civil_status;
    $user->data->spouse_name = $fData->spouse_name;
    $user->data->father = $fData->father;
    $user->data->mother = $fData->mother;
    
    $api->permitting_accounts->update(array("data"=>$user->data),array("id"=>$api->params->id));

    //return
    $api->out( $user->data );

?>