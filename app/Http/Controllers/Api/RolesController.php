<?php

namespace App\Http\Controllers\Api;

use App\Models\Roles;
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
        //
        $roles = Roles::all();
        $size = Roles::count();

        if (empty($size)) {
            return response()->json([
                'status' => false,
                'message' => 'no data found'
            ], 404);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'success',
                'data' => $roles,
                'number' => $size
            ], 200);

        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RolesRequest $request)
    {
        //
        //check if exist
        if (empty($request->name)) {
            return response()->json([
                'status' => false,
                'message' => "the value is empty"
            ], 404);
        }

        $is_exist = false;
        $name = DB::table('roles')->where('name', $request->name)->exists();
        $name ? $is_exist = true : $is_exist = false;

        if ($is_exist) {

            DB::table('roles')
                ->insert(
                    [
                        'name' => $request->name,
                        'created_at' => now()->format('d-m-Y H:i:s'),
                        'updated_at' => now()->format('d-m-Y H:i:s'),
                    ]
                );

            return response()->json([
                'status' => true,
                'message' => "roles saved"
            ], 200);
        } 
        else {
            return response()->json([
                'status' => false,
                'message' => strval($request->name) . " role already exist"
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        if (empty($id)) {
            return response()->json([
                'status' => false,
                'message' => "the value is empty"
            ], 404);
        }
        $table = DB::table('roles')->where('id', $id)->first();
        $is_exist = DB::table('roles')->where('id', $id)->exists();


        if ($is_exist == false) {
            return response()->json([
                'status' => false,
                'message' => 'no data found'
            ], 404);
        }
        else {
            return response()->json([
                'status' => true,
                'message' => 'success',
                'data' => $table,

            ], 200);

        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        $is_exist = false;
        $name = DB::table('roles')->where('id', $id)->exists();
        $name ? $is_exist = true : $is_exist = false;

        if ($is_exist) {
            DB::table('roles')
                ->where('id', $id)
                ->update([
                    'name' => strval($request->name),
                    'updated_at' => now()->format('Y-m-d H:i:s')
                ]);

            return response()->json([
                'status' => true,
                'message' => "job update"
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => strval($id) . " not found"
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
         $is_exist = false;
        $id = DB::table('roles')->where('id',$id)->exists();
        $id ? $is_exist = true : $is_exist = false;

        if ($is_exist) {
            DB::table('roles')
                ->were('id', $id);

            return response()->json([
                'status' => true,
                'message' => "job delete"
            ], 200);
        } 
        else {
            return response()->json([
                'status' => false,
                'message' => strval($id) . "not found"
            ], 404);
        }
    }
    
}
