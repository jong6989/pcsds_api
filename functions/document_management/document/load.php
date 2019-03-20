<?php 

global $api;
if(empty($api)) die();

$api->required_fields(array("offset","last_id"));

$d = $api->wp53_pdt_documents->get(null,null,"ASC","id", 100, $api->params->offset);

if(count($d) > 0){
    if($d[ count($d) - 1 ]->id != $api->params->last_id){
        foreach ($d as $key => $value) {
            $d[$key]->{"images"} = $api->wp53_pdt_images->get(array("deleted"=>"0","document_id"=>$value->id ));
            $d[$key]->{"attachments"} = $api->wp53_pdt_attachments->get(array("deleted"=>"0","document_id"=>$value->id ));
            $metas = $api->wp53_pdt_meta->search(array( "value"=> $value->id . ",%" ));
            $d[$key]->{"meta"} = $metas;
            $d[$key]->{"acts"} = count($metas);
        }
        $api->out( $d );
    }
}
$api->out("No new Data...",0,"");

 ?>