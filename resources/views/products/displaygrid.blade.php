@extends('layouts.app')

@section('content')

{{-- Navbar with Cart and Colour Filter --}}
<div style="padding-top:1%">
    <nav class="navbar navbar-right navbar-expand-sm navbar-dark bg-dark">
        <ul class="navbar-nav ms-auto">
            {{-- Checkout Button --}}
            <li class="nav-item">
                <button id="checkOut"
                        onclick="window.location.href='{{ route('scorder.checkout') }}'"
                        type="button"
                        style="margin-right:5px;"
                        class="btn btn-primary navbar-btn center-block">
                    Check Out
                </button>
            </li>

            {{-- Empty Cart Button --}}
            <li class="nav-item">
                <button id="emptycart"
                        type="button"
                        style="margin-right:5px;"
                        class="btn btn-primary navbar-btn center-block">
                    Empty Cart
                </button>
            </li>

            {{-- Shopping Cart Icon & Total --}}
            <li class="nav-item">
                <span style="font-size:40px;margin-right:0px;"
                      class="glyphicon glyphicon-shopping-cart navbar-btn"></span>
            </li>
            <li class="nav-item">
                <div class="navbar-text" id="shoppingcart"
                     style="font-size:12pt;margin-left:5px;margin-right:0px;">
                    {{ $totalItems ?? 0 }}
                </div>
            </li>
            <li class="nav-item">
                <div class="navbar-text" style="font-size:14pt;margin-left:0px;">Item(s)</div>
            </li>

            {{-- Colour Filter Dropdown --}}
            <li class="nav-item" style="margin-left:10px;">
                <select id="colourselect" class="form-select" size="1">
                    <option value="All">All</option>
                    <option value="Blue">Blue</option>
                    <option value="Red">Red</option>
                    <option value="Green">Green</option>
                    <option value="Yellow">Yellow</option>
                    <option value="Orange">Orange</option>
                </select>
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
                {{-- Product Card with allcolours & colour class for filtering --}}
                <div class="p-2 border col-4 g-3 allcolours {{ $product->colour }}">
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
                                // Map product names to local images
                                $imageMap = [
                                    'T-Shirt' => 'images/products/tshirt.png',
                                    'Sweatshirt' => 'images/products/sweatshirt.png',
                                    'Hoodie' => 'images/products/hoodie.png',
                                ];
                                $imageUrl = asset($imageMap[$product->name] ?? 'images/products/default.png');
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

{{-- jQuery for Add / Empty Cart / Colour Filter --}}
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

    // Filter products by colour
    $("#colourselect").on('change', function() {
        var colour = $(this).find(":selected").val();
        if (colour == 'All') {
            $('.allcolours').show();
        } else {
            $('.allcolours').hide();
            $('.' + colour).show();
        }
    });

});
</script>

@endsection