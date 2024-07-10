<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RolesController;

Route::get('/', function () {
    return view('welcome');
});

