<?php 
    global $api;
    include './././includes/notif.php';
    $notif = new notif($api);
    
    //require some fields
    $api->required_fields(array("user_id","id","remark"));

    $where = array("id_number"=>$api->params->user_id);
    if(!$api->users->exist($where)) $api->out( "",0,"Invalid User" );
    $user = $api->users->get($where)[0];
    // if($user->user_level != 6) $api->out( "",0,"Invalid Access" ); // open access

    $d = $api->transactions->get(array("id"=> $api->params->id));
    if(count($d) == 0) if($user->user_level == 0) $api->out( "",0,"Transaction number invalid" );
    $d = $d[0];

    $d->data->application->status = "Used";

    $staff = $api->users->get(array("id"=>$api->params->user_id ),"id,data")[0];

    //set update data
    $d->data->{"used"} = array(
        "staff" => $staff->data->first_name . " " . $staff->data->last_name,
        "remark" => $api->params->remark,
        "date" => date("Y-m-d H:i:s")
    );

    //transaction update
    $api->transactions->update(
        array("data"=>$d->data,"status"=>7),
        array("id"=>$api->params->id)
    );

    //notify applicant
    $next_id = $api->permitting_notifications->last() + 1;
    $api->permitting_notifications->create(
        array(
            "user_id" => $d->user_id,
            "name" => $d->name,
            "data" => array(
                "transaction_id" => $api->params->id,
                "message"=> "Permit successfully used!",
                "url" => "#!/pages/single/notification?id=" . $next_id
            ),
            "date" => date("Y-m-d H:i:s")
        )
    );

    // notify enforcers 
    $notif->by_level([5,6,7,8],"transaction",$api->params->id,array(
        "message"=> "Permit was used and processed by " . $staff->data->first_name . " " . $staff->data->last_name,
        "staff_id" => $staff->id
    ));

    $d->status = 7;

    //return
    $api->out( $d );

?>