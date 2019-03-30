<?php 
    global $api;
    
    //require some fields
    $api->required_fields(array("transaction_id","password","user_id"));

    //check exist
    $user = $api->users->get(array("id_number"=>$api->params->user_id));
    if(count($user) == 0) $api->out( $api->params->user_id,0,"User not found!" );
    $user = $user[0];

    $c_pass = $user->user_key;
    $v =  validate_password($api->params->password, $c_pass); //php 5
    if(!$v) $api->out( $api->params->password,0,"Incorrect KEY!" );
    $user->user_key = "";
    if(!$user->status) $api->out( $api->params->user_id,0,"Account is de-activated! Please Visit your Admin." );

    if(!isset($user->num_rows)){
        $res = $api->transactions->get(array("id"=>$api->params->transaction_id));
        $api->out( (count($res) > 0)? $res[0] : 0 );
    }else {
        if(count($user) == 0) $api->out( $api->params->password,0,"Incorrect KEY!" );
    }
	

?>