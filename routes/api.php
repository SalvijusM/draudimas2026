<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiOwnerController;
use App\Http\Controllers\Api\ApiCarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::post('/auth/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $token = Auth::user()->createToken('PostmanToken')->plainTextToken;
        return response()->json(['token' => $token]);
    }

    return response()->json(['error' => 'Neteisingi duomenys'], 401);
});

Route::middleware('auth:sanctum')->name('api.')->group(function () {
    Route::apiResource('owners', ApiOwnerController::class);
    Route::apiResource('cars', ApiCarController::class);
});
