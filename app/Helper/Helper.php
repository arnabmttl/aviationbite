<?php

namespace App\Helper;
use App\Models\Flag;

class Helper {

    /**
     * 
     **/
    public static function get_user_flagged_item($user_id,$flagged_id,$flagged_type)
    {
        
        $data = Flag::whereUserId($user_id)->whereFlaggedId($flagged_id)->whereFlaggedType($flagged_type)->first();

        return $data;
    }

    

}
