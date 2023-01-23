<?php

use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('all/products',[ProductsController::class, 'all_products']);
Route::get('all/category',[ProductsController::class, 'categories']);
Route::post('category/items',[ProductsController::class, 'categories_items']);
Route::post('details/product', [ProductsController::class, 'prod_details']);
Route::post('find/product', [ProductsController::class, 'find_product']);


Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::post('logout', [UserController::class, 'logout']);

Route::post('payment',[ProductsController::class, 'payment']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
