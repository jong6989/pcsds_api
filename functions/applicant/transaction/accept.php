<?php 
    global $api;
    
    //require some fields
    $api->required_fields(array("user_id","id","remark"));

    $where = array("id"=>$api->params->user_id);
    if(!$api->users->exist($where)) $api->out( "",0,"Invalid User" );
    $user = $api->users->get($where)[0];
    if($user->user_level == 0) $api->out( "",0,"Invalid Access" );

    $d = $api->transactions->get(array("id"=> $api->params->id));
    if(count($d) == 0) if($user->user_level == 0) $api->out( "",0,"Transaction number invalid" );
    $d = $d[0];

    $d->data->application->status = "Accepted,on Process";

    $staff = $api->users->get(array("id"=>$api->params->user_id ),"id,data")[0];

    //set update data
    $d->data->{"accepted"} = array(
        "staff" => $staff,
        "remark" => $api->params->remark,
        "date" => date("Y-m-d H:i:s")
    );

    //transaction update
    $api->transactions->update(
        array("data"=>$d->data,"status"=>3),
        array("id"=>$api->params->id)
    );

    $d->status = 3;
    $d->{"user"} = $api->permitting_accounts->get(array("id"=>$d->user_id ))[0];

    //return
    $api->out( $d );

?>