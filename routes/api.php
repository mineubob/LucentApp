<?php

use App\Controllers\UserController;
use Lucent\Facades\Route;

// Define your API routes here.
//
// This example registers a REST-style group. Note that the route
// placeholder `{user}` must match the controller method parameter name
// (`User $user`) for route model binding to resolve it.
Route::rest()->group('user')
    ->prefix('/user')
    ->defaultController(UserController::class)
    ->post(path: '/create', method: 'create')
    ->get(path: '/{user}', method: 'show');