<?php 

global $api;
if(empty($api)) die();

$api->required_fields(array("doc_id"));

$d = $api->wp53_pdt_documents->get(array("id"=>$api->params->doc_id));

if(count($d) > 0){
    $d = $d[0];
    $d->{"images"} = $api->wp53_pdt_images->get(array("deleted"=>"0","document_id"=>$api->params->doc_id ));
    $d->{"attachments"} = $api->wp53_pdt_attachments->get(array("deleted"=>"0","document_id"=>$api->params->doc_id ));
    $d->{"meta"} = $api->wp53_pdt_meta->search(array( "value"=> $api->params->doc_id . ",%" ));
    $api->out( $d );
}else {
    $api->out("Document not fount",0,$api->params->doc_id);
}

 ?>