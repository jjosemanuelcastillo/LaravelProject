<?php

use App\Http\Controllers\API\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\LogoutController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UsersController;
use Illuminate\Auth\Events\Login;
use Symfony\Component\HttpFoundation\Request;

Route::group(['middleware' => 'api', 'prefix' => 'auth',], function () {
    //Ruta para devovler el Token del usuario
    Route::post(uri: '/login', action: LoginController::class);
    Route::post('/register', [RegisterController::class, 'register']);
});
Route::group(['middleware' => 'api', 'prefix' => 'auth',], function () {
    //Ruta para devovler el Token del usuario
    Route::post(uri: '/logout', action: LogoutController::class);
});
Route::middleware(['auth:api', 'admin'])->group(function () {
    Route::get('/admin/', [AdminController::class, 'index']);
});
Route::middleware(['auth:api', 'admin'])->group(function () {
    Route::put('/product/{id}/update', [ProductsController::class, 'update']);
    Route::delete('/destroyProduct/{id}', [ProductsController::class, 'destroy']);
    Route::get('/users', [UsersController::class, 'index']);
    Route::middleware(['auth:api'])->get('/users/count', [UserController::class, 'countUsers']);
    Route::middleware(['auth:api'])->put('/products/{id}', [ProductsController::class, 'update']);
    Route::middleware(['auth:api'])->post('/addProduct', [ProductsController::class, 'store']);
    Route::middleware(['auth:api'])->post('/addCategory', [CategoryController::class, 'store']);
    Route::middleware(['auth:api'])->get('/categorias', [CategoryController::class, 'index']);
    Route::middleware(['auth:api'])->get('/getOrderByUser/{id}', [OrdersController::class, 'getOrderByUserId']);
    Route::middleware(['auth:api'])->delete('/users/{id}', [AuthController::class, 'destroy']);
    Route::middleware(['auth:api'])->get('/pedidos/{id}', [OrdersController::class, 'orderDetails']);
    Route::middleware(['auth:api'])->put('/updateOrder/{id}', [OrdersController::class, 'update']);

});
Route::middleware(['auth:api', 'user'])->get('/me', function () {
    return auth('api')->user();
});


Route::get('/categorias', [CategoryController::class, 'index']);
Route::get('/categoria/{id}/products', [CategoryController::class, 'show']);
Route::get('/categoria/{id}/productsByCategory', [ProductsController::class, 'productByCategory']);
Route::get('/products', [ProductsController::class, 'index']);
Route::get('/products/{id}', [ProductsController::class, 'show']);
Route::get('/best-sellers', [ProductsController::class, 'bestSeller']);
Route::post('/compra/{id}', [ProductsController::class, 'purchaseProduct']);
Route::get('/pedidos', [OrdersController::class, 'show']);
Route::get('/pedidos/{id}', [OrdersController::class, 'orderDetails']);
