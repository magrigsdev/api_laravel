<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\PersonnelsRequest;
use App\Utilities\MyMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\RolesRequest;
use App\Http\Controllers\Controller;

class PersonnelController extends Controller
{
    protected $table = 'personnels';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = DB::table($this->table)->get();
        $size = DB::table($this->table)->count();

        //$data = array();
        if (empty($size)) {

            $data = [
                'status' => MyMessage::status(),
                'message' => MyMessage::data_empty(),
            ];
            return response()->json($data, 404);

        } else {
            $data = [
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
    public function store(PersonnelsRequest $request)
    //public function store(Request $request)
    {
        $is_exist = DB::table($this->table)->where('email', $request->name)->exists();
        if ($is_exist) {
            return response()->json([
                'status' => MyMessage::status(),
                'message' => MyMessage::datum_exist($request->email)
            ], 403);
        } 
        else {
            DB::table($this->table)->insert([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'telephone' => $request->telephone,
                'sexe' => $request->sexe,
                'addresse' => $request->addresse,
                'password' => $request->password,
                'hiring_date' => $request->hiring_date,
                'role_id' => $request->role_id,
                'photo' => $request->photo,
                'created_at' => now(),
                'updated_at' => null,   
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
        $is_exist = DB::table($this->table)->where('id', $id)->exists();

        if ($is_exist) {
            $personnel = DB::table($this->table)->where('id', $id)->first();
            return response()->json([
                'status' => MyMessage::status(true),
                'data' => $personnel
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
    public function update(PersonnelsRequest $request, string $id)
    {
        //
        $is_exist = DB::table($this->table)->where('id', $id)->exists();

        if ($is_exist) {
            DB::table($this->table)
                ->where('id', $id)
                ->update([
                        'firstname' => $request->firstname,
                        'lastname' => $request->lastname,
                        'email' => $request->email,
                        'telephone' => $request->telephone,
                        'sexe' => $request->sexe,
                        'addresse' => $request->addresse,
                        'password' => $request->password,
                        'hiring_date' => $request->hiring_date,
                        'role_id' => $request->role_id,
                        'photo' => $request->photo,
                        
                        'updated_at' => now()
                    ]);

            return response()->json([
                'status' => MyMessage::status(true),
                'message' => MyMessage::data_update($request->name)
            ], 200);
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
        //
        $is_exist = DB::table($this->table)->where('id', $id)->exists();
        

        if ($is_exist) {
            $firstname = DB::table($this->table)->where('id', $id)->value('firstname');
            $lastname = DB::table($this->table)->where('id', $id)->value('lastname');
            $name = $firstname . "  " . $lastname;
            DB::table($this->table)
                ->where('id', $id)
                ->delete();
            return response()->json([
                'status' => MyMessage::status(true),
                'message' => MyMessage::data_delete($name)
            ], 200);

        } else {
            return response()->json([
                'status' => MyMessage::status(),
                'message' => MyMessage::data_no_found()
            ], 404);
        }
    }
}
