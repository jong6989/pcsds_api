<?php
    class notif
    {

        public function __construct($api){
            $this->api = $api;
        }

        public function by_level($user_level_array,$item_type,$item_id,$data){
            $ids = array();
            foreach ($user_level_array as $key => $value) {
                $q = $this->api->users->get(array("user_level"=>$value));
                if(count($q) > 0){
                    foreach ($q as $k => $v) {
                        $ids[] = $v->id;
                    }
                }
            }
            $this->set($ids,$item_type,$item_id,$data);
        }

        public function set($id_array,$item_type,$item_id,$data){
            $user_ids_string = "";
            foreach ($id_array as $k => $v) {
                if($user_ids_string == "") $user_ids_string .= ",";
                $user_ids_string .= $v . ",";
            }
            return $this->api->notification->create(array(
                "item_id" => $item_id,
                "item_type" => $item_type,
                "user_id" => $user_ids_string,
                "data" => $data,
                "date" => date("Y-m-d H:i:s")
            ));
        }

    }
    
?>