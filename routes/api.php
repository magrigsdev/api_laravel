<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RolesController;
use App\Http\Controllers\Api\PersonnelController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


#=========================== ROLES ==================================
Route::get('roles/list/', [RolesController::class, "index"]);
Route::any('roles/show/{id}', [RolesController::class, "show"]);
Route::any('roles/save/', [RolesController::class, "store"]);
Route::any('roles/update/{id}', [RolesController::class, "update"]);
Route::any('roles/delete/{id}', [RolesController::class, "destroy"]);

#=========================== PERSONNELS ==================================
Route::get('personnels/list/', [PersonnelController::class, "index"]);
Route::any('personnels/show/{id}', [PersonnelController::class, "show"]);
Route::any('personnels/save/', [PersonnelController::class, "store"]);
Route::any('personnels/update/{id}', [PersonnelController::class, "update"]);
Route::any('personnels/delete/{id}', [PersonnelController::class, "destroy"]);