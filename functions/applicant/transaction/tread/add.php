<?php 
    global $api;
    include './././includes/notif.php';
    include './././includes/tread.php';
    $notif = new notif($api);
    $tread = new tread($api);

    //require some fields
    $api->required_fields(array("user_id","id","message"));

    $staff = $api->users->get(array("id"=>$api->params->user_id ),"id,data")[0];

    //add to tread
    $tread->single($api->params->id,array(
        "staff" => $staff->data->first_name . " " . $staff->data->last_name,
        "message" => base64_encode($api->params->message),
        "date" => date("Y-m-d H:i:s")
    ));

    // notify
    // $notif->by_level([6,7,8],"transaction",$api->params->id,array(
    //     "message"=> $api->params->message,
    //     "transaction_id" => $api->params->id,
    //     "staff_id" => $staff->id
    // ));

    $api->out("ok");

?>