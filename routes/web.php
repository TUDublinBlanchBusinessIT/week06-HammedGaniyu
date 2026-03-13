<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\productController;

// Shop window
Route::get('/', [productController::class, 'displayGrid'])->name('products.displaygrid');
Route::get('product/displaygrid', [productController::class, 'displayGrid']);

// Add item to cart via AJAX
Route::get('product/additem/{id}', [productController::class, 'additem'])
    ->name('products.additem');

// Empty cart via AJAX
Route::get('product/emptycart', [productController::class, 'emptycart'])
    ->name('products.emptycart');