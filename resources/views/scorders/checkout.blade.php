@extends('layouts.app')
@section('content')

<h2>Place Order</h2>

<form action="{{ route('scorder.placeorder') }}" method="POST">
    @csrf
    <table class="table table-condensed table-bordered">
        <thead>
            <tr>
                <th>Id</th><th>Name</th><th>Description</th>
                <th>Colour</th><th>Price</th><th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            @php $ttlCost=0; $ttlQty=0; @endphp
            @foreach ($lineitems as $lineitem)
                @php $product = $lineitem['product']; @endphp
                <tr>
                    <td><input size="3" style="border:none" type="text" name="productid[]" readonly value="{{ $product->id }}"></td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->colour }}</td>
                    <td>{{ $product->price }}</td>
                    <td><input size="3" style="border:none" class="qty" type="text" name="quantity[]" readonly value="{{ $lineitem['qty'] }}"></td>
                </tr>
                @php 
                    $ttlQty += $lineitem['qty'];
                    $ttlCost += $product->price * $lineitem['qty'];
                @endphp
            @endforeach
        </tbody>
    </table>
    <p>Total Quantity: {{ $ttlQty }}</p>
    <p>Total Cost: €{{ number_format($ttlCost,2) }}</p>
    <button type="submit" class="btn btn-primary">Submit Order</button>
</form>

@endsection