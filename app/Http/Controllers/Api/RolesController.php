<?php

namespace App\Http\Controllers\Api;

use App\Utilities\MyMessage;
use Illuminate\Http\Request;
use App\Utilities\MyController;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\RolesRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;

class RolesController extends Controller
{
   
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = DB::table('roles')->get();
        $size = DB::table('roles')->count();

        //$data = array();
        if (empty($size)) {

            $data =  [
                'status' => MyMessage::status(),
                'message' => MyMessage::data_empty(),
            ];
            return response()->json($data, 404);

        } 
        else {
            $data =  [
                'status' => MyMessage::status(true),
                'data' => $list,
                'number' => $size,
            ];
            return response()->json($data, 200);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RolesRequest $request)
    //public function store(Request $request)
    {

        if (!empty($request)) {
            $storage = [
                'name' => $request->name,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            DB::table('roles')->insert($storage);
            return [
                'status' => MyMessage::status(true),
                'message' => MyMessage::data_saved()
            ];
        } 
        else {
            return [
                'status' => false,
                'message' => MyMessage::data_already_exist($request->name)
            ];
        }
        
           
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //

        // $data = MyController::show('roles', $id);
        // if($data['status']){
        //     return response()->json($data, 200);
        // }
        // else{
        //     return response()->json($data, 404);
        // }

        //$name = DB::table($table)->where($column['name'], $request->name)->exists();
        $column_exist = Schema::hasColumn('roles', 'name');

        //$name ? $is_exist = true : $is_exist = false;
        dd($column_exist);
        //now()->format('d-m-Y H:i:s'),
        if ($is_exist) {
            DB::table($table)->insert($storage);
            return [
                'status' => MyMessage::status(true),
                'message' => MyMessage::data_saved()
            ];
        } else {
            return [
                'status' => false,
                'message' => MyMessage::data_already_exist($request->name)
            ];
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RolesRequest $request, string $id)
    {
        //
        $data =  ['name' => strval($request->name),
                'updated_at' => now()->format('Y-m-d H:i:s')
        ];
        
        $update = MyController::update($request, 'roles', $id, $data );

        if($update['status']){
            return response()->json($update, 200);
        }else{
            return response()->json($update, 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $delete = MyController::destroy('roles', $id);
        if($delete['status']){
            return response()->json($delete, 200);
        }
        else{
            return response()->json($delete, 404);
        }
        
    }
    
}
