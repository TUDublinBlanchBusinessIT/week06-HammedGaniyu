<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class productController extends Controller
{
    public function displayGrid()
    {
        $products = Product::all();
        return view('products.displaygrid')
            ->with('products', $products);
    }
}