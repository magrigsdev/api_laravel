<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\PersonnelsRequest;
use App\Utilities\MyMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PersonnelController extends Controller
{
    private $table = 'personnels';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = DB::table($this->table)->get();
        $size = DB::table($this->table)->count();

        $list = $list->jsonSerialize();

        foreach ($list as  $personnel) {
            # code...
            if(isset($personnel->role_id)){
                $personnel->role_id = DB::table('roles')
                    ->where('id', intval($personnel->role_id))
                    ->value('name');
            }
        }
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
        $is_exist = DB::table($this->table)
        ->where('email', $request->email)
        ->exists();       
       // dd($is_exist);
        if ($is_exist) {
            return response()->json([
                'status' => MyMessage::status(),
                'message' => MyMessage::datum_exist($request->email)
            ], 403);
        } 
        else {
            DB::table($this->table)
                    ->insert([
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
                // 'created_at' => now(),
                // 'updated_at' => null,   
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
            $list = DB::table($this->table)->where('id', $id)->first();
            $list->role_id = DB::table('roles')
                ->where('id', intval($list->role_id))
                ->value('name');
            
            return response()->json([
                'status' => MyMessage::status(true),
                'data' => $list
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
    public function update(Request $request, string $id)
    {
        //
        $is_exist = DB::table($this->table)
            ->where('id', $id)->exists();

        $update = [];
        $update_request = [
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'sexe' => $request->sexe,
            'addresse' => $request->addresse,
            'password' => $request->password,
            'hiring_date' => $request->hiring_date,
            'role_id' => $request->role_id,
            'photo' => $request->photo
        ];

        foreach ($update_request as $key =>  $value) {
            # code...
            if(!is_null($value)){
                $update[$key] = $value;
            }
           
        }
        
        if ($is_exist) {

            if(count($update) > 0 ){

                DB::table($this->table)
                    ->where('id', $id)
                    ->update($update);

                return response()->json([
                    'status' => MyMessage::status(true),
                    'message' => MyMessage::data_update($request->name)
                ], 200);
            }
            else {
                return response()->json([
                    'status' => MyMessage::status(),
                    'message' => MyMessage::value_empty()
                ], 403);
            }
            
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
    public function before_date(string $date)
    {
        //
        $date = strval($date);
        $before_date = DB::table($this->table)
        ->where('hiring_date','<', $date)->get();
        foreach ($before_date as $key => $value) {
            # code...
            $value->role_id = DB::table('roles')
                ->where('id', intval($value->role_id))
                ->value('name');
        }
        $size = DB::table($this->table)
            ->where('hiring_date', '<', $date)->count();

        //dd($before_date);
        if (!empty($before_date)) {
            return response()->json([
                'status' => MyMessage::status(true),
                'data' => $before_date,
                'number'=>$size
            ], 200);

        } else {
            return response()->json([
                'status' => MyMessage::status(),
                'message' => MyMessage::data_no_found()
            ], 404);
        }
    }
    public function after_date(string $date)
    {
        //
        $date = strval($date);
        $after_date = DB::table($this->table)
            ->where('hiring_date', '>', $date)->get();

        foreach ($after_date as $key => $value) {
            # code...
            $value->role_id = DB::table('roles')
                ->where('id', intval($value->role_id))
                ->value('name');
        }
        $size = DB::table($this->table)
            ->where('hiring_date', '>', $date)->count();


        if (!empty($after_date)) {

            return response()->json([
                'status' => MyMessage::status(true),
                'data' => $after_date,
                'number'=>$size
            ], 200);

        } else {
            return response()->json([
                'status' => MyMessage::status(),
                'message' => MyMessage::data_no_found()
            ], 404);
        }
    }
    public function between(string $date_debut, string $date_fin)
    {
        //
        
        $between = DB::table($this->table)
            ->whereBetween('hiring_date', [$date_debut, $date_fin])->get();

        foreach ($between as $key => $value) {
            # code...
            $value->role_id = DB::table('roles')
                ->where('id', intval($value->role_id))
                ->value('name');
        }
        $size = DB::table($this->table)
            ->whereBetween('hiring_date', [$date_debut, $date_fin])->count();
        //dd($pp);
        if (count($between) > 0) {

            return response()->json([
                'status' => MyMessage::status(true),
                'data' => $between,
                'number'=>$size
            ], 200);

        } else {
            return response()->json([
                'status' => MyMessage::status(),
                'message' => MyMessage::data_no_found()
            ], 404);
        }
    }
    public function genre(string $sexe)
    {
        //
        $is_exist = DB::table($this->table)->where('sexe', $sexe)->exists();

        if ($is_exist) {
            $list = DB::table($this->table)->where('sexe', $sexe)->get();
            $size = DB::table($this->table)->where('sexe', $sexe)->count();
            foreach ($list as $key => $value) {
                # code...
                $value->role_id = DB::table('roles')
                    ->where('id', intval($value->role_id))
                    ->value('name');
            }

            return response()->json([
                'status' => MyMessage::status(true),
                'data' => $list,
                'number'=>$size
            ], 200);

        } else {
            return [
                'status' => false,
                'message' => MyMessage::data_no_found()
            ];
        }
    }
    public function role(string $role)
    {
        //
        $is_name =  DB::table('roles')->where('name', $role)->exists();
        
        if($is_name){
            $table = DB::table('roles')->where('name', $role)->get();
            foreach ($table as $key => $value) {
                # code...
                $id = $value->id;
            }

            $is_id = DB::table($this->table)->where('role_id', $id)->exists();

            if ($is_id) {
                $list = DB::table($this->table)->where('role_id', $id)->get();
                $size = DB::table($this->table)->where('role_id', $id)->count();
                foreach ($list as $key => $value) {
                    # code...
                    $value->role_id = DB::table('roles')
                        ->where('id', intval($value->role_id))
                        ->value('name');
                }

                return response()->json([
                    'status' => MyMessage::status(true),
                    'data' => $list,
                    'number' => $size
                ], 200);

            } else {
                return [
                    'status' => false,
                    'message' => MyMessage::data_no_found()
                ];
            }
            
        }
        

       
    }
}
