<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\productController;
use App\Http\Controllers\scordersController;

// Shop / Cart
Route::get('/', [productController::class, 'displayGrid'])->name('products.displaygrid');
Route::get('product/displaygrid', [productController::class, 'displayGrid']);
Route::get('product/additem/{id}', [productController::class, 'additem'])->name('products.additem');
Route::get('product/emptycart', [productController::class, 'emptycart'])->name('product.emptycart');

// Checkout / Orders
Route::get('scorder/checkout', [scordersController::class, 'checkout'])->name('scorder.checkout');
Route::post('scorder/placeorder', [scordersController::class, 'placeorder'])->name('scorder.placeorder');