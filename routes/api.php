<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\WorkerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/workers', [WorkerController::class, 'index'])->middleware('auth:api');

    Route::post('/orders',[OrderController::class, 'create'])->middleware('auth:api');
    Route::post('/orders/{id}',[OrderController::class, 'update'])->middleware('auth:api');

    Route::get('/sessions', [TokenController::class, 'index'])->middleware('auth:api');
    Route::delete('/sessions/{id}', [TokenController::class, 'destroy'])->middleware('auth:api');

    Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:api');
});

Route::group([
    'as' => 'passport.',
    'prefix' => config('passport.path', 'passport'),
    'namespace' => '\Laravel\Passport\Http\Controllers',
], function () {
    Route::post('/token', [
        'uses' => 'AccessTokenController@issueToken',
        'as' => 'token',
        'middleware' => 'throttle',
    ]);

    Route::get('/authorize', [
        'uses' => 'AuthorizationController@authorize',
        'as' => 'authorizations.authorize',
        'middleware' => 'web',
    ]);

    Route::middleware('auth:api')->group(function () {
        Route::post('/token/refresh', [
            'uses' => 'TransientTokenController@refresh',
            'as' => 'token.refresh',
        ]);

        Route::post('/authorize', [
            'uses' => 'ApproveAuthorizationController@approve',
            'as' => 'authorizations.approve',
        ]);

        Route::delete('/authorize', [
            'uses' => 'DenyAuthorizationController@deny',
            'as' => 'authorizations.deny',
        ]);

        Route::get('/tokens', [
            'uses' => 'AuthorizedAccessTokenController@forUser',
            'as' => 'tokens.index',
        ]);

        Route::delete('/tokens/{token_id}', [
            'uses' => 'AuthorizedAccessTokenController@destroy',
            'as' => 'tokens.destroy',
        ]);

        Route::get('/clients', [
            'uses' => 'ClientController@forUser',
            'as' => 'clients.index',
        ]);

        Route::post('/clients', [
            'uses' => 'ClientController@store',
            'as' => 'clients.store',
        ]);

        Route::put('/clients/{client_id}', [
            'uses' => 'ClientController@update',
            'as' => 'clients.update',
        ]);

        Route::delete('/clients/{client_id}', [
            'uses' => 'ClientController@destroy',
            'as' => 'clients.destroy',
        ]);

        Route::get('/scopes', [
            'uses' => 'ScopeController@all',
            'as' => 'scopes.index',
        ]);

        Route::get('/personal-access-tokens', [
            'uses' => 'PersonalAccessTokenController@forUser',
            'as' => 'personal.tokens.index',
        ]);

        Route::post('/personal-access-tokens', [
            'uses' => 'PersonalAccessTokenController@store',
            'as' => 'personal.tokens.store',
        ]);

        Route::delete('/personal-access-tokens/{token_id}', [
            'uses' => 'PersonalAccessTokenController@destroy',
            'as' => 'personal.tokens.destroy',
        ]);
    });
});
