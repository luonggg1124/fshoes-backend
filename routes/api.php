<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\Discount\SaleController;
use App\Http\Controllers\Api\ExportController;
use App\Http\Controllers\Api\GeminiController;
use App\Http\Controllers\Api\GroupsController;
use App\Http\Controllers\Api\Image\ImageController;
use App\Http\Controllers\Api\OrderDetailsController;
use App\Http\Controllers\Api\OrdersController;
use App\Http\Controllers\Api\PaymentOnline;
use App\Http\Controllers\Api\PostsController;
use App\Http\Controllers\Api\Product\ProductController;
use App\Http\Controllers\Api\Product\Variation\VariationController;
use App\Http\Controllers\Api\Review\ReviewController;
use App\Http\Controllers\Api\TopicsController;
use App\Http\Controllers\Api\User\AuthController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\VouchersController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;


//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');



Route::get('auth/unauthorized', function () {
    return response()->json([
        'status' => false,
        'message' => 'Unauthorized!',
    ], 401);
})->name('login');


//Admin
Route::group(['middleware' => ['auth:api', 'is_admin','user_banned']], function () {
    Route::apiResource('product', ProductController::class)->parameter('product', 'id')->except('index', 'show');
    Route::get('product/with/trashed', [ProductController::class, 'productWithTrashed'])->name('product.with.trashed');
    Route::get('product/trashed', [ProductController::class, 'productTrashed'])->name('product.list.trashed');
    Route::get('product/trashed/{id}', [ProductController::class, 'getOneTrashed'])->name('product.one.trashed');
    Route::post('product/restore/{id}', [ProductController::class, 'restore'])->name('product.restore');
    Route::delete('product/force-delete/{id}', [ProductController::class, 'forceDestroy'])->name('product.force.delete');
    Route::apiResource('product.variation', VariationController::class)->parameters(['product' => 'pid', 'variation' => 'id']);

    Route::apiResource('user', UserController::class)->parameter('user', 'id');
   
    Route::put('product/{id}/update/variation',[ProductController::class,'updateVariations']);
    Route::put('sale/switch/active/{id}', [SaleController::class, 'switchActive']);
    Route::apiResource('sale', SaleController::class)->parameters(['sale' => 'id'])->except('index');
    Route::apiResource('attribute', \App\Http\Controllers\Api\Attribute\AttributeController::class)->parameter('attribute', 'id');
    Route::get('get/attribute/values/product/{id}', [ProductController::class, 'getAttributeValues'])->name('get.attribute.values');
    Route::post('add/attribute/values/product', [ProductController::class, 'createAttributeValues'])->name('add.attribute.values');
    Route::apiResource('attribute.value', \App\Http\Controllers\Api\Attribute\Value\AttributeValueController::class)->parameters(['attribute' => 'aid', 'value' => 'id'])->except('update');
    Route::get('user', [UserController::class, 'index']);
    Route::get('count/user/has/orders', [UserController::class, 'userHasOrderCount']);
    Route::post('restore/user/{id}',[UserController::class,'restore']);
    Route::apiResource('category', CategoryController::class)->parameter('category', 'id')->except(['index', 'show']);
    Route::post('product/{pid}/restore/variation/{id}',[VariationController::class,'restore']);
    Route::get('products-with-all-queries',[ProductController::class,'allWithQueries']);
    Route::apiResource('sale', SaleController::class)->parameters(['sale' => 'id'])->only('index');
    Route::post('restore/review/{id}',[ReviewController::class,'restore']);
    Route::delete('force/delete/review/{id}',[ReviewController::class,'forceDestroy']);
    Route::apiResource('image', ImageController::class)->parameter('image', 'id')->only(['index', 'store', 'destroy']);
    Route::delete('image/delete-many', [ImageController::class, 'deleteMany'])->name('image.delete.many');
    //End Image

    Route::post('category/{id}/products', [CategoryController::class, 'addProducts'])->name('category.add.products');
    Route::delete('category/{id}/products', [CategoryController::class, 'deleteProducts'])->name('category.delete.products');
    Route::post('admin/create/order',[OrdersController::class,'createAsAdmin'])->name('admin.create.order');
    Route::get('admin/statistics/order',[OrdersController::class, 'statisticsOrder']);
});

// End Admin
Route::get('sales/stream', [SaleController::class, 'stream'])->name('sale.stream');


// Auth
Route::group(['middleware' => ['auth:api','user_banned']], function () {

    Route::put('update-profile', [UserController::class, 'updateProfile'])->name('update-profile');
    Route::post('change-password', [AuthController::class, 'changePassword'])->name('user.changePassword');
   

    Route::get('user/get-favorite/product', [UserController::class, 'getFavoriteProduct'])->name('get.favorite.product');
    Route::post('user/add-favorite/product/{product_id}', [UserController::class, 'addFavoriteProduct'])->name('add.favorite.product');
    Route::delete('user/remove-favorite/product/{product_id}', [UserController::class, 'removeFavoriteProduct'])->name('remove.favorite.product');


    Route::post('review/{id}/like', [ReviewController::class, 'toggleLike'])->name('review.like');
    Route::apiResource('review', ReviewController::class)->parameter('review', 'id');

    Route::get('me/orders', [OrdersController::class, 'me']);
    Route::patch('cancel/order/{id}', [OrdersController::class, 'cancelOrder']);
    Route::post('reorder/order/{id}', [OrdersController::class, 'reOrder']);
    Route::put('order/update/payment-status/{id}', [OrdersController::class, 'updatePaymentStatus']);

    //Discount

    //Discount End
    //Image
    Route::apiResource('cart', CartController::class);
    Route::post('update/user/avatar', [UserController::class, 'updateAvatar']);
    Route::get('vouchers/code/{code}', [VouchersController::class, 'getVoucherByCode']);
});

Route::middleware('api')->post('logout', [AuthController::class, 'logout']);
Route::middleware('api')->get('auth/me', [AuthController::class, 'me']);

Route::middleware('customize_throttle:1,1')->post('forgot/password', [AuthController::class, 'forgotPassword'])->name('forgotPassword');
Route::post('reset/password', [AuthController::class, 'resetPassword'])->name('resetPassword');
Route::post('auth/refresh/token', [AuthController::class, 'refresh']);
Route::post('/check/email', [AuthController::class, 'checkEmail']);
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::get('attributes/isFilter', [\App\Http\Controllers\Api\Attribute\AttributeController::class, 'isFilterAttributes']);
// End Auth

// Category Start

Route::apiResource('category', CategoryController::class)
    ->parameter('category', 'id')->only(['index', 'show']);
Route::get('main/categories', [CategoryController::class, 'mains'])->name('main.categories');

// Category End


//Cart


//Order
Route::apiResource('orders', OrdersController::class);




//Order Detail
Route::apiResource('order-details', OrderDetailsController::class);

//Payment
Route::post('momo', [PaymentOnline::class, 'momo']);
Route::post('vnpay', [PaymentOnline::class, 'vnpay']);
Route::post('stripe', [PaymentOnline::class, 'stripe']);
Route::post('paypal', [PaymentOnline::class, 'paypal']);
Route::get('success-paypal', [PaymentOnline::class, 'successPaypal'])->name('successPaypal');
Route::get('error-paypal', [PaymentOnline::class, 'errorPaypal'])->name('errorPaypal');

//Product Start
Route::get('display/home-page/products', [CategoryController::class, 'displayAtHomePage'])->name('display.home.page');

Route::get('product/detail/{id}', [ProductController::class, 'productDetail'])->name('product.detail');
Route::apiResource('product', ProductController::class)->parameter('product', 'id')->only('index', 'show');
Route::get('products/category/{categoryId}', [ProductController::class, 'productsByCategory'])->name('products.category');
Route::get('product/by/attribute-values', [ProductController::class, 'filterProduct'])->name('product.filter');
Route::get('products/all/summary', [ProductController::class, 'allSummary'])->name('product.all.summary');

//Product End

// Review

// Like

Route::get('product/{id}/reviews', [ReviewController::class, 'reviewsByProduct'])->name('product.reviews');


// End Review



//Route::get('api/auth/google/redirect', [SocialiteController::class, 'googleRedirect']);
//Route::post('auth/google/callback', [SocialiteController::class, 'googleCallback']);

Route::get('test', [TestController::class, 'test']);


//Groups
Route::apiResource('groups', GroupsController::class);
Route::post('groups/restore/{id}', [GroupsController::class, 'restore']);
Route::delete('groups/forceDelete/{id}', [GroupsController::class, 'forceDelete']);


//Topics
Route::apiResource('topics', TopicsController::class);
Route::post('topics/restore/{id}', [TopicsController::class, 'restore']);
Route::delete('topics/forceDelete/{id}', [TopicsController::class, 'forceDelete']);

//Posts
Route::apiResource('posts', PostsController::class);
Route::post('posts/restore/{id}', [PostsController::class, 'restore']);
Route::delete('posts/forceDelete/{id}', [PostsController::class, 'forceDelete']);

//Vouchers
Route::apiResource('vouchers', VouchersController::class);
Route::post('vouchers/restore/{id}', [VouchersController::class, 'restore']);

Route::delete('vouchers/forceDelete/{id}', [VouchersController::class, 'forceDelete']);

//Export Invoice
Route::get('export/order/{id}', [ExportController::class, 'exportInvoice']);


//Export List Record
Route::post('export/order', [ExportController::class, 'exportOrder']);
Route::post('export/user', [ExportController::class, 'exportUser']);
Route::post('export/product', [ExportController::class, 'exportProduct']);


//Statistics
Route::get('statistics/order', [\App\Http\Controllers\Api\StatisticsController::class, 'order']);
Route::get('statistics/product', [\App\Http\Controllers\Api\StatisticsController::class, 'product']);
Route::get('statistics/user', [\App\Http\Controllers\Api\StatisticsController::class, 'user']);
Route::get('statistics/review', [\App\Http\Controllers\Api\StatisticsController::class, 'review']);
Route::get('statistics/overall', [\App\Http\Controllers\Api\StatisticsController::class, 'overall']);


//Gemini
Route::post('/gemini/text', [GeminiController::class, 'text']);


//Import
Route::post('import/voucher', [\App\Http\Controllers\Api\ImportVoucher::class, 'import']);
Route::fallback(function () {
    return response()->json([
        'message' => 'Route not found',
        'error' => 'Not Found',
    ], 404);
});
