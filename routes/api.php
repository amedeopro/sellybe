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

    $products = Product::with(['category' => function($query){
        $query->select(['category_id as id', 'name']);
    }])->get();

   return response()->json($products);
});


Route::get('/categories', function(){

    $categories = Category::all();

    return response()->json($categories);
});
