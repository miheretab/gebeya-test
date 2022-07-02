@extends('layouts.front')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row">
                <div class="h1">{{ 'Store / ' . $client->id }} {{ isset($category) ? '/ ' . $category->slug  : '' }}</div>

                <div class="table">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table responsive stripe">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Image</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>${{ $product->price }}</td>
                                <td><img src="/{{ $product->image }}" height="100px" alt="{{ $product->image }}" /></td>
                                <td>
                                    <a class="btn" href="{{ url(isset($category) ? 'store-cat' : 'store', $client->id) }}{{ isset($category) ? '/' . $category->slug  : '' }}/{{ $product->slug }}" >View</a>
                                    @if ($product->quantity > 0)
                                    <a class="btn" data-mdb-toggle="modal" data-mdb-target="#cartModal" href="#" onclick="event.preventDefault();
                                        document.getElementById('cart-form').setAttribute('action', '{{ url('add-to-cart', $product->slug) }}{{ isset($category) ? '/'. $category->slug : ''}}');
                                        document.getElementById('product-name').textContent = '{{ $product->name }}'" >Add to cart</a>
                                    @else
                                    <span class="sold-out">Sold Out!</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>

@include('includes/cart_modal', compact('cart'))

@endsection
