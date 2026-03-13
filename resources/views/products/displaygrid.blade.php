@extends('layouts.app')

@section('content')
@include('flash::message')

<div class="container mt-4">
    <h2 class="mb-3">Shop Window</h2>

    @if($products->isEmpty())
        <div class="alert alert-warning">
            No products found in the database. Make sure your products table is populated.
        </div>
    @else
        <div class="d-flex flex-wrap align-content-start bg-light">
            @foreach($products as $product)
                <div class="p-2 border col-4 g-3">
                    <div class="card text-center">
                        <!-- Card Header -->
                        <div class="card-header d-block">
                            <h5 class="mx-auto d-block">
                                {{ $product->name }} {{ $product->description }}
                            </h5>
                        </div>

                        <!-- Card Body with Placeholder Image -->
                        <div class="card-body">
                            @php
                                // Map product names to placeholder images
                                $imageUrl = match($product->name) {
                                    'T-Shirt' => 'https://via.placeholder.com/300x200.png?text=T-Shirt',
                                    'Sweatshirt' => 'https://via.placeholder.com/300x200.png?text=Sweatshirt',
                                    'Hoodie' => 'https://via.placeholder.com/300x200.png?text=Hoodie',
                                    default => 'https://via.placeholder.com/300x200.png?text=Product',
                                };
                            @endphp

                            <img 
                                style="width:65%; height:200px;" 
                                class="mx-auto d-block" 
                                src="{{ $imageUrl }}" 
                                alt="{{ $product->name }}">
                        </div>

                        <!-- Product Details -->
                        <div class="card-body">
                            <p><strong>Colour:</strong> {{ $product->colour ?? 'N/A' }}</p>
                            <p><strong>Price:</strong> €{{ number_format($product->price, 2) }}</p>
                        </div>

                        <!-- Card Footer with Add to Cart Button -->
                        <div class="card-footer">
                            <button 
                                id="addItem" 
                                type="button" 
                                class="btn btn-success mx-auto d-block addItem" 
                                value="{{ $product->id }}">
                                Add To Cart
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection