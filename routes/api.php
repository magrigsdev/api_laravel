<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RolesController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('roles/list/', [RolesController::class, "index"]);
Route::any('roles/show/{id}', [RolesController::class, "show"]);
Route::any('roles/save/', [RolesController::class, "store"]);
Route::any('roles/update/{id}', [RolesController::class, "update"]);
Route::any('roles/delete/{id}', [RolesController::class, "destroy"]);