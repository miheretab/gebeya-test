@extends('layouts.front')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('All Store Products') }}</div>

                <div class="card-body">

                <div class="table">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table responsive stripe">
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td class="text-center mb-5">
                                    <a href="{{ url('store', $product->user->id) }}/{{ $product->slug }}" >
                                        <img src="/{{ $product->image }}" width="300px" alt="{{ $product->image }}" />
                                    </a>
                                </td>
                                <td><a href="{{ url('store', $product->user->id) }}">{{ $product->user->name }}</a> - Store [{{ $product->user->id }}]</td>
                                <td class="mt-5">
                                    @if ($product->quantity > 0)
                                    <a class="btn" data-mdb-toggle="modal" data-mdb-target="#cartModal" href="#" onclick="event.preventDefault();
                                        document.getElementById('cart-form').setAttribute('action', '{{ url('add-to-cart', $product->slug) }}{{ isset($category) ? '/'. $category->slug : ''}}');
                                        document.getElementById('product-name').textContent = '{{ $product->name }}'" >Add to cart</a>
                                    @else
                                    Sold Out!
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
