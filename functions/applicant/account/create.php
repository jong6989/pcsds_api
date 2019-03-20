<?php 

    global $api;
    //require some fields
    $api->required_fields(array("user_name","user_pass","data"));

    //check for duplicate account
    $exist = $api->permitting_accounts->exist(array("user_name"=>$api->params->user_name));
    if($exist)
        $api->out($api->params->user_name,0,"Account name is already taken...");

    //hash password
    // $h = password_hash($api->params->user_pass, PASSWORD_ARGON2I);//php 7
    $h =  create_hash($api->params->user_pass);// php 5

    //set array for creating account
    $new = array(
        "user_name"=> $api->params->user_name,
        "user_pass"=> $h,
        "data" => $api->params->data,
        "date" => date("Y-m-d H:i:s")
    );

    //create data
    // var_export($api->params->data);
    $err = $api->permitting_accounts->create($new);

    $exist = $api->permitting_accounts->exist(array("user_name"=>$api->params->user_name));
    if($exist){
        $api->out( $api->permitting_accounts->last() );
    }else {
        $api->out($err,0,"Registration Error...");
    }
        

    

?>