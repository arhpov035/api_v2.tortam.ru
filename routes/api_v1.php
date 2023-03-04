<?php

use App\Http\Controllers\Api\V1\AuthSanctumController;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\ProductCategoryController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\MailController;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\ProductFillingController;

use App\Http\Controllers\CompanyController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::apiResource('/products/{skip?}', \App\Http\Controllers\Api\V1\ProductController::class)->only([
    'index'
])->names('products');

Route::apiResource('/product', \App\Http\Controllers\Api\V1\ProductController::class)->only([
    'store', 'show', 'update', 'destroy'
])->names('product');

//Route::get('/mail', [\App\Http\Controllers\Api\V1\ProductController::class, 'mail']);

Route::get('/mail', [ProductController::class, 'mail']);
Route::get('/mail/contacts', [MailController::class, 'contacts']);



Route::get('/order', [OrderController::class, 'store']);
Route::get('/order_id', [OrderController::class, 'index']);

Route::get('/fillings', [ProductFillingController::class, 'index']);

Route::get('/categoryprod', [ProductCategoryController::class, 'product']);
Route::apiResource('/categories/{skip?}', \App\Http\Controllers\Api\V1\ProductCategoryController::class)->only([
    'index'
])->names('categories');
Route::get('/category/{slug}/{skip?}', [\App\Http\Controllers\Api\V1\ProductCategoryController::class, 'show'])->where(['skip' => '[0-9]+']);

Route::post('/companies', [CompanyController::class, 'store'])->name('companies.store');
Route::post('/admin/udateproduct/{slug}', [ProductController::class, 'udateproduct'])->name('products.udateproduct');

//Route::post('/registration', [AuthController::class, 'registration'])->name('auth.registration');
Route::post('/registration', [AuthController::class, 'registration'])->name('auth.registration');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

Route::middleware('auth:sanctum')->group(function (){
    Route::get('/user', [AuthController::class, 'user'])->name('auth.user');
    Route::put('/update', [AuthController::class, 'update'])->name('auth.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});


Route::get('/compani', function () {
    return view('companies');
});

Route::post('/sanctum/registration', [AuthSanctumController::class, 'registration'])->name('auth.registration');
Route::post('/sanctum/login', [AuthSanctumController::class, 'login'])->name('sanctum.auth.login');

Route::middleware('auth:sanctum')->group(function (){
    Route::get('/sanctum/user', [AuthSanctumController::class, 'user'])->name('sanctum.auth.user');
    Route::post('/sanctum/update', [AuthSanctumController::class, 'update'])->name('sanctum.auth.update');
    Route::post('/sanctum/logout', [AuthSanctumController::class, 'logout'])->name('sanctum.auth.logout');

    Route::apiResource('/admin/categories/', \App\Http\Controllers\Api\V1\ProductCategoryController::class)->only([
        'index'
    ])->names('categories');
});
