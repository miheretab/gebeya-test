@extends('layouts.front')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row">
                <div class="h1">{{ 'Store / ' . $client->id }} {{ isset($category) ? '/ ' . $category->slug  : '' }} / {{ $product->slug }}</div>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                    <div class="h5 mb-2">{{ $product->name }}</div>
                    <div class="h5 mb-2">{{ $product->quantity }}</td>
                    <div class="h5 mb-2">${{ $product->price }}</td>
                    <div class="text-center mb-5"><img src="/{{ $product->image }}" width="300px" alt="{{ $product->image }}" /></td>
                    <div class="mt-5">
                        @if ($product->quantity > 0)
                        <a class="btn" data-mdb-toggle="modal" data-mdb-target="#cartModal" href="#" onclick="event.preventDefault();
                            document.getElementById('cart-form').setAttribute('action', '{{ url('add-to-cart', $product->slug) }}{{ isset($category) ? '/'. $category->slug : ''}}');
                            document.getElementById('product-name').textContent = '{{ $product->name }}'" >Add to cart</a>
                        @else
                        Sold Out!
                        @endif
                    </div>

            </div>
        </div>
    </div>
</div>

@include('includes/cart_modal', compact('cart'))

@endsection
