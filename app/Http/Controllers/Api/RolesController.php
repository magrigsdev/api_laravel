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
        $is_exist = DB::table('roles')->where('name', $request->name)->exists();
        if($is_exist){
            return response()->json([
                'status' => MyMessage::status(),
                'message' => MyMessage::datum_exist($request->name)
            ], 403);
        }
        else {
            DB::table('roles')->insert([
                'name' => $request->name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'status' => MyMessage::status(true),
                'message' => MyMessage::data_saved($request->name)
            ]);

        }     
           
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $is_exist = DB::table('roles')->where('id', $id)->exists();
        
        if ($is_exist) {
            $role = DB::table('roles')->where('id', $id)->first();
            return response()->json([
                'status' => MyMessage::status(true),
                'data' => $role
            ], 200);
            
        } else {
            return [
                'status' => false,
                'message' => MyMessage::data_no_found()
            ];
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RolesRequest $request, string $id)
    {
        //
        $is_exist = DB::table('roles')->where('id', $id)->exists();
        
        if ($is_exist) {
            DB::table('roles')
                ->where('id', $id)
                ->update([
                    'name' => $request->name,
                    'updated_at' => now()
                ]);

            return response()->json([
                'status' => MyMessage::status(true),
                'message' => MyMessage::data_update($request->name)], 200);
        } else {
            return response()->json([
                'status' => MyMessage::status(),
                'message' => MyMessage::data_no_found()
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    

        $is_exist = DB::table('roles')->where('id', $id)->exists();
        $name = DB::table('roles')->where('id', $id)->value('name');
        
        if ($is_exist) {
            DB::table('roles')
                ->where('id', $id)
                ->delete();
            return response()->json([
                'status' => MyMessage::status(true),
                'message' => MyMessage::data_delete($name)], 200);
            
        } else {
            return response()->json([
                'status' => MyMessage::status(),
                'message' => MyMessage::data_no_found()
            ], 404);
        }
        
    }
    
}
