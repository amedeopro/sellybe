<?php

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

Route::get('/products', function(){

    $query = Product::with(['category' => function($query){
        $query->select(['category_id as id', 'name']);
    }])->get()->toArray();

    $products = array('products' => $query);

   return response()->json($products);
});


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
