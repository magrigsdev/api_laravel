<?php

namespace App\Utilities;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\RolesRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;

class MyController
{
    public static function List($table)
    {
        $list = DB::table($table)->get();
        $size = DB::table($table)->count();

        //$data = array();
        if (empty($size)) {

            return [
                'status' => MyMessage::status(),
                'message' => MyMessage::data_empty(),
            ];

        } else {
            return [
                'status' => MyMessage::status(true),
                'data' => $list,
                'number' => $size,
            ];
        }
    }

    public static function store(mixed $request, string $table, $column = [], array $storage)
    {
        $is_exist = false;
        $name = DB::table($table)->where($column['name'], $request->name)->exists();

        $name ? $is_exist = true : $is_exist = false;
        //now()->format('d-m-Y H:i:s'),
        if ($is_exist) {
            DB::table($table)->insert($column);
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
     * Display the specified resource.
     */
    public static function show(string $table, string $id)
    {
        //
        if (empty($id)) {
            return response()->json([
                'status' => false,
                'message' => "the value is empty"
            ], 404);
        }
        $id = intval($id);
        $table = DB::table($table)->where('id', $id)->first();

        if ($table == null) {
            return [
                'status' => MyMessage::status(),
                'message' => MyMessage::data_no_found()
            ];
        } else {
            return [
                'status' => MyMessage::status(true),
                'data' => $table,
            ];
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public static function update(mixed $request, string $table,string $id,  array $updated)
    {
        //

        $is_exist = false;
        $name = DB::table($table)->where('id', $id)->exists();
        $name ? $is_exist = true : $is_exist = false;

        if ($is_exist) {
            DB::table($table)
                ->where('id', $id)
                ->update($updated);

            return [
                'status' => MyMessage::status(true),
                'message' => MyMessage::data_info("updated")
            ];
        } else {
            return [
                'status' => MyMessage::status(),
                'message' => MyMessage::data_no_found()
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public static function destroy(string $table, string $id)
    {
        //
        $is_exist = false;
        $id = DB::table($table)->where('id', $id)->exists();
        $id ? $is_exist = true : $is_exist = false;

        if ($is_exist) {
            DB::table($table)
                ->where('id', $id)
                ->delete();

            return [
                'status' => MyMessage::status(true),
                'message' => MyMessage::data_info("deleted")
            ];
        } else {
            return [
                'status' => MyMessage::status(),
                'message' => MyMessage::data_no_found()
            ];
        }
    }

    public static function is_exist_Column(string $table, string $column): mixed
    {
        return Schema::hasColumn($table, $column) ? true : false;
    }


}
