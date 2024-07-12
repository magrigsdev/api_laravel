<?php

namespace App\Http\Controllers\Api;

use App\Utilities\MyController;
use App\Utilities\MyMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\RolesRequest;
use App\Http\Controllers\Controller;

class RolesController extends Controller
{
   
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = MyController::List('roles');
        if($data['status'] ){
            return response()->json($data, 200);
        }
        else{
            return response()->json($data, 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RolesRequest $request)
    {
        
        $storage = [
            'name' => $request->name,
            'created_at' => now()->format('d-m-Y H:i:s'),
            'updated_at' => now()->format('d-m-Y H:i:s'),
        ];

        $store = MyController::store($request, 'roles',['name'=>'name'], $storage);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //

        $data = MyController::show('roles', $id);
        if($data['status']){
            return response()->json($data, 200);
        }
        else{
            return response()->json($data, 404);
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
