<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::webhooks('wpp/webhook');
Route::webhooks('wpp/webhook', 'default', 'get');
Route::webhooks('wpp/webhook', 'default', 'put');
Route::webhooks('wpp/webhook', 'default', 'patch');
Route::webhooks('wpp/webhook', 'default', 'delete');

Route::get('/update-invoice-numbers', function (Request $request) {
    try {
        $verifyToken = 'Ducker++2024';
        $query = $request->query();
        
        $mode = $query['hub_mode'];
        $token = $query['hub_verify_token'];
        $challenge = $query['hub_challenge'];

        if($mode && $token){
            if($mode === 'subscribe' && $token == $verifyToken){
                return response($challenge, 200)->header('Content-Type','text/plain');
            }
        }
        throw new Exception('Invalid request');


    } catch (\Throwable $th) {
        return response()->json([
            'success' => false,
            'error' => $th->getMessage()
        ],500);
    }
});

