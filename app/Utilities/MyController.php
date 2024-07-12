<?php

namespace App\Utilities;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\RolesRequest;
use App\Http\Controllers\Controller;
class MyController
{
    public static function List($table){
        $list = DB::table($table)->get();
        $size = DB::table($table)->count();

        //$data = array();
        if (empty($size)) {

            return [
                'status' => false,
                'message' => 'no data found',
            ];
           
        } else {
            return [
                'status' => true,
                'message' => 'success',
                'data' => $list,
                'number' => $size,
            ];
        }
    }

    
        
}
