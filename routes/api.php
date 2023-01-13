<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\AttributeValueProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductGroupController;
use App\Http\Controllers\Admin\SiteImageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\UserController as CustomerController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ProductController as UserProductController;

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

Route::get('/', function () {
    return response("Api works!");
});
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('admin/login', [AuthController::class, 'adminLogin']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api,api-admin');
Route::get('email/verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify'); // Make sure to keep this as your route name
Route::get('categories', [SiteController::class, 'categories']);
Route::get('site-data',  [SiteController::class, 'siteData']);

Route::group([
    'middleware' => ['auth:api', 'approved'],
], function () {
    Route::get('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
    Route::get('products', [UserProductController::class, 'getAll']);
    Route::get('user', [CustomerController::class, 'show']);
    Route::patch('user', [CustomerController::class, 'update']);
    Route::get('orders', [OrderController::class, 'index']);
    Route::get('checkout', [OrderController::class, 'checkout']);
    Route::apiResources([
        'addresses' => AddressController::class,
        'cart' => CartController::class,
    ]);
});

Route::group([
    'middleware' => ['auth:api-admin'],
    'prefix' => 'admin'
], function () {
    Route::apiResources([
        'categories' => CategoryController::class,
        'products'   => ProductController::class,
        'admin-users' => AdminUserController::class,
        'groups' => GroupController::class,
        'site-images' => SiteImageController::class,
        'attributes' => AttributeController::class,
    ]);

    Route::apiResource('users', UserController::class)->except('store');
    Route::apiResource('product-groups', ProductGroupController::class)->except('update', 'show');
    Route::apiResource('attribute-values', AttributeValueController::class)->except('index');
    Route::apiResource('attribute-value-products', AttributeValueProductController::class)->except('index', 'show');

    Route::get('roles', [AdminUserController::class, 'roles']);
    Route::post('products/{product}/attachments', [AttachmentController::class, 'store']);
    Route::delete('attachments/{attachment}', [AttachmentController::class, 'destroy']);
    Route::get('orders', [AdminOrderController::class, 'index']);
    Route::patch('orders/{order}', [AdminOrderController::class, 'update']);
    Route::get('logs', [LogController::class, 'index'])->middleware('can:access-logs');
});

Route::group([
    'middleware' => ['guest:api'],
], function () {
    Route::post('forgot', [ForgotPasswordController::class, 'forgotPassword']);
});
