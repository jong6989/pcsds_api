<?php 
    global $api;
    
    //require some fields
    $api->required_fields(array("user_id","id","remark"));

    $where = array("id"=>$api->params->user_id);
    if(!$api->users->exist($where)) $api->out( "",0,"Invalid User" );
    $user = $api->users->get($where)[0];
    if($user->user_level != 7) $api->out( "",0,"Invalid Access" );

    $d = $api->transactions->get(array("id"=> $api->params->id));
    if(count($d) == 0) if($user->user_level == 0) $api->out( "",0,"Transaction number invalid" );
    $d = $d[0];

    $d->data->application->status = "Approved, for recomendation";

    $staff = $api->users->get(array("id"=>$api->params->user_id ),"id,data")[0];

    //set update data
    $d->data->{"approved"} = array(
        "staff" => $staff,
        "remark" => $api->params->remark,
        "date" => date("Y-m-d H:i:s")
    );

    //transaction update
    $api->transactions->update(
        array("data"=>$d->data,"status"=>4),
        array("id"=>$api->params->id)
    );

    $d->status = 4;
    $d->{"user"} = $api->permitting_accounts->get(array("id"=>$d->user_id ))[0];

    //return
    $api->out( $d );

?>