@extends('layouts.app')

@section('content')

{{-- Navbar with Cart Info --}}
<div style="padding-top:1%">
    <nav class="navbar navbar-right navbar-expand-sm navbar-dark bg-dark">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <button id="checkOut"
                        onclick="window.location.href='{{ route('scorder.checkout') }}'"
                        type="button"
                        style="margin-right:5px;"
                        class="btn btn-primary navbar-btn center-block">
                    Check Out
                </button>
            </li>
            <li class="nav-item">
                <button id="emptycart"
                        type="button"
                        style="margin-right:5px;"
                        class="btn btn-primary navbar-btn center-block">
                    Empty Cart
                </button>
            </li>
            <li class="nav-item">
                <span style="font-size:40px;margin-right:0px;"
                      class="glyphicon glyphicon-shopping-cart navbar-btn"></span>
            </li>
            <li class="nav-item">
                <div class="navbar-text" id="shoppingcart" style="font-size:12pt;margin-left:5px;margin-right:0px;">
                    {{ $totalItems ?? 0 }}
                </div>
            </li>
            <li class="nav-item">
                <div class="navbar-text" style="font-size:14pt;margin-left:0px;">Item(s)</div>
            </li>
        </ul>
    </nav>
</div>

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
                        {{-- Card Header --}}
                        <div class="card-header d-block">
                            <h5 class="mx-auto d-block">
                                {{ $product->name }} {{ $product->description }}
                            </h5>
                        </div>

                        {{-- Card Body with Image --}}
                        <div class="card-body">
                            @php
                                $imageUrl = match($product->name) {
                                    'T-Shirt' => 'https://via.placeholder.com/300x200.png?text=T-Shirt',
                                    'Sweatshirt' => 'https://via.placeholder.com/300x200.png?text=Sweatshirt',
                                    'Hoodie' => 'https://via.placeholder.com/300x200.png?text=Hoodie',
                                    default => 'https://via.placeholder.com/300x200.png?text=Product',
                                };
                            @endphp
                            <img style="width:65%; height:200px;" class="mx-auto d-block" src="{{ $imageUrl }}" alt="{{ $product->name }}">
                        </div>

                        {{-- Product Details --}}
                        <div class="card-body">
                            <p><strong>Colour:</strong> {{ $product->colour ?? 'N/A' }}</p>
                            <p><strong>Price:</strong> €{{ number_format($product->price, 2) }}</p>
                        </div>

                        {{-- Add to Cart Button --}}
                        <div class="card-footer">
                            <button type="button"
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

{{-- jQuery for Add / Empty Cart --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).ready(function() {

    // Add Item to Cart
    $(".addItem").click(function() {
        var i = $(this).val();
        $.ajax({
            type: "GET",
            url: "{{ url('product/additem') }}/" + i,
            success: function(response) {
                $('#shoppingcart').text(response.total);
            },
            error: function() {
                alert("Problem communicating with the server");
            }
        });
    });

    // Empty Cart
    $("#emptycart").click(function() {
        $.ajax({
            type: "GET",
            url: "{{ url('product/emptycart') }}",
            success: function() {
                $('#shoppingcart').text(0);
            },
            error: function() {
                alert("Problem communicating with the server");
            }
        });
    });

});
</script>

@endsection