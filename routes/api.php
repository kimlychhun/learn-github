<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Models\Location;

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
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);    
});

//Brands CRUD
Route::group(['prefix'=>'brands'], function($router){
    Route::controller(BrandsController::class)->group(function(){
        Route::get('index','index');
        Route::get('show/{id}','show');
        Route::post('store','store');
        Route::put('update_brand/{id}','update)brand');
        Route::delete('delete_brand/{id}','delete_brand');
    });
});

//categorry CRUD
Route::group(['prefix'=>'category'], function($router){
Route::controller(CategoryController::class)->group(function(){

    Route::get('index','index');
    Route::get('show/{id}','show');
    Route::post('store','store');
    Route::put('update_category/{id}','update_category');
    Route::delete('delete_category/{id}','delete_category');
});
});
Route::group(['prefix'=>'Location'], function($router){
Route::controller(LocationController::class)->group(function(){
    Route::post('store','store');
    Route::put('update/{id}','update');
    Route::delete('destroy/{id}','destroy');
});
});
Route::group(['prefix'=>'products'], function($router){
Route::controller(ProductController::class)->group(function(){
    Route::get('index','index');
    Route::get('show/{id}','show');
    Route::post('store','store');
    Route::put('update/{id}','update');
    Route::delete('destroy/{id}','destroy');
});
});
Route::group(['prefix'=>'orders'], function($router){
Route::controller(OrderController::class)->group(function(){
    Route::get('index','index');
    Route::get('show/{id}','show');
    Route::post('store','store');
    Route::put('get_order_items/{id}','get_order_items');
    Route::put('get_user_orders/{id}','get_user_orders');
    Route::put('change_order_status/{id}','change_order_status');
});
});