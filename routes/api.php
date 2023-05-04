<?php

use App\Http\Controllers\Api\AuthController;
use App\Models\Category;
use App\Models\Product;
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

Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);

Route::get('/products', function(){

    $query = Product::with(['category' => function($query){
        $query->select(['category_id as id', 'name']);
    }])->get()->toArray();

    $products = array('products' => $query);

   return response()->json($products);
})->middleware('auth:sanctum');


Route::get('/categories', function(){

    $query = Category::all()->toArray();

    $categories = array('categories' => $query);

    return response()->json($categories);
});

Route::get('/product_category/{id}', function($id){

    $query = Product::whereHas('category', function($query) use ($id){
        $query->where('category_id', $id);
    })->get()->toArray();

    $products = array('products' => $query);

    return response()->json($products);
});

Route::get('/orders', function(){

    $query = \App\Models\Order::all()->toArray();

    $orders = array('orders' => $query);

    return response()->json($orders);

})->middleware('auth:sanctum');

Route::get('/orders/{order_id}', function($order_id){

    $query = \App\Models\Order::where('id', $order_id)->with(['products'])->get()->toArray();

    $order = array('order' => $query);

    return response()->json($order);

})->middleware('auth:sanctum');

Route::get('/orders/user/{id}', function($id){

    $query = \App\Models\Order::whereHas('user', function($query) use ($id){
        $query->where('id', $id);
    })
        ->with(['products', 'user'])
        ->get()
        ->toArray();

    $orderByUser = array('order_by_user' => $query);

    return response()->json($orderByUser);

})->middleware('auth:sanctum');
