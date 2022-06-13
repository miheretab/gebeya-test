@extends('layouts.front')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row">
                <div class="h1">Cart Page</div>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                  @if (isset($cart['orders']) && !empty($cart['orders']))
                    <div class="table">
                        <table class="table responsive stripe">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Sub Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart['orders'] as $order)
                                <tr>
                                    <td>{{ $order['product']->name }}</td>
                                    <td><input id="quantity-real" type="number" class="form-control" onChange="document.getElementById('quantity').value = this.value;" value="{{ $order['quantity'] }}" required autocomplete="quantity"></td>
                                    <td>${{ $order['product']->price }}</td>
                                    <td>${{ $order['product']->price * $order['quantity'] }}</td>
                                    <td>
                                        <a class="btn" href="{{ url('update-cart', $order['product']->id) }}" onclick="event.preventDefault();
                                            document.getElementById('update-cart-form').submit();">Update</a>
                                        <form id="update-cart-form" action="{{ url('update-cart', $order['product']->id) }}" method="POST" class="d-none">
                                            @csrf
                                            <input id="quantity" name="quantity" type="hidden" value="{{ $order['quantity'] }}" />
                                        </form>
                                        <a class="btn" href="{{ url('remove-from-cart', $order['product']->id) }}{{ isset($category) ? '/'. $category->id : ''}}" onclick="event.preventDefault();
                                            document.getElementById('remove-cart-form').submit();">Remove</a>
                                        <form id="remove-cart-form" action="{{ url('remove-from-cart', $order['product']->id) }}{{ isset($category) ? '/'. $category->id : ''}}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <a class="btn btn-primary" href="{{ url('checkout') }}">Checkout</a>
                  @else
                    <div>No items left in your cart!</div>
                  @endif
            </div>
        </div>
    </div>
</div>

@endsection
