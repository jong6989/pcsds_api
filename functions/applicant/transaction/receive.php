<?php 
    global $api;
    
    //require some fields
    $api->required_fields(array("id","staff_id"));

    //get transaction
    $d = $api->transactions->get(array("id"=>$api->params->id))[0];
    //get Staff
    $staff = $api->users->get(array("id"=>$api->params->staff_id ),"id,data")[0];

    //set update data
    $d->data->{"received"} = array(
        "staff" => $staff,
        "date" => date("Y-m-d H:i:s")
    );

    //transaction update
    $api->transactions->update(
        array("data"=>$d->data,"status"=>1),
        array("id"=>$api->params->id)
    );

    //notify applicant
    $next_id = $api->permitting_notifications->last() + 1;
    $api->permitting_notifications->create(
        array(
            "user_id" => $d->user_id,
            "name" => $d->name,
            "data" => array(
                "transaction_id" => $d->id,
                "message"=> "Your Application was Received by PCSD Staff and now on review.",
                "url" => "#!/pages/single/notification?id=" . $next_id
            ),
            "date" => date("Y-m-d H:i:s")
        )
    );

    $d->status = 1;
    $d->{"user"} = $api->permitting_accounts->get(array("id"=>$d->user_id ))[0];

    $api->out( $d );

?>