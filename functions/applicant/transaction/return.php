<?php 
    global $api;
    include './././includes/notif.php';
    include './././includes/tread.php';
    $notif = new notif($api);
    $tread = new tread($api);
    
    //require some fields
    $api->required_fields(array("user_id","id","remark"));

    $where = array("id"=>$api->params->user_id);
    if(!$api->users->exist($where)) $api->out( "",0,"Invalid User" );

    $d = $api->transactions->get(array("id"=> $api->params->id));
    if(count($d) == 0) if($user->user_level == 0) $api->out( "",0,"Transaction number invalid" );
    $d = $d[0];

    $d->data->application->status = "For Revision";

    $staff = $api->users->get(array("id"=>$api->params->user_id ),"id,data")[0];

    $d->status = ($d->status == 3)? 1 : $d->status - 1;
    //transaction update
    $api->transactions->update(
        array("data"=>$d->data,"status"=> $d->status ),
        array("id"=>$api->params->id)
    );

    //add to tread
    // $tread->single($api->params->id,array(
    //     "staff" => $staff->data->first_name . " " . $staff->data->last_name,
    //     "message" => base64_encode($api->params->remark),
    //     "date" => date("Y-m-d H:i:s")
    // ));

    // notify enforcers 
    // $notif->by_level([5,6,7],"transaction",$api->params->id,array(
    //     "message"=> $d->name . " was Returned by " . $staff->data->first_name . " " . $staff->data->last_name,
    //     "transaction_id" => $api->params->id,
    //     "staff_id" => $staff->id
    // ));

    
    $d->{"user"} = $api->permitting_accounts->get(array("id"=>$d->user_id ))[0];

    //return
    $api->out( $d );

?>