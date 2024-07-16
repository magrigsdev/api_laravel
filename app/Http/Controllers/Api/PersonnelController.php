<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Utilities\MyController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PersonnelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        //$personnels = [];
        $data = MyController::List('personnels');
        // if ($key == 'role_id') {
        //     $value = DB::table('roles')->where('id', intval($value))->value('name');
        // }
        if ($data['status']) {
            $list = $data['data'];
            
            $jsonList = $list->jsonSerialize();
            
            foreach ($jsonList as $item) {
                # code...
                if(isset($item->role_id)){
                    $item->role_id = DB::table('roles')
                    ->where('id', intval($item->role_id))
                    ->value('name');
                }
            }
            
            //dd($list);

            //print_r($jsonList);
            return response()->json($jsonList, 200);
        } else {
            return response()->json($data, 404);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
